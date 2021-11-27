<?php

namespace App\Http\Controllers\API\WebApp\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\WebApp\Auth\RegisterUserReqeust;
use App\Http\Resources\AuthUser\AuthUserResource;
use App\Http\Resources\AuthUser\WebAppUserResource;
use BadMethodCallException;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return new WebAppUserResource(auth()->user());
        }
        throw new BadMethodCallException("User Credentials Are Wrong!");
        
    }

    public function register(RegisterUserReqeust $registerUserReqeust)
    {
       
        $user = User::create($registerUserReqeust->all());
        
        return response()->json([
            'message' => 'User Created!',
            'data' => $user
        ]);
        
    }
}
