<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up(): void
{
    Schema::create('account_stocks', function (Blueprint $table) {
        $table->id();
        $table->foreignId('product_id')->constrained()->cascadeOnDelete();
        $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
        $table->string('email');
        $table->string('password');
        $table->enum('status', ['available', 'sold'])->default('available');
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('account_stocks');
}
};
