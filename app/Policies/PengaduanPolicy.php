<?php

namespace App\Policies;

use App\Models\Pengaduan;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PengaduanPolicy
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
            config('env.role.opd'),
            config('env.role.hotline'),
            config('env.role.subkord'),
            config('env.role.kabid'),
            config('env.role.konselor'),
            config('env.role.kadis'),
            config('env.role.asisten'),
        ]);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Pengaduan  $pengaduan
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Pengaduan $pengaduan)
    {
        if ($user->id_role == config('env.role.opd')) {
            $opdHasRencanaIntervensi = Pengaduan::query()
                ->whereHas('penjangkauan.rencanaIntervensi', function ($q) use ($user) {
                    $q->where('rencana_intervensi.id_opd', $user->id_opd);
                })
                ->where('id', $pengaduan->id)
                ->exists();

            if ($opdHasRencanaIntervensi) {
                return true;
            }
        }

        if ($user->id_role == config('env.role.konselor')) {
            $konselorHasPenjangkauan = Pengaduan::query()
                ->whereHas('penjangkauan.penjangkauan_konselor', function ($q) use ($user) {
                    $q->where('penjangkauan_konselor.id_konselor', $user->id_konselor);
                })
                ->where('id', $pengaduan->id)
                ->exists();

            if ($konselorHasPenjangkauan) {
                return true;
            }
        }

        return in_array($user->id_role, [
            config('env.role.admin'),
            config('env.role.hotline'),
            config('env.role.subkord'),
            config('env.role.kabid'),
            config('env.role.kadis'),
            config('env.role.asisten'),
            // config('env.role.opd'),
            // config('env.role.konselor'),
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
        return $user->id_role == config('env.role.hotline');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Pengaduan  $pengaduan
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Pengaduan $pengaduan)
    {
        if ($user->id_role == config('env.role.admin')) {
            return true;
        }

        if ($user->id_role == config('env.role.hotline')) {
            return true;
        }

        if ($user->id_role == config('env.role.kabid')) {
            return true;
        }

        if ($user->id_role == config('env.role.subkord')) {
            return true;
        }


        return $user->id == $pengaduan->created_by;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Pengaduan  $pengaduan
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Pengaduan $pengaduan)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Pengaduan  $pengaduan
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Pengaduan $pengaduan)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Pengaduan  $pengaduan
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Pengaduan $pengaduan)
    {
        //
    }

    public function KabidApprove(User $user, Pengaduan $pengaduan)
    {
        return $user->id_role == config('env.role.kabid');
    }

    public function subkordApprove(User $user, Pengaduan $pengaduan)
    {
        return $user->id_role == config('env.role.subkord');
    }

    public function kadisApprove(User $user, Pengaduan $pengaduan)
    {
        return $user->id_role == config('env.role.kadis');
    }
}
