<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{

    public function getAllAppointments()
    {
        try {
            $appointments = Appointment::with('user:id,name,surname,phone,address', 'service:id,name,price', 'pet:id,name,type')->get();

        $formattedAppointments = $appointments->map(function($appointment){
            return [
                'id' => $appointment->id,
                'observation' => $appointment->observation,
                'dateTime' => $appointment->dateTime,
                'user' => $appointment->user->only(['name', 'surname', 'phone', 'address']),
                'pet_id' => $appointment->pet_id,
                'pet' => $appointment->pet->only(['name', 'type']),
                'service_id' => $appointment->service_id,
                'service' => $appointment->service->only(['name', 'price'])
            ];
        });

            return [
                "message" => "All Appointments",
                "success" => true,
                "data" => $formattedAppointments
            ];
        } catch (\Exception $th) {
            Log::error("Getting all Appointments: " . $th->getMessage());
            return response()->json(
                [
                    "success" => false,
                    "message" => "Error occurred when getting the users"
                ],
                500
            );
        }
    }

    public function createAppointment(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'observation' => 'required|string',
                'dateTime' => 'required|',
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
                'dateTime' => 'required',
                'service_id' => 'required',
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

            // Verify if the user is authorized to update the appointment
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
            $serviceId = $request->input('service_id');


            $appointment->observation = $observation;
            $appointment->dateTime = $dateTime;
            $appointment->service_id = $serviceId;


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

            // Check if the user is authorized to delete the quote
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
            $user = $request->user(); // Get authenticated user
            $appointments = $user->appointments()
                ->with(['user', 'service', 'pet'])
                ->get(); // Get all the user's appointments with related models

            return response()->json(
                [
                    "success" => true,
                    "message" => "User appointments",
                    "data" => $appointments,
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
