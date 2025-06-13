<template>
    <div>
        <div class="pu_site_page">
            <app-header></app-header>

            <section class="pu_beadcrumb_part" data-bg-img="/img/fotokegiatan/famili2.jpg"
                :style="`background: url(${$assetUrl()}siapppak/images/fotokegiatan/famili2.jpg) center center / cover no-repeat;`">
                <div class="container custom_container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="pu_breadcrumb_inner_content"></div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="pu_causes_details_part padding_bottom">
                <div class="container custom_container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="">
                                <div class="causes_details_inner">
                                    <div class="pu_causes_details_content" style="padding: 20px;">
                                        <h1 class="title fw-bold text-center">
                                            MITRA
                                        </h1>
                                        <div>
                                            <app-datatable-serverside :table_config="tableConfig"
                                                @change-page="getDataTable"
                                                v-model:show_per_page="tableConfig.config.show_per_page"
                                                v-model:search="tableConfig.config.search"
                                                v-model:order="tableConfig.config.order"
                                                v-model:sort_by="tableConfig.config.sort_by"
                                                v-model:current_page="tableConfig.config.current_page">
                                                <template v-slot:body>
                                                    <tr v-for="(context, index) in tableConfig.feeder.data" :key="index">
                                                        <td class="text-center">
                                                            {{ index + 1 }}
                                                        </td>
                                                        <td class="text-left">
                                                            <div class="d-flex align-items-center">
                                                                <!-- <div v-if="context.file_foto">
                                                                    <img class="me-3" :src="context.file_foto" style="width:50px;height:50px;border-radius:5px;">
                                                                </div>
                                                                <div v-else>
                                                                    <img class="me-3" :src="$assetUrl() + 'siapppak/images/user.png'" style="width:50px;height:50px;border-radius:5px;">
                                                                </div> -->
                                                                <div>
                                                                    <div>
                                                                        {{ context.name }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            {{ $noNullable(context.address) }}
                                                        </td>
                                                        <td>
                                                            {{ $noNullable(context.phone) }}
                                                        </td>
                                                    </tr>
                                                </template>
                                            </app-datatable-serverside>
                                        </div>
                                    </div>
                                </div>
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
            pageStatus: 'standby',
            tableConfig: {
                feeder: {
                    column: [
                        {
                            text: 'NO',
                            sort_column: false,
                            style: 'text-align: center; width: 100px',
                        },
                        {
                            text: 'NAMA MITRA',
                            sort_by: 'name',
                            sort_column: true,
                            style: 'text-align: left',
                        },
                        {
                            text: 'ALAMAT',
                            sort_column: false,
                            style: 'text-align: left',
                        },
                        {
                            text: 'NO. TELPON',
                            sort_column: false,
                            style: 'text-align: left',
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
        }
    },
    mounted() {
        this.getDataTable()
    },
    methods: {
        getDataTable() {
            this.tableConfig.config.loading = true
            this.tableConfig.feeder.data = []

            let params = {
                page: this.tableConfig.config.current_page,
                limit: this.tableConfig.config.show_per_page,
                sortby: this.tableConfig.config.sort_by,
                order: this.tableConfig.config.order,
                search: this.tableConfig.config.search
            }

            Api().get(`public/mitra/${this.$route.params.slug}`, { params })
                .then(response => {
                    this.tableConfig.feeder.data = response.data.data
                    this.tableConfig.config.total_data = response.data.total
                    this.tableConfig.config.loading = false
                })
                .catch(error => {
                    this.tableConfig.config.loading = false
                    this.tableConfig.feeder.data = []
                    this.tableConfig.config.total_data = 0
                    this.$axiosHandleError(error)
                });
        },
    }
};
</script>