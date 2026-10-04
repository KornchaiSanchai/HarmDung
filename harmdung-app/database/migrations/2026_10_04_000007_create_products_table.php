<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('platform_id')->constrained()->restrictOnDelete();
            $table->string('plan_name');
            $table->unsignedInteger('duration_days');
            $table->decimal('price', 10, 2);
            $table->integer('stock')->default(0);
            $table->timestamps();
        });

        // SQLite เพิ่ม CHECK ด้วย ALTER ไม่ได้ จึงข้าม (ใช้ MySQL 8.0.16+ / MariaDB เพื่อให้บังคับจริง)
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement('ALTER TABLE products ADD CONSTRAINT chk_products_stock CHECK (stock >= 0)');
            DB::statement('ALTER TABLE products ADD CONSTRAINT chk_products_price CHECK (price >= 0)');
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};