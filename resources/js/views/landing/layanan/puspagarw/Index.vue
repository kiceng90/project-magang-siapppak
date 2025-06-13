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
                                            PUSPAGA Balai RW
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
                                                            {{index + 1}}
                                                        </td>
                                                        <td class="text-left">
                                                            <div class="d-flex flex-column align-items-start">
                                                                <p class="mb-0">{{ context.name }} - RW {{ context.rw }}</p>
                                                                <p class="mb-0">Dibentuk pada tahun : {{ context.inauguration_year }}</p>
                                                            </div>
                                                        </td>
                                                        <td class="text-left">
                                                            <p class="mb-0">Alamat : {{ context.address }}</p>
                                                            <p class="mb-0">Kelurahan : {{ context.kelurahan.name }}</p>
                                                            <p class="mb-0">Kecamatan : {{ context.kelurahan.kecamatan.name }}</p>
                                                            <p class="mb-0">Wilayah : {{ context.wilayah.name }}</p>
                                                        </td>
                                                        <td class="text-left">
                                                            <p class="mb-0">Hari : {{ context.operational_day }}</p>
                                                            <p class="mb-0">Jam : {{ context.operational_start_time }}-{{ context.operational_end_time }}</p>
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
            tableConfig: {
                feeder: {
                    column: [{
                            text: 'NO',
                            sort_column: false,
                            style: 'text-align: center',
                        },
                        {
                            text: 'PUSPAGA BALAI RW',
                            sort_by: 'name',
                            sort_column: true,
                            style: 'text-align: left',
                        },
                        {
                            text: 'Wilayah',
                            sort_column: false,
                            style: 'text-align: left',
                        },
                        {
                            text: 'WAKTU PELAYANAN',
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
        }
    },
    mounted() {
        this.getDataTable();
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

            Api().get(`public/d-balai-puspaga-rw`, { params })
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