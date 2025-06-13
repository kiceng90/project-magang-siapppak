<template>
    <div>
        <div class="pu_site_page">
            <app-header></app-header>

            <section class="main-banner-v2">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <img :src="$assetUrl() + '/siapppak/images/banner/img-banner-konsultasi.png'" class="main-header-rounded" style="border-radius: 30px;">
                            <h3 class="main-title-v2 title-float-shadow"></h3>
                        </div>
                    </div>
                </div>    
            </section>

            <section class="py-3" style="background: #e9e9e9;">
                <div class="container">
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <div class="konsultasi-sidebar mb-3">
                                <div class="konsultasi-sidebar-title">
                                    Layanan Telekonsultasi
                                </div>
                                <div class="p-3">
                                    <div class="form-check pb-1" v-for="kategorikonseling, index in kategorikonselings" :key="index">
                                        <label class="form-check-label">
                                            <div class="form-check pb-1">
                                                <input class="form-check-input" type="checkbox" :value="kategorikonseling.id" v-model="kategorikonseling_ids" :id="'kategori-konseling-' + index" @change="getJadwalKonseling()">
                                                <label class="form-check-label" :for="'kategori-konseling-' + index" style="font-size: 17px;padding-top:5px;">
                                                    {{ kategorikonseling.name }}
                                                </label>
                                            </div>         
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="row" v-if="konselors.length > 0">
                                <div class="col-md-6" v-for="konselor,index in konselors" :key="index">
                                    <div class="konsul-box-rounded mb-4">
                                        <div class="row">
                                            <div class="col-4 text-center">
                                                <div v-if="konselor.foto">
                                                    <img :src="konselor.foto" style="border-radius: 50%; width: 100px; height: 100px;" />
                                                </div>
                                                <div v-else>
                                                    <img :src="$assetUrl() + 'siapppak/images/user.png'" style="border-radius: 50%; width: 100px; height: 100px;" />
                                                </div>
                                            </div>
                                            <div class="col-8" style="min-height: 100px;">
                                                <p class="name">
                                                    {{ konselor.name }}
                                                </p>
                                                <div v-for="jadwal, jadwalindex in konselor.jadwal_active" :key="jadwalindex" class="name mb-3" style="font-size: 16px; font-weight: 600; color: #c81e4f;">
                                                    <div>
                                                        {{ jadwal.day_string }}
                                                    </div>
                                                    <div v-for="jadwaldetail, jadwaldetailindex in jadwal.jadwal_detail" :key="jadwaldetailindex">
                                                        <p class="mb-0" style="font-size: 16px; font-weight: 600;" :style="{color: jadwaldetail.is_booked ? 'gray' : '#c81e4f'}">
                                                            {{ jadwaldetail.start_time }} - {{ jadwaldetail.end_time }} <template v-if="jadwaldetail.is_booked"><span style="color: gray;">(Booked)</span></template>
                                                        </p>
                                                        <p class="position" style="font-size: 16px;color:#000; font-weight: 600; margin-bottom: 10px;line-height: 1.5;">
                                                            {{ jadwaldetail.kategori.name }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="pt-3">
                                                    <a :href="'/login?pathTo=/dashboard/booking-jadwal-konseling/' + konselor.id" class="btn-small-red">
                                                        <i class="fa fa-fw fa-calendar-alt text-white mr-2"></i>
                                                        Pilih Konselor Ini
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-else>
                                <h5>
                                    Belum ada jadwal konseling apapun.
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <app-footer></app-footer>

        </div>

        <app-popupsearch></app-popupsearch>

        <app-mobilemenu></app-mobilemenu>
    </div>
</template>

<script>
import Api from "@/services/api"

export default {
    data() {
        return {
            konselors: [],
            kategorikonselings: [],
            kategorikonseling_ids: []
        }
    },
    mounted() {
        this.getKategoriKonseling()
        this.getJadwalKonseling()
    },
    methods: {
        getKategoriKonseling() {
            Api().get(`public/m-kategori-konseling`)
                .then(response => {
                    this.kategorikonselings = response.data
                })
                .catch(error => {
                    this.$axiosHandleError(error)
                })
        },
        getJadwalKonseling() {
            let params = {
                id_kategori_konseling: this.kategorikonseling_ids
            }
            Api().get(`public/m-jadwal-konseling`, { params })
            .then(response => {
                    this.konselors = response.data.data
                })
                .catch(error => {
                    this.$axiosHandleError(error)
                })
        },
    }
};
</script>