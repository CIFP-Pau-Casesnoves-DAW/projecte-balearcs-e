<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Usuaris;
use App\Models\Comentaris;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ControlaDadesComentaris
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->header('Authorization')) { // Hem rebut el header d’autorització?
            $key = explode(' ', $request->header('Authorization')); // Esperam un token 'Bearer token'
            $token = 'x'; // Els usuaris que no han fet mai un login tenen un token buit;
            if (count($key) == 2) {
                $token = $key[1]; // key[0]->Bearer key[1]→token
            }
            $comentari_id = $request->route('id');
            $usuari_id = Comentaris::where('id', $comentari_id)->value('usuari_id');
            $user = Usuaris::where('api_token', $token)
                ->first();
            if (!empty($user) && ($user->id == $usuari_id || $user->rol == "administrador")) {
                $request->merge(['md_rol' => $user->rol, 'md_id' => $user->id]);
                return $next($request); // Usuaris trobat. Token correcta. Continuam am la petició
            } else {
                return response()->json(['error' => 'Accés no autoritzat'], 401); // token incorrecta
            }
        } else {
            return response()->json(['error' => 'Token no rebut'], 401);
        }
    }
}
