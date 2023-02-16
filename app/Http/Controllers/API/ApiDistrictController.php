<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\DistrictCollection;
use App\Models\District;
use Illuminate\Http\Request;

class ApiDistrictController extends Controller
{
    public function selectKecamatan()
    {
        $results = District::when(request('term'), function ($query) {
                return $query->where('name', 'like', '%' . request('term') . '%');
            })
            ->when(request('regency_id'), function ($query) {
                return $query->where('regency_id', request('regency_id') );
            })
            ->limit(30)
            ->get();

        return new DistrictCollection($results);
    }
}
