<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // ลบสมาชิกที่มีออเดอร์ไม่ได้ (ใช้โชว์ demo constraint)
            $table->foreignId('user_id')->constrained()->restrictOnDelete();
            // NULL = ไม่ได้ใช้คูปอง
            $table->foreignId('coupon_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('subtotal', 10, 2);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->string('status', 20)->default('paid'); // ชำระเงินจำลอง
            $table->timestamps();
        });

        if (DB::getDriverName() !== 'sqlite') {
            DB::statement('ALTER TABLE orders ADD CONSTRAINT chk_orders_total CHECK (total = subtotal - discount_amount)');
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};