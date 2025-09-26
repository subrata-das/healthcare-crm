<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'email', 'specialization', 'phone', 'user_id'
    ];

    public function appointment(): HasOne
    {
        return $this->HasOne(Appointment::class);
    }
}
