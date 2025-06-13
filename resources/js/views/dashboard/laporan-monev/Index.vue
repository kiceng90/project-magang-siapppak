<template>
    <dashboard-base-layout>
        <!--begin::Post-->
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <!--begin::Container-->
            <div id="kt_content_container" class="container-xxl">
                <div
                    class="card card-flush mt-5 mb-5 mb-xl-10"
                    id="kt_profile_details_view"
                >
                    <div class="card card-xl-stretch mb-5 mb-xl-8">
                        <div
                            class="card-header border-0 pt-5 align-items-center"
                        >
                            <h3
                                class="card-title align-items-start flex-column"
                            >
                                <span
                                    class="card-label fw-bolder text-dark mb-2"
                                    style="font-size: 20px !important"
                                    >Laporan Kegiatan Monev</span
                                >
                            </h3>
                            <button type="button" class="btn btn-sm c-primary-custom me-3 ms-auto"
                                style="background: #FFF4DD !important;color:#EE7B33 !important"
                                @click="exportAll"
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
                            <router-link v-if="isKonselor" :to="{name: 'kegiatan-monev-tambah'}" class="btn btn-sm bg-primary-custom">
                                <span class="text-white">Tambah Data</span>
                            </router-link>
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
                                >
                                <template v-slot:body>
                                    <TableRow
                                        v-for="(item, index) in tableConfig.feeder.data"
                                        :item="item"
                                        :index="index"
                                        :key="index"
                                    >
                                        <template #menu>
                                            <li>
                                                <router-link class="dropdown-item py-3" :to="{name: 'kegiatan-monev-show', params: {id: item.id}}">Lihat</router-link>
                                            </li>
                                            <li v-if="isKonselor">
                                                <router-link class="dropdown-item py-3" :to="{name: 'kegiatan-monev-edit', params: {id: item.id}}">Edit</router-link>
                                            </li>
                                            <li v-if="isSubkord">
                                                <a class="dropdown-item py-3" href="javascript:void(0);" @click="$emit('verifLaporan', item)">Verifikasi</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item py-3" href="javascript:void(0);" @click="$emit('exportLaporan', item)">Export</a>
                                            </li>
                                            <li v-if="isAdmin">
                                                <a class="dropdown-item py-3" href="javascript:void(0);" @click="$emit('deleteLaporan', item)">Hapus</a>
                                            </li>
                                        </template>
                                    </TableRow>
                                </template>
                            </app-datatable-serverside>
                            <!-- <DataTable
                                :table_config="tableConfig"
                                v-model:show_per_page="
                                    tableConfig.config.show_per_page
                                "
                                v-model:search="tableConfig.config.search"
                                v-model:order="tableConfig.config.order"
                                v-model:sort_by="tableConfig.config.sort_by"
                                v-model:current_page="
                                    tableConfig.config.current_page
                                "
                                @change-page="getDataTable"
                                @verifLaporan="verifLaporan"
                                @exportLaporan="exportLaporan"
                            >
                            </DataTable> -->
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Container-->
        </div>
    </dashboard-base-layout>
</template>

<script>
import moment from "moment";
import TableRow from './TableRow.vue';

import Api from "@/services/api";

export default {
    components: { TableRow },
    data() {
        return {
            tableConfig: {
                feeder: {
                    // column_parent: [
                    //     {
                    //         text: "NO",
                    //         rowspan: 2,
                    //         style: 'width: 1%;',
                    //     },
                    //     {
                    //         text: 'IDENTITAS PETUGAS',
                    //         colspan: 6,
                    //     },
                    //     {
                    //         text: 'IDENTITAS PUSPAGA',
                    //         colspan: 4,
                    //     }
                    // ],
                    // column: [
                    //     {
                    //         text: "Nama Lengkap",
                    //         style: 'white-space: nowrap; text-align: center;',
                    //         getData(rowData){
                    //             return rowData?.konselor?.name
                    //         },
                    //     },
                    //     {
                    //         text: "NIK",
                    //         style: 'white-space: nowrap; text-align: center;',
                    //         getData(rowData){
                    //             return rowData?.konselor?.dkonselor?.nik
                    //         },
                    //     },
                    //     {
                    //         text: "No. HP (WhatsApp)",
                    //         style: 'text-align: center;',
                    //         rowStyle: 'white-space: nowrap;',
                    //         getData(rowData){
                    //             return rowData?.konselor?.phone_number
                    //         },
                    //     },
                    //     {
                    //         text: "Jabatan Petugas",
                    //         style: 'white-space: nowrap; text-align: center;',
                    //         getData(rowData){
                    //             return rowData?.jabatan?.name
                    //         },
                    //     },
                    //     {
                    //         text: "Apakah  Kegiatan Puspaga Balai RW Masih Aktif",
                    //         style: 'min-width: 200px; text-align: center;',
                    //         accessor: 'active_string'
                    //     },
                    //     {
                    //         text: "Tanggal Monev",
                    //         style: 'text-align: center; white-space: nowrap;',
                    //         rowStyle: 'white-space: nowrap;',
                    //         getData(rowData){
                    //             return moment(rowData.date).locale('id').format('DD MMMM YYYY')
                    //         }
                    //     },
                    //     {
                    //         text: "Kecamatan Puspaga RW",
                    //         style: 'text-align: center; min-width: 180px;',
                    //         getData(rowData){
                    //             return rowData?.balai_puspaga_rw?.kelurahan?.kecamatan?.name
                    //         }
                    //     },
                    //     {
                    //         text: "Kelurahan Puspaga RW",
                    //         style: 'text-align: center; min-width: 180px;',
                    //         getData(rowData){
                    //             return rowData?.balai_puspaga_rw?.kelurahan?.name
                    //         }
                    //     },
                    //     {
                    //         text: "Puspaga RW",
                    //         style: 'text-align: center; white-space: nowrap; min-width: 180px;',
                    //         getData(rowData){
                    //             return rowData?.balai_puspaga_rw?.name
                    //         }
                    //     },
                    //     {
                    //         text: "Staf Penanggungjawab",
                    //         style: 'text-align: center;',
                    //         getData(rowData){
                    //             return rowData?.balai_puspaga_rw?.konselor?.name
                    //         }
                    //     },
                    // ],
                    column: [
                        {
                            text: "NO",
                            sort_column: false,
                            style: 'width: 1%;',
                        },
                        {
                            text: 'TANGGAL MONEV',
                            sort_by: 'date',
                            sort_column: true,
                            style: 'text-align: left; white-space: nowrap;',
                        },
                        {
                            text: 'IDENTITAS PETUGAS',
                            sort_column: false,
                            style: 'text-align: left; white-space: nowrap;',
                        },
                        {
                            text: 'IDENTITAS PUSPAGA',
                            sort_column: false,
                            style: 'text-align: left; white-space: nowrap;',
                        },
                        {
                            text: 'STATUS VERIFIKASI',
                            sort_column: false,
                            style: 'text-align: left; white-space: nowrap;',
                        },
                        {
                            text: 'AKSI',
                            sort_column: false,
                            style: 'text-align: left; white-space: nowrap;',
                        }
                    ],
                    data: [],
                },
                config: {
                    title: "Datatable",
                    show_per_page: 10,
                    search: "",
                    order: "desc",
                    sort_by: "id",
                    total_data: 0,
                    current_page: 1,
                    loading: false,
                    show_search: true,
                },
            },
            listKuesioner: [],
            columnKategori: [],
            columnSubkategori: [],
            filterDateRange: [],
        }; // data
    },
    methods: {
        groupBy: function(xs, key) {
            return xs.reduce(function(rv, x) {
                rv[x[key]] = (rv[x[key]] || []).push(x);
                return rv;
            }, {});
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
            };

            if (this.filterDateRange.length > 0) {
                Object.assign(params, {
                    start_date: this.filterDateRange[0],
                    end_date: this.filterDateRange[1],
                })
            }
            
            // const jumlahPertanyaanPerSubkategori = this.columnSubkategori.reduce((prev, current)=>{
            //     prev[`total_answer_${current.id}`] = current.questionCount;
            //     return prev;
            // },{})

            Api()
                .get(`laporan-monev`, {
                    params,
                })
                .then((response) => {
                    let data = response.data?.data?.data;

                    // const transformedData = data.map(row=>{
                    //     const jawabanWithSubkategori = row.jawaban.map(j=>({
                    //             ...j,
                    //             id_sub_kategori: j.kuesioner.id_sub_kategori_laporan_monev,
                    //         }));
                    //     const subkategoriWithTotalJawaban = jawabanWithSubkategori.reduce((prev, current)=>{
                    //         const key = `total_answer_${current.id_sub_kategori}`
                    //         prev[key] = (prev[key] || 0) + 1;
                    //         return prev;
                    //     }, {})
                        
                    //     return {
                    //         ...row,
                    //         ...Object.entries(subkategoriWithTotalJawaban).map(([k, v])=>{
                    //             const totalPertanyaan = jumlahPertanyaanPerSubkategori[k]
                    //             const totalJawaban = v;
                    //             return {
                    //                 key: k,
                    //                 value: `${totalJawaban} dari ${totalPertanyaan} Pertanyaan Selesai`
                    //             }
                    //         }).reduce((prev, current)=>{
                    //             prev[current.key] = current.value;
                    //             return prev;
                    //         },{}),
                    //     }
                    // })

                    this.tableConfig.feeder.data = data;
                    this.tableConfig.config.total_data = response.data.data.total;

                    this.tableConfig.config.loading = false;
                })
                .catch((error) => {
                    this.tableConfig.config.loading = false;

                    this.tableConfig.feeder.data = [];
                    this.tableConfig.config.total_data = 0;

                    this.$axiosHandleError(error);
                });
        },
        onSuccessAddEdit() {
            this.tableConfig.config.current_page = 1;
            this.getDataTable();
        },
        getKuisioner(){
            return Api()
                .get('laporan-monev-list-kuesioner')
                .then(response=>{
                    this.listKuesioner = response?.data?.data ?? [];
                    // this.listKuesioner.forEach(kategori=>{
                    //     this.columnKategori.push(kategori)
                    //     if(kategori.name !== 'Dokumentasi'){
                    //         this.tableConfig.feeder.column_parent.push({
                    //             text: kategori.name,
                    //             colspan: kategori.sub_kategori.length,
                    //             style: 'white-space: nowrap; text-transform: uppercase;',
                    //         })
                    //         kategori.sub_kategori.forEach(({kuesioner, is_active, ...s})=>{
                    //             this.columnSubkategori.push({...s, questionCount: kuesioner.length})
                    //             this.tableConfig.feeder.column.push({
                    //                 text: s.name,
                    //                 accessor: `total_answer_${s.id}`,
                    //                 style: 'text-align: center; min-width: 150px;'
                    //             })
                    //         })
                    //     }
                    // })
                    
                    // this.tableConfig.feeder.column_parent.push(
                    // {
                    //     text: "STATUS VERIFIKASI",
                    //     rowspan: 2,
                    // });
                    // this.tableConfig.feeder.column_parent.push(
                    // {
                    //     text: "AKSI",
                    //     rowspan: 2,
                    // });
                });
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

                    Api().put(`laporan-monev/${item.id}/verif`)
                    .then(response => {
                        $("#modal-tambah").modal('hide');
                        _this.getDataTable();

                        _this.$swal({
                            title: "Berhasil!",
                            text: 'Verifikasi laporan kegiatan monev',
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
        exportLaporan(item){
            this.$ewpLoadingShow();
            Api().get(`laporan-monev-export/${item.id}`, {
                responseType: 'blob',
            }).then(response => {
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', `Laporan Kegiatan Monev - ${item.konselor?.name}.xlsx`);
                document.body.appendChild(link);
                link.click();
            }).catch(error => {
                this.$axiosHandleError(error);
            }).then(() => {
                this.$ewpLoadingHide();
            });
        },
        exportAll(){
            this.$ewpLoadingShow();
            Api().get(`laporan-monev-export`, {
                responseType: 'blob',
            }).then(response => {
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', `Laporan Kegiatan Monev.xlsx`);
                document.body.appendChild(link);
                link.click();
            }).catch(error => {
                this.$axiosHandleError(error);
            }).then(() => {
                this.$ewpLoadingHide();
            });
        }
    },
    mounted() {
        this.getKuisioner().then(()=>{
            this.getDataTable();
        });
    },
    computed: {
        isAdmin() {
            return this.$store.state.profile.role_id == process.env.MIX_ROLE_ADMIN_ID;
        },
        isKonselor() {
            return this.$store.state.profile.role_id == process.env.MIX_ROLE_KONSELOR_ID;
        },
        isSubkord() {
            return this.$store.state.profile.role_id == process.env.MIX_ROLE_SUBKORD_ID;
        },
    }
};
</script>
