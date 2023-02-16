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
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('user.index_user');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users'],
            'phone' => ['required', 'numeric', 'unique:users'],
            'password' => ['required'],
        ], [
            'name.required' => 'nama lengkap wajib diisi!',
            'email.required' => 'email wajib diisi!',
            'email.email' => 'format email salah!',
            'phone.required' => 'no. whatsap wajib diisi!',
            'phone.unique' => 'no. whatsap sudah terdaftar!',
            'email.unique' => 'email sudah terdaftar!',
            'phone.numeric' => 'no. whatsap harus berupa angka!',
            'password.required' => 'password wajib diisi!',
        ])->validated();

        $request->merge([
            'password' => Hash::make($request->password)
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
        return view('user.show_user', compact('user'));
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
        dd($user);

        Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users'],
            'phone' => ['required', 'numeric', 'unique:users'],
            'password' => ['required'],
        ], [
            'name.required' => 'nama lengkap wajib diisi!',
            'email.required' => 'email wajib diisi!',
            'email.email' => 'format email salah!',
            'phone.required' => 'no. whatsap wajib diisi!',
            'phone.unique' => 'no. whatsap sudah terdaftar!',
            'email.unique' => 'email sudah terdaftar!',
            'phone.numeric' => 'no. whatsap harus berupa angka!',
            'password.required' => 'password wajib diisi!',
        ])->validated();


        try {
            DB::beginTransaction();

            $user = User::create($request->all());

            DB::commit();

            $message = [
                'success' => $user->name .= 'berhasil didaftarkan'
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
        //
    }

    public function userDatatables(Request $request)
    {
        $model = User::query()->when(request('role'), function($query) {
            return $query->where('role_id', request('role'));
        });

        return DataTables::of($model)
            ->addColumn('action', function ($model) {
                $detil = '<a href="' . url('user/' . $model->id) . '" class="btn btn-warning btn-sm" >Detil</a>';
                return $detil;
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

        return view('user.reset_password', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        
        try {

            $user = auth()->user();
    
            Validator::make($request->all(), [
                'password' => ['required'],
            ], [
                'password.required' => 'password wajib diisi!',
            ])->validated();

            DB::beginTransaction();

            $user->password = Hash::make($request->password);

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
