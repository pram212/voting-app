<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\AuthController;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);

        return view('user.index_user');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', User::class);

        return view('user.create_user');
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
            'province_id' => [Rule::requiredIf($request->role == '2') ],
            'regency_id' => [Rule::requiredIf($request->role == '2') ],
            'district_id' => [Rule::requiredIf($request->role == '2') ],
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

            return Redirect::route('user.show', $user->id)->with($message);
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

        return view('user.show_user', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {   
        $this->authorize('view', $user);

        return view('user.edit_user', compact('user'));
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
            'province_id' => [Rule::requiredIf($request->role == '2') ],
            'regency_id' => [Rule::requiredIf($request->role == '2') ],
            'district_id' => [Rule::requiredIf($request->role == '2') ],
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
        $model = User::query()->when(request('role'), function($query) {
            return $query->where('role_id', request('role'));
        });

        return DataTables::of($model)
            ->addColumn('action', function ($model) {
                $detil = '<a href="' . url('user/' . $model->id) . '/edit" class="btn btn-warning btn-sm" >Edit</a>';
                $buttonDelete = '<button type="button" class="btn btn-danger btn-delete btn-sm">Hapus</button>';
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

    public function formUpdatePassword()
    {
        $user = auth()->user();

        $this->authorize('update', $user);

        return view('user.reset_password', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        try {

            $user = auth()->user();

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

            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return redirect('/login');

        } catch (Exception $e) {

            DB::rollBack();

            return back()->with('failed', $e->getMessage());

        }
    }

   
}
