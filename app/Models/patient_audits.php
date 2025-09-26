<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class patient_audits extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'patient_id', 'action', 'old_values', 'new_values', 'ip_address'
    ];
}
