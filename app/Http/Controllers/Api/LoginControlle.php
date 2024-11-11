<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Log;
use Tymon\JWTAuth\Facades\JWTAuth;


class LoginControlle extends Controller
{

    public function login(Request $request)
    {
        $dados = $request->only('email', 'password');

        $user = User::where('email', $dados['email'])->first();

        if (!$user || !Hash::check($dados['password'], $user->password)) {
            abort(401, 'invalido');
        }
    
        $token = JWTAuth::fromUser($user);

        return response()->json([
            'data' => [
                'token' => $token,
            ],
        ]);
    }
    

    public function logout(User $user): JsonResponse
    {
        try {
            $user->token()->delete();

            return response()->json([
                'status' => true,
                'messagem' => 'voce doi deslogado',
            ], 201);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'messagem' => 'erro ao deslogar'
            ], 404);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
