<template>
    <tr style="vertical-align: baseline;">
        <td class="text-center">{{index + 1}}</td>
        <td class="text-left">
            {{ item.date ? $moment(item.date).locale('id').format('DD MMMM YYYY') : '-' }}
        </td>
        <td class="text-left">
            <p class="fw-bolder mb-2 text-nowrap">{{ mahasiswa.name }}</p>
            <p class="mb-0 text-nowrap">NIK: {{ mahasiswa.nik }}</p>
            <p class="mb-0 text-nowrap">No. HP: {{ mahasiswa.phone }}</p>
        </td>
        <td class="text-left">
            <p class="fw-bolder mb-2 text-nowrap">{{ mahasiswa.jenis_mahasiswa.name }}</p>
            <div class="mb-2">
                <p class="fw-600 mb-0">
                    Jenjang:
                </p>
                {{ mahasiswa.pendidikan_terakhir.name }}
            </div>
            <div class="mb-2">
                <p class="fw-600 mb-0">
                    Asal Universitas:
                </p>
                {{ mahasiswa.instansi_pendidikan.name }}
            </div>
        </td>
        <td class="text-left">
            <span class="text-nowrap fw-bolder">{{ $noNullable(item.mahasiswa?.balai_puspaga?.name) }}</span>
            <div class="mt-2">
                <p class="mb-0 py-1">RW: {{ $noNullable(item.mahasiswa?.balai_puspaga?.rw) }}</p>
                <p class="mb-0 py-1">Kelurahan: {{ $noNullable(item.mahasiswa?.balai_puspaga?.kelurahan?.name) }}</p>
                <p class="mb-0 py-1">Kecamatan: {{ $noNullable(item.mahasiswa?.balai_puspaga?.kelurahan?.kecamatan?.name) }}</p>
                <p class="mb-0 py-1">Penanggungjawab: {{ $noNullable(item.puspaga_rw?.konselor?.name) }}</p>
            </div>
        </td>
        <td class="text-left">
            {{ statusVerifikasi || '-' }}
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
    computed: {
        mahasiswa(){
            return this.item.mahasiswa.sample_mahasiswa ?? {}
        }, 
        laporanKegiatanStatus(){
            return this.$store.state.enums.laporanKegiatanStatus ?? {};
        },
        statusVerifikasi(){            
            const label = Object.values(this.laporanKegiatanStatus).find(it=>it.value === this.item.status)?.label;
            return label;
        }
    }
}
</script>