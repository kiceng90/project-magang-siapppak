<?php

namespace App\Policies;

use App\Models\DKonselor;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DKonselorPolicy
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
        if ($user->id_role == config('env.role.admin')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DKonselor  $dKonselor
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, DKonselor $dKonselor)
    {
        if ($user->id_role == config('env.role.admin')) {
            return true;
        }
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
     * @param  \App\Models\DKonselor  $dKonselor
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, DKonselor $dKonselor)
    {
        if ($user->id_role == config('env.role.admin')) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DKonselor  $dKonselor
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, DKonselor $dKonselor)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DKonselor  $dKonselor
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, DKonselor $dKonselor)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DKonselor  $dKonselor
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, DKonselor $dKonselor)
    {
        //
    }

    public function export(User $user) {
        if ($user->id_role == config('env.role.admin')) {
            return true;
        }
    }

    public function import(User $user) {
        if ($user->id_role == config('env.role.admin')) {
            return true;
        }
    }

    public function cetakPdf(User $user, DKonselor $dKonselor) {
        if ($user->id_role == config('env.role.admin')) {
            return true;
        }
    }

    public function summary(User $user) {
        if ($user->id_role == config('env.role.admin')) {
            return true;
        }
    }
}
