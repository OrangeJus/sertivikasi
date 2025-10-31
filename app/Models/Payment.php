<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'rental_id', 
        'payment_date', 
        'amount', 
        'payment_method', 
        'payment_proof', 
        'payment_status',
        'payment_type',
        'verified_by',
        'verified_at',
        'rejection_reason'
    ];

    protected $casts = [
        'payment_date' => 'datetime',
        'verified_at' => 'datetime',
        'amount' => 'decimal:2',
    ];

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // Scopes
    public function scopeRentalPayment($query)
    {
        return $query->where('payment_type', 'rental');
    }

    public function scopePenaltyPayment($query)
    {
        return $query->where('payment_type', 'penalty');
    }

    public function scopePending($query)
    {
        return $query->where('payment_status', 'pending');
    }

    public function scopeVerified($query)
    {
        return $query->where('payment_status', 'paid')
            ->whereNotNull('verified_by');
    }
}