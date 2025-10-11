<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Bank;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create sample banks
        Bank::create([
            'name' => 'Arkard Bank',
            'routing_number' => '021000021',
            'swift_code' => 'ARKAUS33',
            'country_code' => 'US',
            'currency' => 'USD'
        ]);

        Bank::create([
            'name' => 'Chase Bank',
            'routing_number' => '021000021',
            'swift_code' => 'CHASUS33',
            'country_code' => 'US',
            'currency' => 'USD'
        ]);

        Bank::create([
            'name' => 'Barclays Bank',
            'routing_number' => null,
            'swift_code' => 'BARCGB22',
            'country_code' => 'GB',
            'currency' => 'GBP'
        ]);

        // Create sample users with complete data
        $user1 = User::create([
            'name' => 'John Smith',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'account_number' => '10000001',
            'balance' => 5000.00,
            'phone' => '+1-555-0101',
            'address' => '123 Main Street',
            'city' => 'New York',
            'state' => 'NY',
            'zip_code' => '10001',
            'date_of_birth' => '1985-06-15',
            'account_type' => 'checking',
            'routing_number' => '021000021'
        ]);

        $user2 = User::create([
            'name' => 'Sarah Johnson',
            'email' => 'sarah@example.com',
            'password' => Hash::make('password'),
            'account_number' => '10000002',
            'balance' => 2500.00,
            'phone' => '+1-555-0102',
            'address' => '456 Oak Avenue',
            'city' => 'Los Angeles',
            'state' => 'CA',
            'zip_code' => '90210',
            'date_of_birth' => '1990-03-22',
            'account_type' => 'savings',
            'routing_number' => '021000021'
        ]);

        // Create a test transaction between users
        $transaction = $user1->transactions()->create([
            'transaction_ref' => 'ARK' . date('YmdHis') . rand(1000, 9999),
            'type' => 'transfer',
            'amount' => 100.00,
            'balance_before' => 5000.00,
            'balance_after' => 4900.00,
            'description' => "Transfer to Sarah Johnson (10000002) - Arkard Bank",
            'status' => 'completed',
            'recipient_account_number' => '10000002',
            'recipient_bank_name' => 'Arkard Bank',
            'recipient_name' => 'Sarah Johnson',
            'narration' => 'Test transfer'
        ]);

        // Create corresponding transaction for recipient
        $user2->transactions()->create([
            'transaction_ref' => $transaction->transaction_ref . 'R',
            'type' => 'deposit',
            'amount' => 100.00,
            'balance_before' => 2500.00,
            'balance_after' => 2600.00,
            'description' => "Transfer from John Smith (10000001)",
            'status' => 'completed',
            'recipient_account_number' => '10000001',
            'recipient_bank_name' => 'Arkard Bank',
            'recipient_name' => 'John Smith',
            'narration' => 'Test transfer'
        ]);
    }
}