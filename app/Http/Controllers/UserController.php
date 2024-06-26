<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\UserServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::where('id', '!=', auth()->user()->id)->paginate($request->limit);
        return response($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request, UserServices $service)
    {
        if ($service->storeUser($request)) {
            return response(['message' => 'user added successfully'], 200);
        }
        return response(['message' => 'server error'], 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::select('name', 'email')->where('id', $id)->first();
        return response($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(User $user, UpdateUserRequest $request)
    {
        if (!$user) {
            return response(['message' => 'No User Found!'], 500);
        } else {
            $user->update($request->validated());
        }

        return response(200);
    }

    //update user status
    public function updateStatus(User $user, UserServices $service)
    {
        if ($service->changeStatus($user->id)) {
            return response(200);
        }
        return response(500);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if (!$user) {
            return response(['message' => 'No User Found!'], 500);
        } else {
            $user->delete();
        }
    }

    public function logout(Request $request){
        $user = $request->user();

        /** @var User $user **/
        $user->currentAccessToken()->delete();

        return response([
            "user" => $user
        ], 200);
    }
}
