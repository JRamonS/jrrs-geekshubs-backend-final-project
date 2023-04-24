<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class PetController extends Controller
{

    public function registerPet(Request $request)
{
    try {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'breed' => 'required|string',
            'age' => 'required|string',
            'type' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $name = $request->input('name');
        $type = $request->input('type');

        // Check if the pet already exists in the database before creating it.
        $existingPet = Pet::where('name', $name)
                        ->where('type', $type)
                        ->first();

        if ($existingPet) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Pet already exists."
                ],
                400
            );
        }

        // If there is no existing pet with the same name and type, create a new one.
        $age = $request->input('age');
        $breed = $request->input('breed');
        

        $pet = new Pet();
        $pet->name = $name;
        $pet->breed = $breed;
        $pet->age = $age;
        $pet->type = $type;
        $pet->user_id = auth()->user()->id;

        $pet->save();

        return response()->json(
            [
                "success" => true,
                "message" => "Pet registered successfully",
                "data" => $pet
            ],
            200
        );
    } catch (\Throwable $th) {
        Log::error("REGISTER PET: " . $th->getMessage());
        return response()->json(
            [
                "success" => false,
                "message" => "Error registering pet"
            ],
            500
        );
    }
}


    public function getPetsByUser(Request $request)
{
    try {
        $user = $request->user(); // Get authenticated user
        $pets = $user->pets()->get(); // Get all the user's pets

        return response()->json(
            [
                "success" => true,
                "message" => "User pets",
                "data" => $pets->map(function($pet) {
                    return [
                        'id' => $pet->id,
                        'name' => $pet->name,
                        'breed' => $pet->breed,
                        'age' => $pet->age,
                        'type' => $pet->type,
                    ];
                })
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
