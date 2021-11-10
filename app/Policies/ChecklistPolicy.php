<?php

namespace App\Policies;

use App\Models\Checklist;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChecklistPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function store(User $user, Checklist $checklist)
    {
        return $user->id === $checklist->user_id;
    }

    public function update(User $user, Checklist $checklist)
    {
        return $user->id === $checklist->user_id;
    }

    public function show(User $user, Checklist $checklist)
    {
        return $user->id === $checklist->user_id;
    }

    public function destroy(User $user, Checklist $checklist)
    {
        return $user->id === $checklist->user_id;
    }
}
