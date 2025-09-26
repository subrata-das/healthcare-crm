<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Appointment::class);
        $appointments = Appointment::paginate(10);
        if(!$appointments){
            return $this->error('Data not found', [], 404);
        }

        return $this->success($appointments, 'Appointments detail');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Appointment::class);

        $validator = Validator::make(request()->all(), [
            'patient_id' => 'required|integer|exists:patients,id',
            'doctor_id' => 'required|integer|exists:doctors,id',
            'appointment_date' => 'required|date_format:Y-m-d',
            'appointment_time' => 'required|date_format:H:i',
            'status' => 'required|in:Scheduled, Confirmed, Completed, Cancelled, No-Show',
            'notes' => 'nullable|string',

        ]);
        
        if ($validator->fails()) {
            return $this->error('Unprocessable content occurred', $validator->errors(), 422);
        }
        $preAppointment = Appointment::getDoctorAppointment();
        if($preAppointment->isNotEmpty()){
            return $this->error('Already schedule', [], 200);
        }
        $appointment = Appointment::create(request()->all());
        return $this->success($preAppointment, 'Appointment has been created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make(request()->all(), [
            'patient_id' => 'integer|exists:patients,id',
            'doctor_id' => 'integer|exists:doctors,id',
            'appointment_date' => 'date_format:Y-m-d',
            'appointment_time' => 'date_format:H:i',
            'status' => 'in:Scheduled, Confirmed, Completed, Cancelled, No-Show',
            'notes' => 'nullable|string',

        ]);
        
        if ($validator->fails()) {
            return $this->error('Unprocessable content occurred', $validator->errors(), 422);
        }
        $appointment = Appointment::with('doctor')->find($id);
        
        if(!$appointment){
            return $this->error('Data not found', [], 404);
        }
        $this->authorize('update', $appointment);
        $preAppointment = Appointment::getDoctorAppointment();
        if($preAppointment->isNotEmpty()){
            return $this->error('Already schedule', [], 404);
        }
        // dd($appointment);
        $updated_appointment = Appointment::PrepareBeforeUpdate($appointment);
        // dd($updated_appointment );
        $updated_appointment->save();
        return $this->success($updated_appointment, 'Appointment has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $appointment = Appointment::find($id);
        if(!$appointment){
            return $this->error('Data not found', [], 404);
        }
        $this->authorize('delete', $appointment);
        $appointment->delete();
        return $this->success($appointment, 'Appointment has been deleted successfully.');
    }


    public function by_patient(string $id){
        $id = (int)$id;
        $appointments = Appointment::with('doctor')->with('patient')->where('patient_id', $id)->get();
        foreach ($appointments as $appointment) {
            $this->authorize('viewByPatient', $appointment);
        }
        
        if($appointments->isEmpty()){
            return $this->error('data not found', [], 404);
        }
        return $this->success($appointments, 'result.');
    }

    public function by_doctor(string $id){
        $appointments = Appointment::with('patient')->where('doctor_id', $id)->get();
        foreach ($appointments as $appointment) {
            $this->authorize('viewByDoctor', $appointment);
        }
        if($appointments->isEmpty()){
            return $this->error('data not found', [], 404);
        }
        return $this->success($appointments, 'Appointments detail');
    }
}
