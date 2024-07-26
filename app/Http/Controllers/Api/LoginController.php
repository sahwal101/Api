<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;



use App\Models\User;


class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     */
    public function authenticate(Request $request)
    {
        if (!auth()->attempt($request->only('email', 'password'))) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid login details'
            ], 401);
        }
        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response ()->json([
            'status' => true,
            'data' => $user,
            'access_token' => $token,
            'message' => 'Login Success',
        ], 200);
    }

    public function logout(Request $request)
    {
       auth()->user()->tokens()->delete();

       return response()->json([
        'status' => true,
        'message' => 'Logout Success',
       ], 200);
    }

    public function register(Request $request)

    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if($validator->fails()) {
            return response()->json($validator->erors());
        }

        $user = User::created([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return response()->json([
            'data'=> $user,
            'succes'=> true,
            'message'=> 'User Berhasil Dibuat',
        ]);
    }
}
