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
                                <span class="card-label fw-bolder text-dark mb-2"
                                    style="font-size:20px !important;">Master Sub Kategori Monev</span>
                            </h3>
                            <button type="button" class="btn btn-sm bg-primary-custom ms-auto"
                                @click="showModalAdd">
                                <span class="text-white">Tambah Data</span>
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
                                        @onEdit="showModalEdit(item)"
                                    />
                                </template>
                            </app-datatable-serverside>
                        </div>

                    </div>
                </div>
            </div>
            <!--end::Container-->
        </div>
        <ModalAdd @onSuccess="onSuccessAddEdit"/>
        <ModalEdit :data="modalEditData" @onSuccess="onSuccessAddEdit"/>
    </dashboard-base-layout>
</template>

<script>
import ModalAdd from './ModalAdd.vue';
import ModalEdit from './ModalEdit.vue';
import TableRow from './TableRow.vue';

import Api from "@/services/api";

export default {
    components: { TableRow, ModalAdd, ModalEdit },
    data(){
        return  {
            tableConfig: {
                feeder: {
                    column: [{
                            text: 'NO',
                            style: 'text-align: center',
                        },
                        {
                            text: 'NAMA',
                            sort_by: 'name',
                            sort_column: true,
                            style: 'text-align: left',
                        },
                        {
                            text: 'KATEGORI',
                            style: 'text-align: left',
                        },
                        {
                            text: 'ORDER',
                            style: 'text-align: left',
                        },
                        {
                            text: 'STATUS',
                            style: 'text-align: center',
                        },
                        {
                            text: 'AKSI',
                            sort_column: false,
                            style: 'text-align: center',
                        }
                    ],
                    data: [
                        {},
                        {},
                    ],
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
            }
        }
    },
    methods: {
        showModalAdd: () => $("#modal-tambah").modal('show'),
        showModalEdit(item){
            this.modalEditData = {...item};
            $("#modal-edit").modal('show');
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

            Api().get(`m-sub-kategori-laporan-monev`, {
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
        onSuccessAddEdit(){
            this.tableConfig.config.current_page = 1;
            this.getDataTable();
        }
    },
    mounted(){
        this.getDataTable();
    }
}
</script>