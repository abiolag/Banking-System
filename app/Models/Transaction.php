<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_ref',
        'user_id',
        'type',
        'amount',
        'balance_before',
        'balance_after',
        'description',
        'status',
        'recipient_account_number',
        'recipient_routing_number',
        'recipient_bank_name',
        'recipient_name',
        'swift_code',
        'iban',
        'narration',
        // Add these new fields:
        'transfer_type',
        'bank_name',
        'bank_country',
        'bank_address',
        'intermediary_bank',
        'token',
        'token_expires_at',
        'approved_by',
        'approved_at',
        'rejected_by', 
        'rejected_at',
        'rejection_reason',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'balance_before' => 'decimal:2',
        'balance_after' => 'decimal:2',
        'created_at' => 'datetime',
        'token_expires_at' => 'datetime'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeTransfers($query)
    {
        return $query->where('type', 'transfer');
    }

    public function scopeWireTransfers($query)
    {
        return $query->where('type', 'wire_transfer');
    }

    // Helper Methods
    public function generateTransactionRef()
    {
        return 'ARK' . date('YmdHis') . rand(1000, 9999);
    }

    public function getFormattedAmountAttribute()
    {
        return '$' . number_format($this->amount, 2);
    }

    public function isTransfer()
    {
        return $this->type === 'transfer';
    }

    public function isWireTransfer()
    {
        return $this->type === 'wire_transfer';
    }

    public function isDomesticTransfer()
    {
        return $this->isTransfer() && empty($this->swift_code);
    }

    public function isInternationalTransfer()
    {
        return $this->isWireTransfer() || !empty($this->swift_code);
    }

    // Token-related methods
    public function isTokenValid()
    {
        return $this->token && $this->token_expires_at && $this->token_expires_at->isFuture();
    }

    public function isTokenExpired()
    {
        return $this->token_expires_at && $this->token_expires_at->isPast();
    }
}