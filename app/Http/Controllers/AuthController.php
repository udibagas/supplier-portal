<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    // untuk register vendor
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        $input = $request->all();
        $input['password'] = bcrypt($request->password);
        $input['role'] = User::ROLE_VENDOR;
        $input['active'] = 1;
        $input['api_token'] = str_random(60);
        $user = User::create($input);
        $jwt_token = JWTAuth::attempt($request->only('email', 'password'));

        return response()->json([
            'success' => true,
            'token' => $jwt_token,
            'user' => $user
        ]);
    }

    public function login(Request $request)
    {
        $input = $request->only('email', 'password');
        $input['active'] = 1;
        $jwt_token = null;

        if (!$jwt_token = JWTAuth::attempt($input)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Email or Password',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'token' => $jwt_token,
            'user' => auth()->user()
        ]);
    }

    public function logout(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);

        try {
            JWTAuth::invalidate($request->token);

            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, the user cannot be logged out'
            ], 500);
        }
    }

    public function getAuthUser(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);

        $user = JWTAuth::authenticate($request->token);

        return response()->json(['user' => $user]);
    }
}
