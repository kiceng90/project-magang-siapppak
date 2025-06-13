<template>
    <div>
        <div class="d-flex flex-column flex-root">
            <div class="page d-flex flex-row flex-column-fluid">
                <app-sidebar></app-sidebar>
                <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                    <app-navbar></app-navbar>
                    
                    <div id="main-content">
                        <div class="post d-flex flex-column-fluid" id="kt_post">
                            <div id="kt_content_container" class="container-xxl">
                                <div class="card card-flush mt-5 mb-5 mb-xl-10">
                                    <div class="card-header border-0 pt-5">
                                        <h3 class="card-title align-items-start flex-column">
                                            <span class="card-label fw-bolder text-dark mb-2"
                                                  style="font-size:20px !important;">Master Data Klien Lapor PPA</span>
                                        </h3>
                                    </div>
                                    <div class="card-body pt-5">
                                        <app-datatable-serverside :table_config="tableConfig"
                                                                   @change-page="getDataTable"
                                                                   v-model:show_per_page="tableConfig.config.show_per_page"
                                                                   v-model:search="tableConfig.config.search"
                                                                   v-model:order="tableConfig.config.order"
                                                                   v-model:sort_by="tableConfig.config.sort_by"
                                                                   v-model:current_page="tableConfig.config.current_page">
                                            <template v-slot:body>
                                                <tr v-for="(context, index) in tableConfig.feeder.data" :key="context.id">
                                                    <td class="text-center">{{ index + 1 }}</td>
                                                    <td class="text-left">
                                                        <div>{{ context.nama_klien }}</div>
                                                        <div class="text-gray-600">{{ context.no_telp_klien }}</div>
                                                        <div class="pt-2">{{ context.alamat_klien }}</div> 
                                                    </td>
                                                    <td class="text-left">
                                                        <div>{{ context.nama_pelapor }}</div>
                                                        <div class="text-gray-600">{{ context.no_telp_pelapor }}</div>
                                                        <div class="pt-2">{{ context.alamat_pelapor }}</div>
                                                    </td>
                                                    <td class="text-left">{{ context.kelurahan.nama }}</td>
                                                    <td class="text-left">{{ context.kategori.nama }}</td>
                                                    <td class="text-left">
                                                        <span v-if="context.status.nama === 'Menunggu Validasi'" class="badge badge-warning">{{ context.status.nama }}</span>
                                                        <span v-else class="badge badge-success">{{ context.status.nama }}</span>
                                                    </td>
                                                    <td class="text-center">
                                                            <div class="dropdown" style="position:static !important;">
                                                                <button class="btn btn-secondary btn-xs dropdown-toggle"
                                                                    type="button" data-bs-toggle="dropdown"
                                                                    style="padding:5px 10px !important;"
                                                                    aria-expanded="false">
                                                                    Aksi
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li><a class="dropdown-item py-3"
                                                                            @click="redirectCetak(context.id_pengaduan)">Cetak
                                                                            Kasus
                                                                        </a>
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
                    </div>
                </div>
            </div>
        </div>
        <app-scroll-top></app-scroll-top>
    </div>
</template>

<script>
import Api from "@/services/api";
import useVuelidate from '@vuelidate/core';
import { required, requiredIf } from '@vuelidate/validators';

export default {
    data() {
        return {
            v$: useVuelidate(),
            tableConfig: {
                feeder: {
                    column: [{
                                text: 'NO',
                                sort_column: false,
                                style: 'text-align: center',
                            },
                            {
                                text: 'KLIEN',
                                sort_by: 'nama_klien',
                                sort_column: true,
                                style: 'text-align: left',
                            },
                            {
                                text: 'PELAPOR',
                                sort_column: true,
                                style: 'text-align: left',
                            },
                            {
                                text: 'KELURAHAN',
                                sort_by: 'kelurahan_nama',
                                sort_column: true,
                                style: 'text-align: left',
                            },
                            {
                                text: 'KATEGORI PERMASALAHAN',
                                // sort_by: 'phone_number',
                                sort_column: false,
                                style: 'text-align: left',
                            },
                            {
                                text: 'STATUS',
                                sort_column: false,
                                style: 'text-align: left',
                            },
                        ],
                    data: [],
                },
                config: {
                    show_per_page: 10,
                    search: '',
                    order: 'desc',
                    sort_by: 'id',
                    total_data: 2,
                    current_page: 1,
                    loading: false,
                }
            },
        };
    },
    mounted() {
        this.getDataTable();
    },
    methods: {
        getDataTable() {
            this.tableConfig.config.loading = true;

            const params = {
                page: this.tableConfig.config.current_page,
                limit: this.tableConfig.config.show_per_page,
                search: this.tableConfig.config.search,
                withKecamatan: 1,
                withKeluargaKlien: 1,
            };

            Api().get('https://ppa-dp3appkb.surabaya.go.id/api_newpetra/api/siapppak/laporans', { params })
                .then(response => {
                    this.tableConfig.feeder.data = response.data.data;
                    this.tableConfig.config.total_data = response.data.total;

                    this.tableConfig.config.loading = false;
                })
                .catch(error => {
                    this.tableConfig.config.loading = false;
                    this.tableConfig.feeder.data = [];
                    this.tableConfig.config.total_data = 0;
                    this.$axiosHandleError(error);
                })
                .finally(() => {
                    this.tableConfig.config.loading = false;
                });
        },
        // history(id) {
        //     this.$router.push({ name: 'klien-history-kasus', params: { id } });
        // }  ?page=2&withKecamatan=1&withKeluargaKlien=1
    }
};
</script>
