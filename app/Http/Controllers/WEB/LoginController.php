<?php

namespace App\Http\Controllers\WEB;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use BaconQrCode\Renderer\Path\Close;
use Closure;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
        return view('login.index',[
            'title'=>'Login'
        ]);
    }


    public function authenticate(Request $request){
        $credentials = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required'
    ]);

    $user = User::where('email', $request->email)->first();

    if(!$user) {
        return back()->with('loginError', 'Login gagal!');
    }

    if(Auth::attempt($credentials)){
        $request->session()->regenerate();
        $userRole = Auth::user()->role;

        if($userRole === 'admin'){
            return redirect()->intended('/admin/dashboard');
        }elseif($userRole === 'manajemen'){
            return redirect()->intended('/manajemen/dashboard');
        }
    }
    return redirect()->back()->with('loginError', 'Email atau password salah.');

    }

    public function logout(Request $request){
        
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');

    }

}
