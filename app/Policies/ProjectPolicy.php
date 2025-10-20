<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProjectPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Project $projectMember): bool
    {
        return ($user->is_admin || $user->id === $projectMember->user_id);
    }

}
