<?php

namespace App\Http\Middleware;

use App\Models\Usuaris;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ControlaRegistreUsuaris
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->header('Authorization')) { // Hem rebut el header d’autorització?
            $key = explode(' ', $request->header('Authorization')); // Esperam un token 'Bearer token'
            $token = 'x'; // Els usuaris que no han fet mai un login tenen un token buit;
            if (count($key) == 2) {
                $token = $key[1]; // key[0]->Bearer key[1]→token
            }
            $user = Usuaris::where('api_token', $token)
                ->first();
            if (!empty($user) && $user->rol == 'administrador') {
                $request->merge(['md_rol' => $user->rol, 'md_id' => $user->id]);
                return $next($request); // Usuaris administrador trobat. Token correcta. Continuam am la petició
            } else {
                return response()->json(['error' => 'Accés no autoritzat'], 401); // token incorrecta
            }
        } else {
            return $next($request);
        }
    }
}
