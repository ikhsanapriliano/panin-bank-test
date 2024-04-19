<?php

namespace App\Http\Controllers;

use App\Dto\ResponseDto;
use App\Dto\UserDto;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class AuthController extends Controller
{
    private AuthService $AuthService;

    public function __construct(AuthService $AuthService)
    {
        $this->AuthService = $AuthService;
    }

    public function register(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
                'role' => 'required'
            ]);

            $payload = new UserDto($request->name, $request->email, $request->password, $request->role);

            $data = $this->AuthService->register($payload);
            $message = "success";

            $response = new ResponseDto($message, $data);

            return response()->json($response, 201);
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function login(Request $request): JsonResponse 
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|min:6',
            ]);

            $credentials = $request->only('email', 'password');

            $data = $this->AuthService->login($credentials);
            $message = "success";

            if ($data === null) {
                $message = "wrong email or password";
            }

            $response = new ResponseDto($message, $data);

            return response()->json($response, 200);
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
