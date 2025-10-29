<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['nama_kategori','deskripsi'];

    public function gensets()
    {
        return $this->belongsToMany(Genset::class, 'category_genset');
    }
}
