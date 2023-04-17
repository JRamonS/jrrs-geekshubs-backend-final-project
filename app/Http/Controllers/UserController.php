<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
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
}
