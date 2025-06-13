<?php

namespace App\Policies;

use App\Models\PsikologVolunteer;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PsikologVolunteerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        // 
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PsikologVolunteer  $psikologVolunteer
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, PsikologVolunteer $psikologVolunteer)
    {
        // 
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        if ($user->id_role == config('env.role.admin')) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PsikologVolunteer  $psikologVolunteer
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, PsikologVolunteer $psikologVolunteer)
    {
        if ($user->id_role == config('env.role.admin')) {
            return true;
        }

        if ($user->id == $psikologVolunteer->created_by) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PsikologVolunteer  $psikologVolunteer
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, PsikologVolunteer $psikologVolunteer)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PsikologVolunteer  $psikologVolunteer
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, PsikologVolunteer $psikologVolunteer)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PsikologVolunteer  $psikologVolunteer
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, PsikologVolunteer $psikologVolunteer)
    {
        //
    }

    public function lists(User $user) {
        if ($user->id_role == config('env.role.admin')) {
            return true;
        }
    }
}
