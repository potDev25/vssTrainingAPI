<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\UserServices;
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

        //vadlidate the uploaded file
        $data = $request->validate([
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        // Get the file extension
        $extention = $request->file('image')->getClientOriginalExtension();

        // Get the mines type
        $minesType = $request->file('image')->getMimeType();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('media', 'public');
        }

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
}
