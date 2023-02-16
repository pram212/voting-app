<?php

namespace App\Http\Controllers;

use App\Models\TPS;
use App\Http\Requests\StoreTPSRequest;
use App\Http\Requests\UpdateTPSRequest;
use DataTables;
use Illuminate\Support\Facades\DB;

class TPSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            
            $model = TPS::query()
                        ->with([ 'provinsi', 'kota', 'kecamatan', 'desa'])
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
                        });
            
            return DataTables::of($model)
                ->addIndexColumn()
                ->addColumn('action', function ($model) {
                    $buttonEdit = '<a href="' . url('tps/' . $model->id) . '/edit" class="btn btn-warning btn-sm" >Edit</a>';
                    $buttonDelete = '<button type="button" class="btn btn-danger btn-delete btn-sm">Hapus</button>';
                    return '<div class="btn-group">' . $buttonEdit .  $buttonDelete . '</div>';
                })
                ->editColumn('created_at', function($model) {
                    return date('d/m/Y', strtotime(@$model->created_at));
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        return view('tps.index_tps');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tps.form_tps');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTPSRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTPSRequest $request)
    {
        try {
            DB::beginTransaction();

            TPS::create($request->all());

            DB::commit();

            $message = [
                'success' => 'TPS berhasil disimpan'
            ];

            return back()->with($message);

        } catch(Exception $ex) {

            DB::rollBack();

            return back()->with('failed', $ex->getMessage());
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TPS  $tPS
     * @return \Illuminate\Http\Response
     */
    public function show(TPS $tPS)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TPS  $tPS
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tps = TPS::findOrFail($id);

        return view('tps.form_tps', compact('tps'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTPSRequest  $request
     * @param  \App\Models\TPS  $tPS
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTPSRequest $request, $id)
    {

        $tps = TPS::findOrFail($id);

        try {
            DB::beginTransaction();

            $tps->update($request->all());

            DB::commit();

            $message = [
                'success' => 'TPS berhasil diubah'
            ];

            return back()->with($message);

        } catch(Exception $ex) {

            DB::rollBack();

            return back()->with('failed', $ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TPS  $tPS
     * @return \Illuminate\Http\Response
     */
    public function destroy(TPS $tPS)
    {
        //
    }
}
