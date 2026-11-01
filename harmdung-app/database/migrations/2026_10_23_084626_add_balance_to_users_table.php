<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // ยอดเริ่มต้น 100 บาท (ไม่มีระบบเติมเงิน)
            $table->decimal('balance', 12, 2)->default(100)->after('password');
        });

        // กันยอดติดลบ (SQLite เพิ่ม CHECK ด้วย ALTER ไม่ได้ จึงข้าม)
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement('ALTER TABLE users ADD CONSTRAINT chk_users_balance CHECK (balance >= 0)');
        }

        // กำหนดเงินเริ่มต้นให้ admin@example.com
        DB::table('users')->where('email', 'admin@example.com')->update(['balance' => 99999999]);
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement('ALTER TABLE users DROP CHECK chk_users_balance');
        }

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('balance');
        });
    }
};