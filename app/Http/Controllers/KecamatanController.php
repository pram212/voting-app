<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDistrictRequest;
use App\Http\Requests\UpdateDistrictRequest;
use Illuminate\Http\Request;
use App\Models\District;
use Exception;
use Illuminate\Support\Facades\DB;
use DataTables;

class KecamatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', District::class);

        if (request()->ajax()) {
            
            $model = District::query()->with('regency.province');

            return DataTables::of($model)
                ->addColumn('action', function ($model) {
                    $detil = '<a href="' . url('kecamatan/' . $model->id) . '/edit" class="btn btn-warning btn-sm" >Edit</a>';
                    $buttonDelete = '<button type="button" class="btn btn-danger btn-delete btn-sm">Hapus</button>';
                    return '<div class="btn-group">' . $detil . $buttonDelete . '</div>';
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        return view('kecamatan.index_kecamatan');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', District::class);

        return view('kecamatan.form_kecamatan');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorekecamatanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDistrictRequest $request)
    {

        $this->authorize('create', District::class);

        $id = District::max('id');
        
        $kecamatan = District::create([
            'id' => $id + 1,
            'name' => strtoupper($request->name),
            'regency_id' => $request->regency_id,
        ]);
    
        $message = [
            'success' => $kecamatan->name .= 'berhasil disimpan'
        ];

        return back()->with($message);
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\kecamatan  $kecamatan
     * @return \Illuminate\Http\Response
     */
    public function show(District $kecamatan)
    {
        $this->authorize('view', $kecamatan);

        return view('kecamatan.show_kecamatan', compact('kecamatan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\kecamatan  $kecamatan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kecamatan = District::find($id);

        $this->authorize('update', $kecamatan);

        return view('kecamatan.form_kecamatan', compact('kecamatan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatekecamatanRequest  $request
     * @param  \App\Models\kecamatan  $kecamatan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDistrictRequest $request, $id)
    {
        
        $kecamatan = District::findOrFail($id);

        $this->authorize('update', $kecamatan);

        try {
            DB::beginTransaction();

            $request->merge(['name' => strtoupper($request->name)]);

            $kecamatan->update($request->all());

            DB::commit();

            $message = [
                'success' => $kecamatan->nama .= 'berhasil diupdate'
            ];

            return back()->with($message);

        } catch (Exception $ex) {

            DB::rollBack();

            return back()->with('failed', $ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\kecamatan  $kecamatan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $kecamatan = District::findOrFail($id);

            $this->authorize('delete', $kecamatan);

            $kecamatan->delete();

            DB::commit();

            return response()->json('data berhasil dihapus', 200);

        } catch (Exception $ex) {

            DB::rollBack();

            return response()->json($ex->getMessage(), 422);
        }
    }
}
