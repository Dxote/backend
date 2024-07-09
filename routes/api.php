<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\AbsensiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//API Routes

Route::post("register", [ApiController::class, "register"]);
Route::post("login", [ApiController::class, "login"]);

Route::group(
    [
        "middleware" => ["auth:api"]
    ],
    function () {
        Route::get("profile", [ApiController::class, "profile"]);
        Route::get("refresh", [ApiController::class, "refreshToken"]);
        Route::get('logout', [ApiController::class, 'logout']);
        Route::get('check-token', [ApiController::class, 'checkToken']);

        
        Route::post("/karyawancreate", [KaryawanController::class, "create"]);
        Route::put("/karyawanupdate/{id}", [KaryawanController::class, "update"]);
        Route::delete("/karyawandelete/{id}", [KaryawanController::class, "delete"]);
        Route::get("/karyawan", [KaryawanController::class, "index"]);
        Route::post("/karyawan", [KaryawanController::class, "store"]);
        Route::get("/karyawan/{id}", [KaryawanController::class, "show"]);
        Route::post('absensi', [AbsensiController::class, 'store']);
        Route::get("/absensi", [AbsensiController::class, "index"]);
        Route::delete('/absensi/{id}', [AbsensiController::class, 'destroy']);
    }
);

