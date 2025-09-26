<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\patient_audits;

class PatientAuditController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($patient_id)
    {
        $this->authorize('viewAny', patient_audits::class);
        return patient_audits::where('patient_id', $patient_id)->get();
    }

}
