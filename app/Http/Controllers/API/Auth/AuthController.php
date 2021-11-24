<?php

namespace App\Http\Controllers\API\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\LogoutUserRequest;
use App\Http\Requests\Users\StoreUserRequest;
use App\Http\Resources\AuthUser\AuthUserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    
    public function login(Request $request) {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
                'device_name' => 'required',
            ]);
        
            $user = User::where('email', $request->email)->first();
        
            if (! $user || ! Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }

            $user->tokens()->where('name', $request->device_name)->delete();
            $token = $user->createToken($request->device_name, ['item:read','item:write'])->plainTextToken;
            $user->token = $token;
            $user->device_name = $request->device_name;
            
            return new AuthUserResource($user);

        } catch (\Throwable $th) {
            throw $th;
        }
        
    }

    public function register(StoreUserRequest $storeUserRequest) {
        try {
            User::create($storeUserRequest->all());
            return response()->json([
                'message' => 'User Created!'
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
        }

    }
    public function logout(LogoutUserRequest $logoutUserRequest) {
        try {
            $user = User::findOrFail($logoutUserRequest->user_id);
            $user->tokens()->where('name', $logoutUserRequest->device_name)->delete();
            return response()->json([
                'message' => 'User Logged Out!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }
}
