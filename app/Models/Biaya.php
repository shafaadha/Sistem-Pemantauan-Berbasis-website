<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Action;

class Biaya extends Model
{
    use HasFactory;
    public $timestamps = true;

    protected $fillable = ['biaya','log_id'];

    public function pembayaran()
    {
        return $this->belongsTo(AccessLog::class, 'log_id');
    }
}
