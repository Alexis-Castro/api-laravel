<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PersonalResource;
use App\Models\Personal;
use Illuminate\Http\Request;

class PersonalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $personal = PersonalResource::collection(Personal::all());
        return $personal;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function decryptt($dni) {
        $key = openssl_digest("Q455ds@.q*#", 'SHA256', TRUE);
        $c = base64_decode(strtr($dni, '-_', '+/') . str_repeat('=', 3 - (3 + strlen($dni)) % 4));
        $ivlen = openssl_cipher_iv_length($cipher = "AES-128-CBC");
        $iv = substr($c, 0, $ivlen);
        $hmac = substr($c, $ivlen, $sha2len = 32);
        $ciphertext_raw = substr($c, $ivlen + $sha2len);
        $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, true);
        if (hash_equals($hmac, $calcmac)) {
            return openssl_decrypt($ciphertext_raw, $cipher, $key, OPENSSL_RAW_DATA, $iv);
        };
    }

    public function shortUrl($dni) {
        $ran_url = substr(md5(microtime()), rand(0, 26), 5);
    }

    public function show($dni)
    {
        $dniDecryp = $this->decryptt($dni);

        $consulta = Personal::select('PERSONAL.nombres','PERSONAL.apellido_paterno','PERSONAL.apellido_materno','CARGOS.descripcion AS cargo','PERSONAL.foto','PERSONAL.celular','PERSONAL.email','PERSONAL.web','PERSONAL.facebook','PERSONAL.twitter','PERSONAL.youtube','PERSONAL.tiktok', 'PERSONAL.estado')
        ->join('CARGOS', 'PERSONAL.idcargo', '=', 'CARGOS.idcargo')
        ->where('PERSONAL.dni','=', $dniDecryp)
        ->get();

        // $personal = Personal::findOrFail($dni);
        // return $personal;

        return response()->json([
            'data' => $consulta[0],
            'res' => true,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
