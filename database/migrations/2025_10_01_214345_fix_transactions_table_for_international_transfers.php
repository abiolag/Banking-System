<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Add missing intermediary_bank column
        Schema::table('transactions', function (Blueprint $table) {
            if (!Schema::hasColumn('transactions', 'intermediary_bank')) {
                $table->string('intermediary_bank')->nullable()->after('iban');
            }
        });

        // Update status ENUM to include 'pending_approval'
        DB::statement("ALTER TABLE transactions MODIFY COLUMN status ENUM('pending', 'completed', 'failed', 'cancelled', 'pending_approval') NOT NULL DEFAULT 'pending'");
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            if (Schema::hasColumn('transactions', 'intermediary_bank')) {
                $table->dropColumn('intermediary_bank');
            }
        });

        // Revert status ENUM
        DB::statement("ALTER TABLE transactions MODIFY COLUMN status ENUM('pending', 'completed', 'failed', 'cancelled') NOT NULL DEFAULT 'pending'");
    }
};