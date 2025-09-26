<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id', 'doctor_id', 'appointment_date', 'appointment_time', 'status', 'notes'
    ];


    public function patient(): BelongsTo    
    {
        return $this->BelongsTo(Patient::class);
    }

    public function doctor(): BelongsTo    
    {
        return $this->BelongsTo(Doctor::class);
    }



    public static function getDoctorAppointment(){
        return Appointment::where('doctor_id', Request::input('doctor_id'))
                            ->where('appointment_date', Request::input('appointment_date'))
                            ->where('appointment_time', Request::input('appointment_time'))
                            ->get();
        
    }

    public static function getPatientById($id){
        return Appointment::where('patient_id', $id)->get();
    }


    public static function PrepareBeforeUpdate($patient){
        $inputs = request()->all();
        foreach ($inputs as $key => $value) {
            if(isset($patient->$key) && ($patient->$key != $value)){
                $patient->$key = $value;
            }
        }
        return $patient;
    }


}
