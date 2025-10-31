<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Rental extends Model
{
    protected $fillable = [
        'user_id', 
        'genset_id', 
        'tanggal_mulai', 
        'tanggal_selesai', 
        'total_harga', 
        'denda',
        'hari_keterlambatan',
        'tanggal_pengembalian_aktual',
        'status', 
        'catatan',
        'status_pengembalian',
        'tanggal_request_pengembalian',
        'catatan_pengembalian_user',
        'catatan_pengembalian_admin',
        'denda_dibayar',
        'tanggal_bayar_denda',
        'bukti_bayar_denda',
        'denda_verified_by',
        'denda_verified_at'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'tanggal_pengembalian_aktual' => 'datetime',
        'tanggal_request_pengembalian' => 'datetime',
        'tanggal_bayar_denda' => 'datetime',
        'denda_verified_at' => 'datetime',
        'total_harga' => 'decimal:2',
        'denda' => 'decimal:2',
        'denda_dibayar' => 'boolean',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function genset()
    {
        return $this->belongsTo(Genset::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function penaltyPayments()
    {
        return $this->hasMany(Payment::class)->where('payment_type', 'penalty');
    }

    public function pendingPenaltyPayment()
    {
        return $this->hasOne(Payment::class)
            ->where('payment_type', 'penalty')
            ->where('payment_status', 'pending');
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'denda_verified_by');
    }

    // Attributes
    public function getDurasiAttribute()
    {
        return $this->tanggal_mulai->diffInDays($this->tanggal_selesai) + 1;
    }

    public function getTotalPembayaranAttribute()
    {
        return $this->total_harga + $this->denda;
    }

    // Business Logic Methods
    public function isOverdue()
    {
        if ($this->status !== 'active') {
            return false;
        }
        return now()->greaterThan($this->tanggal_selesai->endOfDay());
    }

    public function getOverdueDays()
    {
        if (!$this->isOverdue()) {
            return 0;
        }
        
        // Hitung dari tanggal selesai sampai sekarang (absolute)
        return (int) $this->tanggal_selesai->endOfDay()->diffInDays(now()->startOfDay());
    }

    public function calculatePenaltyAmount()
    {
        if (!$this->isOverdue()) {
            return 0;
        }

        $overdueDays = $this->getOverdueDays();
        $penaltyPerDay = $this->genset->harga_sewa * 2;
        
        return $overdueDays * $penaltyPerDay;
    }

    public function isPenaltyPaidAndVerified()
    {
        return $this->denda_dibayar && 
               $this->denda_verified_by !== null && 
               $this->denda_verified_at !== null;
    }

    public function hasPendingPenaltyPayment()
    {
        return $this->penaltyPayments()
            ->where('payment_status', 'pending')
            ->exists();
    }

    public function canRequestReturn()
    {
        // Must be active
        if ($this->status !== 'active') {
            return false;
        }

        // Cannot request if already requested
        if ($this->status_pengembalian === 'diminta') {
            return false;
        }

        // If overdue, penalty must be paid and verified
        if ($this->isOverdue()) {
            return $this->isPenaltyPaidAndVerified();
        }

        return true;
    }

    public function calculateDenda()
    {
        return $this->calculatePenaltyAmount();
    }

    public function canUploadPenaltyProof()
    {
        // Must be active and overdue
        if ($this->status !== 'active' || !$this->isOverdue()) {
            return false;
        }

        // Cannot upload if already verified
        if ($this->isPenaltyPaidAndVerified()) {
            return false;
        }

        // Cannot upload if there's pending payment
        if ($this->hasPendingPenaltyPayment()) {
            return false;
        }

        return true;
    }
}