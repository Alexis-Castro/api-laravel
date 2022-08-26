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
 
Route::get('personal/{dni}/0P.FdWSI5wMwb8jmPcDcBFyJ9OxGPw2qgIPLh5VT2ZUxzndmMIuA7Q0Chq7S', function (Request $request, $dni) {

    // --- Decrypt --- //
    $key = openssl_digest("Q455ds@.q*#", 'SHA256', TRUE);
     
    $c = base64_decode( strtr( $dni, '-_', '+/') . str_repeat('=', 3 - ( 3 + strlen( $dni )) % 4 ));
    $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
    $iv = substr($c, 0, $ivlen);
    $hmac = substr($c, $ivlen, $sha2len=32);
    $ciphertext_raw = substr($c, $ivlen+$sha2len);
    $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, OPENSSL_RAW_DATA, $iv);
    $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, true);
    if (hash_equals($hmac, $calcmac))
 

    $personal = Personal::select('PERSONAL.NOMBRES','PERSONAL.APELLIDO_PATERNO','PERSONAL.APELLIDO_MATERNO','CARGOS.DESCRIPCION AS CARGO','PERSONAL.FOTO','PERSONAL.CELULAR',
    'PERSONAL.EMAIL','PERSONAL.WEB','PERSONAL.FACEBOOK','PERSONAL.TWITTER','PERSONAL.YOUTUBE','PERSONAL.TIKTOK')
    ->join('CARGOS', 'PERSONAL.idcargo', '=', 'CARGOS.idcargo')
    ->where('PERSONAL.DNI','=', $original_plaintext)
    ->get();

    return  $personal;

});



