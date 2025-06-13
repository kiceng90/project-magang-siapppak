<template>
    <tr style="vertical-align: top;">
        <td class="text-center">{{index + 1}}</td>
        <td class="text-left">
            {{ item.date ? $moment(item.date).locale('id').format('DD MMMM YYYY') : '-' }}
        </td>
        <td class="text-left">
            <span class="text-nowrap fw-bolder">{{ item.konselor?.name }}</span>
            <div class="mt-2">
                <p class="mb-0 py-1">NIK: {{ $noNullable(item.konselor?.dkonselor?.nim) }}</p>
                <p class="mb-0 py-1">No. HP: {{ item.konselor?.phone_number }}</p>
                <p class="mb-0 py-1">Jabatan Petugas: {{ item.jabatan?.name }}</p>
            </div>
        </td>
        <td class="text-left">
            <span class="text-nowrap fw-bolder">{{ item.balai_puspaga_rw?.name }}</span>
            <div class="mt-2">
                <p class="mb-0 py-1">RW: {{ item.balai_puspaga_rw?.rw }}</p>
                <p class="mb-0 py-1">Kelurahan: {{ item.balai_puspaga_rw?.kelurahan?.name }}</p>
                <p class="mb-0 py-1">Kecamatan: {{ item.balai_puspaga_rw?.kelurahan?.kecamatan?.name }}</p>
            </div>
        </td>
        <td class="text-left">
            <span class="text-nowrap"> {{ item.status_string }} </span>
        </td>
        <td class="text-center">
            <div class="dropdown" style="position:static !important;" v-if="!hideActions">
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
            <span v-else>-</span>
        </td>
    </tr>
</template>

<script>
export default {
    props: {
        item: Object,
        index: Number,
        hideActions: Boolean,
    },
}
</script>