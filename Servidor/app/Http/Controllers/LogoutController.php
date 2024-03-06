<?php

namespace App\Http\Controllers;

use App\Models\Usuaris;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LogoutController extends Controller
{
    public function logout($id)
    {
        try {
            $usuari = Usuaris::findOrFail($id);
            $usuari["api_token"] = null;
            $usuari->save();
            return response()->json(['status' => 'success', 'data' => $usuari]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'data' => $usuari + $e], 401);
        }
    }
}
