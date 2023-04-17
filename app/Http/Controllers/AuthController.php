<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|regex:/^[\pL\s\-]+$/u',
                'surname' => 'required|string|regex:/^[\pL\s\-]+$/u',
                'email' => ['required', 'email', 'unique:users,email', 'regex:/^[^@]+(\.[^@]+)*@\w+(\.\w+)+$/'],
                'password' => 'required|string|min:8|max:25|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]+$/',
                'phone' => 'required|string|max:15',
                'address' => 'required|string|max:40',
                
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $user = User::create([
                'name' => $request['name'],
                'surname' => $request['surname'],
                'email' => $request['email'],
                'password' => bcrypt($request['password']),
                'phone' => $request['phone'],
                'address' => $request['address'],
                'role_id' => 1
            ]);


            $res = [
                "success" => true,
                "message" => "User registered successfully",
                'data' => $user,
            ];

            

            return response()->json(
                $res,
                Response::HTTP_CREATED
            );
        } catch (\Throwable $th) {
            Log::error("Register error: " . $th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Register error"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|string',
                'password' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $user = User::query()->where('email', $request['email'])->first();
            // Validate if the user exists
            if (!$user) {
                return response(
                    ["success" => false, "message" => "Email or password are invalid",],
                    Response::HTTP_NOT_FOUND
                );
            }
            // Validate the password
            if (!Hash::check($request['password'], $user->password)) {
                return response(["success" => true, "message" => "Email or password are invalid"], Response::HTTP_NOT_FOUND);
            }

            $token = $user->createToken('apiToken')->plainTextToken;

            $res = [
                "success" => true,
                "message" => "User logged successfully",
                "token" => $token
            ];

            return response()->json(
                $res,
                Response::HTTP_ACCEPTED
            );
        } catch (\Throwable $th) {
            Log::error("Login error: " . $th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Login error"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function logout(Request $request)
    {
        try {
            $accessToken = $request->bearerToken();
            // Get access token from database
            $token = PersonalAccessToken::findToken($accessToken);
            // Revoke token
            $token->delete();

            return response(
                [
                    "success" => true,
                    "message" => "Logout successfully"
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            Log::error("Logout error: " . $th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Profile error"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function profile()
    {
        $user = auth()->user();

        return response(
            [
                "success" => true,
                "message" => "User profile get succsessfully",
                "data" => $user
            ],
            Response::HTTP_OK
        );
    }

    public function updateProfile(Request $request,)
    {
        try {

            //Verify user authentication
            $user = auth()->user();

            $validator = Validator::make($request->all(), [
                'phone' => 'required|string|max:15',
                'address' => 'required|string|max:60',
            ]);
        
            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }
        
            $register = User::find($user->id);
        
            if (!$register) {
                return response()->json(
                    [
                        "success" => true,
                        "message" => "Profile doesn't exists",
                    ],
                    400
                );
            }
        
            $phone = $request->input('phone');
            $address = $request->input('address');
        
            if (isset($phone)) {
                $register->phone = $phone;
            }
        
            if (isset($address)) {
                $register->address = $address;
            }
        
            $register->save();
        
            return response()->json(
                [
                    "success" => true,
                    "message" => "Profile updated",
                    "data" => $register
                ],
                200
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "success" => false,
                    "message" => $th->getMessage()
                ],
                500
            );
        }
    }
}
