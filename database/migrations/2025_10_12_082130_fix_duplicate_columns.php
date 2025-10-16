<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Check if columns exist before adding them
        if (!Schema::hasColumn('transactions', 'swift_code')) {
            Schema::table('transactions', function (Blueprint $table) {
                $table->string('swift_code')->nullable()->after('bank_address');
            });
        }
        
        // Add other missing columns with checks
        $columnsToCheck = ['bank_name', 'bank_country', 'bank_address', 'iban', 'intermediary_bank'];
        
        foreach ($columnsToCheck as $column) {
            if (!Schema::hasColumn('transactions', $column)) {
                Schema::table('transactions', function (Blueprint $table) use ($column) {
                    $table->string($column)->nullable();
                });
            }
        }
    }

    public function down()
    {
        // Don't drop columns to preserve data
    }
};