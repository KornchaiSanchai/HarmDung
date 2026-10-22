<?php

namespace App\Http\Controllers;

use App\Services\CouponService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CouponController extends Controller
{
    public function __construct(private CouponService $coupons) {}

    /**
     * แสดงหน้าชำระเงิน (Checkout) พร้อมดึงข้อมูลคูปองและคำนวณราคาเริ่มต้นจาก Backend
     */
    public function checkout(Request $request): View
    {
        $user = $request->user();
        $items = $this->coupons->resolveCartItems($user);
        $options = $this->coupons->optionsFor($user, $items);

        $savedCode = $request->session()->get('coupon_code');
        $summary = $this->coupons->apply($savedCode, $items, $user);

        return view('checkout', [
            'coupons'       => $options,
            'summary'       => $summary,
            'items'         => $items,
            'activeCoupon'  => $summary['coupon'] ?? null,
        ]);
    }

    /**
     * ผู้ใช้เลือกคูปองหรือกรอกรหัสคูปอง
     * ทำการ Validate เงื่อนไขราคาขั้นต่ำ และคำนวณส่วนลดจาก Backend
     */
    public function select(Request $request): JsonResponse|RedirectResponse
    {
        $data = $request->validate([
            'code'  => ['nullable', 'string', 'max:50'],
            'items' => ['nullable', 'array'],
        ]);

        $code = trim((string) ($data['code'] ?? ''));

        // ถ้าเลือก "ไม่ใช้คูปอง" หรือส่งค่าว่างมา
        if (blank($code) || strtoupper($code) === 'NONE') {
            return $this->remove($request);
        }

        $user  = $request->user();
        $items = $this->coupons->resolveCartItems($user, $request->input('items'));
        $check = $this->coupons->validate($code, $user, $items);

        if (! $check['valid']) {
            $request->session()->forget('coupon_code');

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'valid'    => false,
                    'message'  => $check['message'],
                    'subtotal' => $this->coupons->sum($items),
                    'discount' => 0.0,
                    'total'    => $this->coupons->sum($items),
                ], 422);
            }

            return redirect()->to(url()->previous().'#coupons')->withErrors(['code' => $check['message']]);
        }

        // คูปองผ่านเงื่อนไข บันทึกลง Session
        $coupon = $check['coupon'];
        $request->session()->put('coupon_code', $coupon->code);
        $summary = $this->coupons->apply($coupon->code, $items, $user);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'valid'             => true,
                'message'           => $summary['message'],
                'code'              => $coupon->code,
                'name'              => $summary['name'] ?? '',
                'desc'              => $summary['desc'] ?? '',
                'subtotal'          => $summary['subtotal'],
                'eligible_subtotal' => $summary['eligible_subtotal'],
                'discount'          => $summary['discount'],
                'total'             => $summary['total'],
            ]);
        }

        return redirect()->to(url()->previous().'#coupons')->with('coupon_status', $summary['message']);
    }

    /**
     * ยกเลิกการใช้คูปองส่วนลด
     */
    public function remove(Request $request): JsonResponse|RedirectResponse
    {
        $request->session()->forget('coupon_code');

        $user    = $request->user();
        $items   = $this->coupons->resolveCartItems($user, $request->input('items'));
        $summary = $this->coupons->apply(null, $items, $user);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'removed'  => true,
                'valid'    => true,
                'message'  => 'เลือกไม่ใช้คูปองส่วนลด',
                'code'     => null,
                'subtotal' => $summary['subtotal'],
                'discount' => 0.0,
                'total'    => $summary['subtotal'],
            ]);
        }

        return redirect()->to(url()->previous().'#coupons')->with('coupon_status', 'ไม่ใช้คูปอง');
    }

    /**
     * ดึงรายการคูปองที่ประเมินเงื่อนไขแล้วสำหรับหน้า Checkout
     */
    public function options(Request $request): JsonResponse
    {
        $user  = $request->user();
        $items = $this->coupons->resolveCartItems($user, $request->input('items'));

        return response()->json($this->coupons->optionsFor($user, $items));
    }
}