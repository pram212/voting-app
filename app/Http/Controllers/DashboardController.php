<?php

namespace App\Http\Controllers;

use App\Models\Calon;
use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Rekapitulasi;
use App\Models\TPS;
use App\Models\User;
use App\Models\Village;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tps = TPS::query()
            ->when(auth()->user()->role == 2, fn ($query) => $query->where('village_id', auth()->user()->village_id))
            ->when(request('province_id'), fn ($query) => $query->where('province_id', request('province_id')))
            ->when(request('regency_id'), fn ($query) => $query->where('regency_id', request('regency_id')))
            ->when(request('district_id'), fn ($query) => $query->where('district_id', request('district_id')))
            ->when(request('village_id'), fn ($query) => $query->where('village_id', request('village_id')))
            ->when(request('nomor'), fn ($query) => $query->where('nomor', 'like', '%' . request('nomor') . '%'));

        $totalTps = $tps->count();

        if (request('province_id')) {
            $request->merge([
                'province_name' => Province::find(request('province_id'))?->name
            ]);
        }
        if (request('regency_id')) {
            $request->merge([
                'regency_name' => Regency::find(request('regency_id'))?->name
            ]);
        }
        if (request('district_id')) {
            $request->merge([
                'district_name' => District::find(request('district_id'))?->name
            ]);
        }
        if (request('village_id')) {
            $request->merge([
                'village_name' => Village::find(request('village_id'))?->name
            ]);
        }

        $totalSuara = Rekapitulasi::whereIn('tps_id', $tps->pluck('id'))->sum('jumlah_suara');

        $progressBarData = [];
        $pieChartLabels = [];
        $pieChartData = [];
        $pieChartColor = [];

        $calons = Calon::with('tps')->get();

        foreach ($calons as $calon) {
            
            // ambil total suara dari rekapitulasis.jumlah_suara berdasarkan calon_id=calons.id yang sedang dilooping;
            // $jumlahSuara = $calon->tps()->whereIn('rekapitulasis.tps_id', $tps->pluck('id') )->sum('rekapitulasis.jumlah_suara');

            $jumlahSuara = Rekapitulasi::where('calon_id', $calon->id)->whereIn('tps_id', $tps->pluck('id'))->sum('jumlah_suara');

            // cek jika jumlah suara = 0 (untuk menghindari error 'division by zero')
            if ($jumlahSuara) {
                $presentaseSuara = round($jumlahSuara / $totalSuara * 100, 2);
            } else {
                $presentaseSuara = 0;
            }

            // isi $progressBarData untuk ditampilkan di dashboard berupa progress bar
            array_push($progressBarData, [
                'calon' => $calon->keterangan,
                'persentase' => $jumlahSuara ? round($jumlahSuara / $totalSuara * 100, 2) : 0,
                'jumlah_suara' => $jumlahSuara,
                'color' => randomColor() // App/Http/Helpers/helpers.php
            ]);

            // isi $pieChartData untuk mengisi data pada pie chart
            array_push(
                $pieChartData, $presentaseSuara
            );

            // isi $pieChartLabels untuk label setiap data dalam pie chart
            array_push($pieChartLabels, "NO. URUT $calon->no_urut");
            // isi $pieChartColor untuk label setiap warna dalam pie chart
            array_push($pieChartColor, randomColor());
        }
    
        // return $progressBarData;

        return view('home', compact('pieChartLabels', 'pieChartData', 'totalTps', 'totalSuara', 'progressBarData', 'pieChartColor'));
    }
}
