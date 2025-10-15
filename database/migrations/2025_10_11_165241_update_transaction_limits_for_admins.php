<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Update existing columns with new limits
        });
        
        // Update all non-admin users with new limits
        \App\Models\User::where('is_admin', false)->update([
            'daily_limit' => 1000000.00,
            'max_transaction' => 100000.00
        ]);
    }

    public function down()
    {
        // Revert to old limits if needed
        \App\Models\User::where('is_admin', false)->update([
            'daily_limit' => 100000.00,
            'max_transaction' => 50000.00
        ]);
    }
};