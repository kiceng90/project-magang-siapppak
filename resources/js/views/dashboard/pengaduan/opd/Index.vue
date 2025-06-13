<template>
    <div>
        <div class="card card-flush mt-5 mb-5 mb-xl-10" id="kt_profile_details_view">
            <div class="card card-xl-stretch mb-5 mb-xl-8">
                <div class="card-header border-0 pt-5 align-items-center">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder text-dark mb-2" style="font-size:20px !important;">Data
                            Pengaduan</span>
                    </h3>
                </div>
                <div class="card-body pt-5">
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
                                    <div class="text-gray-500">{{context.is_has_nik ? context.nik_klien : context.identity_number}}</div>
                                </td>
                                <td class="text-center">
                                    <div>
                                        <span
                                            :class="`badge ${context.status.label_status}`">{{context.status.status}}</span>
                                    </div>
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
                                text: 'STATUS',
                                sort_column: false,
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
                        total_data: 2,
                        current_page: 1,
                        loading: false,
                        show_search: true,
                    }
                },

                single: {

                    filter: {
                        daterange: []
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
