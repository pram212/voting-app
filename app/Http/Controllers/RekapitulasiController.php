<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRekapitulasiRequest;
use App\Models\Calon;
use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Rekapitulasi;
use App\Models\TPS;
use App\Models\Village;
use DataTables;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RekapitulasiController extends Controller
{
    public function index()
    {
        $rekapitulasi = TPS::with(['calon', 'provinsi', 'kota', 'kecamatan', 'desa'])
            ->when(auth()->user()->role == 2, fn ($query) => $query->where('village_id', auth()->user()->village_id))
            ->when(request('province_id'), fn ($query) => $query->where('province_id', request('province_id')))
            ->when(request('regency_id'), fn ($query) => $query->where('regency_id', request('regency_id')))
            ->when(request('district_id'), fn ($query) => $query->where('district_id', request('district_id')))
            ->when(request('village_id'), fn ($query) => $query->where('village_id', request('village_id')))
            ->when(request('nomor'), fn ($query) => $query->where('nomor', 'like', '%' . request('nomor') . '%'))
            ->paginate(20);
            
        if (request('province_id')) {
            request()->merge([
                'province_name' => Province::find(request('province_id'))?->name
            ]);
        }
        if (request('regency_id')) {
            request()->merge([
                'regency_name' => Regency::find(request('regency_id'))?->name
            ]);
        }
        if (request('district_id')) {
            request()->merge([
                'district_name' => District::find(request('district_id'))?->name
            ]);
        }
        if (request('village_id')) {
            request()->merge([
                'village_name' => Village::find(request('village_id'))?->name
            ]);
        }

        $headerCalon = Calon::pluck('id');

        return view('rekapitulasi.index_rekapitulasi', compact('rekapitulasi', 'headerCalon'));
    }

    public function create()
    {
        return view('rekapitulasi.create_rekapitulasi');
    }

    public function store(StoreRekapitulasiRequest $request)
    {
    }

    public function edit($id)
    {

        $tps = TPS::find($id);

        return view('rekapitulasi.create_rekapitulasi', compact('tps'));
    }

    public function update(Request $request, $tpsId)
    {
        try {
            DB::beginTransaction();
            
            $this->authorize('create', Rekapitulasi::class);
    
            $tps = TPS::find($tpsId);
    
            $tps->catatan = $request->catatan;
            $tps->user_id = auth()->user()->id;
            $tps->save();
    
            $calons = [];
    
            foreach ($request->calon_id as $key => $value) {
                $calons[$value] = [
                    "jumlah_suara" => $request->jumlah_suara[$key],
                ];
            }
    
            $tps->calon()->sync($calons);


            DB::commit();

            $message = [
                'success' => 'hasil TPS berhasil disimpan'
            ];

            return redirect('rekapitulasi')->with($message);
        } catch (\Exception $ex) {
            DB::rollBack();

            return back()->with('failed', $ex->getMessage());
        }
    }
}
