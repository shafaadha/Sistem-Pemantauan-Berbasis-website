<?php

namespace App\Http\Controllers\API;

use App\Models\QR;
use Carbon\Carbon;
use App\Models\Biaya;
use App\Models\Scanplat;
use App\Models\AccessLog;
use App\Models\ConfigHarga;
use Illuminate\Http\Request;
use App\Events\GateNotification;
use App\Http\Controllers\Controller;

class ValidationController extends Controller
{
    public function scanIn(Request $request){
        $validated = $request->validate([
            'code' => 'required',
        ]);

        //cek QR
        $cekqr = QR::where('code', $validated['code'])->first();
        $date = Carbon::now();

        //cek qr tamu atau mahasiswa
        if($cekqr){
            $kategori = $cekqr->kategori;

            $validasiqr = AccessLog::create([
                'q_r_id'=>$cekqr->id,
                'code'=>$cekqr->code,
                'no_plat'=>$cekqr->no_plat,
                'date'=> $date->toDateString(),
                'status_in'=> 'Valid QR Code',
                'time_masuk'=>$date->toTimeString(),
            ]) ;

            return response()->json([
                'status'=>'success', 'message'=> 'Valid QR', 'log_id'=>$validasiqr->id]);
        }

        else{

            return response()->json(['status'=>"fail", 'message'=>'silahkan mendaftar']);
        }
    }

    public function scanOut(Request $request){
        $validated = $request->validate([
            'code' => 'required',
        ]);

        //cek QR di Log
        $ceklog = AccessLog::where('date', Carbon::today())
                            ->where('code', $validated['code'])
                            ->latest('time_masuk')
                            ->first();

        $accessLogId = $ceklog->id;

        $date = Carbon::now();
        if ($accessLogId === null ){
            return response()->json(['status'=>'Fail']);
        }

        //cek qr tamu atau mahasiswa
        if($ceklog){
            $date = Carbon::now();
    
            $kategori = $ceklog->kategori;
    
            // Update properti waktu keluar dan status out
            $ceklog->time_keluar = Carbon::now()->toTimeString();
            $time_masuk = Carbon::parse($ceklog->time_masuk);
            $ceklog->status_out = 'Valid QR';
            $ceklog->waktu = $time_masuk->diffInMinutes($ceklog->time_keluar);
            $ceklog->save();
    
            // Proses pembayaran
            $biaya = self::processPayment($accessLogId);
    
            return response()->json([
                'status'=>'success', 
                'message'=> 'Valid QR',
                'log_id'=> $accessLogId
            ]);
        } else {
            // Jika $ceklog null, kirim respons dengan pesan kesalahan
            return response()->json([
                'status'=>"fail", 
                'message'=>'Silahkan menggunakan QR yang benar'
            ]);
        }
    }

    public function platIn(Request $request)
    {
        $validated = $request->validate([
            'plat_masuk' =>'required',
            'gambar_in'=> 'image|nullable|file|max:1024',
            'log_id'=>'required',
        ]);

        $date = Carbon::now();

        $ceklog = AccessLog::where('id', $validated['log_id'])->first();

        $validated['gambar_in'] = $request->file('gambar_in')->store('plat-images');

        $scanplat = Scanplat::create([
            $validated['gambar_in'] = $request->file('gambar_in')->store('plat-images'),
            'log_id' => $validated['log_id'],
            'no_plat' => $ceklog->no_plat,
            'plat_masuk'=> $validated['plat_masuk'],
            'similarity_masuk'=> self::checkStringSimilarity($validated['plat_masuk'], $ceklog->no_plat),
            'gambar_in'=> $validated['gambar_in'],
            'tcek_masuk' => $ceklog->time_masuk,
            'status_in' => 'Valid QR',
            'date'=> $ceklog->date,
        ]);

        return response()->json(['status'=>'success']);
    }

    public function platOut(Request $request){
        $validated = $request->validate([
            'plat_keluar' =>'required',
            'gambar_out'=> 'image|nullable|file|max:1024',
            'log_id'=>'required',
        ]);

        $ceklog = AccessLog::where('date', Carbon::today())
                            ->where('id', $validated['log_id'])
                            ->latest('time_masuk')
                            ->first();

        $logscanplat = Scanplat::where('log_id', $validated['log_id'])->first();

        $ceklogplat = Scanplat::where('date', Carbon::today())
                                ->where ('plat_masuk', $validated['plat_keluar'])
                                ->latest('tcek_masuk')
                                ->first();

        if($ceklogplat){
            $gambarout = $validated['gambar_out'] = $request->file('gambar_out')->store('plat-images');
            $checkStringSimilarity = self::checkStringSimilarity($validated['plat_keluar'], $ceklogplat->plat_masuk);
            $logscanplat->tcek_keluar = Carbon::now()->toTimeString();
            $logscanplat->similarity_keluar = $checkStringSimilarity;
            $logscanplat->plat_keluar = $validated['plat_keluar'];
            $logscanplat->gambar_out = $gambarout;
            $logscanplat->status_out = 'Plat yang masuk dan keluar sama';
            $logscanplat->save();  
            return response()->json(['status'=>'success', 'message' => 'Kendaraan yang masuk dan keluar sama']);
        }
        elseif($ceklogplat == null){
            $gambarout = $validated['gambar_out'] = $request->file('gambar_out')->store('plat-images');
            $checkStringSimilarity = self::checkStringSimilarity($validated['plat_keluar'], $logscanplat->plat_masuk);
            $logscanplat->tcek_keluar = Carbon::now()->toTimeString();
            $logscanplat->similarity_keluar = $checkStringSimilarity;
            $logscanplat->plat_keluar = $validated['plat_keluar'];
            $logscanplat->gambar_out = $gambarout;
            $logscanplat->status_out = 'Plat yang masuk dan keluar berbeda';
            $logscanplat->save();
            $datasend = [
                'no_plat' =>$logscanplat->plat_keluar,
                'time'=>$logscanplat->tcek_keluar,
                'message' => $logscanplat->peristiwa->qrcode->pengguna->name, 'baru saja'
            ];
            event(new GateNotification($datasend));
            
            return response()->json(['status'=>'success', 'message' => 'Kendaraan yang masuk dan keluar berbeda']);

        }
    }



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

    public static function checkStringSimilarity($a, $x){
        //fungsi similarity
        $len = strlen($x);
        $similarityCount = 0;
        
        for ($i = 0; $i < $len; $i++) {
            // Pastikan indeks $i ada di dalam panjang string $x juga
            if (isset($x[$i]) && $a[$i] === $x[$i]) {
                $similarityCount++;
            } else {
                break; // Jika indeks tidak ditemukan di $x, keluar dari loop
            }
        }
        // Avoiding division by zero
        $similarityPercentage = ($similarityCount / $len) * 100 ;
        $similarityStringPercentage = strval($similarityPercentage);
        
        return $similarityStringPercentage;
    }

}
