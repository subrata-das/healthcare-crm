<?php

namespace App\Policies;

use App\Models\patient_audits;
use App\Models\User;

class PatientAuditPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->hasRole(['Admin'])) {
            return true;
        }

        return false;
    }
}
