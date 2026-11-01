<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ซ้ำกับ 2026_10_22_194952_add_min_spend_to_coupons_table → เพิ่มเฉพาะเมื่อยังไม่มีคอลัมน์
        if (Schema::hasColumn('coupons', 'min_spend')) {
            return;
        }

        Schema::table('coupons', function (Blueprint $table) {
            $table->decimal('min_spend', 10, 2)->default(0)->after('discount_percent');
        });
    }

    public function down(): void
    {
        // คอลัมน์ min_spend เป็นของ migration 2026_10_22_194952 ให้ตัวนั้นเป็นคน drop
    }
};