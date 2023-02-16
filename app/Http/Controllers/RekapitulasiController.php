<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRekapitulasiRequest;
use App\Models\Rekapitulasi;
use DataTables;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RekapitulasiController extends Controller
{
    public function index()
    {

        if (request()->ajax()) {
            
            $model = Rekapitulasi::query()
                        ->with(['calonPejabat.jabatan', 'provinsi', 'kota', 'kecamatan', 'desa', 'user'])
                        ->when(request('calon_pejabat_id') != null , function($query) {
                            return $query->where('calon_pejabat_id', request('calon_pejabat_id'));
                        })
                        ->when(request('province_id') != null, function($query) {
                            return $query->where('province_id', request('province_id'));
                        })
                        ->when(request('regency_id') != null, function($query) {
                            return $query->where('regency_id', request('regency_id'));
                        })
                        ->when(request('district') != null, function($query) {
                            return $query->where('district', request('district'));
                        })
                        ->when(request('village_id') != null, function($query) {
                            return $query->where('village_id', request('village_id'));
                        })
                        ->when(request('user_id') != null, function($query) {
                            return $query->where('user_id', request('user_id'));
                        })
                        ;
            
            return DataTables::of($model)
                ->addIndexColumn()
                ->addColumn('action', function ($model) {
                    return 'no action';
                    $detil = '<a href="' . url('jabatan/' . $model->id) . '/edit" class="btn btn-warning btn-sm" >Edit</a>';
                    $buttonDelete = '<button type="button" class="btn btn-danger btn-delete btn-sm">Hapus</button>';
                    return '<div class="btn-group">' . $detil . '</div>';
                })
                ->addColumn('jabatan', function($model) {
                    return @$model->calonPejabat->jabatan->nama;
                })
                ->editColumn('created_at', function($model) {
                    return date('d/m/Y', strtotime(@$model->created_at));
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
