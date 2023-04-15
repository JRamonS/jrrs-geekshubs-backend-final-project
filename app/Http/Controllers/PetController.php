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
            $breed = $request->input('breed');
            $age = $request->input('age');
            $type = $request->input('type');

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
                    "message" => "Pet Register",
                    "data" => $pet
                ],
                200
            );
        } catch (\Throwable $th) {
            Log::error("REGISTER PET: " . $th->getMessage());
            return response()->json(
                [
                    "success" => false,
                    "message" => "error register pet"
                ],
                500
            );
        }
    }
    

    public function getPetsByUser(Request $request)
{
    try {
        $user = $request->user(); // Obtener el usuario autenticado
        $pets = $user->pets()->get(); // Obtener todas las mascotas del usuario

        return response()->json(
            [
                "success" => true,
                "message" => "User pets",
                "data" => $pets->map(function($pet) {
                    return [
                        'id' => $pet->id,
                        'name' => $pet->name,
                        'breed' => $pet->breed,
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