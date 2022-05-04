<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Personal;
use App\Models\Cargo;

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
 
Route::get('personal/{dni}/ASDFBFDGB', function (Request $request, $dni) {

    $personal = Personal::select('PERSONAL.NOMBRES','PERSONAL.APELLIDO_PATERNO','PERSONAL.APELLIDO_MATERNO','CARGOS.DESCRIPCION AS CARGO','PERSONAL.FOTO','PERSONAL.CELULAR',
    'PERSONAL.EMAIL','PERSONAL.WEB','PERSONAL.FACEBOOK','PERSONAL.TWITTER','PERSONAL.YOUTUBE','PERSONAL.TIKTOK')
    ->join('CARGOS', 'PERSONAL.idcargo', '=', 'CARGOS.idcargo')
    ->where('PERSONAL.DNI','=', $dni)
    ->get();

return $personal;

});



