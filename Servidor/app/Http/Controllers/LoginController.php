<?php

namespace App\Http\Controllers;

use App\Models\Usuari;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $usuari = Usuari::where('mail', $request->input('mail'))->first();
        if ($usuari && Hash::check($request->input('password'), $usuari->contrasenya)) {
            $apikey = base64_encode(Str::random(40));
            $usuari["api_token"] = $apikey;
            $usuari->save();
            return response()->json(['status' => 'Login ok', 'result' => $apikey]);
        } else {
            return response()->json(['status' => 'fail'], 401);
        }
    }
}
