<?php

namespace App\Models;

use App\Models\QR;
use App\Models\Scanplat;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\WEB\BiayaParkirController;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccessLog extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = ['q_r_id','plat_id','code', 'no_plat', 'date', 'time_masuk', 'time_keluar', 'status_in', 'status_out'];

    //relation to qr code
    public function qrcode()
    {
        return $this->belongsTo(QR::class, 'q_r_id');
    }

    function peristiwa(){
		return $this->hasOne(Scanplat::class, 'log_id');
	}

    function biaya(){
        return $this->hasOne(Biaya::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($accessLog) {
            $biayaController = new BiayaParkirController();
            $biayaController->processPayment($accessLog->id);
        });
    }

}
