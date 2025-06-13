<template>
    <div>
        <div class="d-flex flex-column flex-root">
            <div class="page d-flex flex-row flex-column-fluid">
                <app-sidebar></app-sidebar>
                <div
                    class="wrapper d-flex flex-column flex-row-fluid"
                    id="kt_wrapper"
                >
                    <app-navbar></app-navbar>
                    <!-- isi contentnya ya -->

                    <div id="main-content">
                        <!--begin::Post-->
                        <div class="post d-flex flex-column-fluid" id="kt_post">
                            <!--begin::Container-->
                            <div
                                id="kt_content_container"
                                class="container-xxl"
                            >
                                <div
                                    class="card card-flush mt-5 mb-5 mb-xl-10"
                                    id="kt_profile_details_view"
                                >
                                    <div
                                        class="card card-xl-stretch mb-5 mb-xl-8"
                                    >
                                        <div
                                            class="card-header border-0 pt-5 align-items-center"
                                        >
                                            <h3
                                                class="card-title align-items-start flex-column"
                                            >
                                                <span
                                                    class="card-label fw-bolder text-dark mb-2"
                                                    style="
                                                        font-size: 20px !important;
                                                    "
                                                    >Database Rumah Perubahan</span
                                                >
                                            </h3>
                                            <div class="d-flex flex-column align-items-end">
                                            <button
                                                type="button"
                                                class="btn btn-sm c-primary-custom mb-5"
                                                style="
                                                    background: #fff4dd !important;
                                                    color: #ee7b33 !important;
                                                "
                                                @click="exportData"
                                            >
                                                <span>
                                                    <svg
                                                        width="22"
                                                        height="23"
                                                        viewBox="0 0 22 23"
                                                        fill="none"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                    >
                                                        <path
                                                            opacity="0.3"
                                                            d="M5.36913 2.33203H12.5918C12.9169 2.33203 13.2315 2.44724 13.4798 2.65721L17.8464 6.35064C18.1553 6.6119 18.3334 6.99592 18.3334 7.40047V18.9084C18.3334 20.5497 18.3147 20.6654 16.631 20.6654H5.36913C3.68549 20.6654 3.66675 20.5497 3.66675 18.9084V4.08898C3.66675 2.44765 3.68549 2.33203 5.36913 2.33203Z"
                                                            fill="#EE7B33"
                                                        />
                                                        <path
                                                            fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M8.20541 13.1654H9.99885V15.0057C9.99885 15.2589 10.2041 15.4641 10.4572 15.4641H11.3952C11.6483 15.4641 11.8535 15.2589 11.8535 15.0057V13.1654H13.647C13.9001 13.1654 14.1053 12.9602 14.1053 12.707C14.1053 12.5986 14.0668 12.4936 13.9968 12.4109L11.276 9.19734C11.1124 9.00415 10.8232 8.98014 10.63 9.1437C10.6107 9.16007 10.5928 9.17801 10.5764 9.19734L7.85562 12.4109C7.69205 12.604 7.71606 12.8933 7.90925 13.0568C7.99202 13.1269 8.09696 13.1654 8.20541 13.1654Z"
                                                            fill="#EE7B33"
                                                        />
                                                    </svg>
                                                    &ensp;Export Data</span
                                                >
                                            </button>
                                            <div class="d-flex align-items-end" style="width:300px;">
                                                <app-datepicker type="date" placeholder="Pilih tanggal selesai" :format="'DD-MM-YYYY'"
                                                    :value-type="'YYYY-MM-DD'" :class="'me-0 w-100'" :range="true"
                                                    :style="'max-width:300px !important;'"
                                                    @change="tableConfig.config.current_page = 1; getDataTable()"
                                                    v-model:value="single.filter.daterange">
                                                </app-datepicker>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="card-body pt-5">
                                            <div class="row mb-3">
                                                <div class="col-lg-2 pb-5">
                                                    <div
                                                        style="
                                                            font-size: 20px;
                                                            font-weight: 600;
                                                        "
                                                        class="pt-2"
                                                    >
                                                        Filter Data
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 pb-5">
                                                    <app-select-single
                                                        v-model="
                                                            single.filter
                                                                .kategori
                                                        "
                                                        :show_button_clear="
                                                            false
                                                        "
                                                        :placeholder="'Pilih Kabupaten/Kota'"
                                                        :options="
                                                            filter_list_kategori_computed
                                                        "
                                                        :serverside="true"
                                                        :loading="
                                                            pageStatus ==
                                                            'kategori-load'
                                                        "
                                                        @change-search="
                                                            getKategori
                                                        "
                                                        @option-change="
                                                            resetMateri();
                                                            tableConfig.config.current_page = 1;
                                                            getDataTable();
                                                        "
                                                    >
                                                    </app-select-single>
                                                </div>
                                                <div class="col-lg-5 pb-5">
                                                    <app-select-single
                                                        v-model="
                                                            single.filter
                                                                .materi
                                                        "
                                                        :show_button_clear="
                                                            false
                                                        "
                                                        :options="
                                                            filter_list_materi_computed
                                                        "
                                                        :serverside="true"
                                                        :loading="
                                                            pageStatus ==
                                                            'materi-load'
                                                        "
                                                        @change-search="
                                                            getMateri(
                                                                single.filter
                                                                    .kategori.id
                                                            )
                                                        "
                                                        @option-change="
                                                            tableConfig.config.current_page = 1;
                                                            getDataTable();
                                                        "
                                                    >
                                                    </app-select-single>
                                                </div>
                                            </div>
                                            <app-datatable-serverside
                                                :table_config="tableConfig"
                                                @change-page="getDataTable"
                                                v-model:show_per_page="
                                                    tableConfig.config
                                                        .show_per_page
                                                "
                                                v-model:search="
                                                    tableConfig.config.search
                                                "
                                                v-model:order="
                                                    tableConfig.config.order
                                                "
                                                v-model:sort_by="
                                                    tableConfig.config.sort_by
                                                "
                                                v-model:current_page="
                                                    tableConfig.config
                                                        .current_page
                                                "
                                            >
                                                <template v-slot:body>
                                                    <tr
                                                        v-for="(
                                                            context, index
                                                        ) in tableConfig.feeder
                                                            .data"
                                                    >
                                                        <td class="text-center">
                                                            {{ index + 1 }}
                                                        </td>
                                                        <td class="text-left">{{ context.nama }}</td>
                                                        <td class="text-left">
                                                            {{ context.materi && context.materi.kategori ? context.materi.kategori.name : '-' }}
                                                        </td>
                                                        
                                                        <td class="text-left" style="width: 200px">
                                                            {{ context.materi ? context.materi.name : '-' }}
                                                        </td>
                                                        
                                                        <td class="text-left">
                                                            {{ formatDate(context.created_at) }}
                                                        </td>
                                                        <td class="text-left">
                                                            {{ context.skor }}
                                                        </td>
                                                    </tr>
                                                </template>
                                            </app-datatable-serverside>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Container-->
                        </div>

                        <!--end::Post-->
                    </div>

                    <!-- end of content -->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Page-->
        </div>
        <app-scroll-top></app-scroll-top>
    </div>
</template>

<script>
import Api from "@/services/api";
import useVuelidate from "@vuelidate/core";
import { required, sameAs, requiredIf, minLength } from "@vuelidate/validators";

export default {
    data() {
        return {
            v$: useVuelidate(),
            pageStatus: "standby",
            flag: "insert",
            list_kategori: [],
            list_materi: [],
            single: {
                id: "",
                name: "",
                kategori: {},
                materi: {},
                updated_at: {},

                filter: {
                    kategori: {
                        id: "0",
                        text: "Semua Kategori",
                    },

                    materi: {
                        id: "0",
                        text: "Semua Materi",
                    },

                    daterange: [],

                },
            },
            tableConfig: {
                feeder: {
                    column: [
                        {
                            text: "NO",
                            sort_column: false,
                            style: "text-align: center",
                        },
                        {
                            text: "NAME",
                            sort_by: "id",
                            sort_column: true,
                            style: "text-align: left",
                        },
                        {
                            text: "KATEGORI",
                            sort_by: "id_kategori",
                            sort_column: false,
                            style: "text-align: left",
                        },
                        {
                            text: "MATERI",
                            sort_by: "id_materi",
                            sort_column: false,
                            style: "text-align: left; width: 200px",
                        },
                        {
                            text: "TANGGAL SELESAI",
                            sort_by: "created_at",
                            sort_column: true,
                            style: "text-align: left;",
                        },
                        {
                            text: "SKOR",
                            sort_column: false,
                            style: "text-align: center;",
                        },
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
        };
    },
    computed: {
        filter_list_kategori_computed() {
            let response = [];

            response.push({
                id: "0",
                text: "Semua Kategori",
            });

            for (let i = 0; i < this.list_kategori.length; i++) {
                response.push(this.list_kategori[i]);
            }

            return response;
        },

        filter_list_materi_computed() {
            let response = [
                {
                    id: "0",
                    text: "Semua Materi",
                },
            ];

            this.list_materi.forEach((item) => {
                response.push({
                    id: item.id,
                    text: item.text || item.name,
                });
            });

            return response;
        },
    },
    validations() {
        return {
            single: {
                name: {
                    required,
                },
                kategori: {
                    required,
                },
                materi: {
                    required,
                },
            },
        };
    },
    mounted() {
        reinitializeAllPlugin();
        this.getDataTable();
    },
    methods: {
        resetMateri() {
            this.single.filter.materi = {
                id: "0",
                text: "Semua Materi",
            };
            this.list_materi = [];
        },
        formatDate(dateString) {
            const date = new Date(dateString);
            const months = [
                "Januari",
                "Februari",
                "Maret",
                "April",
                "Mei",
                "Juni",
                "Juli",
                "Agustus",
                "September",
                "Oktober",
                "November",
                "Desember",
            ];
            const day = date.getDate();
            const month = months[date.getMonth()];
            const year = date.getFullYear();
            return `${day} ${month} ${year}`;
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

            if (
                this.single.filter.kategori &&
                this.single.filter.kategori.id &&
                this.single.filter.kategori.id !== "0"
            ) {
                params.id_kategori = this.single.filter.kategori.id;
            }
            if (
                this.single.filter.materi &&
                this.single.filter.materi.id &&
                this.single.filter.materi.id !== "0"
            ) {
                params.id_materi = this.single.filter.materi.id;
            }

            if (this.single.filter.daterange.length > 0) {
                    Object.assign(params, {
                        start_date: this.single.filter.daterange[0],
                        end_date: this.single.filter.daterange[1],
                    })
                }
            Api().get(`rumahperubahan-jawaban`, { params }).then((response) => {
                console.log("API Response:", response);
                
                // Directly use the data array from the response
                if (response.data && response.data.data) {
                    this.tableConfig.feeder.data = response.data.data;
                    this.tableConfig.config.total_data = response.data.total || response.data.data.length;
                } else {
                    console.error("Unexpected API response format:", response);
                    this.tableConfig.feeder.data = [];
                    this.tableConfig.config.total_data = 0;
                }
                
                this.tableConfig.config.loading = false;
            })
            .catch((error) => {
                console.error("API Error:", error);
                this.tableConfig.config.loading = false;
                this.tableConfig.feeder.data = [];
                this.tableConfig.config.total_data = 0;
                this.$axiosHandleError(error);
            });
        },
        save() {
            this.v$.$touch();
            if (this.v$.$error) {
                return false;
            }

            this.$ewpLoadingShow();

            // Using FormData for file uploads
            let formData = new FormData();
            formData.append("name", this.single.name);
            formData.append(
                "id_materi",
                this.single.materi ? this.single.materi.id : ""
            );


            Api()
                .post("rumahperubahan-jawaban", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((response) => {
                    $("#modal-form").modal("hide");
                    this.$swal({
                        title: "Berhasil!",
                        text: "Menambahkan data materi",
                        icon: "success",
                    }).then(() => {
                        this.tableConfig.config.current_page = 1;
                        this.getDataTable();
                    });
                })
                .catch((error) => {
                    this.$axiosHandleError(error);
                })
                .then(() => {
                    this.$ewpLoadingHide();
                });
        },
        getKategori(keyword, limit) {
            this.pageStatus = "kategori-load";

            Api()
                .get(`kategori/listsDB?limit=${limit}&search=${keyword}`)
                .then((response) => {
                    this.list_kategori = [];

                    for (let i = 0; i < response.data.data.length; i++) {
                        this.list_kategori.push({
                            id: response.data.data[i].id,
                            text: response.data.data[i].name,
                        });
                    }
                })

                .catch((error) => {
                    this.$axiosHandleError(error);
                })
                .then(() => {
                    this.pageStatus = "standby";
                });
        },
        getMateri(id_kategori) {
            const searchTerm =
                this.single.filter.materi &&
                typeof this.single.filter.materi === "string"
                    ? this.single.filter.materi
                    : "";

            this.pageStatus = "materi-load";

            const apiUrl = id_kategori
                ? `m-rumah-perubahan-materi/listsDB?limit=15&search=${searchTerm}&id_kategori=${id_kategori}`
                : `m-rumah-perubahan-materi/listsDB?limit=15&search=${searchTerm}`;

            Api()
                .get(apiUrl)
                .then((response) => {
                    if (response.data && response.data.data) {
                        this.list_materi = response.data.data.map((item) => ({
                            id: item.id,
                            text: item.name,
                        }));
                    } else {
                        console.error(
                            "Respons API tidak sesuai format yang diharapkan:",
                            response.data
                        );
                    }
                })
                .catch((error) => {
                    console.error(
                        "Terjadi error saat memuat materi:",
                        error
                    );
                    this.$axiosHandleError(error);
                })
                .finally(() => {
                    this.pageStatus = "standby";
                });
        },
        reset() {
            this.v$.$reset();

            this.flag = "insert";

            this.single.id = "";
            this.single.name = "";
            this.single.kategori = {};
            this.single.materi = {};
        },
        exportData() {
            this.$ewpLoadingShow();

            const params = {
                kategori: this.single.filter.kategori?.id || null,
                materi: this.single.filter.materi?.id || null,
                search: this.tableConfig.config.search || "",
                startdate: this.single.filter.daterange[0],
                enddate: this.single.filter.daterange[1],
            };

            Api()
                .get(`rumahperubahan-jawaban/export`, {
                    params,
                    responseType: "blob",
                })
                .then((response) => {
                    const url = window.URL.createObjectURL(
                        new Blob([response.data])
                    );
                    const link = document.createElement("a");
                    link.href = url;
                    link.setAttribute(
                        "download",
                        `Database Peserta Rumah Perubahan.xlsx`
                    );
                    document.body.appendChild(link);
                    link.click();
                })
                .catch((error) => {
                    this.$axiosHandleError(error);
                })
                .finally(() => {
                    this.$ewpLoadingHide();
                });
        },
    },
};
</script>

<style scoped>
.icon-password {
    cursor: pointer;
    float: right;
    position: relative;
    bottom: 32px;
    right: 10px;
    font-size: 20px;
}

.bg-primary-custom {
    padding: 8px;
    border: none;
    border-radius: 5px;
    font-size: 10px;
}
</style>
