<template>
    <tr>
        <td class="text-center">{{index + 1}}</td>
        <td class="text-left">
            <img class="rounded" width="100" height="100" style="object-fit: cover;" :src="item.file_thumbnail" alt="Thumbnail">
        </td>
        <td class="text-center">
            <p class="mb-0 fw-bolder ">
                {{ item.title }}
            </p>
        </td>
        <td class="text-center">
            <p class="mb-0 fw-bolder ">
                {{ item.nama_mahasiswa || "Admin SIAP PPAK" }}
            </p>
        </td>
        <td class="text-center">
            <p class="mb-0 fw-bolder ">
                {{ item.kecamatan_puspaga || "DP3APPKB" }}
            </p>
        </td>

        <td class="text-center">
            <div class="text-center w-100">
                <div
                    class="form-check form-switch form-check-custom form-check-solid justify-content-center">
                    <input class="form-check-input h-20px w-40px"
                        type="checkbox" value="1"
                        :checked="item.is_active"
                        @click="changeStatus" />
                </div>
            </div>
        </td>
        <td class="text-center">
            <span class="action-datatable-column m-2 d-inline-flex"
                @click="$emit('onEdit')"
                style="cursor:pointer">

                <svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.10953 15.3575L2.38436 15.9331C2.17711 16.0021 1.95475 16.012 1.74217 15.9618C1.5296 15.9116 1.33518 15.8033 1.18069 15.6489C1.02619 15.4945 0.917705 15.3001 0.867372 15.0876C0.817038 14.875 0.826838 14.6527 0.895682 14.4454L1.47135 12.7193L4.10953 15.3575ZM2.79043 8.762L8.06678 14.0383L16.6413 5.46382L11.3649 0.1875L2.79043 8.762Z" fill="#50CD89" />
                </svg>

            </span>
        </td>
    </tr>
</template>

<script>
import Api from "@/services/api";

export default {
    props: {
        item: Object,
        index: Number,
    },
    methods:{
        changeStatus() {
            this.$ewpLoadingShow();
            Api().put(`artikel/${this.item.id}/switch-status`)
                .then(response => {
                    this.$toast.success("Status berhasil diubah!");
                })
                .catch(error => {
                    this.$axiosHandleError(error);
                    this.$emit('onSuccessSwitchStatus')
                }).finally(() => {
                    this.$ewpLoadingHide();
                })
        }
    },
}
</script>