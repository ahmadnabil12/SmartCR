<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grant extends Model
{
    protected $fillable = [
        'grant_amount', 'grant_provider', 'project_title', 'project_description', 'start_date', 'end_date', 'duration', 'leader_id'
    ];

    /**
     * A grant has one project leader (Academician).
     */
    public function leader()
    {
        return $this->belongsTo(Academician::class, 'leader_id'); // Corrected: using belongsTo to define the relationship
    }

    public function members()
    {
        return $this->academicians()->wherePivot('role', 'member');
    }

    /**
     * A grant can have many members (Academicians).
     */
    public function academicians()
    {
        return $this->belongsToMany(Academician::class)
            ->withPivot('role')
            ->withTimestamps();
    }

    /**
     * A grant can have many milestones.
     */
    public function milestones()
    {
        return $this->hasMany(Milestone::class);  // One to many (Grant -> Milestones)
    }
}
