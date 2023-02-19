<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegencyRequest;
use App\Http\Requests\UpdateRegencyRequest;
use App\Models\Regency;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;

class RegencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Regency::class);

        if (request()->ajax()) {
            
            $model = Regency::query();

            return DataTables::of($model)
                ->addColumn('action', function ($model) {
                    $detil = '<a href="' . url('kota/' . $model->id) . '/edit" class="btn btn-warning btn-sm" >Edit</a>';
                    $buttonDelete = '<button type="button" class="btn btn-danger btn-delete btn-sm">Hapus</button>';
                    return '<div class="btn-group">' . $detil . $buttonDelete . '</div>';
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        return view('kota.index_kota');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Regency::class);

        return view('kota.form_kota');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorekotaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRegencyRequest $request)
    {

        $this->authorize('create', Regency::class);

        $id = Regency::max('id');
        
        $kota = Regency::create([
            'id' => $id + 1,
            'name' => strtoupper($request->name),
        ]);
    
        $message = [
            'success' => $kota->name .= 'berhasil disimpan'
        ];

        return back()->with($message);
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\kota  $kota
     * @return \Illuminate\Http\Response
     */
    public function show(Regency $kota)
    {
        $this->authorize('view', $kota);

        return view('kota.show_kota', compact('kota'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\kota  $kota
     * @return \Illuminate\Http\Response
     */
    public function edit(Regency $kota)
    {
        $this->authorize('update', $kota);

        return view('kota.form_kota', compact('kota'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatekotaRequest  $request
     * @param  \App\Models\kota  $kota
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRegencyRequest $request, $id)
    {
        
        $kota = Regency::findOrFail($id);

        $this->authorize('update', $kota);

        try {
            DB::beginTransaction();

            $request->merge(['name' => strtoupper($request->name)]);

            $kota->update($request->all());

            DB::commit();

            $message = [
                'success' => $kota->nama .= 'berhasil diupdate'
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
     * @param  \App\Models\kota  $kota
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $kota = Regency::findOrFail($id);

            $this->authorize('delete', $kota);

            $kota->delete();

            DB::commit();

            return response()->json('data berhasil dihapus', 200);

        } catch (Exception $ex) {

            DB::rollBack();

            return response()->json($ex->getMessage(), 422);
        }
    }
}
