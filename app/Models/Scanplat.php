<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scanplat extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = ['log_id', 'no_plat', 'gambar_in', 'gambar_out', 'date', 'tcek_masuk', 'tcek_keluar', 'status_in', 'status_out', 'similarity_masuk', 'similarity_keluar', 'plat_masuk', 'plat_keluar'];

    public function peristiwa()
    {
        return $this->belongsTo(AccessLog::class, 'log_id');
    }
}
