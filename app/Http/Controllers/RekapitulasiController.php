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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RekapitulasiController extends Controller
{
    public function index()
    {

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

        if (auth()->user()->role == 2) {

            $rekapitulasi = TPS::with(['calon', 'provinsi', 'kota', 'kecamatan', 'desa'])
                ->when(auth()->user()->role == 2, fn ($query) => $query->where('village_id', auth()->user()->village_id))
                ->when(request('province_id'), fn ($query) => $query->where('province_id', request('province_id')))
                ->when(request('regency_id'), fn ($query) => $query->where('regency_id', request('regency_id')))
                ->when(request('district_id'), fn ($query) => $query->where('district_id', request('district_id')))
                ->when(request('village_id'), fn ($query) => $query->where('village_id', request('village_id')))
                ->when(request('nomor'), fn ($query) => $query->where('nomor', 'like', '%' . request('nomor') . '%'))
                ->paginate(25)
                ->withQueryString();

            return view('rekapitulasi.index_rekapan_saksi', compact('rekapitulasi', 'headerCalon'));
        } else {

            $rekapitulasi = $this->rekapPerProvinsi();

            $jenisrekap = "PROVINSI";

            if (request('province_id')) {
                $rekapitulasi = $this->rekapPerKota(request('province_id'));
                $jenisrekap = "KOTA";
            }
            if (request('regency_id')) {
                $rekapitulasi = $this->rekapPerKecamatan(request('regency_id'));
                $jenisrekap = "KECAMATAN";
            }
            if (request('district_id')) {
                $rekapitulasi = $this->rekapPerDesa(request('district_id'));
                $jenisrekap = 'DESA';
            }

            // return $rekapitulasi;

            return view('rekapitulasi.index_rekapan_admin', compact('rekapitulasi', 'headerCalon', 'jenisrekap'));
        }
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
        $validator = Validator::make($request->all(), []);


        $validator->after(function ($validator) use ($request) {

            foreach ($request->jumlah_suara as $key => $value) {
                if ($value > 1000) {
                    $validator->errors()->add(
                        'max_jumlah_suara',
                        'Jumlah Suara tidak boleh lebih dari 1000! '
                    );
                }
            }
        });

        $validator->validate();

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


    public function rekapPerProvinsi()
    {
        $rekapan = Province::get();

        $calon = Calon::all();

        $rekapan->transform(function ($rekapan) use ($calon) {
            $arrData = [];

            foreach ($calon as $item) {
                array_push($arrData, [
                    'no' => $item->no_urut,
                    'jumlah_suara' => Rekapitulasi::where('calon_id', $item->id)->where('province_id', $rekapan->id)->sum('jumlah_suara'),
                ]);

                $rekapan->totalcalon .= $item->no_urut = 0;
            }

            $rekapan->rekapan = $arrData;

            return $rekapan;
        });

        return $rekapan;
    }

    public function rekapPerKota($province_id)
    {
        $rekapan = Regency::where('province_id', $province_id)->get();

        $calon = Calon::select('id', 'no_urut', 'keterangan')->get();

        $rekapan->transform(function ($rekapan) use ($calon) {
            $arrData = [];

            foreach ($calon as $item) {
                array_push($arrData, [
                    'no' => $item->no_urut,
                    'jumlah_suara' => Rekapitulasi::where('calon_id', $item->id)->where('regency_id', $rekapan->id)->sum('jumlah_suara'),
                ]);
            }

            $rekapan->rekapan = $arrData;

            return $rekapan;
        });

        return $rekapan;
    }

    public function rekapPerKecamatan($regency_id)
    {
        $rekapan = District::where('regency_id', $regency_id)->get();

        $calon = Calon::select('id', 'no_urut', 'keterangan')->get();

        $rekapan->transform(function ($rekapan) use ($calon) {
            $arrData = [];

            foreach ($calon as $item) {
                array_push($arrData, [
                    'no' => $item->no_urut,
                    'jumlah_suara' => Rekapitulasi::where('calon_id', $item->id)->where('district_id', $rekapan->id)->sum('jumlah_suara'),
                ]);
            }

            $rekapan->rekapan = $arrData;

            return $rekapan;
        });

        return $rekapan;
    }

    public function rekapPerDesa($district_id)
    {
        $rekapan = Village::where('district_id', $district_id)->get();

        $calon = Calon::select('id', 'no_urut', 'keterangan')->get();

        $rekapan->transform(function ($rekapan) use ($calon) {
            $arrData = [];

            foreach ($calon as $item) {
                array_push($arrData, [
                    'no' => $item->no_urut,
                    'jumlah_tps' => TPS::where('village_id', $rekapan->id)->count(),
                    'jumlah_suara' => Rekapitulasi::where('calon_id', $item->id)->where('village_id', $rekapan->id)->sum('jumlah_suara'),
                ]);
            }

            $rekapan->rekapan = $arrData;

            return $rekapan;
        });

        return $rekapan;
    }
}
