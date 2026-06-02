<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    // Получить все записи пользователя
    public function index(Request $request)
    {
        $appointments = Appointment::where('user_email', $request->user()->email)->get();
        return response()->json($appointments);
    }

    // Создать новую запись
    public function store(Request $request)
    {
        $request->validate([
            'service' => 'required|string',
            'price' => 'required|integer',
            'date' => 'required|string',
        ]);

        $appointment = Appointment::create([
            'user_email' => $request->user()->email,
            'service' => $request->service,
            'price' => $request->price,
            'date' => $request->date,
            'status' => 'pending',
        ]);

        return response()->json($appointment, 201);
    }
}
