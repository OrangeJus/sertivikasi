<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genset extends Model
{
    protected $fillable = [
        'nama_genset','kapasitas','status','harga_sewa','deskripsi','image'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_genset');
    }

    public function isAvailable(): bool
    {
        return $this->status === 'tersedia';
    }
}
