<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    protected $fillable = [
        'user_id', 'genset_id', 'tanggal_mulai', 'tanggal_selesai', 'total_harga', 'status', 'catatan'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'total_harga' => 'decimal:2',
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
}
