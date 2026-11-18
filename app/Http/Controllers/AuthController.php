<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // fungsi register untuk mendaftarkan pengguna baru.
    // fungsi ini menerima permintaan HTTP (Request) yang berisi data pengguna, memvalidasi data tersebut, membuat pengguna baru di database, dan menghasilkan token API untuk autentikasi.
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            // kondisi 'confirmed' memastikan bahwa ada field tambahan bernama 'password_confirmation' yang harus cocok dengan field 'password'.
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            ...$data,
            'password' => Hash::make($data['password']),
        ]);
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json(
            ['user' => $user, 'token' => $token],
            201
        );
    }

    public function login(Request $request)
    {
        $c = $request->validate([

            'email' => ['required', 'email'],

            'password' => ['required'],
        ]);

        $user = User::where('email', $c['email'])->first();

        if (
            ! $user ||

            ! Hash::check($c['password'], $user->password)
        ) {

            return response()->json([
                'success' => false,

                'message' => 'Email atau password salah.',
            ], 401);

        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json(

            ['user' => $user, 'token' => $token]
        );
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout berhasil.']);
    }
}
