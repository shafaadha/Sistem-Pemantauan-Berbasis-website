<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QR extends Model
{
    use HasFactory;
    protected $table = 'q_r_s';
    protected $fillable = ['code', 'pengguna_id', 'no_plat', 'kategori'];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }
    public function plat()
    {
        return $this->hasOne(Plat::class);
    } 
}
