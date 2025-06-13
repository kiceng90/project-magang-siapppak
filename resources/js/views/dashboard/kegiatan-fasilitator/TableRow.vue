<template>
    <tr style="vertical-align: baseline;">
        <td class="text-center">{{index + 1}}</td>
        <td class="text-left">
            {{ item.date ? $moment(item.date).locale('id').format('DD MMMM YYYY') : '-' }}
        </td>
        <td class="text-left">
            <p class="mb-0 text-nowrap">Nama : <span class="fw-bolder">{{ item.fasilitator?.name }}</span></p>
            <p class="mb-0 text-nowrap">NIK : {{ item.fasilitator?.nik }}</p>
            <p class="mb-0 text-nowrap">No. HP : {{ item.fasilitator?.no_hp }}</p>
            <p class="mb-0 text-nowrap">Jabatan : {{ item.fasilitator?.jabatan.name }}</p>
        </td>
        <td class="text-left">
            <p class="mb-0 text-nowrap">RW : <span class="fw-bolder">{{ item.fasilitator?.rw }}</span></p>
            <p class="mb-0 text-nowrap">Kelurahan : {{ item.fasilitator?.kelurahan?.name }}</p>
            <p class="mb-0 text-nowrap">Kecamatan : {{ item.fasilitator?.kelurahan?.kecamatan?.name }}</p>
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
export default {
    props: {
        item: Object,
        index: Number,
    },
}
</script>