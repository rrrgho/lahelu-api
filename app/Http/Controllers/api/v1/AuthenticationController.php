<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;


 

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Lahelu Clone ( API Documentation )",
 *      description="API documentation for my Laravel application",
 * )
 * 
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     properties={
 *         @OA\Property(property="id", type="integer", format="int64", example=1),
 *         @OA\Property(property="name", type="string", example="John Doe"),
 *         @OA\Property(property="email", type="string", format="email", example="johndoe@mail.com"),
 *         @OA\Property(property="created_at", type="string", format="date-time"),
 *         @OA\Property(property="updated_at", type="string", format="date-time")
 *     }
 * )
 */

class AuthenticationController extends Controller
{
    /**
     * @OA\Post(
     *     path="api/v1/auth/user/registration",
     *     summary="Register a new user",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email","password"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="johndoe@mail.com"),
     *             @OA\Property(property="password", type="string", format="password", example="johnsecret99")   

     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="user", type="object", ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,   

     *         description="Validation error",   

     *     )
     * )
     */
    public function registration(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create the new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Return a successful response with the created user data
        return response()->json(['user' => $user], 201);
    }

    /**
     * @OA\Post(
     *     path="api/v1/auth/user/login",
     *     summary="Login a user",
     *     tags={"Auth"},
     *     description="This will return a token which can be used to access all protected APIs. Please note that the token has an expiration time.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="email", example="wiza.yasmin@example.org"),   

     *             @OA\Property(property="password", type="string", format="password", example="password")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful",   

     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="1|ViZArgCtEcv3I5VIAI9zPRGaTk3bkFKhDmMqzHwL0aae1863")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid credentials",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *     )
     * )
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Create a token for the user using Sanctum
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json(['token' => $token], 200);
    }

    /**
     * @OA\Get(
     *     path="api/v1/auth/user",
     *     summary="Get authenticated user data",
     *     description="This function is protected by Laravel Sanctum. Please make sure the client passes the token before hitting this route.",
     *     security={{"sanctum": {}}}, 
     *     @OA\Response(
     *         response=200,
     *         description="User data retrieved successfully",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     )
     * )
     */
    public function getUserData(Request $request)
    {
        // Get the authenticated user
        $user = Auth::user();
        
        // Return the user data
        return response()->json($user, 200);
    }

    /**
     * Missing Token
     * Customize this to inform Client
     * about the token validation
     */
    public function missingToken(){
        return response()->json([
            'error' => 'You need token to verify and access protected API'
        ], 401);
    }
}
