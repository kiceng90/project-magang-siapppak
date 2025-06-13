<template>
    <tr style="vertical-align: top;">
        <td class="text-center">{{index + 1}}</td>
        <td class="text-left" v-if="userRole == 'konselor' || userRole == 'admin'">
            <div class="d-flex align-items-center gap-4">
                <div class="d-flex flex-column">
                    <p class="mb-0">
                        Nama : <span class="fw-bolder" style="font-size: 1rem; text-transform: capitalize;">{{ item.klien.name }}</span>
                    </p>
                    <span v-if="item.klien.email" style="white-space: nowrap;">
                        Phone : {{ item.klien.phone }}
                    </span>
                </div>
            </div>
        </td>
        <td class="text-left" v-if="userRole == 'konselor' || userRole == 'admin'">
            <div class="d-flex align-items-center gap-4">
                <div class="d-flex flex-column">
                    <p v-if="item.klien.kabupaten?.name"  style="white-space: nowrap;" class="mb-0">
                        Asal : <span class="fw-bolder" :class="{'text-primary': item.klien.kabupaten.name === 'Surabaya'}">{{ item.klien.kabupaten.name }}</span>
                    </p>
                    <span v-if="item.klien.kelurahan?.kecamatan?.name" style="white-space: nowrap;">
                        Kecamatan : {{ item.klien.kelurahan?.kecamatan.name }}
                    </span>
                    <span v-if="item.klien.kelurahan?.name" style="white-space: nowrap;">
                        Kelurahan : {{ item.klien.kelurahan.name }}
                    </span>
                    <p style="white-space: nowrap;" class="mb-0">
                        <span v-if="item.klien.rt" style="white-space: nowrap;">
                            RT {{ item.klien.rt }}
                        </span>
                        <span v-if="item.klien.rw" style="white-space: nowrap;">
                            RW {{ item.klien.rw }}
                        </span>
                    </p>
                    <p v-if="item.klien.address">{{ item.klien.address }}</p>
                </div>
            </div>
        </td>
        <td class="text-left" v-if="userRole == 'klien' || userRole == 'admin'">
            <div class="d-flex align-items-start">
                <a class="me-2" target="_blank" :href="item.jadwal_detail.jadwal.konselor?.foto || item.jadwal_detail.jadwal.psikolog?.foto || $assetUrl() + '/siapppak/images/user.png'" >
                    <img class="rounded" width="50" height="50" :src="item.jadwal_detail.jadwal.konselor?.foto || item.jadwal_detail.jadwal.psikolog?.foto || $assetUrl() + '/siapppak/images/user.png'" alt="Avatar">
                </a>
                <div>
                    <div class="fw-bolder text-capitalize" style="font-size: 1rem;">
                        {{ item.jadwal_detail.jadwal.konselor?.name || item.jadwal_detail.jadwal.psikolog?.name }}
                    </div>
                    <span class="badge badge-light">{{ item.jadwal_detail.jadwal.konselor?.consultant_type || item.jadwal_detail.jadwal.psikolog?.consultant_type }}</span>
                </div>
            </div>
        </td>
        <td class="text-left">
            <div>
                {{ item.jadwal_detail.jadwal.day_string  }}, {{ item.date_string }}
            </div>
            <div>
                {{ item.jadwal_detail.start_time }} - {{ item.jadwal_detail.end_time }}
            </div>
            <span class="d-inline-flex flex-nowrap align-items-center px-2 py-1 border rounded">
                <svg class="me-2" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"></path><path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"></path></svg>
                <span style="white-space: nowrap;">
                    {{ item.time_remain }} dari sekarang
                </span>
            </span>
        </td>
        <td class="text-left">
            <div v-html="item.keterangan"></div>
        </td>
        <td class="text-left fw-bolder">
            <span>
                {{ item.status_string }}
            </span>
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
        userRole: String,
        hideActions: Boolean,
    }
}
</script>