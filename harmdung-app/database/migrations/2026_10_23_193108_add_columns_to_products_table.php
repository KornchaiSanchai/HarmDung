<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // เช็กว่าถ้ายังไม่มีคอลัมน์ platform_key ถึงค่อยสร้าง
            if (!Schema::hasColumn('products', 'platform_key')) {
                $table->string('platform_key')->nullable()->after('id');
            }
            
            // เช็กว่าถ้ายังไม่มีคอลัมน์ plan_name ถึงค่อยสร้าง
            if (!Schema::hasColumn('products', 'plan_name')) {
                $table->string('plan_name')->nullable()->after('platform_key');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['platform_key', 'plan_name']);
        });
    }
};