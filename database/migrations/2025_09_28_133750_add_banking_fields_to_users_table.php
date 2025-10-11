<?php
// File: database/migrations/xxxx_xx_xx_xxxxxx_add_banking_fields_to_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('account_number')->unique()->nullable();
            $table->decimal('balance', 15, 2)->default(0);
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('country')->default('US');
            $table->date('date_of_birth')->nullable();
            $table->enum('account_type', ['checking', 'savings', 'business'])->default('checking');
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->string('ssn')->nullable(); // Social Security Number (US) / National Insurance (UK)
            $table->string('routing_number')->nullable(); // For US domestic transfers
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'account_number', 
                'balance', 
                'phone', 
                'address', 
                'city',
                'state',
                'zip_code',
                'country',
                'date_of_birth', 
                'account_type', 
                'status', 
                'ssn',
                'routing_number'
            ]);
        });
    }
};