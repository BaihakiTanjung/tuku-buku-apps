<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors()
            ], 422);
        }

        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = $request->user();
        $token = $user->createToken('auth_token')->plainTextToken;
        $tokenExpired = Carbon::parse($user->tokens()->first()->created_at)->addMinutes(60);

        return response()->json([
            'access_token' => $token,
            'user' => $user,
            'role' => $user->role,
            'code' => 200,
            'token_type' => 'Bearer',
            'token_expired' => $tokenExpired
        ]);
    }

    public function logout(Request $request)
    {


        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Successfully logged out',
            'code' => 200
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|min:6',
            'confirmPassword' => 'required|same:password'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'user'
        ]);
        $user->save();

        return response()->json([
            'message' => 'Successfully created user!',
            'code' => 200,
            'user' => $user,

        ], 201);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
