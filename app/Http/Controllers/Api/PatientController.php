<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Traits\ApiResponser;
use App\Models\Patient;

class PatientController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Patient::class);
        $patients = Patient::paginate(10);
        if(!$patients){
            return $this->error('Data not found', [], 404);
        }

        return $this->success($patients, 'Patient Details');
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
        $this->authorize('create', Patient::class);

        $validator = Validator::make(request()->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date_format:Y-m-d',
            'gender' => 'required|in:Male,Female,Other',
            'phone_number' => 'required|string|max:10|unique:patients,phone_number',
            'email' => 'nullable|string|email|unique:patients,email',
            'address' => 'nullable|string',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:10',
            'insurance_details' => 'nullable|json'
        ]);
        
        if ($validator->fails()) {
            return $this->error('Unprocessable content occurred', $validator->errors(), 422);
        }
        $patient = Patient::create(request()->all());
        return $this->success($patient, 'Patient has been created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $patient = Patient::find($id);
        if(!$patient){
            return $this->error('Data not found', [], 404);
        }
        $this->authorize('view', $patient);
        return $this->success($patient, 'Patient has been created successfully.');
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
            'first_name' => 'string|max:255',
            'last_name' => 'string|max:255',
            'date_of_birth' => 'date_format:Y-m-d',
            'gender' => 'in:Male,Female,Other',
            'phone_number' => 'string|max:10|unique:patients,phone_number',
            'email' => 'nullable|string|email|unique:patients,email',
            'address' => 'nullable|string',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:10',
            'insurance_details' => 'nullable|json'
        ]);
        
        if ($validator->fails()) {
            return $this->error('Unprocessable content occurred', $validator->errors(), 422);
        }

        $patient = Patient::find($id);
        $this->authorize('update', $patient);
        if(!$patient){
            return $this->error('Data not found', [], 404);
        }
        $updated_patient = Patient::PrepareBeforeUpdate($patient);
        // dd($updated_patient );
        // $patient = Patient::updating($updated_patient);
        $patient->save();
        return $this->success($patient, 'Patient has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $patient = Patient::find($id);
        $this->authorize('delete', $patient);
        if(!$patient){
            return $this->error('Data not found', [], 404);
        }
        $patient->delete();
        return $this->success($patient, 'data has been deleted successfully.');
    }

    public function search(Request $request){
        $search_str = $request->input('filter');
        if(!$search_str){
            return $this->error('Data not found', [], 404);
        }
        $patients = Patient::where('first_name', 'like', '%' . $search_str . '%')
                          ->orWhere('last_name', 'like', '%' . $search_str . '%')
                          ->orWhere('phone_number', 'like', '%' . $search_str . '%')
                          ->orderBy('created_at', 'desc')
                          ->paginate(10);

        if(!$patients){
            return $this->error('Data not found', [], 404);
        }

        return $this->success($patients, 'Search result');
    }
}
