<?php

namespace App\Http\Controllers;

use App\Models\Usuaris;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/login",
     *     tags={"Authentication"},
     *     summary="User Login",
     *     description="Logs in a user and generates an API token for authentication.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"mail", "contrasenya"},
     *             @OA\Property(property="mail", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="contrasenya", type="string", format="password", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="Login ok"),
     *             @OA\Property(property="result", type="string", description="Generated API token")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Login failed",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="fail"),
     *             @OA\Property(property="usuari", type="object", description="User information in case of failure")
     *         )
     *     )
     * )
     */
    public function login(Request $request)
    {
        $usuari = Usuaris::where('mail', $request->input('mail'))->first();
        if ($usuari && Hash::check($request->input('contrasenya'), $usuari->contrasenya)) {
            $apikey = base64_encode(Str::random(40));
            $usuari["api_token"] = $apikey;
            $usuari->save();
            return response()->json(['status' => 'Login ok', 'result' => $apikey]);
        } else {
            return response()->json(['status' => 'fail', 'usuari' => $usuari], 401);
        }
    }
}
