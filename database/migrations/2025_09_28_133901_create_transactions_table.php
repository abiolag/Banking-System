<?php
// File: database/migrations/xxxx_xx_xx_xxxxxx_create_transactions_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_ref')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['transfer', 'deposit', 'withdrawal', 'bill_payment', 'wire_transfer']);
            $table->decimal('amount', 15, 2);
            $table->decimal('balance_before', 15, 2);
            $table->decimal('balance_after', 15, 2);
            $table->string('description');
            $table->enum('status', ['pending', 'completed', 'failed', 'reversed'])->default('pending');
            $table->string('recipient_account_number')->nullable();
            $table->string('recipient_routing_number')->nullable(); // For US domestic transfers
            $table->string('recipient_bank_name')->nullable();
            $table->string('recipient_name')->nullable();
            $table->string('swift_code')->nullable(); // For international transfers
            $table->string('iban')->nullable(); // For international transfers
            $table->text('narration')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'created_at']);
            $table->index('transaction_ref');
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};