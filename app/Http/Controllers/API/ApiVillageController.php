<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\VillageCollection;
use App\Models\Village;
use Illuminate\Http\Request;

class ApiVillageController extends Controller
{
    public function selectDesa()
    {
        $results = Village::when(request('term'), function ($query) {
                return $query->where('name', 'like', '%' . request('term') . '%');
            })
            ->when(request('district_id'), function ($query) {
                return $query->where('district_id', request('district_id') );
            })
            ->limit(30)
            ->get();

        return new VillageCollection($results);
    }
}
