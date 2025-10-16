<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('daily_limit', 15, 2)->default(100000.00); // $100,000 daily limit
            $table->decimal('max_transaction', 15, 2)->default(50000.00); // $50,000 per transaction
            $table->decimal('daily_transferred', 15, 2)->default(0.00); // Track daily total
            $table->date('last_transaction_date')->nullable(); // Reset daily counter
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['daily_limit', 'max_transaction', 'daily_transferred', 'last_transaction_date']);
        });
    }
};