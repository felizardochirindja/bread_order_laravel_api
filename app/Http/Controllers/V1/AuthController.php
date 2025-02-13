<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ShowUserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function __construct(
        private UserController $userController,
    ) {}

    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            Log::error('user login failed');

            return response()->json(
                [
                    'status' => 'ERROR',
                    'message' => 'Unauthorized',
                ],
                401,
            );
        }

        return $this->respondWithToken($token, 'logged in successfully');
    }

    public function logout()
    {
        auth()->logout();

        return response()->json([
            'status' => 'OK',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh(), 'acess token refreshed successfully');
    }

    public function me()
    {
        return response()->json([
            'status' => 'OK',
            'message' => '',
            'data' => auth()->user(),
        ]);
    }

    public function signUp(Request $request)
    {
        $request->validate([
            'username' => ['required'],
            'email' => ['required'],
            'password' => ['required'],
        ]);

        $user = $this->userController->store($request->username, $request->email, $request->password);

        return response([
            'status' => 'OK',
            'message' => 'user signed up successfully!',
            'data' => new ShowUserResource($user),
        ]);
    }

    private function respondWithToken(string $token, string $message)
    {
        return response()->json([
            'status' => 'OK',
            'message' => $message,
            'data' => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ]
        ]);
    }
}
