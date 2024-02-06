<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

/**
 * Class AuthController
 *
 * This class handles authentication-related API endpoints such as user registration, login, and logout.
 * It extends the BaseController for handling response formatting.
 *
 * @package App\Http\Controllers
 */
class AuthController extends BaseController
{
    /**
     * Register a new user.
     *
     * @param  \Illuminate\Http\Request  $request  The HTTP request containing user registration data.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response indicating success or failure of user registration.
     */
    public function register(Request $request): JsonResponse
    {
        // Validation rules for user registration data
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        // If validation fails, return error response
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        // Create a new user with hashed password
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        // Generate token for the user
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['name'] = $user->name;

        // Return success response
        return $this->sendResponse($success, 'User registered successfully.');
    }

    /**
     * Authenticate and login a user.
     *
     * @param  \Illuminate\Http\Request  $request  The HTTP request containing user login credentials.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response indicating success or failure of user login.
     */
    public function login(Request $request): JsonResponse
    {
        // Attempt authentication using email and password
        if (Auth::attempt([
            'email' => $request->email, 'password' => $request->password
        ])) {
            $user = Auth::user();

            // Generate token for the authenticated user
            $success['token'] = $user->createToken('MyApp')->accessToken;
            $success['name'] = $user->name;

            // Return success response
            return $this->sendResponse($success,
                'User logged in successfully.');
        }

        // If authentication fails, return error response
        return $this->sendError('Unauthorized.', ['error' => 'Unauthorized']);
    }

    /**
     * Logout the authenticated user (Revoke the token).
     *
     * @param  \Illuminate\Http\Request  $request  The HTTP request containing user authentication token.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response indicating success of user logout.
     */
    public function logout(Request $request): JsonResponse
    {
        // Revoke the authentication token for the authenticated user
        $request->user()->token()->revoke();

        // Return success response
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
