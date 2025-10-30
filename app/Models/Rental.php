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
        'catatan'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'tanggal_pengembalian_aktual' => 'datetime',
        'total_harga' => 'decimal:2',
        'denda' => 'decimal:2',
    ];

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

    /**
     * Get rental duration in days
     */
    public function getDurasiAttribute()
    {
        return $this->tanggal_mulai->diffInDays($this->tanggal_selesai) + 1;
    }

    /**
     * Check if rental is overdue
     */
    public function isOverdue()
    {
        if ($this->status !== 'active') {
            return false;
        }
        return now()->greaterThan($this->tanggal_selesai);
    }

    /**
     * Get overdue days
     */
    public function getHariTerlambatAttribute()
    {
        if (!$this->isOverdue()) {
            return 0;
        }
        return now()->diffInDays($this->tanggal_selesai);
    }

    /**
     * Calculate penalty/denda
     */
    public function calculateDenda()
    {
        if (!$this->isOverdue()) {
            return 0;
        }

        $hariTerlambat = $this->hari_terlambat;
        $dendaPerHari = $this->genset->harga_sewa * 2; // 2x harga sewa per hari
        
        return $hariTerlambat * $dendaPerHari;
    }

    /**
     * Get total payment including penalty
     */
    public function getTotalPembayaranAttribute()
    {
        return $this->total_harga + $this->denda;
    }
}