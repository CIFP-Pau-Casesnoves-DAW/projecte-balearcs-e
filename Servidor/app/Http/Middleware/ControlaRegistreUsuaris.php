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
        $mail = '';
        $user = Usuaris::where('mail', $mail)
            ->first();
        if (!empty($user) && $user->rol === 'administrador') {
            $request->merge(['md_rol' => $user->rol, 'md_id' => $user->id]);
            return $next($request);
        } else {
            return response()->json(['error' => 'Accés no autoritzat'], 401);
        }
    }
}
