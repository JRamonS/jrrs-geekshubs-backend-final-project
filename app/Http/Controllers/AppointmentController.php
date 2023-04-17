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


public function updateAppointment(Request $request,)
{
    try {
        $validator = Validator::make($request->all(), [
            'observation' => 'required|string',
            'dateTime' => 'required|date_format:Y-m-d H:i:s',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $appointment = Appointment::find($request->input('appointment_id'));

        if (!$appointment) {
            return response()->json(
                [
                    "success" => true,
                    "message" => "Appointment doesn't exists",
                ],
                400
            );
        }

        // Verificar si el usuario está autorizado para actualizar la cita
        if ($appointment->pet->user_id !== auth()->user()->id) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "You are not authorized to update this appointment",
                ],
                400
            );
        }

        $observation = $request->input('observation');
        $dateTime = $request->input('dateTime');


        $appointment->observation = $observation;
        $appointment->dateTime = $dateTime;


        $appointment->save();

        return response()->json(
            [
                "success" => true,
                "message" => "Appointment updated",
                "data" => $appointment
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

public function deleteAppointment(Request $request,)
{
    try {
        $appointment = Appointment::find($request->input('appointment_id'));

        if (!$appointment) {
            return response()->json(
                [
                    "success" => true,
                    "message" => "Appointment doesn't exists",
                ],
                400
            );
        }

        // Verificar si el usuario está autorizado para eliminar la cita
        if ($appointment->pet->user_id !== auth()->user()->id) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "You are not authorized to delete this appointment",
                ],
                400
            );
        }

        $appointment->delete();

        return response()->json(
            [
                "success" => true,
                "message" => "Appointment deleted"
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

public function getAppointmentsByUser(Request $request)
{
    try {
        $user = $request->user(); // Obtener el usuario autenticado
        $appointments = $user->appointments()->get(); // Obtener todas las citas del usuario

        return response()->json(
            [
                "success" => true,
                "message" => "User appointments",
                "data" => $appointments
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
