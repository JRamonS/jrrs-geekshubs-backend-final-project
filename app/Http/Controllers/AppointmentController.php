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

            $appointments = Appointment::with(
                [ 
                    'pet' => function ($query) {
                        $query->select('id', 'name', 'breed', 'type');
            }, 
                    'service' => function ($query) {
                        $query->select('id', 'duration', 'description', 'type');
            },
                    'user' => function ($query) {
                        $query->select('id', 'name', 'surname', 'phone', 'address');
            }])
            ->select('id', 'observation', 'dateTime', 'pet_id', 'service_id', 'user_id')
            ->get();

            return [
                "message" => "All Appointments",
                "success" => true,
                "data" => $appointments,
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
            $appointments = $user->appointments()->get(); // Get all the user's appointments

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
