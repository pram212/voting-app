<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use function GuzzleHttp\Promise\all;

class RegisterController extends Controller
{
    public function index() 
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'nama' => ['required'],
            'phone' => ['required', 'unique:users'],
            'province_id' => ['required'],
            'regency_id' => ['required'],
            'password' => ['required'],
            'district_id' => ['required'],
            'village_id' => ['required'], 
        ])->validated();

            
        $request->merge([
            'role' => 2,
            'password' => Hash::make($request->password)
        ]);

        $user = User::create($request->all());

        auth()->login($user);

        return redirect('/home');

    }

}
