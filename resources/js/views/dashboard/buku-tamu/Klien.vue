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
                                                    >Buku Tamu</span
                                                >
                                            </h3>
                                            <button
                                                type="button"
                                                class="btn btn-sm c-primary-custom me-3"
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
                                        </div>
                                        <div class="card-body pt-5">
                                            <div class="col-lg-6 pb-5">
                                                <div
                                                    class="row align-items-center"
                                                >
                                                    <div
                                                        class="col-lg-4 fw-bolder mb-5"
                                                    >
                                                        Keterangan Status
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <div
                                                            class="d-flex flex-wrap"
                                                        >
                                                            <!-- Filter Semua -->
                                                            <span
                                                                class="badge badge-light-primary mb-5 me-3 c-pointer"
                                                                @click="
                                                                    onClickFilterStatus(
                                                                        undefined
                                                                    )
                                                                "
                                                                :class="{
                                                                    'badge-light-success':
                                                                        filter.statusBukuTamu ===
                                                                        undefined,
                                                                }"
                                                            >
                                                                Semua
                                                            </span>

                                                            <!-- Filter Terkonfirmasi -->
                                                            <span
                                                                class="badge badge-light-primary mb-5 me-3 c-pointer"
                                                                @click="
                                                                    onClickFilterStatus(
                                                                        'terkonfirmasi'
                                                                    )
                                                                "
                                                                :class="{
                                                                    'badge-light-success':
                                                                        filter.statusBukuTamu ===
                                                                        'terkonfirmasi',
                                                                }"
                                                            >
                                                                Terkonfirmasi
                                                            </span>

                                                            <!-- Filter Belum Verifikasi -->
                                                            <span
                                                                class="badge badge-light-primary mb-5 me-3 c-pointer"
                                                                @click="
                                                                    onClickFilterStatus(
                                                                        'belum_verifikasi'
                                                                    )
                                                                "
                                                                :class="{
                                                                    'badge-light-success':
                                                                        filter.statusBukuTamu ===
                                                                        'belum_verifikasi',
                                                                }"
                                                            >
                                                                Belum Verifikasi
                                                            </span>
                                                        </div>
                                                    </div>
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
                                                        <td class="text-left">
                                                            <div
                                                                class="d-flex align-items-center gap-4"
                                                            >
                                                                <div
                                                                    class="d-flex flex-column"
                                                                >
                                                                    <p
                                                                        class="mb-0"
                                                                    >
                                                                        Nama :
                                                                        <span
                                                                            class="fw-bolder"
                                                                            style="
                                                                                font-size: 1rem;
                                                                                text-transform: capitalize;
                                                                            "
                                                                            >{{
                                                                                context.nama
                                                                            }}</span
                                                                        >
                                                                    </p>
                                                                    <span
                                                                        style="
                                                                            white-space: nowrap;
                                                                        "
                                                                    >
                                                                        NIK :
                                                                        {{
                                                                            context.nik
                                                                        }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-left">
                                                            <div
                                                                class="d-flex align-items-center gap-4"
                                                            >
                                                                <div
                                                                    class="d-flex flex-column"
                                                                >
                                                                    <p
                                                                        style="
                                                                            white-space: nowrap;
                                                                        "
                                                                        class="mb-0"
                                                                    >
                                                                        Asal :
                                                                        <span
                                                                            class="fw-bolder"
                                                                            :class="{
                                                                                'text-primary':
                                                                                    context.kota_kabupaten_ktp ===
                                                                                    'Surabaya',
                                                                            }"
                                                                            >{{
                                                                                context.kota_kabupaten_ktp
                                                                            }}</span
                                                                        >
                                                                    </p>
                                                                    <span
                                                                        style="
                                                                            white-space: nowrap;
                                                                        "
                                                                    >
                                                                        Kecamatan
                                                                        :
                                                                        {{
                                                                            context.kecamatan_ktp
                                                                        }}
                                                                    </span>
                                                                    <span
                                                                        style="
                                                                            white-space: nowrap;
                                                                        "
                                                                    >
                                                                        Kelurahan
                                                                        :
                                                                        {{
                                                                            context.kel_desa_ktp
                                                                        }}
                                                                    </span>
                                                                    <p
                                                                        style="
                                                                            white-space: nowrap;
                                                                        "
                                                                        class="mb-0"
                                                                    >
                                                                        <span
                                                                            style="
                                                                                white-space: nowrap;
                                                                            "
                                                                        >
                                                                            RT
                                                                            {{
                                                                                context.rt_ktp
                                                                            }}
                                                                        </span>
                                                                        <span
                                                                            style="
                                                                                white-space: nowrap;
                                                                            "
                                                                        >
                                                                            RW
                                                                            {{
                                                                                context.rw_ktp
                                                                            }}
                                                                        </span>
                                                                    </p>
                                                                    <p>
                                                                        {{
                                                                            context.alamat_ktp
                                                                        }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-left">
                                                            <div
                                                                class="text-center w-100"
                                                            >
                                                                <div
                                                                    class="d-flex flex-column"
                                                                >
                                                                    <p
                                                                        class="mb-0"
                                                                    >
                                                                        <span
                                                                            class="fw-bolder"
                                                                            style="
                                                                                font-size: 1rem;
                                                                                text-transform: capitalize;
                                                                            "
                                                                        >
                                                                            <ul
                                                                                class="text-start p-0"
                                                                                style="
                                                                                    list-style-position: inside;
                                                                                "
                                                                            >
                                                                                <li
                                                                                    v-for="layanan in context.mkebutuhan_layanan"
                                                                                    :key="
                                                                                        layanan.id
                                                                                    "
                                                                                >
                                                                                    {{
                                                                                        layanan.name
                                                                                    }}
                                                                                </li>
                                                                            </ul>
                                                                        </span>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-left">
                                                            <div
                                                                class="d-flex flex-column"
                                                            >
                                                                <p class="mb-0">
                                                                    <span
                                                                        class="fw-bolder text-capitalize"
                                                                        :class="{
                                                                            'badge-light-success':
                                                                                context.status ===
                                                                                'terkonfirmasi',
                                                                            'badge-light-danger':
                                                                                context.status ===
                                                                                'belum_verifikasi',
                                                                        }"
                                                                    >
                                                                        {{
                                                                            context.status.replace(
                                                                                "_",
                                                                                " "
                                                                            )
                                                                        }}
                                                                    </span>
                                                                </p>
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
                                                                        <router-link :to="{name: 'buku-tamu-cetak', params: { id: context.id }}" class="dropdown-item py-3">
                                                                            Cetak Laporan
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

export default {
    data() {
        return {
            v$: useVuelidate(),
            pageStatus: "standby",
            filter: {
                statusBukuTamu: undefined, // Menyimpan status yang dipilih
            },
            statusBukuTamuOptions: [
                { labelStatus: "Terkonfirmasi", value: "terkonfirmasi" },
                { labelStatus: "Belum Verifikasi", value: "belum_verifikasi" },
            ],
            tableConfig: {
                feeder: {
                    column: [
                        {
                            text: "NO",
                            sort_column: false,
                            style: "text-align: center",
                        },
                        {
                            text: "PENGUNJUNG",
                            sort_column: true,
                            style: "text-align: left",
                        },
                        {
                            text: "ALAMAT",
                            sort_column: true,
                            style: "text-align: left",
                        },
                        {
                            text: "KEBUTUHAN",
                            sort_column: false,
                            style: "text-align: left",
                        },
                        {
                            text: "STATUS",
                            sort_column: false,
                            style: "text-align: left",
                        },
                        {
                            text: "AKSI",
                            sort_column: false,
                            style: "text-align: center",
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
    computed: {},
    validations() {},
    mounted() {
        reinitializeAllPlugin();
        this.getDataTable();
    },
    methods: {
        exportData() {
            console.log("Export data dipanggil!");
            this.$ewpLoadingShow();

            Api()
                .get(`export-buku-tamu`, { responseType: "blob" })
                .then((response) => {
                    console.log("Response diterima!", response);
                    const url = window.URL.createObjectURL(
                        new Blob([response.data])
                    );
                    const link = document.createElement("a");
                    link.href = url;
                    link.setAttribute("download", "Data Buku Tamu.xlsx");
                    document.body.appendChild(link);
                    link.click();
                })
                .catch((error) => {
                    console.error("Error terjadi!", error);
                    if (error.response) {
                        console.log("Status:", error.response.status);
                        console.log("Data:", error.response.data);
                    }
                    this.$axiosHandleError(error);
                })

                .finally(() => {
                    this.$ewpLoadingHide();
                });
        },
        onClickFilterStatus(status) {
            this.filter.statusBukuTamu = status; // Update status filter
            this.getDataTable(); // Panggil ulang getDataTable untuk memuat data sesuai filter
        },
        async fetchBukuTamuDetails() {
            this.pageStatus = "loading";
            try {
                const response = await Api().get(
                    `/buku-tamu/${this.$route.params.id}`
                );

                if (response.data.status === "success") {
                    this.bukuTamu = response.data.data;
                    this.pageStatus = "standby";
                } else {
                    console.warn("API returned a non-success status");
                    this.pageStatus = "error";
                }
            } catch (error) {
                console.error("Failed to fetch buku tamu details:", error);
                this.pageStatus = "error";
            }
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
                status: this.filter.statusBukuTamu,
            };

            Api()
                .get(`buku-tamu`, {
                    params,
                })
                .then((response) => {
                    let data = response.data.data;

                    this.tableConfig.feeder.data = data;
                    this.tableConfig.config.total_data = response.data.total;

                    this.tableConfig.config.loading = false;
                })
                .catch((error) => {
                    this.tableConfig.config.loading = false;

                    this.tableConfig.feeder.data = [];
                    this.tableConfig.config.total_data = 0;

                    this.$axiosHandleError(error);
                });
        },

        reset() {
            this.v$.$reset();
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
</style>
