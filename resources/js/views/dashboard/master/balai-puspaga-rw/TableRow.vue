<template>
    <tr>
        <td class="text-center">{{index + 1}}</td>
        <td class="text-left">
            <div class="d-flex flex-column align-items-start">
                <p class="mb-0 fw-bolder" style="font-size: 1rem;">{{ item.name }} - RW {{ item.rw }}</p>
                <p class="mb-0">Dibentuk pada tahun : {{ item.inauguration_year }}</p>
                <p class="mb-0">Ketua RW : <strong>{{ item.rw_name }}</strong></p>
                <p class="mb-0">No Telp. Ketua RW : {{ item.rw_phone }}</p>
            </div>
        </td>
        <td class="text-left">
            <p class="mb-0">Alamat : {{ item.address }}</p>
            <p class="mb-0">Kelurahan : {{ item.kelurahan.name }}</p>
            <p class="mb-0">Kecamatan : {{ item.kelurahan.kecamatan.name }}</p>
            <p class="mb-0">Wilayah : {{ item.wilayah.name }}</p>
        </td>
        <td class="text-left">
            <p class="mb-0">Hari : {{ item.operational_day }}</p>
            <p class="mb-0">Jam : {{ item.operational_start_time }}-{{ item.operational_end_time }}</p>
        </td>
        <td class="text-left">
            <span>{{ item.konselor.name }}</span>
        </td>
        <td class="text-left">
            <div class="text-center w-100">
                <div
                    class="form-check form-switch form-check-custom form-check-solid justify-content-center">
                    <input class="form-check-input h-20px w-40px"
                        type="checkbox" value="1" :checked="item.is_active"
                        @click="changeStatus" />
                </div>
            </div>
        </td>
        <td class="text-center">
            <span class="badge badge-light">Aktif</span>
        </td>
        <td class="text-center">
            <div class="dropdown" style="position:static !important;">
                <button class="btn btn-secondary btn-xs dropdown-toggle"
                    type="button" data-bs-toggle="dropdown"
                    style="padding:5px 10px !important;"
                    aria-expanded="false">
                    Aksi
                </button>
                <ul class="dropdown-menu">
                    <slot name="menu"></slot>
                </ul>
            </div>
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
        changeStatus(id) {
            this.$ewpLoadingShow();
            Api().put(`d-balai-puspaga-rw/${this.item.id}/switch-status`)
                .then(response => {
                    this.$toast.success("Status berhasil diubah!");
                    this.$emit('onSuccessSwitchStatus')
                })
                .catch(error => {
                    this.$axiosHandleError(error);
                }).finally(() => {
                    this.$ewpLoadingHide();
                })
        }
    }
}
</script>