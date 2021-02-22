<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

use App\Http\Requests\AuthRequest;

class SessionController extends Controller
{
    public function auth(AuthRequest $request)
    {
        $request->validated();

        $user = User::where('email', $request->email)->first();
        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json(["message" => "email atau password yang dimasukkan kurang tepat"], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json(["access_token" => $user->createToken('my-token')->plainTextToken], Response::HTTP_CREATED);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        // $request->user()->tokens()->where('tokenable_id', auth()->user()->id)->delete();

        return response()->json(["message" => "logout berhasil"], Response::HTTP_OK);
    }
}
