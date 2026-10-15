<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Review;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ReviewController extends Controller
{
    public function store(Request $request, Movie $movie): RedirectResponse
    {
        $data   = $this->validated($request);
        $userId = $request->user()->id;

        if (Review::where('user_id', $userId)->where('movie_id', $movie->id)->exists()) {
            return $this->back($movie)->withErrors(['review' => 'คุณรีวิวหนังเรื่องนี้แล้ว แก้ไขรีวิวเดิมได้']);
        }

        try {
            Review::query()->insert([
                'user_id'    => $userId,
                'movie_id'   => $movie->id,
                'rating'     => $data['rating'],
                'comment'    => $data['comment'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (UniqueConstraintViolationException) {
            // กดส่งซ้ำพร้อมกันจนชน primary key (user_id, movie_id)
            return $this->back($movie)->withErrors(['review' => 'คุณรีวิวหนังเรื่องนี้แล้ว']);
        }

        return $this->back($movie)->with('status', 'บันทึกรีวิวเรียบร้อย');
    }

    public function update(Request $request, Movie $movie): RedirectResponse
    {
        $data = $this->validated($request);

        // กรองด้วย user_id ของคนที่ล็อกอิน จึงแก้ได้เฉพาะรีวิวของตัวเอง
        $affected = Review::where('user_id', $request->user()->id)
            ->where('movie_id', $movie->id)
            ->update([
                'rating'     => $data['rating'],
                'comment'    => $data['comment'] ?? null,
                'updated_at' => now(),
            ]);

        abort_if($affected === 0, 404, 'ไม่พบรีวิวของคุณ');

        return $this->back($movie)->with('status', 'แก้ไขรีวิวเรียบร้อย');
    }

    public function destroy(Request $request, Movie $movie): RedirectResponse
    {
        $deleted = Review::where('user_id', $request->user()->id)
            ->where('movie_id', $movie->id)
            ->delete();

        abort_if($deleted === 0, 404, 'ไม่พบรีวิวของคุณ');

        return $this->back($movie)->with('status', 'ลบรีวิวเรียบร้อย');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'rating'  => ['required', 'integer', 'between:1,5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ], [
            'rating.required' => 'กรุณาให้คะแนน',
            'rating.integer'  => 'คะแนนต้องเป็นตัวเลข',
            'rating.between'  => 'คะแนนต้องอยู่ระหว่าง 1 ถึง 5',
            'comment.max'     => 'คอมเมนต์ยาวได้ไม่เกิน 1000 ตัวอักษร',
        ]);
    }

    private function back(Movie $movie): RedirectResponse
    {
        // movies.show เป็น route ของมะปิน ถ้ายังไม่มีจะกลับไปหน้าก่อนหน้า
        return Route::has('movies.show')
            ? redirect()->to(route('movies.show', $movie).'#reviews')
            : back();
    }
}