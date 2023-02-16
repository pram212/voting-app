<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Http\Request;

class ApiUserController extends Controller
{
    public function selectUser()
    {
        $results = User::when(request('term'), function ($query) {
            return $query->where('name', 'like', '%' . request('term') . '%');
        })
            ->limit(30)
            ->get();

        return new UserCollection($results);
    }
}
