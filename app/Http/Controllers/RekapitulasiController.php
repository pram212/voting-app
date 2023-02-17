<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRekapitulasiRequest;
use App\Models\Rekapitulasi;
use App\Models\TPS;
use DataTables;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RekapitulasiController extends Controller
{
    public function index()
    {

        if (request()->ajax()) {
            
            $model = TPS::query()
                        ->with(['calon', 'provinsi', 'kota', 'kecamatan', 'desa'])
                        ->where('village_id', auth()->user()->village_id);
            
            return DataTables::of($model)
                ->addIndexColumn()
                ->addColumn('action', function ($model) {
                    $detil = '<a href="' . url('rekapitulasi/' . $model->id) . '/edit" class="btn btn-success btn btn-edit" >Entry</a>';
                    return '<div class="btn-group">' . $detil . '</div>';
                })
                ->addColumn('total_suara', function($model) {
                    return number_format($model->calon->sum('pivot.jumlah_suara'));
                })
                ->rawColumns(['action'])
                ->toJson();

        }

        return view('rekapitulasi.index_rekapitulasi');
    }

    public function create()
    {
        return view('rekapitulasi.create_rekapitulasi');
    }

    public function store(StoreRekapitulasiRequest $request)
    {
        
        try {
            DB::beginTransaction();

            $request->merge([
                'user_id' => auth()->id()
            ]);

            $jabatan = Rekapitulasi::create($request->all());

            DB::commit();

            $message = [
                'success' => 'hasil TPS berhasil disimpan'
            ];

            return back()->with($message);

        } catch(Exception $ex) {

            DB::rollBack();

            return back()->with('failed', $ex->getMessage());
        }
    }
}
