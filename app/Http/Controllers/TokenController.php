<?php

namespace App\Http\Controllers;

use App\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TokenController extends Controller
{
    public function gerarToken(Request $request)
    {
        $this->validate($request, [
            "email" => "required|email",
            "password" => "required"
        ]);
        $usuario = User::where("email", $request->email)->first();
        $correta = Hash::check($request->password, $usuario->password);
        if (is_null($usuario) || !$correta) {
            return response()->json("", 401);
        }
        
        $token = JWT::encode(["email" => $usuario->email], env("JWT_KEY"));
        return [
            "access_token" => $token
        ];
    }
}
