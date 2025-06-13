<?php

namespace App\Policies;

use App\Models\SatgasPpa;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SatgasPpaPolicy
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

        if ($user->id_role == config('env.role.kelurahan')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SatgasPpa  $satgasPpa
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, SatgasPpa $satgasPpa)
    {
        if ($user->id_role == config('env.role.admin')) {
            return true;
        }

        if ($user->id_role == config('env.role.kelurahan')) {
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

        if ($user->id_role == config('env.role.kelurahan')) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SatgasPpa  $satgasPpa
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, SatgasPpa $satgasPpa)
    {
        if ($user->id_role == config('env.role.admin')) {
            return true;
        }

        if ($user->id_role == config('env.role.kelurahan')) {
            return true;
        }

        if ($user->id == $satgasPpa->created_by) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SatgasPpa  $satgasPpa
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, SatgasPpa $satgasPpa)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SatgasPpa  $satgasPpa
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, SatgasPpa $satgasPpa)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SatgasPpa  $satgasPpa
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, SatgasPpa $satgasPpa)
    {
        //
    }

    public function export(User $user) {
        if ($user->id_role == config('env.role.admin')) {
            return true;
        }

        if ($user->id_role == config('env.role.kelurahan')) {
            return true;
        }
    }

    public function import(User $user) {
        if ($user->id_role == config('env.role.admin')) {
            return true;
        }

        if ($user->id_role == config('env.role.kelurahan')) {
            return true;
        }
    }

    public function cetakPdf(User $user, SatgasPpa $satgasPpa) {
        if ($user->id_role == config('env.role.admin')) {
            return true;
        }

        if ($user->id_kelurahan == $satgasPpa->id_kelurahan) {
            return true;
        }
    }

    public function downloadSK(User $user, SatgasPpa $satgasPpa) {
        if ($user->id_role == config('env.role.admin')) {
            return true;
        }

        if ($user->id_kelurahan == $satgasPpa->id_kelurahan) {
            return true;
        }
    }

    public function summary(User $user) {
        if ($user->id_role == config('env.role.admin')) {
            return true;
        }

        if ($user->id_role == config('env.role.kelurahan')) {
            return true;
        }
    }
}
