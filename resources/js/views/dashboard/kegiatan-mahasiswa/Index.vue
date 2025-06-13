<template>
    <dashboard-base-layout>
        <!--begin::Post-->
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <!--begin::Container-->
            <div id="kt_content_container" class="container-xxl">
            <div class="alert alert-success mt-5" role="alert" v-if="isMahasiswaAssigned && dataMahasiswa">
                <h4 class="alert-heading">Data Penempatan Anda!</h4>
                <!-- <p class="mb-0">Balai Puspaga RW : <b>{{ dataMahasiswa.balai_puspaga.name }}</b></p> -->
                <!-- <p class="mb-0">Kelurahan : <b>{{ dataMahasiswa.balai_puspaga.kelurahan.name }}</b></p> -->
                <p class="mb-0">Kecamatan : <b>{{ dataMahasiswa.balai_puspaga.kelurahan.kecamatan.name }}</b></p>
                <p class="mb-0">Nama Penanggung Jawab : <b>{{ dataMahasiswa.konselor.name }}</b></p>
                <p class="mb-0">No. HP Penanggung Jawab : <b>{{ dataMahasiswa.konselor.phone_number }}</b></p>
            </div>

            <div class="card card-flush mt-5 mb-5 mb-xl-10" id="kt_profile_details_view" v-if="isMahasiswaAssigned || isAdmin || isKonselor || isSubkord">
                    <div class="card card-xl-stretch mb-5 mb-xl-8">
                        <div class="card-header border-0 pt-5 align-items-center">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bolder text-dark mb-2" style="font-size:20px !important;">Laporan Kegiatan Mahasiswa</span>
                            </h3>

                            <button type="button" class="btn btn-sm c-primary-custom me-3 ms-auto"
                                style="background: #FFF4DD !important;color:#EE7B33 !important"
                                @click="exportData"
                                v-if="tableConfig.feeder.data.length > 0 && !isMahasiswa"
                            >
                                <span>
                                    <svg width="22" height="23" viewBox="0 0 22 23" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3"
                                            d="M5.36913 2.33203H12.5918C12.9169 2.33203 13.2315 2.44724 13.4798 2.65721L17.8464 6.35064C18.1553 6.6119 18.3334 6.99592 18.3334 7.40047V18.9084C18.3334 20.5497 18.3147 20.6654 16.631 20.6654H5.36913C3.68549 20.6654 3.66675 20.5497 3.66675 18.9084V4.08898C3.66675 2.44765 3.68549 2.33203 5.36913 2.33203Z"
                                            fill="#EE7B33" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M8.20541 13.1654H9.99885V15.0057C9.99885 15.2589 10.2041 15.4641 10.4572 15.4641H11.3952C11.6483 15.4641 11.8535 15.2589 11.8535 15.0057V13.1654H13.647C13.9001 13.1654 14.1053 12.9602 14.1053 12.707C14.1053 12.5986 14.0668 12.4936 13.9968 12.4109L11.276 9.19734C11.1124 9.00415 10.8232 8.98014 10.63 9.1437C10.6107 9.16007 10.5928 9.17801 10.5764 9.19734L7.85562 12.4109C7.69205 12.604 7.71606 12.8933 7.90925 13.0568C7.99202 13.1269 8.09696 13.1654 8.20541 13.1654Z"
                                            fill="#EE7B33" />
                                    </svg>
                                    &ensp;Export Data
                                </span>
                            </button>
                            <button type="button" class="btn btn-sm bg-primary-custom" @click="showModalAdd" v-if="isMahasiswa && dataMahasiswa">
                                <span class="text-white">Tambah Laporan Kegiatan</span>
                            </button>
                        </div>

                        <div class="card-body pt-5">
                            <div class="row d-flex align-items-center mb-5">
                                <label class="col-lg-3 d-inline fw-bolder" style="font-size: 16px;">
                                    Filter Tanggal
                                </label>
                                <div class="d-flex align-items-center ms-5" style="width:300px;">
                                    <app-datepicker type="date" placeholder="Pilih tanggal laporan" :format="'DD-MM-YYYY'"
                                        :value-type="'YYYY-MM-DD'" :class="'me-3 w-100'" :range="true"
                                        :style="'max-width:300px !important;'"
                                        @change="tableConfig.config.current_page = 1; getDataTable()"
                                        v-model:value="filterDateRange">
                                    </app-datepicker>
                                </div>
                            </div>
                            <div class="row d-flex align-items-center mb-5" v-if="isAdmin">
                                <label class="col-lg-3 d-inline fw-bolder" style="font-size: 16px;">
                                    Filter Status Mahasiswa
                                </label>
                                <div class="col-lg-4 ms-5">
                                    <app-select-single v-model="single.filter.jenisMahasiswa"
                                        :show_button_clear="false"
                                        :show_search="false"
                                        :options="listJenisMahasiswaFilter" 
                                        :serverside="true"
                                        @change-search="getJenisMahasiswaFilter"
                                        @option-change="tableConfig.config.current_page = 1; getDataTable()">
                                    </app-select-single>
                                </div>
                            </div>
                            <div class="row d-flex align-items-center mb-5" v-if="isAdmin">
                                <label class="col-lg-3 d-inline fw-bolder" style="font-size: 16px;">
                                    Filter Penempatan
                                </label>
                                <div class="col-lg-3 ms-5">
                                    <app-select-single v-model="single.filter.subDistrict"
                                        :show_button_clear="false"
                                        :options="listSubDistrictFilter"
                                        :serverside="true"
                                        :loading="pageStatus == 'sub-district-domicile-load'"
                                        @change-search="getSubDistrictFilter"
                                        @option-change="tableConfig.config.current_page = 1; getDataTable()">
                                    </app-select-single>
                                </div>
                                <div class="col-lg-3 ms-5">
                                    <app-select-single v-model="single.filter.village"
                                        :disabled="single.filter.subDistrict.id == '0'"
                                        :show_button_clear="false"
                                        :options="listVillageFilter"
                                        :serverside="true"
                                        :loading="pageStatus == 'village-filter-load'"
                                        @change-search="getVillageFilter"
                                        @option-change="tableConfig.config.current_page = 1; getDataTable()">
                                    </app-select-single>
                                </div>
                            </div>                               
                            <app-datatable-serverside :table_config="tableConfig"
                                v-model:show_per_page="tableConfig.config.show_per_page"
                                v-model:search="tableConfig.config.search"
                                v-model:order="tableConfig.config.order"
                                v-model:sort_by="tableConfig.config.sort_by"
                                v-model:current_page="tableConfig.config.current_page"
                                @change-page="getDataTable"
                                :disable_search="false"
                                >
                                <template v-slot:body>
                                    <TableRow
                                        v-for="(item, index) in tableConfig.feeder.data"
                                        :item="item"
                                        :index="index"
                                        :key="index"
                                        @onEdit="showModalEdit(item.id, item.sample_mahasiswa.name)"
                                    >
                                        <template #menu>
                                            <li>
                                                <a class="dropdown-item py-3" href="javascript:void(0);" @click="showModalLihatLaporan(item)">Lihat Laporan Kegiatan Harian</a>
                                            </li>
                                            <li v-if="isKonselor || isSubkord">
                                                <a class="dropdown-item py-3" href="javascript:void(0);" @click="verifLaporan(item)">Verifikasi Laporan Kegiatan Harian</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item py-3" href="javascript:void(0);" @click="exportDataId(item)">Export Laporan Kegiatan Ini</a>
                                            </li>
                                        </template>
                                    </TableRow>
                                </template>
                            </app-datatable-serverside>
                        </div>

                    </div>
                </div>
            <div class="alert alert-success mt-5" role="alert" v-else-if="!loadingMahasiswa">
                <h4 class="alert-heading">Info!</h4>
                <p class="mb-0">Anda belum ditugaskan oleh Dinas Pemberdayaan Perempuan dan Perlindungan Anak serta Pengendalian Penduduk dan Keluarga Berencana (DP3APPKB) Kota Surabaya.</p>
                <p>Dimohon untuk menunggu.</p>
            </div>
            </div>
            <!--end::Container-->
        </div>
        <ModalAdd @onSuccess="onSuccessAddEdit"/>
        <ModalLihatLaporan :data="modalLihatLaporanData"/>
    </dashboard-base-layout>
</template>

<script>
import ModalAdd from './ModalAdd.vue';
import ModalLihatLaporan from './ModalLihatLaporan.vue';
import TableRow from './TableRow.vue';
import moment from 'moment';

import Api from "@/services/api";

export default {
    components: { TableRow, ModalAdd, ModalLihatLaporan },
    data(){
        return  {
            loadingMahasiswa: true,
            pageStatus: 'standby',
            listJenisMahasiswaFilter: [],
            listSubDistrictFilter: [],
            listVillageFilter: [],
            single: {
                filter: {
                    jenisMahasiswa: {
                        id: '0',
                        text: 'Semua'
                    },
                    subDistrict: {
                        id: '0',
                        text: 'Semua'
                    },
                    village: {
                        id: '0',
                        text: 'Semua'
                    }
                }
            },
            tableConfig: {
                feeder: {
                    column: [{
                            text: 'NO',
                            sort_column: false,
                            style: 'text-align: center',
                        },
                        {
                            text: 'Tanggal Kegiatan',
                            sort_column: false,
                            style: 'text-align: left; text-transform: uppercase; white-space: nowrap;',
                        },
                        {
                            text: 'Mahasiswa',
                            style: 'text-transform: uppercase; white-space: nowrap;',
                            sort_column: false,
                        },
                        {
                            text: 'Status Mahasiswa',
                            sort_column: false,
                            style: 'text-transform: uppercase;',
                        },
                        {
                            text: 'Penempatan',
                            sort_column: false,
                            style: 'text-transform: uppercase;',
                        },
                        {
                            text: 'Status Verifikasi',
                            sort_column: false,
                            style: 'text-align: left; text-transform: uppercase; white-space: nowrap;',
                        },
                        {
                            text: 'Aksi',
                            sort_column: false,
                            style: 'text-transform: uppercase; text-align: center',
                        }
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
            modalEditData: {
                id: null,
                name: null
            },
            modalLihatLaporanData: {},
            filterDateRange: [],
            dataMahasiswa: null,
            isMahasiswaAssigned: false,
        }
    },
    methods: {
        showModalAdd: () => $("#modal-tambah").modal('show'),
        showModalEdit(id, name){
            this.modalEditData = {id, name};
            $("#modal-edit").modal('show');
        },
        showModalLihatLaporan(item){
            this.modalLihatLaporanData = {...item}
            $("#modal-lihat-laporan").modal('show');
        },
        getDataTable() {
            this.tableConfig.config.loading = true;
            this.tableConfig.feeder.data = [];

            let params = {
                page: this.tableConfig.config.current_page,
                limit: this.tableConfig.config.show_per_page,
                sortby: this.tableConfig.config.sort_by,
                order: this.tableConfig.config.order,
                search: this.tableConfig.config.search,
                role_filter: 'mahasiswa'
            }

            if (this.single.filter.jenisMahasiswa.id && this.single.filter.jenisMahasiswa.id != '0') {
                Object.assign(params, {
                    id_jenis_mahasiswa: this.single.filter.jenisMahasiswa.id
                })
            }

            if (this.single.filter.subDistrict.id && this.single.filter.subDistrict.id != '0') {
                Object.assign(params, {
                    id_kecamatan: this.single.filter.subDistrict.id
                })
            }

            if (this.single.filter.village.id && this.single.filter.village.id != '0') {
                Object.assign(params, {
                    id_kelurahan: this.single.filter.village.id
                })
            }

            if (this.filterDateRange.length > 0) {
                Object.assign(params, {
                    start_date: this.filterDateRange[0],
                    end_date: this.filterDateRange[1],
                })
            }

            let url = `laporan-mahasiswa`

            Api().get(url, {
                    params
                })
                .then(response => {

                    let data = response.data?.data;

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
        onSuccessAddEdit(){
            this.tableConfig.config.current_page = 1;
            this.getDataTable();
        },
        verifLaporan(item){
            const _this = this;
            this.$swal({
                title: 'Verifikasi laporan?',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#EE7B33',
                cancelButtonColor: '#FFFFFF',
                cancelButtonTextColor: "black",
                confirmButtonText: 'Ya, Verifikasi',
                cancelButtonText: 'Batal'
            }).then(function (result) {
                if (result.isConfirmed) {
                    _this.$ewpLoadingShow();
                    
                    const date = item.laporan_rapat[0]?.date || item.laporan_konseling[0]?.date || item.laporan_sosialisasi[0]?.date;
                    const filterDate = date.split('T')[0] // YYYY-MM-DD

                    const formData = {
                        tanggal_filter: filterDate,
                        id_mahasiswa_balai_puspaga_rw: item.id,
                    }

                    Api().put(`laporan-mahasiswa/verifAll`, formData)
                        .then(response => {
                            _this.getDataTable();

                            _this.$swal({
                                title: "Berhasil!",
                                text: 'Verifikasi laporan kegiatan',
                                icon: "success",
                            })
                        })
                        .catch(error => {
                            _this.$axiosHandleError(error);
                        }).finally(() => {
                            _this.$ewpLoadingHide();
                        });
                }
            });
        },
        exportData(){
            this.$ewpLoadingShow();
            let params = {
                role_filter: 'mahasiswa',
                start_date: '',
                end_date: '',
                id_jenis_mahasiswa: '',
            }
            if (this.filterDateRange.length > 0) {
                Object.assign(params, {
                    start_date: this.filterDateRange[0],
                    end_date: this.filterDateRange[1],
                })
            }
            if (this.single.filter.jenisMahasiswa.id && this.single.filter.jenisMahasiswa.id != '0') {
                Object.assign(params, {
                    id_jenis_mahasiswa: this.single.filter.jenisMahasiswa.id
                })
            }
            Api().get(`laporan-mahasiswa-export`, {
                responseType: 'blob',
                params
            }).then(response => {
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', `Laporan Kegiatan Mahasiswa.xlsx`);
                document.body.appendChild(link);
                link.click();
            }).catch(error => {
                this.$axiosHandleError(error);
            }).then(() => {
                this.$ewpLoadingHide();
            });
        },
        exportDataId(item){
            this.$ewpLoadingShow();
            Api().get(`laporan-mahasiswa-export/${item.id}`, {
                responseType: 'blob',
                params: {
                    role_filter: 'mahasiswa',
                }
            }).then(response => {
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', `Laporan Kegiatan Harian Mahasiswa - ${item.mahasiswa.sample_mahasiswa.name}.xlsx`);
                document.body.appendChild(link);
                link.click();
                console.log(response)
            }).catch(error => {
                this.$axiosHandleError(error);
            }).then(() => {
                this.$ewpLoadingHide();
            });
        },
        checkReplacementMahasiswa(){
            this.loadingMahasiswa = true;
            Api().get('mahasiswa-balai-check-replacement').then((response)=>{
                this.isMahasiswaAssigned = true;
                this.dataMahasiswa = response.data.data;
            }).finally(()=>{
                this.loadingMahasiswa = false;
            })
        },
        getSelectList(url, listKey, pageStatus = 'select-load') {
            this.pageStatus = pageStatus

            Api().get(url)
                .then(response => {

                    this[listKey] = [];

                    for (let i = 0; i < response.data.data.length; i++) {
                        this[listKey].push({
                            id: response.data.data[i].id,
                            text: response.data.data[i].name,
                        });
                    }

                })
                .catch(error => {
                    this[listKey] = [];
                    this.$axiosHandleError(error);
                }).finally(() => {
                    this.pageStatus = 'standby';
                })
        },
        getSubDistrict(keyword, limit, listKey, pageStatus) {
            this.getSelectList(`m-kecamatan/lists?limit=${limit}&search=${keyword}`, listKey,
                pageStatus)
        },
        getVillage(keyword, limit, subDistrictId = '', listKey, pageStatus) {
            this.getSelectList(
                `m-kelurahan/lists?limit=${limit}&search=${keyword}&id_kecamatan=${subDistrictId}`,
                listKey, pageStatus)
        },
        getJenisMahasiswaFilter(keyword, limit) {
            Api().get(`m-jenis-mahasiswa/lists?search=${keyword}&limit=${limit}`)
                .then(response => {

                    this.listJenisMahasiswaFilter = [{
                        id: '0',
                        text: 'Semua'
                    }];

                    for (let i = 0; i < response.data.data.length; i++) {
                        this.listJenisMahasiswaFilter.push({
                            id: response.data.data[i].id,
                            text: response.data.data[i].name,
                        });
                    }

                })
                .catch(error => {
                    this.listJenisMahasiswaFilter = [{
                        id: '0',
                        text: 'Semua'
                    }];
                    this.$axiosHandleError(error);
                })
        },
        getSubDistrictFilter(keyword, limit) {
            this.pageStatus = 'sub-district-filter-load';

            Api().get(`m-kecamatan/listsMahasiswa?search=${keyword}&limit=${limit}`)
                .then(response => {

                    this.listSubDistrictFilter = [{
                        id: '0',
                        text: 'Semua'
                    }];

                    for (let i = 0; i < response.data.data.length; i++) {
                        this.listSubDistrictFilter.push({
                            id: response.data.data[i].id,
                            text: response.data.data[i].name,
                        });
                    }

                })
                .catch(error => {
                    this.listSubDistrictFilter = [{
                        id: '0',
                        text: 'Semua'
                    }];
                    this.$axiosHandleError(error);
                }).finally(() => {
                    this.pageStatus = 'standby';
                })
        },
        getVillageFilter(keyword, limit) {
            this.pageStatus = 'village-filter-load';

            Api().get(
                    `m-kelurahan/lists?search=${keyword}&limit=${limit}&id_kecamatan=${this.single.filter.subDistrict.id}`
                )
                .then(response => {

                    this.listVillageFilter = [{
                        id: '0',
                        text: 'Semua'
                    }];

                    for (let i = 0; i < response.data.data.length; i++) {
                        this.listVillageFilter.push({
                            id: response.data.data[i].id,
                            text: response.data.data[i].name,
                        });
                    }

                })
                .catch(error => {
                    this.listVillageFilter = [{
                        id: '0',
                        text: 'Semua'
                    }];
                    this.$axiosHandleError(error);
                }).finally(() => {
                    this.pageStatus = 'standby';
                })
        },
    },
    mounted(){
        if(this.isMahasiswa){
            this.checkReplacementMahasiswa();
        }
        this.getDataTable();
    },
    computed: {
        isMahasiswa(){
            return this.$store.state.profile.role_id == process.env.MIX_ROLE_MAHASISWA_ID
        },
        isAdmin(){
            return this.$store.state.profile.role_id == process.env.MIX_ROLE_ADMIN_ID
        },
        isKonselor(){
            return this.$store.state.profile.role_id == process.env.MIX_ROLE_KONSELOR_ID;
        },
        isSubkord(){
            return this.$store.state.profile.role_id == process.env.MIX_ROLE_SUBKORD_ID;
        },
    }
}
</script>