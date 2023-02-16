<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\JabatanCollection;
use App\Models\Jabatan;
use Illuminate\Http\Request;

class ApiJabatanController extends Controller
{
    public function selectJabatan(Request $request)
    {
        $results = Jabatan::when(request('term'), function ($query) {
                return $query->where('nama', 'like', '%' . request('term') . '%');
            })
            ->limit(30)
            ->get();

        return new JabatanCollection($results);
    }
}
