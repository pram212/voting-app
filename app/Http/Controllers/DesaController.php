<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVillageRequest;
use App\Http\Requests\UpdateVillageRequest;
use Illuminate\Http\Request;
use App\Models\Village;
use Exception;
use Illuminate\Support\Facades\DB;
use DataTables;

class DesaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Village::class);

        if (request()->ajax()) {
            
            $model = Village::query();

            return DataTables::of($model)
                ->addColumn('action', function ($model) {
                    $detil = '<a href="' . url('pengaturan/desa/' . $model->id) . '/edit" class="btn btn-info" >Edit</a>';
                    $buttonDelete = '<button type="button" class="btn btn-danger btn-delete">Hapus</button>';
                    return '<div class="btn-group">' . $detil . $buttonDelete . '</div>';
                })
                ->addColumn('provinsi', function($model) {
                    return $model->district->regency->province->name;
                })
                ->addColumn('kota', function($model) {
                    return $model->district->regency->name;
                })
                ->addColumn('kecamatan', function($model) {
                    return $model->district->name;
                })
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->toJson();
        }

        return view('desa.index_desa');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Village::class);

        return view('desa.form_desa');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoredesaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVillageRequest $request)
    {

        $this->authorize('create', Village::class);

        $id = Village::max('id');
        
        $desa = Village::create([
            'id' => $id + 1,
            'name' => strtoupper($request->name),
            'district_id' => $request->district_id,
        ]);
    
        $message = [
            'success' => $desa->name . ' berhasil disimpan'
        ];

        return redirect('pengaturan/desa')->with($message);
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\desa  $desa
     * @return \Illuminate\Http\Response
     */
    public function show(Village $desa)
    {
        $this->authorize('view', $desa);

        return view('desa.show_desa', compact('desa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\desa  $desa
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $desa = Village::find($id);

        $this->authorize('update', $desa);

        return view('desa.form_desa', compact('desa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatedesaRequest  $request
     * @param  \App\Models\desa  $desa
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVillageRequest $request, $id)
    {
        
        $desa = Village::findOrFail($id);

        $this->authorize('update', $desa);

        try {
            DB::beginTransaction();

            $request->merge(['name' => strtoupper($request->name)]);

            $desa->update($request->all());

            DB::commit();

            $message = [
                'success' => 'Data berhasil diupdate'
            ];

            return redirect('pengaturan/desa')->with($message);

        } catch (Exception $ex) {

            DB::rollBack();

            throw $ex;

            return back()->with('failed', $ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\desa  $desa
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $desa = Village::findOrFail($id);

            $this->authorize('delete', $desa);

            $desa->delete();

            DB::commit();

            return response()->json('data berhasil dihapus', 200);

        } catch (Exception $ex) {

            DB::rollBack();

            return response()->json($ex->getMessage(), 422);
        }
    }
}
