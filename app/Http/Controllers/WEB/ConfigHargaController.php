<?php

namespace App\Http\Controllers\WEB;

use App\Models\ConfigHarga;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ConfigHargaController extends Controller
{

    public function form()
    {
        $parkirConfig = ConfigHarga::findOrFail(1);
        $harga = ConfigHarga::all();
        
        $prefix = Auth::user()->role === 'admin' ? 'admin.' : 'manajemen.';
        return view($prefix. '.harga.update', ['harga' => $harga]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'harga_jam_pertama' => 'nullable|numeric', 
            'harga_per_jam' => 'nullable|numeric', 
            'harga_menit_pertama' => 'nullable|numeric', 
            'harga_per_menit' => 'nullable|numeric', 
        ]);
    
        $parkirConfig = ConfigHarga::findOrFail(1);
    
        // Retrieve the current values of the fields from the database
        $currentValues = $parkirConfig->only([
            'harga_jam_pertama', 
            'harga_per_jam', 
            'harga_menit_pertama',
            'harga_per_menit',
        ]);
    
        // Filter out the null or empty values from the request
        $requestData = array_filter($request->only([
            'harga_jam_pertama', 
            'harga_per_jam', 
            'harga_menit_pertama', 
            'harga_per_menit', 
        ]));
    
        // Merge the current values with the non-empty request data
        $mergedData = array_merge($currentValues, $requestData);
    
        // Update the model with the merged data
        $parkirConfig->update($mergedData);
        
        $prefix = Auth::user()->role === 'admin' ? 'admin.' : 'manajemen.';
        if ($parkirConfig->wasChanged()) {
            return redirect()->route($prefix. 'updateharga')->with('success', 'Harga telah diperbarui');
        } else {
            return redirect()->route($prefix. 'updateharga')->with('info', 'Tidak ada perubahan yang diperlukan');
        }
    }
    
    
    


}

