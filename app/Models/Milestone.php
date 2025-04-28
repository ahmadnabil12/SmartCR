<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Milestone extends Model
{

    protected $fillable = [
        'milestone_title', 'completion_date', 'deliverable', 'status', 'remark', 'grant_id',
    ];

    /**
     * A milestone belongs to a grant.
     */
    public function grant()
    {
        return $this->belongsTo(Grant::class);  // Many to one (Milestone -> Grant)
    }

}