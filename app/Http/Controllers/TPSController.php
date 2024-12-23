<?php

namespace App\Http\Controllers;

use App\Models\TPS;
use App\Http\Requests\StoreTPSRequest;
use App\Http\Requests\UpdateTPSRequest;
use App\Models\Calon;
use App\Models\Rekapitulasi;
use DataTables;
use Exception;
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
        $this->authorize('viewAny', TPS::class);

        if (request()->ajax()) {
            
            $model = TPS::query()
                        ->when(request('province_id') != null, function($query) {
                            return $query->where('province_id', request('province_id'));
                        })
                        ->when(request('regency_id') != null, function($query) {
                            return $query->where('regency_id', request('regency_id'));
                        })
                        ->when(request('district_id') != null, function($query) {
                            return $query->where('district_id', request('district_id'));
                        })
                        ->when(request('village_id') != null, function($query) {
                            return $query->where('village_id', request('village_id'));
                        });
            
            return DataTables::of($model)
                ->addIndexColumn()
                ->editColumn('role', function ($model) {
                    return $model->role == 1 ? "admin" : "model";
                })
                ->addColumn('provinsi', function ($model) {
                    return $model->provinsi? $model->provinsi->name : "-";
                })
                ->addColumn('kota', function ($model) {
                    return $model->kota ? $model->kota->name : '-';
                })
                ->addColumn('kecamatan', function ($model) {
                    return $model->kecamatan? $model->kecamatan->name: '-';
                })
                ->addColumn('desa', function ($model) {
                    return $model->desa ? $model->desa->name : '-';
                })
                ->addColumn('action', function ($model) {
                    $buttonEdit = '<a href="' . url('pengaturan/tps/' . $model->id) . '/edit" class="btn btn-info" >Edit</a>';
                    $buttonDelete = '<button type="button" class="btn btn-danger btn-delete">Hapus</button>';
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
        $this->authorize('create', TPS::class);

        return view('tps.create_tps');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTPSRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTPSRequest $request)
    {

        $this->authorize('create', TPS::class);

        DB::beginTransaction();

        $tps = TPS::create($request->all());

        $calon = Calon::pluck('id');

        $tps->calon()->syncWithPivotValues($calon, [
            'province_id' => $tps->province_id,
            'regency_id' => $tps->regency_id,
            'district_id' => $tps->district_id,
            'village_id' => $tps->village_id,
        ]);

        DB::commit();

        return response()->json('data berhasil disimpan', 200);

        $message = [
            'success' => 'TPS berhasil disimpan'
        ];

        return back()->with($message);

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

        $this->authorize('update', $tps);

        return view('tps.edit_tps', compact('tps'));
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

        $this->authorize('update', $tps);

        try {
            DB::beginTransaction();

            $tps->update($request->all());

            DB::commit();

            $message = [
                'success' => 'TPS berhasil diubah'
            ];

            return redirect('pengaturan/tps')->with($message);

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
    public function destroy($id)
    {
        $tps = TPS::find($id);

        $this->authorize('delete', $tps);

        try {
            DB::beginTransaction();

            $tps->calon()->detach();

            $tps->delete();

            DB::commit();

            return response()->json('data berhasil dihapus', 200);

        } catch (Exception $ex) {

            DB::rollBack();

            return response()->json($ex->getMessage(), 422);
        }
    }
}
