<template>
    <tr style="vertical-align: top;">
        <td class="text-center">{{index + 1}}</td>
        <td class="text-left">
            <div style="display: grid; grid-template-columns: auto 1fr;">
                <a :href="item.foto_url || $assetUrl() + '/siapppak/images/user.png'" target="_blank">
                    <img class="rounded" width="50" height="50" :src="item.foto_url || $assetUrl() + '/siapppak/images/user.png'" alt="Avatar">
                </a>
                <span class="text-nowrap fw-bolder ms-3">{{ item.name }}</span>
            </div>
            <div class="mt-2">
                <p class="mb-0 py-1 border-top">NIK: {{ item.nik }}</p>
                <p class="mb-0 py-1 border-top">No. Telpon: {{ item.phone }}</p>
                <p class="mb-0 py-1 border-top">Email: {{ item.email }}</p>
                <p class="mb-0 py-1 border-top">Tanggal Lahir: {{ item.birth_date }}</p>
                <p class="mb-0 py-1 border-top">Tempat Kelahiran: {{ item.kabupaten_lahir?.name }}</p>
                <p class="mb-0 py-1 border-top">Tanggal Registrasi: {{ item.tanggal_daftar }}</p>
            </div>
        </td>
        <td class="text-left">
            <span class="text-nowrap fw-bolder">{{ item.jenis_mahasiswa?.name }}</span>
            <div class="mt-2">
                <p class="mb-0 py-1 border-top">NIM: {{ item.nim }}</p>
                <p class="mb-0 py-1 border-top">Jenjang: {{ item.pendidikan_terakhir?.name }}</p>
                <p class="mb-0 py-1 border-top">Jurusan: {{ item.jurusan?.name }}</p>
                <p class="mb-0 py-1 border-top">Asal Universitas: {{ item.instansi_pendidikan?.name }}</p>
                <p class="mb-0 py-1 border-top">Semester: {{ item.semester }}</p>
                <p class="mb-0 py-1 border-top">IPK: {{ item.ipk }}</p>
            </div>
        </td>
        <td class="text-left">
            <div class="mb-3">
                <span class="text-nowrap fw-bolder">Domisili</span>
                <div class="mt-2">
                    <p class="mb-0 py-1 border-top">{{ item.domicile_address }}</p>
                    <p class="mb-0 py-1 border-top">RT {{ item.domicile_rt }}, RW {{ item.domicile_rw }}, Kelurahan {{ item.kelurahan_domisili?.name }}</p>
                    <p class="mb-0 py-1 border-top">Kecamatan {{ item.kelurahan_domisili?.kecamatan?.name }}, Kota: {{ item.kelurahan_domisili?.kecamatan?.kabupaten?.name }}</p>
                </div>
            </div>
            <div>
                <span class="text-nowrap fw-bolder">Sesuai KK</span>
                <div class="mt-2">
                    <p class="mb-0 py-1 border-top">{{ item.kk_address }}</p>
                    <p class="mb-0 py-1 border-top">RT {{ item.kk_rt }}, RW {{ item.kk_rw }}, Kelurahan {{ item.kelurahan_kk?.name }}</p>
                    <p class="mb-0 py-1 border-top">Kecamatan {{ item.kelurahan_kk?.kecamatan?.name }}, Kota: {{ item.kelurahan_kk?.kecamatan?.kabupaten?.name }}</p>
                </div>
            </div>
        </td>
        <td class="text-left">
            <span class="text-nowrap fw-bolder">{{ $noNullable(item.puspaga_rw?.balai_puspaga?.name) }}</span>
            <div class="mt-2">
                <p class="mb-0 py-1 border-top">RW: {{ $noNullable(item.puspaga_rw?.balai_puspaga?.rw) }}</p>
                <p class="mb-0 py-1 border-top">Kelurahan: {{ $noNullable(item.puspaga_rw?.balai_puspaga?.kelurahan?.name) }}</p>
                <p class="mb-0 py-1 border-top">Kecamatan: {{ $noNullable(item.puspaga_rw?.balai_puspaga?.kelurahan?.kecamatan?.name) }}</p>
                <p class="mb-0 py-1 border-top">Penanggungjawab: {{ $noNullable(item.puspaga_rw?.konselor?.name) }}</p>
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
    },
}
</script>