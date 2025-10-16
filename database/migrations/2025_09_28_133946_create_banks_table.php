<?php
// File: database/migrations/xxxx_xx_xx_xxxxxx_create_banks_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('banks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('routing_number')->nullable(); // US routing number
            $table->string('swift_code')->nullable(); // International SWIFT/BIC
            $table->string('country_code', 2)->default('US');
            $table->string('currency', 3)->default('USD');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('banks');
    }
};