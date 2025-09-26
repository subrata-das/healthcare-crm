<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Relations\HasOne;


class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name', 'last_name', 'date_of_birth', 'gender', 'phone_number',
        'email', 'address', 'emergency_contact_name', 'emergency_contact_phone',
        'insurance_details', 'patient_id',
    ];


    public function appointment(): HasOne
    {
        return $this->HasOne(Appointment::class);
    }

    // Automatically generate patient_id before saving
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($patient) {
            // Loop until a truly unique ID is generated (in case of collision)
            do {
                $patientId = 'PAT-' . strtoupper(Str::random(8));
            } while (self::where('patient_id', $patientId)->exists());

            $patient->patient_id = $patientId;
        });

        // Audit: Created
        static::created(function ($patient) {
            Patient::logAudit($patient, 'created', [], $patient->toArray());
        });

        // Audit: Updated
        static::updating(function ($patient) {
            $original = $patient->getOriginal();
            $changes = $patient->getDirty();

            if (!empty($changes)) {
                Patient::logAudit($patient, 'updated', $original, $changes);
            }
        });

        // Audit: Deleted
        static::deleted(function ($patient) {
            Patient::logAudit($patient, 'deleted', $patient->toArray(), []);
        });
    }

    public static function logAudit($patient, $action, $oldValues = [], $newValues = [])
    {
        patient_audits::create([
            'user_id'     => Auth::id() ?? null,
            'patient_id'  => $patient->id,
            'action'      => $action,
            'old_values'  => json_encode($oldValues),
            'new_values'  => json_encode($newValues),
            'ip_address'  => Request::ip(),
        ]);
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
