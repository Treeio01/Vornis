<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->string('status')->index()->change();
        });

        if (DB::getDriverName() !== 'sqlite') {
            DB::statement('ALTER TABLE addresses MODIFY user_id BIGINT UNSIGNED NOT NULL');
            DB::statement('ALTER TABLE addresses MODIFY reward DECIMAL(12,2) NULL DEFAULT 0');
        }

        Schema::table('addresses', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIndex(['status']);
        });

        if (DB::getDriverName() !== 'sqlite') {
            DB::statement('ALTER TABLE addresses MODIFY reward VARCHAR(255) NULL');
            DB::statement('ALTER TABLE addresses MODIFY user_id INT NOT NULL');
        }
    }
};
