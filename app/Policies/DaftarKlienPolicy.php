<?php

namespace App\Policies;

use App\Models\DaftarKlien;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DaftarKlienPolicy
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
        return in_array($user->id_role, [
            config('env.role.admin'),
            config('env.role.hotline'),
            config('env.role.kabid'),
            config('env.role.kadis'),
            config('env.role.subkord'),
            config('env.role.konselor'),
        ]);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DaftarKlien  $daftarKlien
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, DaftarKlien $daftarKlien)
    {
        return in_array($user->id_role, [
            config('env.role.admin'),
            config('env.role.hotline'),
            config('env.role.kabid'),
            config('env.role.kadis'),
            config('env.role.subkord'),
            config('env.role.konselor'),
        ]);
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
     * @param  \App\Models\DaftarKlien  $daftarKlien
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, DaftarKlien $daftarKlien)
    {
        if ($user->id_role == config('env.role.admin')) {
            return true;
        }

        if ($user->id == $daftarKlien->created_by) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DaftarKlien  $daftarKlien
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, DaftarKlien $daftarKlien)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DaftarKlien  $daftarKlien
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, DaftarKlien $daftarKlien)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DaftarKlien  $daftarKlien
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, DaftarKlien $daftarKlien)
    {
        //
    }

    public function historiPengaduan(User $user, DaftarKlien $daftarKlien)
    {
        return true;
    }

    public function historiPenanganan(User $user, DaftarKlien $daftarKlien)
    {
        return true;
    }
}
