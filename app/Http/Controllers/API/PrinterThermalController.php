<?php

namespace App\Http\Controllers;

use App\Models\Biaya;
use Illuminate\Http\Request;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class PrinterThermalController extends Controller
{
    public function index(){
        return view('print-view');
    }

    public function print($accessLogId){
        try{
            $existingPayment = Biaya::where('log_id', $accessLogId)->first();
            if (!$existingPayment) {
                return back()->with('danger', 'Data pembayaran tidak ditemukan');
            }

            $biaya = $existingPayment->biaya;
            $connector = new WindowsPrintConnector("Nama Printer");

            $printer = new Printer($connector);
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setTextSize(1, 2);
            $printer->setEmphasis(true);
            $printer->text("Rp $biaya\n");
            $printer->setTextSize(1,1);
            $printer->setEmphasis(false);
            $printer->text("Rp " . number_format($biaya, 0, ',', '.') . "\n");
            $printer->text("-----------------------------\n");
            $printer->text("Parkir Online");
            $printer->feed();
            $printer->cut();
            $printer->close();
            return back()->with('success', 'Tulisan berhasil dicetak');
        }
        catch(\Exception $e){
            return back()->with('danger', 'Gagal dicetak:'. $e->getMessage());
        }
    }
    
}
