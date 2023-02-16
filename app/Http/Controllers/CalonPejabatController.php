<?php

namespace App\Http\Controllers;

use App\Models\CalonPejabat;
use App\Http\Requests\StoreCalonPejabatRequest;
use App\Http\Requests\UpdateCalonPejabatRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;

class CalonPejabatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        if (request()->ajax()) {
            
            $model = CalonPejabat::query();

            return DataTables::of($model)
                ->addColumn('action', function ($model) {
                    $detil = '<a href="' . url('calon/' . $model->id) . '/edit" class="btn btn-warning btn-sm" >Edit</a>';
                    $buttonDelete = '<button type="button" class="btn btn-danger btn-delete btn-sm">Hapus</button>';
                    return '<div class="btn-group">' . $detil . $buttonDelete . '</div>';
                })
                ->editColumn('jabatan', function ($model) {
                    return $model->jabatan->nama;
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
     * @param  \App\Http\Requests\StoreCalonPejabatRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCalonPejabatRequest $request)
    {
        try {
            DB::beginTransaction();

            $calonPejabat = CalonPejabat::create($request->all());

            DB::commit();

            $message = [
                'success' => $calonPejabat->nama .= 'berhasil didaftarkan'
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
     * @param  \App\Models\CalonPejabat  $calonPejabat
     * @return \Illuminate\Http\Response
     */
    public function show(CalonPejabat $calonPejabat)
    {
        return view('calon.show_calon', compact('calonPejabat'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CalonPejabat  $calonPejabat
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $calonPejabat = CalonPejabat::findOrFail($id);

        return view('calon.edit_calon', compact('calonPejabat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCalonPejabatRequest  $request
     * @param  \App\Models\CalonPejabat  $calonPejabat
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCalonPejabatRequest $request, $id)
    {
        $calonPejabat = CalonPejabat::findOrFail($id);

        try {
            DB::beginTransaction();

            $calonPejabat->update($request->all());

            DB::commit();

            $message = [
                'success' => $calonPejabat->nama .= 'berhasil diupdate'
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
     * @param  \App\Models\CalonPejabat  $calonPejabat
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $calonPejabat = CalonPejabat::findOrFail($id);

            $calonPejabat->delete();

            DB::commit();

            return response()->json('data berhasil dihapus', 200);
        } catch (Exception $ex) {

            DB::rollBack();

            return response()->json($ex->getMessage(), 422);
        }
    }

    public function calonDatatables(Request $request)
    {
        $model = CalonPejabat::query();

        return DataTables::of($model)
            ->addColumn('action', function ($model) {
                $detil = '<a href="' . url('calon/' . $model->id) . '/edit" class="btn btn-warning btn-sm" >Edit</a>';
                $buttonDelete = '<button type="button" class="btn btn-danger btn-delete btn-sm">Hapus</button>';
                return '<div class="btn-group">' . $detil . $buttonDelete . '</div>';
            })
            ->editColumn('jabatan', function ($model) {
                return $model->jabatan->nama;
            })
            ->rawColumns(['action'])
            ->toJson();
    }
}
