<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{


    public function createAppointment(Request $request)
{
    try {
        $validator = Validator::make($request->all(), [
            'observation' => 'required|string',
            'dateTime' => 'required|date_format:Y-m-d H:i:s',
            'service_id' => 'required',
            'pet_id' => 'required|exists:pets,id,user_id,' . auth()->user()->id  
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $observation = $request->input('observation');
        $dateTime = $request->input('dateTime');
        $serviceId = $request->input('service_id');
        $petId = $request->input('pet_id');

        $appointment = new Appointment();
        $appointment->observation = $observation;
        $appointment->dateTime = $dateTime;
        $appointment->pet_id = $petId;
        $appointment->service_id = $serviceId;
        $appointment->user_id = auth()->user()->id;

        $appointment->save();

        return response()->json(
            [
                "success" => true,
                "message" => "Appointment created",
                "data" => $appointment
            ],
            200
        );
    } catch (\Throwable $th) {
        Log::error("CREATE APPOINTMENT: " . $th->getMessage());
        return response()->json(
            [
                "success" => false,
                "message" => "Error creating appointment"
            ],
            500
        );
    }
}
    
}
