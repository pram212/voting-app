<?php

namespace App\Http\Controllers;

use App\Models\Calon;
use App\Http\Requests\StoreCalonRequest;
use App\Http\Requests\UpdateCalonRequest;
use Illuminate\Support\Facades\DB;
use DataTables;
use Exception;

class CalonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            
            $model = Calon::query();

            return DataTables::of($model)
                ->addColumn('action', function ($model) {
                    $detil = '<a href="' . url('calon/' . $model->id) . '/edit" class="btn btn-warning btn-sm" >Edit</a>';
                    $buttonDelete = '<button type="button" class="btn btn-danger btn-delete btn-sm">Hapus</button>';
                    return '<div class="btn-group">' . $detil . $buttonDelete . '</div>';
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        return view('calon.index_calon');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('calon.create_calon');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCalonRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCalonRequest $request)
    {
        try {
            DB::beginTransaction();

            $calon = Calon::create($request->all());

            DB::commit();

            $message = [
                'success' => $calon->nama .= 'berhasil didaftarkan'
            ];

            return back()->with($message);
        } catch (Exception $ex) {

            DB::rollBack();

            return back()->with('failed', $ex->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Calon  $calon
     * @return \Illuminate\Http\Response
     */
    public function show(Calon $calon)
    {
        return view('calon.show_calon', compact('calon'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Calon  $calon
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $calon = Calon::findOrFail($id);

        return view('calon.form_calon', compact('calon'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCalonRequest  $request
     * @param  \App\Models\Calon  $calon
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCalonRequest $request, $id)
    {
        $calon = Calon::findOrFail($id);

        try {
            DB::beginTransaction();

            $calon->update($request->all());

            DB::commit();

            $message = [
                'success' => $calon->nama .= 'berhasil diupdate'
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
     * @param  \App\Models\Calon  $calon
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $calon = Calon::findOrFail($id);

            $calon->delete();

            DB::commit();

            return response()->json('data berhasil dihapus', 200);
        } catch (Exception $ex) {

            DB::rollBack();

            return response()->json($ex->getMessage(), 422);
        }
    }
}
