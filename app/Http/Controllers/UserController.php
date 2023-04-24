<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{

    public function getAllUsers()
    {
        try {
            $users = User::query()->get();

            return [
                "message" => "All Users",
                "success" => true,
                "data" => $users
            ];
        } catch (\Exception $th) {
            Log::error("Getting all Users: " . $th->getMessage());
            return response()->json(
                [
                    "success" => false,
                    "message" => "Error occurred when getting the users"
                ],
                500
            );
        }
    }

    public function getUserById(Request $request)
{
    try {
        $user = Auth::user();
        $userById = $user;

        return [
            "message" => "User",
            "success" => true,
            "data" => $userById
        ];
    } catch (\Exception $th) {
        Log::error("Getting User by ID: " . $th->getMessage());
        return response()->json(
            [
                "success" => false,
                "message" => "Error occurred when getting the user"
            ],
            500
        );
    }
}

    public function deleteUser(Request $request,)
{
    try {
        $id = $request->input('id');
        $user = User::findOrFail($id);
        $user->active = false;
        $user->save();

        //Disable all pets associated with the user
        $user->pets()->update(['active' => false]);

        return response()->json(
            [
                "success" => true,
                "message" => "User deleted"
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
