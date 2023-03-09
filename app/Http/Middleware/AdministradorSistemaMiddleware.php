<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\User;

class AdministradorSistemaMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $usuarioLogado = auth()->user();
        $usuario = User::with('estabelecimentos.plano')->find($usuarioLogado->codigo_usuario);
        // return new JsonResponse(['dados' =>  $usuario], 200);

        if ($usuario->estabelecimentos->plano->eh_admin != 1) {
            return new JsonResponse([
                'error' => true,
                'message' => 'Você não tem permissão para acessar esta página.'
            ], 403);
        }

        return $next($request);
    }
}
