<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProvinsiRequest;
use App\Http\Requests\UpdateProvinsiRequest;
use App\Models\Province;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;

class ProvinsiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Province::class);

        if (request()->ajax()) {
            
            $model = Province::query();

            return DataTables::of($model)
                ->addColumn('action', function ($model) {
                    $detil = '<a href="' . url('pengaturan/provinsi/' . $model->id) . '/edit" class="btn btn-info" >Edit</a>';
                    $buttonDelete = '<button type="button" class="btn btn-danger btn-delete">Hapus</button>';
                    return '<div class="btn-group">' . $detil . $buttonDelete . '</div>';
                })
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->toJson();
        }

        return view('provinsi.index_provinsi');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Province::class);

        return view('provinsi.form_provinsi');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreprovinsiRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProvinsiRequest $request)
    {

        $this->authorize('create', Province::class);

        $id = Province::max('id');
        
        $provinsi = Province::create([
            'id' => $id + 1,
            'name' => strtoupper($request->name),
        ]);
    
        $message = [
            'success' => $provinsi->name .= 'berhasil disimpan'
        ];

        return redirect('pengaturan/provinsi')->with($message);
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\provinsi  $provinsi
     * @return \Illuminate\Http\Response
     */
    public function show(Province $provinsi)
    {
        $this->authorize('view', $provinsi);

        return view('provinsi.show_provinsi', compact('provinsi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\provinsi  $provinsi
     * @return \Illuminate\Http\Response
     */
    public function edit(Province $provinsi)
    {
        $this->authorize('update', $provinsi);

        return view('provinsi.form_provinsi', compact('provinsi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateprovinsiRequest  $request
     * @param  \App\Models\provinsi  $provinsi
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProvinsiRequest $request, $id)
    {
        
        $provinsi = Province::findOrFail($id);

        $this->authorize('update', $provinsi);

        try {
            DB::beginTransaction();

            $provinsi->update(['name' => strtoupper($request->name)]);

            DB::commit();

            $message = [
                'success' => $provinsi->nama .= 'berhasil diupdate'
            ];

            return redirect('pengaturan/provinsi')->with($message);

        } catch (Exception $ex) {

            DB::rollBack();

            return back()->with('failed', $ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\provinsi  $provinsi
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $provinsi = Province::findOrFail($id);

            $this->authorize('delete', $provinsi);

            $provinsi->delete();

            DB::commit();

            return response()->json('data berhasil dihapus', 200);

        } catch (Exception $ex) {

            DB::rollBack();

            return response()->json($ex->getMessage(), 422);
        }
    }
}
