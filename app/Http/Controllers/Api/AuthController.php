<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    private $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
        $this->userRepository = $userRepository;
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        try {
            if (! $token = auth()->attempt($credentials)) {
                return response()->json(['error' => 'invalid credentials'], 401);
            }
        } catch (\PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException $e) {
            return response()->json([
                'error' => 'Unauthorize'
            ], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function register(UserRequest $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ];
        $result = $this->userRepository->register($data);
        return response()->json([
            'success' => true,
            'data' => $result
        ]);
    }
}