<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
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
        'routing_number',
        'is_admin',
        'daily_limit',
        'max_transaction',
        'daily_transferred',
        'last_transaction_date',
        'google_id',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'ssn'
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'is_admin' => 'boolean',
            'password' => 'hashed',
            'balance' => 'decimal:2',
            'date_of_birth' => 'date',
            'daily_limit' => 'decimal:2',
            'max_transaction' => 'decimal:2',
            'daily_transferred' => 'decimal:2',
        ];
    }

    // Relationships
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function sentTransfers()
    {
        return $this->hasMany(Transaction::class, 'user_id')->where('type', 'transfer');
    }

    // Helper Methods
    public function generateAccountNumber()
    {
        do {
            $accountNumber = (string) rand(10000000, 99999999);
        } while (self::where('account_number', $accountNumber)->exists());

        return $accountNumber;
    }

    public function generateRoutingNumber()
    {
        return '0' . rand(10000000, 39999999);
    }

    public function getFormattedBalanceAttribute()
    {
        return '$' . number_format($this->balance, 2);
    }

    public function getFormattedAddressAttribute()
    {
        if (!$this->address || !$this->city || !$this->state) {
            return 'Address not complete';
        }
        
        return "{$this->address}, {$this->city}, {$this->state} {$this->zip_code}";
    }

    public function canTransact($amount)
    {
        return $this->status === 'active' && $this->balance >= $amount;
    }

    public function isUSBased()
    {
        return $this->country === 'US';
    }

    public function isUKBased()
    {
        return $this->country === 'GB';
    }

    // NEW: Transfer limit methods with admin exclusion
    public function canTransfer($amount)
    {
        // Admins have no limits
        if ($this->is_admin) {
            return ['success' => true];
        }

        // Reset daily counter if it's a new day
        if ($this->last_transaction_date != today()->toDateString()) {
            $this->update([
                'daily_transferred' => 0,
                'last_transaction_date' => today()
            ]);
            $this->refresh(); // Reload the model to get updated values
        }

        // Check transaction limit
        if ($amount > $this->max_transaction) {
            return [
                'success' => false,
                'message' => "Transaction amount exceeds your per-transaction limit of $" . number_format($this->max_transaction, 2)
            ];
        }

        // Check daily limit
        if (($this->daily_transferred + $amount) > $this->daily_limit) {
            return [
                'success' => false,
                'message' => "This transaction would exceed your daily limit of $" . number_format($this->daily_limit, 2) . 
                            ". Remaining today: $" . number_format($this->daily_limit - $this->daily_transferred, 2)
            ];
        }

        // Check sufficient balance
        if ($amount > $this->balance) {
            return [
                'success' => false,
                'message' => "Insufficient balance. Available: $" . number_format($this->balance, 2)
            ];
        }

        return ['success' => true];
    }

    public function updateTransferStats($amount)
    {
        // Don't track limits for admins
        if ($this->is_admin) {
            return;
        }

        $this->update([
            'daily_transferred' => $this->daily_transferred + $amount,
            'last_transaction_date' => today()
        ]);
    }

    // Helper to get remaining daily limit
    public function getRemainingDailyLimitAttribute()
    {
        // Admins have unlimited transfers
        if ($this->is_admin) {
            return 'Unlimited';
        }

        if ($this->last_transaction_date != today()->toDateString()) {
            return $this->daily_limit;
        }
        return $this->daily_limit - $this->daily_transferred;
    }

    // Helper to check if user has limits
    public function getHasTransferLimitsAttribute()
    {
        return !$this->is_admin;
    }

    // Add this method to your User model
    public function updateLastActivity()
    {
        $this->update([
            'last_activity_at' => now(),
            'last_login_ip' => request()->ip()
        ]);
    }

    public function getLastLoginAttribute()
    {
        return $this->last_activity_at ? $this->last_activity_at->diffForHumans() : 'Never';
    }
}