<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\AuthServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function login(LoginRequest $request, AuthServices $service){
        $credentials = $request->validated();
        
        if($service->loginUser($credentials) === 500){
            return response(['message_error' => 'Account Blocked!'], 422);
        }elseif($service->loginUser($credentials) === 422){
            return response(['message_error' => 'Invalid Credentials!'], 422);
        }

       /** @var User $user **/
        $user = Auth::user();
        $user_token = $user->createToken('main')->plainTextToken;

        return response(compact('user', 'user_token'));
    }
}
