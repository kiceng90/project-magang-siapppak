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
                                    style="font-size:20px !important;">Komunikasi, Informasi dan Edukasi (KIE)</span>
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
                                        @onSuccessSwitchStatus="getDataTable"
                                        @onEdit="showModalEdit(item.id)"
                                    />
                                </template>
                            </app-datatable-serverside>

                        </div>
                    </div>
                </div>
            </div>
            <!--end::Container-->
        </div>
        <ModalAdd @onSuccess="getDataTable"/>
        <ModalEdit :data="modalEditData" @onSuccess="getDataTable"/>
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
        return {
            tableConfig: {
                feeder: {
                    column: [{
                            text: 'NO',
                            sort_column: false,
                            style: 'text-align: center; width: 80px;',
                        },
                        {
                            text: 'THUMBNAIL',
                            sort_by: 'thumbnail',
                            sort_column: false,
                            style: 'text-align: left; width: 150px;',
                        },
                        {
                            text: 'JENIS KONTEN',
                            sort_by: 'jenis_konten',
                            sort_column: true,
                            style: 'text-align: left; width: 150px;',
                        },
                        {
                            text: 'JUDUL',
                            sort_by: 'judul',
                            sort_column: true,
                            style: 'text-align: left',
                        },
                        {
                            text: 'STATUS',
                            sort_by: 'status',
                            sort_column: false,
                            style: 'text-align: center; width: 100px;',
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
            }, // table config
            modalEditData: {
                id: null,
                type : null,
                title : null,
                description : null,
                url_video_youtube : null,
                file_thumbnail : null,
            }
        }
    },
    methods: {
        showModalAdd: () => $("#modal-tambah").modal('show'),
        showModalEdit(id){
            const item = this.tableConfig.feeder.data.find((e) => e.id == id);
            this.modalEditData = {
                id: item.id,
                type : item.type,
                title : item.title,
                description : item.description,
                url_video_youtube : item.url_video_youtube,
                file_thumbnail : item.file_thumbnail,
            }
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

            Api().get(`kie`, {
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
            }
    },
    mounted(){
        this.getDataTable();
    }
}
</script>