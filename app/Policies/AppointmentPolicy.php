<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AppointmentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->hasRole(['Admin', 'CRM Agent'])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Appointment $appointment): bool
    {
        //
        // Allow Admins or CRM Agents
        if ($user->hasRole(['Admin', 'CRM Agent', 'Doctor'])) {
            return true;
        }

        // Allow Patient to see their own record
        if ($user->hasRole('Patient') && $user->email === $appointment->email) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->hasRole(['Admin', 'CRM Agent'])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Appointment $appointment): bool
    {
        // dd($appointment->doctor->user_id);
        if ($user->hasRole(['Admin', 'CRM Agent'])) {
            return true;
        }

        if ($user->hasRole('Doctor') && $user->id === $appointment->doctor->user_id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Appointment $appointment): bool
    {
        if ($user->hasRole(['Admin', 'CRM Agent'])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Appointment $appointment): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Appointment $appointment): bool
    {
        //
    }

    public function viewByPatient(User $user, Appointment $appointment): bool
    {
        // dd($appointment);

        if ($user->hasRole(['Admin', 'CRM Agent'])) {
            return true;
        }

        // Allow Patient to see their own record
        if ($user->hasRole('Patient') && $user->email === $appointment->patient->email) {
            return true;
        }

        if ($user->hasRole('Doctor') && $user->id === $appointment->doctor->user_id) {
            return true;
        }
        // return true;
    }

    public function viewByDoctor(User $user, Appointment $appointment): bool
    {
        // dd($appointment);

        if ($user->hasRole(['Admin', 'CRM Agent'])) {
            return true;
        }

        if ($user->hasRole('Doctor') && $user->id === $appointment->doctor->user_id) {
            return true;
        }
        // return true;
    }

}
