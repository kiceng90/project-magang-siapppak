<template>
    <div>
        <div class="card card-flush mt-5 mb-5 mb-xl-10" id="kt_profile_details_view">
            <div class="card card-xl-stretch mb-5 mb-xl-8">
                <div class="card-header border-0 pt-5 align-items-center">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder text-dark mb-2" style="font-size:20px !important;">Data
                            Pengaduan</span>
                    </h3>
                    <div class="d-flex align-items-center w-100" style="max-width:300px;">
                        <app-datepicker type="date" placeholder="Pilih tanggal pengaduan" :format="'DD-MM-YYYY'"
                            :value-type="'YYYY-MM-DD'" :class="'me-3 w-100'" :style="'max-width:300px !important;'"
                            @change="tableConfig.config.current_page = 1; getDataTable()" :range="true"
                            v-model:value="single.filter.daterange">
                        </app-datepicker>
                    </div>

                </div>
                <div class="card-body pt-5">
                    <div class="row align-items-center">
                        <div class="col-lg-2 fw-bolder mb-5" style="font-size:14px;">
                            Keterangan Status
                        </div>
                        <div class="col-lg-10">
                            <div class="d-flex flex-wrap">
                                <span class="badge badge-light-primary mb-5 me-3 c-pointer" @click="single.filter.id_status = '1'; tableConfig.config.current_page = 1; getDataTable()">Perlu Penanganan</span>
                                <span class="badge badge-light-info mb-5 me-3 c-pointer" @click="single.filter.id_status = '3,4,7,8,9'; tableConfig.config.current_page = 1; getDataTable()">Proses Verifikasi</span>
                                <span class="badge badge-light-warning mb-5 me-3 c-pointer" @click="single.filter.id_status = '5'; tableConfig.config.current_page = 1; getDataTable()">Proses Penjangkauan</span>
                                <span class="badge badge-light-danger mb-5 me-3 c-pointer" @click="single.filter.id_status = '2,6'; tableConfig.config.current_page = 1; getDataTable()">Di Revisi/Dirujuk</span>
                                <span class="badge badge-light-success mb-5 me-3 c-pointer" @click="single.filter.id_status = '10'; tableConfig.config.current_page = 1; getDataTable()">Pengaduan Selesai</span>
                            </div>
                        </div>
                    </div>
                    <app-datatable-serverside :table_config="tableConfig" @change-page="getDataTable"
                        v-model:show_per_page="tableConfig.config.show_per_page"
                        v-model:search="tableConfig.config.search" v-model:order="tableConfig.config.order"
                        v-model:sort_by="tableConfig.config.sort_by"
                        v-model:current_page="tableConfig.config.current_page">
                        <template v-slot:body>
                            <tr v-for="(context, index) in tableConfig.feeder.data">
                                <td class="text-center">{{index + 1}}</td>
                                <td class="text-left">{{context.registration_number}}</td>
                                <td class="text-left">
                                    <div>{{context.mama_klien}}</div>
                                    <div class="text-gray-500">
                                        {{context.is_has_nik ? context.nik_klien : context.identity_number}}</div>
                                    <div class="pt-2">{{context.alamat_klien}}</div>
                                    <div class="text-gray-600">{{context.nama_kelurahan}}, {{context.nama_kecamatan}}
                                    </div>
                                </td>                             
                                <td class="text-left">
                                    <div>{{context.nama_pelapor}}</div>
                                    <div class="text-gray-500">{{context.nik_pelapor}}</div>
                                </td>
                                <td class="text-left">
                                    <div>{{context.sumber}}</div>
                                    <div class="text-gray-500">
                                        {{$moment(context.tgl_pengaduan).locale('id').format('DD MMMM YYYY  hh:mm:ss')}}
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div>
                                        <span class="badge"
                                            :class="context.status.label_status">{{context.status.status}}</span>
                                    </div>
                                    <div class="text-gray-500" v-if="context.status.description">
                                        {{context.status.description}}</div>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown" style="position:static !important;">
                                        <button class="btn btn-secondary btn-xs dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" style="padding:5px 10px !important;"
                                            aria-expanded="false">
                                            Aksi
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <router-link class="dropdown-item py-3" :to="{name: 'pengaduan-detail', params: { id: context.id }}">
                                                    Detail Data
                                                </router-link>
                                            </li>
                                            <li>
                                                <router-link :to="{name: 'pengaduan-cetak', params: { id: context.id }}" class="dropdown-item py-3" v-if="context.status.id == 10">
                                                    Cetak Laporan
                                                </router-link>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </app-datatable-serverside>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Api from "@/services/api";
    export default {
        data() {
            return {
                pageStatus: 'standby',
                flag: 'insert',
                tableConfig: {
                    feeder: {
                        column: [{
                                text: 'NO',
                                sort_column: false,
                                style: 'text-align: center',
                            },
                            {
                                text: 'NO REGISTRASI',
                                sort_by: 'registration_number',
                                sort_column: true,
                                style: 'text-align: left',
                            },
                            {
                                text: 'KLIEN-NIK',
                                sort_by: 'mama_klien',
                                sort_column: true,
                                style: 'text-align: left',
                            },                                
                            {
                                text: 'PELAPOR-NIK',
                                sort_by: 'nama_pelapor',
                                sort_column: true,
                                style: 'text-align: left',
                            },
                            {
                                text: 'SUMBER - TGL PENGADUAN',
                                sort_by: 'tgl_pengaduan',
                                sort_column: true,
                                style: 'text-align: left',
                            },
                            {
                                text: 'STATUS',
                                sort_by: 'id_status',
                                sort_column: true,
                                style: 'text-align: center',
                            },
                            {
                                text: 'AKSI',
                                sort_column: false,
                                style: 'text-align: center',
                            },
                        ],
                        data: [],
                    },
                    config: {
                        title: 'Datatable',
                        show_per_page: 10,
                        search: '',
                        order: 'desc',
                        sort_by: 'id',
                        total_data: 0,
                        current_page: 1,
                        loading: false,
                        show_search: true,
                    }
                },

                single: {

                    filter: {
                        daterange: [],
                        id_status: ''
                    },
                }
            }

        },
        mounted() {
            reinitializeAllPlugin();

            this.getDataTable();
        },
        methods: {
            detail(id) {
                this.$router.push({
                    name: 'pengaduan-detail',
                    params: { id: id}
                })
            },
            getDataTable() {

                this.tableConfig.config.loading = true;
                this.tableConfig.feeder.data = [];

                let params = {
                    page: this.tableConfig.config.current_page,
                    limit: this.tableConfig.config.show_per_page,
                    sortby: this.tableConfig.config.sort_by,
                    order: this.tableConfig.config.order,
                    search: this.tableConfig.config.search
                }

                if (this.single.filter.id_status) {
                    Object.assign(params, {
                        id_status: this.single.filter.id_status,                        
                    })
                }

                if (this.single.filter.daterange.length > 0) {
                    Object.assign(params, {
                        start_date: this.single.filter.daterange[0],
                        end_date: this.single.filter.daterange[1],
                    })
                }

                Api().get(`pengaduan`, {
                        params
                    })
                    .then(response => {

                        let data = response.data.data;

                        this.tableConfig.feeder.data = data;
                        this.tableConfig.config.total_data = response.data.total;

                        this.tableConfig.config.loading = false;
                    })
                    .catch(error => {

                        this.tableConfig.config.loading = false;

                        this.tableConfig.feeder.data = [];
                        this.tableConfig.config.total_data = 0;

                        this.$axiosHandleError(error);
                    });
            },
        }
    }

</script>

<style scoped>

</style>
