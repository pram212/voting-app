<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Http\Resources\ProviceCollection;

class ApiProvinceController extends Controller
{
    public function selectProvinsi()
    {
        $results = Province::when(request('term'), function ($query) {
            return $query->where('name', 'like', '%' . request('term') . '%');
        })
            ->limit(30)
            ->get();

        return new ProviceCollection($results);
    }
}
