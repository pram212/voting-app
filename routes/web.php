<?php

use App\Http\Controllers\API\ApiCalonPejabatController;
use App\Http\Controllers\API\ApiDistrictController;
use App\Http\Controllers\API\ApiJabatanController;
use App\Http\Controllers\API\ApiProvinceController;
use App\Http\Controllers\API\ApiRegencyController;
use App\Http\Controllers\API\ApiUserController;
use App\Http\Controllers\API\ApiVillageController;
use App\Http\Controllers\API\UserDatatableController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CalonController;
use App\Http\Controllers\CalonPejabatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DesaController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\KotaController;
use App\Http\Controllers\ProvinsiController;
use App\Http\Controllers\RekapitulasiController;
use App\Http\Controllers\SaksiController;
use App\Http\Controllers\TPSController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});

Route::middleware('guest')->group(function() {
    Route::get('/login', [AuthController::class, 'index']);
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login');
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
});

Route::middleware('auth')->group(function(){
    Route::get('/home', [DashboardController::class, 'index']);

    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::resource('/user', UserController::class);

    Route::get('/datatable/user', [UserController::class, 'userDatatables']);

    Route::get('resetpassword/{id}', [UserController::class, 'formUpdatePassword'])->name('user.resetpassword');

    Route::post('resetpassword/{id}', [UserController::class, 'updatePassword'])->name('user.updatepassword');

    Route::resource('calon', CalonController::class);

    Route::resource('tps', TPSController::class);
    
    Route::resource('saksi', SaksiController::class);

    Route::get('/datatable/calon', [CalonController::class, 'calonDatatables']);

    // Route::resource('jabatan', JabatanController::class);

    Route::resource('rekapitulasi', RekapitulasiController::class);

    Route::resource('provinsi', ProvinsiController::class);
    Route::resource('kota', KotaController::class);
    Route::resource('kecamatan', KecamatanController::class);
    Route::resource('desa', DesaController::class);

    // select option ajax resource
    
});

Route::get('/select2/getjabatan', [ApiJabatanController::class, 'selectJabatan'] );
Route::get('/select2/getprovinsi', [ApiProvinceController::class, 'selectProvinsi'] );
Route::get('/select2/getkota', [ApiRegencyController::class, 'selectKota'] );
Route::get('/select2/getkecamatan', [ApiDistrictController::class, 'selectKecamatan'] );
Route::get('/select2/getdesa', [ApiVillageController::class, 'selectDesa'] );
Route::get('/select2/getuser', [ApiUserController::class, 'selectUser'] );

