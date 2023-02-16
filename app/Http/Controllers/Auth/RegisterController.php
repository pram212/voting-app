<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
            'phone' => ['required'],
            'province_id' => [Rule::requiredIf($request->role == 2)],
            'regency_id' => [Rule::requiredIf($request->role == 2)],
            'district_id' => [Rule::requiredIf($request->role == 2)],
            'village_id' => [Rule::requiredIf($request->role == 2)], 
        ])->validated();
    }

}
