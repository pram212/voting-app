<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\RegencyCollection;
use App\Models\Regency;
use Illuminate\Http\Request;

class ApiRegencyController extends Controller
{
    public function selectKota()
    {
        $results = Regency::when(request('term'), function ($query) {
                return $query->where('name', 'like', '%' . request('term') . '%');
            })
            ->when(request('province_id'), function ($query) {
                return $query->where('province_id', request('province_id'));
            })
            ->limit(30)
            ->get();
    
        return new RegencyCollection($results);
    }
}
