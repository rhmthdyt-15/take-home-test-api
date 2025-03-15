<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function getUsers(){
        $user = User::all();
        return response()->json($user, 200);

    }

    public function createUsers(CreateUserRequest $request){
          $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request['password']),
        ]);

          return response()->json([
            'message' => "Create User Successfully!",
            'data' => $user
        ]);
    }

    public function getUsersDetail(int $id) {

        $user = User::findOrFail($id);
        return response()->json($user);

    }

    public function updateUsers(UpdateUserRequest $request, int $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validated();

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        return response()->json([
            'message' => 'User updated!',
            'data' => (object)[]
        ]);
    }


    public function deleteUsers(int $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'Users deleted']);
    }


}