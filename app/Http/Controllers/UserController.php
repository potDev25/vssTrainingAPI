<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::paginate($request->limit);
        return response($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $saveUser = User::create($request->validated());

        if ($saveUser) {
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
    public function update(User $user, Request $request)
    {   
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id
        ]);
        
        if(!$user) {
            return response(['message' => 'No User Found!'], 500);
        } else {
            $user->update($data);
        }

        return response(200);
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
}
