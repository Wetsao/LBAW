<?php

namespace App\Policies;

use App\Models\ProjectCoordinator;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProjectCoordinatorPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        return $user->isCoordinator($user);
    }
}
