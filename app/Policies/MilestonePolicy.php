<?php

namespace App\Policies;

use App\Models\User;

class MilestonePolicy
{
    public function create(User $user, Grant $grant)
    {
        // Only project leader can create a milestone
        return Gate::allows('isLeader', $grant);
    }

    public function update(User $user, Milestone $milestone)
    {
        // Only project leader can update milestones for their grant
        return Gate::allows('isLeader', $milestone->grant);
    }

    public function delete(User $user, Milestone $milestone)
    {
        // Only project leader can delete milestones for their grant
        return Gate::allows('isLeader', $milestone->grant);
    }

    public function __construct()
    {
        //
    }
}
