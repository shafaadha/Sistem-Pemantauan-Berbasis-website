<?php

namespace App\Http\Controllers\WEB;

use Carbon\Carbon;
use App\Models\Biaya;
use App\Models\AccessLog;
use App\Models\ConfigHarga;
use Illuminate\Http\Request;
use GuzzleHttp\Promise\Create;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BiayaParkirController extends Controller
{
    public static function processPayment($accessLogId)
    {
        // Ambil data access log dari database
        $parkirConfig = ConfigHarga::find(1);
        $accessLog = AccessLog::find($accessLogId);
    
        if ($accessLog !== null) {
            // Konversi waktu masuk dan waktu keluar ke objek Carbon
            $time_masuk = new Carbon($accessLog->time_masuk);
            $time_keluar = new Carbon($accessLog->time_keluar);
            
            // Hitung durasi dalam jam
            $duration = $time_masuk->diffInHours($time_keluar);
    
            // Jika durasi adalah 0, atur durasi menjadi 1
            if ($duration == 0) {
                $duration = 1;
            }
            
            // Inisialisasi harga awal
            $price = $parkirConfig->harga_jam_pertama;
            
            // Jika durasi melebihi 1 jam, tambahkan harga untuk jam-jam tambah
            if ($duration > 1) {
                $price += ($duration - 1) * $parkirConfig->harga_per_jam;
            }
    
            $existingPayment = Biaya::where('log_id', $accessLogId)->first();
            if ($existingPayment !== null) {
                if ($accessLog->time_keluar !== null) {
                    $existingPayment->biaya = $price;
                    $existingPayment->save();
                }
            } else {
                $payment = Biaya::create([
                    'log_id' => $accessLogId,
                    'biaya' => $price,
                ]);
            }
        }
    }
    
    public function index(){
        $payments = Biaya::orderBy('created_at', 'desc')->paginate(10);
        $prefix = Auth::user()->role === 'admin' ? 'admin.' : 'manajemen.';
        return view($prefix. 'pembayaran.index', ['payments' => $payments]);
    }

    public function paymentsNow(){
        $paymentNow = Biaya::whereDate('created_at', today())->orderBy('created_at', 'desc')->paginate(10);
        $prefix = Auth::user()->role === 'admin' ? 'admin.' : 'manajemen.';
        return view($prefix. 'pembayaran.index', ['payments' => $paymentNow]);
    }

    
}
