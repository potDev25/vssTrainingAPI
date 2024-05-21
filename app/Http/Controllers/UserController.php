<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
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
    public function show(User $user)
    {
        if (!$user) {
            return response(['message' => 'No User Found!'], 500);
        }
        return response($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        
        if(!$user) {
            return response(['message' => 'No User Found!'], 500);
        } else {
            $user->update($validated);
        }

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
