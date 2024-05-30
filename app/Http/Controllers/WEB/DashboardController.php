<?php

namespace App\Http\Controllers\WEB;

use App\Events\GateOpened;
use App\Models\QR;
use Carbon\Carbon;
use App\Models\Pengguna;
use App\Models\AccessLog;
use Illuminate\Http\Client\Request;
use App\Http\Controllers\Controller;
use App\Models\Biaya;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class DashboardController extends Controller
{
    public function index()
    {
   

        $penggunacount = Pengguna::count();
        $jumlah_masuk = AccessLog::whereNotNull('time_masuk')->count();
        $jumlah_keluar = AccessLog::whereNotNull('time_keluar')->count();
        $prefix = Auth::user()->role === 'admin' ? 'admin.' : 'manajemen.';   
        return view($prefix. 'dashboard.index2', ['pengguna_count'=> $penggunacount, 'jumlah_masuk'=>$jumlah_masuk, 
        'jumlah_keluar'=>$jumlah_keluar]);

    }

    public function search(Request $request)
    {
        $pengguna = $request->qrcode();
        $qrcode = QR::find($pengguna);
    }

    public function getCurrentTime(){
        return response()->json(['time'=>now()]);
    }

    public function transaksi(){
        $date = Carbon::now();
        $pendapatan = Biaya::whereDate('created_at', $date)->get();
        $totalpendapatan = 0;
        foreach ($pendapatan as $p){
            $totalpendapatan += $p->biaya;
        }

        //transaksi
        $transaksiCount = AccessLog::whereNotNull('time_masuk')
        ->whereNotNull('time_keluar')->whereDate('date', $date)
        ->count();
        return response()->json([
            'totalPendapatan' => $totalpendapatan,
            'transaksi' => $transaksiCount,
        ]);
    }

    public function getChartData(){

        $startDate = Carbon::now()->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        $accessLogs = AccessLog::whereNotNull('date')->whereBetween('date', [$startDate,$endDate])->get();

        //data masuk
        $data = $accessLogs->groupBy(function($item){
            return Carbon::parse($item->time_masuk)->format('H:00');
        })->map(function($group){
            return $group->count();
        });

        $labelsAccessLog = $data->keys();
        $jumlahMasuk = $data->values();
        
        //data pembayaran
        $startDatePayments = Carbon::now()->startOfMonth();
        $endDatePayments = Carbon::now()->endOfMonth();
    
        $payments = Biaya::whereBetween('created_at', [$startDatePayments, $endDatePayments])->get();
    
        $dataPayments = $payments->groupBy(function($item){
            return Carbon::parse($item->created_at)->format('Y-m-d');
        })->map(function($group){
            return $group->sum('biaya');
        });
    
        $labelsPayments = $dataPayments->keys();
        $paymentsCount = $dataPayments->values();
    
        return response()->json([
            'labels_access_log' => $labelsAccessLog,
            'jumlah_masuk' => $jumlahMasuk,
            'labels_payments' => $labelsPayments,
            'payments' => $paymentsCount,
        ]);
    }
    

    public static function slot()
    {
        $slotTersedia = "100";
        $countIn = AccessLog::whereDate('date', now())->whereNotNull('time_masuk')->count();
        $countOut = AccessLog::whereDate('date', now())->whereNotNull('time_keluar')->count();
        $slotNow = $slotTersedia - ($countIn - $countOut);

        return response()->json(["slot" => $slotNow]);
    }
}
