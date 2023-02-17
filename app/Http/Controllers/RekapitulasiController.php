<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRekapitulasiRequest;
use App\Models\Rekapitulasi;
use App\Models\TPS;
use DataTables;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use tidy;

class RekapitulasiController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Rekapitulasi::class);

        if (request()->ajax()) {
            
            $model = TPS::query()
                        ->with(['calon', 'provinsi', 'kota', 'kecamatan', 'desa'])
                        ->where('village_id', auth()->user()->village_id);
            
            return DataTables::of($model)
                ->addIndexColumn()
                ->addColumn('action', function ($model) {
                    $buttonEntry = '<a href='. url('rekapitulasi/' .$model->id .'/edit') .' type="button" class="btn btn-primary btn-entry btn-sm">Entry</a>';
                    return '<div class="btn-group">' . $buttonEntry . '</div>';
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
       
    }

    public function edit($id)
    {

        DB::beginTransaction();
        
        $tps = TPS::find($id);

        $this->authorize('viewAny', Rekapitulasi::class);

        return view('rekapitulasi.create_rekapitulasi', compact('tps'));
        
    }

    public function update(Request $request, $tpsId)
    {
        
        try {
            DB::beginTransaction();

            $tps = TPS::find($tpsId);

            $calons = [];

            foreach ($request->calon_id as $key => $value) {
                $calons[$value] = [
                    "jumlah_suara" => $request->jumlah_suara[$key],
                    "keterangan" => $request->keterangan[$key] 
                ];
            }

            $tps->calon()->sync($calons);

            DB::commit();

            $message = [
                'success' => 'hasil TPS berhasil disimpan'
            ];

            return redirect('rekapitulasi')->with($message);

        } catch (\Exception $ex) {
            DB::rollBack();

            return back()->with('failed', $ex->getMessage());
        }
        
    }
    
}
