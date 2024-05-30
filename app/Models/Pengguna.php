<?php

namespace App\Models;

use App\Models\QR;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengguna extends Model
{
    use HasFactory;
    protected $table = 'penggunas';
    protected $fillable = ['nim', 'name', 'phone_number', 'jurusan', 'alamat', 'orang_tua'];
    public function getRouteKeyName(){
        return'nim';
    }

    public function qrcode()
    {
        return $this->hasOne(QR::class);
    }      

    public function hasQRCode()
    {
        return $this->qrcode()->exists();
    }
}
