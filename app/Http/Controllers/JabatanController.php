<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Http\Requests\StoreJabatanRequest;
use App\Http\Requests\UpdateJabatanRequest;
use DataTables;
use Exception;
use Illuminate\Support\Facades\DB;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {

            $model = Jabatan::query();

            return DataTables::of($model)
                ->addIndexColumn()
                ->addColumn('action', function ($model) {
                    $detil = '<a href="' . url('jabatan/' . $model->id) . '/edit" class="btn btn-warning btn-sm" >Edit</a>';
                    $buttonDelete = '<button type="button" class="btn btn-danger btn-delete btn-sm">Hapus</button>';
                    return '<div class="btn-group">' . $detil . $buttonDelete . '</div>';
                })
                ->editColumn('created_at', function($model) {
                    return date('d/m/Y', strtotime($model->created_at));
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('jabatan.index_jabatan');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('jabatan.create_jabatan');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreJabatanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreJabatanRequest $request)
    {
        try {
            DB::beginTransaction();

            $jabatan = Jabatan::create($request->all());

            DB::commit();

            $message = [
                'success' => $jabatan->nama .= 'berhasil didaftarkan'
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
     * @param  \App\Models\Jabatan  $jabatan
     * @return \Illuminate\Http\Response
     */
    public function show(Jabatan $jabatan)
    {
        return view('jabatan.show_jabatan', compact('jabatan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Jabatan  $jabatan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        
        return view('jabatan.edit_jabatan', compact('jabatan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateJabatanRequest  $request
     * @param  \App\Models\Jabatan  $jabatan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateJabatanRequest $request, $id)
    {
        $jabatan = Jabatan::findOrFail($id);
        
        try {
            DB::beginTransaction();

            $jabatan->update($request->all());

            DB::commit();

            $message = [
                'success' => $jabatan->nama .= 'berhasil diupdate'
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
     * @param  \App\Models\Jabatan  $jabatan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $jabatan = Jabatan::findOrFail($id);

            $jabatan->delete();

            DB::commit();

            return response()->json('data berhasil dihapus', 200);

        } catch(Exception $ex) {

            DB::rollBack();

            return response()->json($ex->getMessage(), 422);
            
        }
    }
}
