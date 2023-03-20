<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use Illuminate\Http\Request;
use DataTables;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Village;

class SaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);

        if (request()->ajax()) {
            $saksi = User::query()
                ->when(request('role'), function ($query) {
                    return $query->where('role_id', request('role'));
                })
                ->when(request('province_id') != null, function($query) {
                    return $query->where('province_id', request('province_id'));
                })
                ->when(request('regency_id') != null, function($query) {
                    return $query->where('regency_id', request('regency_id'));
                })
                ->when(request('district_id') != null, function($query) {
                    return $query->where('district_id', request('district_id'));
                })
                ->when(request('village_id') != null, function($query) {
                    return $query->where('village_id', request('village_id'));
                })
                ->where('role', 2);

            return DataTables::of($saksi)
                ->addColumn('action', function ($saksi) {
                    $resetPassword = '<a href="' . url('resetpassword/' . $saksi->id) . '" class="btn btn-warning " >Update Password</a>';
                    $profil = '<a href="' . url('pengaturan/saksi/' . $saksi->id) . '/edit" class="btn btn-info " >Profil</a>';
                    $buttonDelete = '<button type="button" class="btn btn-danger btn-delete ">Hapus</button>';
                    return '<div class="btn-group">' . $resetPassword . $profil.  $buttonDelete . '</div>';
                })
                ->editColumn('role', function ($saksi) {
                    return $saksi->role == 1 ? "admin" : "saksi";
                })
                ->addColumn('provinsi', function ($saksi) {
                    return $saksi->provinsi->name;
                })
                ->addColumn('kota', function ($saksi) {
                    return $saksi->kota->name;
                })
                ->addColumn('kecamatan', function ($saksi) {
                    return $saksi->kecamatan->name;
                })
                ->addColumn('desa', function ($saksi) {
                    return $saksi->desa->name;
                })
                ->editColumn('created_at', function ($saksi) {
                    return date('d/m/Y - H:i', strtotime($saksi->created_at)) ?? "-";
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        return view('saksi.index_saksi');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', User::class);

        return view('saksi.create_saksi');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', User::class);

        Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users'],
            'phone' => ['required', 'numeric', 'unique:users'],
            'province_id' => [Rule::requiredIf($request->role == '2')],
            'regency_id' => [Rule::requiredIf($request->role == '2')],
            'district_id' => [Rule::requiredIf($request->role == '2')],
            'village_id' => [Rule::requiredIf($request->role == '2')],
        ], [
            'name.required' => 'nama lengkap wajib diisi!',
            'email.required' => 'email wajib diisi!',
            'email.email' => 'format email salah!',
            'phone.required' => 'no. whatsap wajib diisi!',
            'phone.unique' => 'no. whatsap sudah terdaftar!',
            'email.unique' => 'email sudah terdaftar!',
            'phone.numeric' => 'no. whatsap harus berupa angka!',
            'password.required' => 'password wajib diisi!',
            'province_id.required' => 'provinsi wajib diisi!',
            'regency_id.required' => 'kota wajib diisi!',
            'district_id.required' => 'kecamatan wajib diisi!',
            'village_id.required' => 'desa wajib diisi!',
        ])->validate();

        $request->merge([
            'password' => Hash::make('password')
        ]);

        try {
            DB::beginTransaction();

            $user = User::create($request->all());

            DB::commit();

            $message = [
                'success' => $user->name .= ' berhasil didaftarkan'
            ];

            return Redirect::route('saksi.show', $user->id)->with($message);
        } catch (Exception $e) {
            DB::rollBack();

            return back()->with('failed', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);

        return view('saksi.show_saksi', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        
        $this->authorize('view', $user);

        return view('saksi.edit_saksi', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone' => ['required', 'numeric', Rule::unique('users')->ignore($user->id)],
            'province_id' => [Rule::requiredIf($request->role == '2')],
            'regency_id' => [Rule::requiredIf($request->role == '2')],
            'district_id' => [Rule::requiredIf($request->role == '2')],
            'village_id' => [Rule::requiredIf($request->role == '2')],
        ], [
            'name.required' => 'nama lengkap wajib diisi!',
            'email.required' => 'email wajib diisi!',
            'email.email' => 'format email salah!',
            'phone.required' => 'no. whatsap wajib diisi!',
            'phone.unique' => 'no. whatsap sudah terdaftar!',
            'email.unique' => 'email sudah terdaftar!',
            'phone.numeric' => 'no. whatsap harus berupa angka!',
            'province_id.required' => 'provinsi wajib diisi!',
            'regency_id.required' => 'kota wajib diisi!',
            'district_id.required' => 'kecamatan wajib diisi!',
            'village_id.required' => 'desa wajib diisi!',
        ])->validate();


        try {
            DB::beginTransaction();

            $user->update($request->all());

            DB::commit();

            $message = [
                'success' => $user->name .= 'Profil Anda berhasil diubah'
            ];

            return back()->with($message);
        } catch (Exception $e) {

            DB::rollBack();

            return back()->with('failed', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        try {
            DB::beginTransaction();

            $user->delete();

            DB::commit();

            return response()->json('data berhasil dihapus', 200);
        } catch (Exception $ex) {

            DB::rollBack();

            return response()->json($ex->getMessage(), 422);
        }
    }

    public function userDatatables(Request $request)
    {
        $model = User::query()->when(request('role'), function ($query) {
            return $query->where('role_id', request('role'));
        })->where('role', 2);

        return DataTables::of($model)
            ->addColumn('action', function ($model) {
                $detil = '<a href="' . url('resetpassword/' . $model->id) . '" class="btn btn-warning " >Update Password</a>';
                $buttonDelete = '<button type="button" class="btn btn-danger btn-delete ">Hapus</button>';
                return '<div class="btn-group">' . $detil . $buttonDelete . '</div>';
            })
            ->editColumn('role', function ($model) {
                return $model->role == 1 ? "admin" : "saksi";
            })
            ->editColumn('created_at', function ($model) {
                return date('d/m/Y - H:i', strtotime($model->created_at)) ?? "-";
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function formUpdatePassword($id)
    {
        $user = User::find($id);

        $this->authorize('update', $user);

        return view('saksi.reset_password', compact('user'));
    }

    public function updatePassword(Request $request, $id)
    {
        try {

            $user = User::find($id);

            $this->authorize('update', $user);

            Validator::make($request->all(), [
                'password' => ['required'],
            ], [
                'password.required' => 'password wajib diisi!',
            ])->validated();

            DB::beginTransaction();

            $user->password = Hash::make($request->password);

            $user->update_password = 1;

            $user->save();

            DB::commit();

            return redirect('user')->with('success', 'password ' . $user->name . ' berhasil diubah menjadi ' . $request->password);
        } catch (Exception $e) {

            DB::rollBack();

            return back()->with('failed', $e->getMessage());
        }
    }

    public function indexRekapan()
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

        $rekapitulasi = $this->rekapPerProvinsi();
        $jenisrekap = "PROVINSI";
        $totalSaksi = User::where('role', 2)->count();
        $totalSaksiPerLokasi = User::whereHas('provinsi')->count();

        if (request('province_id')) {
            $rekapitulasi = $this->rekapPerKota(request('province_id'));
            $jenisrekap = "KOTA";
            $totalSaksiPerLokasi = User::whereHas('kota')->count();
        }
        if (request('regency_id')) {
            $rekapitulasi = $this->rekapPerKecamatan(request('regency_id'));
            $jenisrekap = "KECAMATAN";
            $totalSaksiPerLokasi = User::whereHas('kecamatan')->count();
        }
        if (request('district_id')) {
            $rekapitulasi = $this->rekapPerDesa(request('district_id'));
            $jenisrekap = 'DESA';
            $totalSaksiPerLokasi = User::whereHas('desa')->count();
        }

        // return $rekapitulasi;

        return view('saksi.index_rekapan_saksi', compact('rekapitulasi', 'jenisrekap', 'totalSaksi', 'totalSaksiPerLokasi'));
    }

    public function rekapPerProvinsi()
    {
        $rekapan = Province::withCount('saksi')->get();

        return $rekapan;
    }

    public function rekapPerKota($province_id)
    {
        $rekapan = Regency::where('province_id', $province_id)->withCount('saksi')->get();

        return $rekapan;
    }

    public function rekapPerKecamatan($regency_id)
    {
        $rekapan = District::where('regency_id', $regency_id)->withCount('saksi')->get();

        return $rekapan;
    }

    public function rekapPerDesa($district_id)
    {
        $rekapan = Village::where('district_id', $district_id)->withCount('saksi')->get();

        return $rekapan;

    }
}
