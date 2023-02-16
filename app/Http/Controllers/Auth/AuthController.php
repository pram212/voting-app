<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function index()
    {
        return view('Auth.Login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'phone' => ['required', 'numeric'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {

            $session = DB::table('sessions')->where('user_id', auth()->id())->first();

            if ($session) {
                Auth::logout();
                return back()->with([
                    'loginError' => "akun telah digunakan"
                ]);
            } 
            
            $request->session()->regenerate();

            return redirect()->intended('/home');
          

        }

        return back()->with([
            'loginError' => 'Login Gagal !',
        ]);
    }

    public function logout(Request $request)
    {

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
