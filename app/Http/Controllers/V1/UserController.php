<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ShowUserResource;
use App\Models\User;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function store(string $username, string $email, string $password): User
    {
        $userData = [
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ];

        return User::create($userData);
    }

    public function show(string $id)
    {
        $user = User::findOrFail($id);
        
        return response([
            'status' => 'OK',
            'message' => 'daily order read successfully',
            'data' => new ShowUserResource($user),
        ]);
    }
}
