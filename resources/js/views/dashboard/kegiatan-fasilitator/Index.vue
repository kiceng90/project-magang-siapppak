<template>
    <dashboard-base-layout>
        <!--begin::Post-->
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <!--begin::Container-->
            <div id="kt_content_container" class="container-xxl">

            <div class="card card-flush mt-5 mb-5 mb-xl-10" id="kt_profile_details_view" v-if="isFasilitator || isAdmin || isKonselor || isSubkord">
                    <div class="card card-xl-stretch mb-5 mb-xl-8">
                        <div class="card-header border-0 pt-5 align-items-center">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bolder text-dark mb-2" style="font-size:20px !important;">Laporan Kegiatan Fasilitator Puspaga Balai RW</span>
                            </h3>

                            <button type="button" class="btn btn-sm c-primary-custom ms-auto" :class="{'me-3': isFasilitator}"
                                style="background: #FFF4DD !important;color:#EE7B33 !important"
                                @click="exportData"
                                v-if="tableConfig.feeder.data.length > 0"
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
                            <button type="button" class="btn btn-sm bg-primary-custom" @click="showModalAdd" v-if="isFasilitator">
                                <span class="text-white">Tambah Laporan Kegiatan</span>
                            </button>
                        </div>

                        <div class="card-body pt-5">
                            <div class="d-flex align-items-center mb-5">
                                <label class="d-inline fw-bolder" style="font-size: 16px;">
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
                            <app-datatable-serverside :table_config="tableConfig"
                                v-model:show_per_page="tableConfig.config.show_per_page"
                                v-model:search="tableConfig.config.search"
                                v-model:order="tableConfig.config.order"
                                v-model:sort_by="tableConfig.config.sort_by"
                                v-model:current_page="tableConfig.config.current_page"
                                @change-page="getDataTable"
                                :disable_search="true"
                                >
                                <template v-slot:body>
                                    <TableRow
                                        v-for="(item, index) in tableConfig.feeder.data"
                                        :item="item"
                                        :index="index"
                                        :key="index"
                                        @onEdit="showModalEdit(item.id, item.name)"
                                    >
                                        <template #menu>
                                            <li>
                                                <a class="dropdown-item py-3" href="javascript:void(0);" @click="showModalLihatLaporan(item)">Lihat Laporan Kegiatan Harian</a>
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
            </div>
            <!--end::Container-->
        </div>
        <ModalAdd @onSuccess="onSuccessAddEdit" :ttd="dataFasilitator.ttd" :id_puspaga_rw="dataFasilitator.id" v-if="isFasilitator && dataFasilitator"/>
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
            tableConfig: {
                feeder: {
                    column: [{
                            text: 'No',
                            sort_column: false,
                            style: 'text-transform: uppercase; text-align: center;',
                        },
                        {
                            text: 'Tanggal Kegiatan',
                            sort_column: false,
                            style: 'text-align: left; text-transform: uppercase; white-space: nowrap;',
                        },
                        {
                            text: 'Fasilitator',
                            sort_column: false,
                            style: 'text-transform: uppercase; text-align: left; white-space: nowrap;',
                        },
                        {
                            text: 'Puspaga Balai RW',
                            sort_column: false,
                            style: 'text-transform: uppercase; text-align: left; white-space: nowrap;',
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
            dataFasilitator: null,
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
                role_filter: 'fasilitator',
            }

            if (this.filterDateRange.length > 0) {
                Object.assign(params, {
                    start_date: this.filterDateRange[0],
                    end_date: this.filterDateRange[1],
                })
            }

            let url = `fasilitator/laporan`

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
        exportData(){
            this.$ewpLoadingShow();
            Api().get(`fasilitator/laporan-export`, {
                responseType: 'blob',
                params: {
                    role_filter: 'fasilitator',
                }
            }).then(response => {
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', `Laporan Kegiatan Fasilitator.xlsx`);
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
            Api().get(`fasilitator/laporan-export/${item.id}`, {
                responseType: 'blob',
                params: {
                    role_filter: 'fasilitator',
                }
            }).then(response => {
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', `Laporan Kegiatan Harian Fasilitator-${item.fasilitator.name}.xlsx`);
                document.body.appendChild(link);
                link.click();
            }).catch(error => {
                this.$axiosHandleError(error);
            }).then(() => {
                this.$ewpLoadingHide();
            });
        },
        getDataFasilitator(){
            Api().get('fasilitator/data-fasilitator').then((response)=>{
                this.dataFasilitator = response.data.data;
            })
        }
    },
    mounted(){
        if(this.isFasilitator){
            this.getDataFasilitator();
        }
        this.getDataTable();
    },
    computed: {
        isFasilitator(){
            return this.$store.state.profile.role_id == process.env.MIX_ROLE_FASILITATOR_ID
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