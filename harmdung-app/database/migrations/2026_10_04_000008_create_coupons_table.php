<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->decimal('discount_percent', 5, 2);
            $table->date('expiry_date');
            $table->unsignedInteger('usage_limit');
            $table->unsignedInteger('used_count')->default(0);
            $table->timestamps();
        });

        if (DB::getDriverName() !== 'sqlite') {
            DB::statement('ALTER TABLE coupons ADD CONSTRAINT chk_coupons_discount CHECK (discount_percent BETWEEN 1 AND 100)');
            DB::statement('ALTER TABLE coupons ADD CONSTRAINT chk_coupons_usage CHECK (used_count <= usage_limit)');
        }
        // หมายเหตุ: ใช้หลังวันหมดอายุไม่ได้ -> ตรวจใน CouponService ตอน checkout
    }

    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};