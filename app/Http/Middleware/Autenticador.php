<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Exception;
use Firebase\JWT\JWT;

class Autenticador
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            //code...
        
            if (!$request->hasHeader('Authorization')) {
                throw new Exception();
            }
            $token = str_replace("Bearer ", "", $request->header("Authorization"));
            $dadosAutenticacao = JWT::decode($token, env("JWT_KEY"), ["HS256"]);
            // return new GenericUser(["email" => $dadosAutenticacao["email"]]);
            $usuario = User::where('email', $dadosAutenticacao->email)->first();
            if ($usuario) {
                return $next($request);
            }
            return new Exception();
        } catch (\Exception $th) {
            return response()->json("Não autorizado", 401);
        }
    }
}
