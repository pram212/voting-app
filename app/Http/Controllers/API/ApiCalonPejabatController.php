<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CalonPejabatCollection;
use App\Models\CalonPejabat;

class ApiCalonPejabatController extends Controller
{
    public function selectCalon()
    {
        $results = CalonPejabat::when(request('term'), function ($query) {
            return $query->where('nama', 'like', '%' . request('term') . '%');
        })
            ->limit(100)
            ->get();

        return new CalonPejabatCollection($results);
    }
}
