<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Academician extends Model
{

    protected $fillable = [
        'name', 'staff_number', 'email', 'college', 'department', 'position', 'user_id'
    ];

    //testing testing

    /**
     * Academician can lead many grants (as project leader).
     */
    public function ledGrants()
    {
        return $this->hasMany(Grant::class, 'leader_id');  // One to many (Academician -> Grants)
    }

    /**
     * Academician can be a member of many grants.
     */
    public function grants()
    {
        return $this->belongsToMany(Grant::class, 'academician_grants')  // Many to many (Academician -> Grants)
                    ->withPivot('role');  // Store the 'role' of the academician in the pivot table
    }
}
