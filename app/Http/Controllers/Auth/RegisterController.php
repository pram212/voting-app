<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function index() 
    {
        return "fomr register";
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'nama' => ['required'],
            'email' => ['required', 'email'],
            'phone' => ['required']
        ])->validated();
    }

}
