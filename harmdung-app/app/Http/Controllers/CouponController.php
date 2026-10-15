<?php

namespace App\Http\Controllers;

use App\Services\CouponService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function __construct(private CouponService $coupons) {}

    /** ผู้ใช้เลือกคูปองในหน้าชำระเงิน ถ้าส่ง code มาว่างแปลว่าเลือก "ไม่ใช้คูปอง" */
    public function select(Request $request): JsonResponse|RedirectResponse
    {
        $data = $request->validate(['code' => ['nullable', 'string', 'max:50']]);
        $code = $data['code'] ?? null;

        if (blank($code)) {
            return $this->remove($request);
        }

        $user  = $request->user();
        $items = $this->coupons->cartItemsOf($user);
        $check = $this->coupons->validate($code, $user, $items);

        if (! $check['valid']) {
            $request->session()->forget('coupon_code');

            return $request->expectsJson()
                ? response()->json(['valid' => false, 'message' => $check['message']], 422)
                : redirect()->to(url()->previous().'#coupons')->withErrors(['code' => $check['message']]);
        }

        $request->session()->put('coupon_code', $check['coupon']->code);

        if ($request->expectsJson()) {
            $summary = $this->coupons->apply($check['coupon']->code, $items);

            return response()->json([
                'valid'    => true,
                'message'  => $check['message'],
                'code'     => $check['coupon']->code,
                'subtotal' => $summary['subtotal'],
                'discount' => $summary['discount'],
                'total'    => $summary['total'],
            ]);
        }

        return redirect()->to(url()->previous().'#coupons')->with('coupon_status', $check['message']);
    }

    public function remove(Request $request): JsonResponse|RedirectResponse
    {
        $request->session()->forget('coupon_code');

        return $request->expectsJson()
            ? response()->json(['removed' => true])
            : redirect()->to(url()->previous().'#coupons')->with('coupon_status', 'ไม่ใช้คูปอง');
    }
}