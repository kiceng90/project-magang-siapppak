<?php

namespace App\Policies;

use App\Models\Pkbm;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PkbmPolicy
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

        if ($user->id_role == config('env.role.kecamatan')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Pkbm  $pkbm
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Pkbm $pkbm)
    {
        if ($user->id_role == config('env.role.admin')) {
            return true;
        }

        if ($user->id_role == config('env.role.kecamatan')) {
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
        if ($user->id_role == config('env.role.kecamatan')) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Pkbm  $pkbm
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Pkbm $pkbm)
    {
        if ($user->id_role == config('env.role.admin')) {
            return true;
        }

        if ($user->id_role == config('env.role.kelurahan')) {
            return true;
        }

        if ($user->id == $pkbm->created_by) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Pkbm  $pkbm
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Pkbm $pkbm)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Pkbm  $pkbm
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Pkbm $pkbm)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Pkbm  $pkbm
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Pkbm $pkbm)
    {
        //
    }

    public function export(User $user) {
        if ($user->id_role == config('env.role.admin')) {
            return true;
        }

        if ($user->id_role == config('env.role.kecamatan')) {
            return true;
        }
    }

    public function import(User $user) {
        if ($user->id_role == config('env.role.kecamatan')) {
            return true;
        }
    }

    public function cetakPdf(User $user, Pkbm $pkbm) {
        if ($user->id_role == config('env.role.admin')) {
            return true;
        }

        if ($user->id_role == config('env.role.kecamatan')) {
            return true;
        }
    }

    public function downloadSK(User $user, Pkbm $pkbm) {
        if ($user->id_role == config('env.role.admin')) {
            return true;
        }

        if ($user->id_kecamatan == $pkbm->id_kecamatan) {
            return true;
        }
    }

    public function summary(User $user) {
        if ($user->id_role == config('env.role.admin')) {
            return true;
        }

        if ($user->id_role == config('env.role.kecamatan')) {
            return true;
        }
    }
}
