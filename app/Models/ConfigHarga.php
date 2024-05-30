<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigHarga extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['harga_jam_pertama','harga_per_jam'];
    
}
