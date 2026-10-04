<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            // สินค้าที่เคยขายแล้วลบไม่ได้
            $table->foreignId('product_id')->constrained()->restrictOnDelete();
            $table->unsignedInteger('quantity');
            $table->decimal('unit_price', 10, 2); // snapshot ราคา ณ เวลาซื้อ
            $table->primary(['order_id', 'product_id']);
        });

        if (DB::getDriverName() !== 'sqlite') {
            DB::statement('ALTER TABLE order_items ADD CONSTRAINT chk_order_items_qty CHECK (quantity > 0)');
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};