<template>
    <dashboard-base-layout>
        <!--begin::Post-->
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <!--begin::Container-->
            <div id="kt_content_container" class="container-xxl">

            <div class="card card-flush mt-5 mb-5 mb-xl-10" id="kt_profile_details_view">
                    <div class="card card-xl-stretch mb-5 mb-xl-8">
                        <div class="card-header border-0 pt-5 align-items-center">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bolder text-dark mb-2" style="font-size:20px !important;">Mahasiswa</span>
                            </h3>
                            <button type="button" class="btn btn-sm c-primary-custom ms-auto"
                                style="background: #FFF4DD !important;color:#EE7B33 !important"
                                @click="exportData">
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
                        </div>

                        <div class="card-body pt-5">
                            <app-datatable-serverside :table_config="tableConfig"
                                v-model:show_per_page="tableConfig.config.show_per_page"
                                v-model:search="tableConfig.config.search"
                                v-model:order="tableConfig.config.order"
                                v-model:sort_by="tableConfig.config.sort_by"
                                v-model:current_page="tableConfig.config.current_page"
                                @change-page="getDataTable"
                                >
                                <template v-slot:body>
                                    <TableRow
                                        v-for="(item, index) in tableConfig.feeder.data"
                                        :item="item"
                                        :index="index"
                                        :key="index"
                                    >
                                        <template #menu>
                                            <li v-if="!item.puspaga_rw || !item.is_active">
                                                <a class="dropdown-item py-3" href="javascript:void(0);" @click="onAssign(item.id)">Penugasan</a>
                                            </li>
                                            <li v-if="item.puspaga_rw && item.is_active">
                                                <a class="dropdown-item py-3" href="javascript:void(0);" @click="setInactive(item.id)">Non-aktifkan</a>
                                            </li>
                                            <li v-if="item.ktp_url">
                                                <a class="dropdown-item py-3" href="javascript:void(0);" @click="showModalSeeKTP(item)">Lihat KTP</a>
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
        <ModalAssign :data="dataModalAssign" @onSuccess="getDataTable" />
        <dashboard-modal :title="`Lihat KTP - ${dataModalLihatKTP.name}`" id="modal-lihat-ktp">
            <img style="width: 100%; height: auto;" :src="dataModalLihatKTP.ktp_url" alt="KTP"/>
            <template #footer>
                <button class="btn btn-sm bg-second-primary-custom text-white" type="button" @click="closeModalSeeKTP">
                    OK
                </button>
            </template>
        </dashboard-modal>
    </dashboard-base-layout>
</template>

<script>
import Api from "@/services/api";

import TableRow from './TableRow.vue';
import ModalAssign from './ModalAssign.vue';

export default {
    components: {ModalAssign, TableRow},
    data(){
        return {
            tableConfig: {
                feeder: {
                    column: [{
                            text: 'NO',
                            sort_column: false,
                            style: 'text-align: center',
                        },
                        {
                            text: 'IDENTITAS MAHASISWA',
                            sort_by: 'name',
                            sort_column: true,
                            style: 'text-align: left; white-space: nowrap;',
                        },
                        {
                            text: 'STATUS PENDIDIKAN',
                            sort_column: false,
                            style: 'text-align: left; white-space: nowrap;',
                        },
                        {
                            text: 'TEMPAT TINGGAL',
                            sort_column: false,
                            style: 'text-align: left; white-space: nowrap;',
                        },
                        {
                            text: 'PENEMPATAN',
                            sort_column: false,
                            style: 'text-align: left; white-space: nowrap;',
                        },
                        {
                            text: 'STATUS PENUGASAN',
                            sort_column: false,
                            style: 'text-align: left; white-space: nowrap;',
                        },
                        {
                            text: 'AKSI',
                            sort_column: false,
                            style: 'text-align: center',
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
            dataModalAssign: {
                id: null,
            },
            dataModalLihatKTP: {
                ktp_url: null,
                name: null,
            },
        }
    },
    methods:{
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

            Api().get(`d-mahasiswa`, {
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
        onAssign(id){
            this.dataModalAssign = {
                id,
            }
            $("#modal-assign").modal('show');
        },
        setInactive(id){
            Api().put(`d-mahasiswa/${id}/set-inactive`)
                .then(response => {
                    this.$emit('onSuccess');

                    this.$swal({
                        title: "Berhasil!",
                        text: 'Mahasiswa berhasil dinon-aktifkan!',
                        icon: "success",
                    }).then(() => this.getDataTable());
                })
                .catch(error => {
                    this.$axiosHandleError(error);
                }).finally(() => {
                    this.$ewpLoadingHide();
                });
        },
        showModalSeeKTP(item){
            this.dataModalLihatKTP = {
                ktp_url: item.ktp_url,
                name: item.name,
            }
            $("#modal-lihat-ktp").modal('show');
        },
        closeModalSeeKTP: () => $("#modal-lihat-ktp").modal('hide'),
        exportData(){
            this.$ewpLoadingShow();
            Api().get(`d-mahasiswa-export`, {
                responseType: 'blob',
            }).then(response => {
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', `Laporan Mahasiswa.xlsx`);
                document.body.appendChild(link);
                link.click();
            }).catch(error => {
                this.$axiosHandleError(error);
            }).then(() => {
                this.$ewpLoadingHide();
            });
        },
    },
    mounted(){
        this.getDataTable();
    }
}
</script>