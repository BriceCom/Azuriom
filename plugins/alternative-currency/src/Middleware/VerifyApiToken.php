<?php

namespace Azuriom\Plugin\AlternativeCurrency\Middleware;


use Closure;
use Illuminate\Http\Request;

class VerifyApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Récupérer l'en-tête Authorization
        $authorizationHeader = $request->header('Authorization');

        // Vérifier que l'en-tête contient "Bearer <token>"
        if (!$authorizationHeader || !str_starts_with($authorizationHeader, 'Bearer ')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Extraire le token
        $token = substr($authorizationHeader, 7); // Supprime le préfixe "Bearer "

        // Vérifier si le token est valide
        if ($token !== setting('alternative_currency.api_key')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
