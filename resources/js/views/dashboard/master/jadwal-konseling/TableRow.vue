<template>
    <tr>
        <td class="text-center">{{index + 1}}</td>
        <td class="text-left">
            <div class="d-flex flex-column align-items-start">
                <span class="fw-bolder" style="font-size: 1rem;">{{ item.name || '' }}</span>
                <span>{{ item.phone_number || '' }}</span>
            </div>
        </td>
        <td class="text-left">
            <template v-for="day in item.jadwal">
                <span class="fw-bolder">
                    {{ day.day_string}} :
                </span>
                <div v-for="jadwal in day.jadwal_detail">- {{ jadwal.kategori.name }}, {{ jadwal.start_time }} - {{ jadwal.end_time }}</div>
            </template>
        </td>
        <td class="text-left">
            <div
                class="form-check form-switch form-check-custom form-check-solid mb-3"
                v-for="day in item.jadwal"
            >
                <label class="form-check-label me-2" style="margin-left: 0;"> {{ day.day_string }} :</label>
                <input class="form-check-input h-20px w-40px"
                    type="checkbox" value="1" :checked="day.is_active"
                    @click="changeStatus(day.id)" />
            </div>
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
            Api().put(`m-jadwal-konseling/${id}/switch-status`)
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