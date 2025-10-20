<?php

namespace App\Policies;

use App\Models\ProjectMember;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProjectMemberPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        return $user->isCoordinator($user);
    }


    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ProjectMember $projectMember): bool
    {
        return (!$user->is_admin || $user->id === $projectMember->user_id);
    }

}
