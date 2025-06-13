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
                                                    >Database Peserta</span
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
                                                            resetSubkategori();
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
                                                                .subkategori
                                                        "
                                                        :show_button_clear="
                                                            false
                                                        "
                                                        :options="
                                                            filter_list_subkategori_computed
                                                        "
                                                        :serverside="true"
                                                        :loading="
                                                            pageStatus ==
                                                            'subkategori-load'
                                                        "
                                                        @change-search="
                                                            getSubkategori(
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
                                                        <td class="text-left">
                                                            {{
                                                                context.user
                                                                    .name
                                                            }}
                                                        </td>
                                                        <td class="text-left">
                                                            {{
                                                                context.user
                                                                    .role
                                                                    .name
                                                            }}
                                                        </td>
                                                        <td class="text-left">
                                                            {{
                                                                context
                                                                    .subkategori
                                                                    .kategori
                                                                    .name
                                                            }}
                                                        </td>
                                                        <td
                                                            class="text-left"
                                                            style="width: 200px"
                                                        >
                                                            {{
                                                                context
                                                                    .subkategori
                                                                    .name
                                                            }}
                                                        </td>
                                                        <td class="text-left">
                                                            {{
                                                                formatDate(
                                                                    context.updated_at
                                                                )
                                                            }}
                                                        </td>
                                                        <td class="text-center">
                                                            <button
                                                                type="button"
                                                                class="bg-primary-custom"
                                                                @click="
                                                                    unduhSertif(
                                                                        context.id
                                                                    )
                                                                "
                                                            >
                                                                <span
                                                                    class="text-white"
                                                                    ><i
                                                                        class="bi bi-file-arrow-down"
                                                                        style="
                                                                            color: white;
                                                                        "
                                                                    ></i>
                                                                    Unduh
                                                                    Piagam</span
                                                                >
                                                            </button>
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
import html2canvas from "html2canvas";
import jsPDF from "jspdf";

export default {
    data() {
        return {
            v$: useVuelidate(),
            pageStatus: "standby",
            flag: "insert",
            list_kategori: [],
            list_subkategori: [],
            single: {
                id: "",
                name: "",
                kategori: {},
                subkategori: {},
                updated_at: {},

                filter: {
                    kategori: {
                        id: "0",
                        text: "Semua Kategori",
                    },

                    subkategori: {
                        id: "0",
                        text: "Semua Sub Kategori",
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
                            text: "ROLE",
                            sort_by: "id",
                            sort_column: false,
                            style: "text-align: left",
                        },
                        {
                            text: "KATEGORI",
                            sort_by: "id_sub_kategori",
                            sort_column: false,
                            style: "text-align: left",
                        },
                        {
                            text: "SUB KATEGORI",
                            sort_by: "id_sub_kategori",
                            sort_column: false,
                            style: "text-align: left; width: 200px",
                        },
                        {
                            text: "TANGGAL SELESAI",
                            sort_by: "updated_at",
                            sort_column: true,
                            style: "text-align: left;",
                        },
                        {
                            text: "AKSI",
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

        filter_list_subkategori_computed() {
            let response = [
                {
                    id: "0",
                    text: "Semua Sub Kategori",
                },
            ];

            this.list_subkategori.forEach((item) => {
                response.push({
                    id: item.id,
                    text: item.text || item.name,
                });
            });

            return response;
        },

        formattedTanggalSertifikat() {
            const options = { year: "numeric", month: "long", day: "numeric" };
            return new Date(this.tanggalSertifikat).toLocaleDateString(
                "id-ID",
                options
            );
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
                subkategori: {
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
        resetSubkategori() {
            this.single.filter.subkategori = {
                id: "0",
                text: "Semua Sub Kategori",
            };
            this.list_subkategori = [];
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
        async fetchSertifikatData(idProgresSubkategori) {
            try {
                const response = await Api().get(
                    `/databasepeserta/sertifikat/${idProgresSubkategori}`
                );
                return response.data;
            } catch (error) {
                console.error("Gagal mengambil data sertifikat:", error);
                throw error;
            }
        },
        async unduhSertif(context) {
            try {
                const data = await this.fetchSertifikatData(context);

                const pdf = new jsPDF({
                    orientation: "landscape",
                    unit: "px",
                    format: [2000, 1414],
                });

                const page1 = document.createElement("div");
                page1.style.position = "absolute"; // Pastikan elemen berada di luar area tampilan
                page1.style.top = "0"; // Tetap di atas
                page1.style.left = "99999px"; // Jauh di luar area layar
                page1.style.width = "2000px";
                page1.style.height = "1414px";
                page1.innerHTML = `
    <img src="/assets/siapppak/filesertif/bg-sertiff.png" style="width:100%; height:100%;" />
    <div style="position:absolute; top:470px; left:50%; transform: translateX(-50%); font-size:20px; font-weight: bold; text-align: center; white-space: nowrap; color: black"; font-family: Arial, Helvetica, sans-serif;">
        ${data.nosurat || "No Surat"}
    </div>
    <div style="position:absolute; top:645px; left:50%; transform: translateX(-50%); font-size:58px; font-weight: bolder; text-align: center; white-space: nowrap; color: #022448"; font-family: Arial, Helvetica, sans-serif;">
        ${data.user_name || "Nama Default"}
    </div>
    <div style="position:absolute; top:776px; left:50%; transform: translateX(-50%); font-size:30px; font-weight:bold; text-align: center; color: #022448; width:100%;">
        Sebagai Peserta E-Learning ${
            data.sub_category_name || "Kategori Default"
        }
    </div>
    <div style="position:absolute; top:971px; left:948px; font-size:24px; font-weight: 800; text-align: left; white-space: nowrap; color: black;">
        ${data.formatted_date || "11 November 2024"}
    </div>
`;

                document.body.appendChild(page1);
                const canvas1 = await html2canvas(page1, {
                    useCORS: true,
                    scale: 2,
                });
                pdf.addImage(canvas1, "JPEG", 0, 0, 2000, 1414);
                document.body.removeChild(page1);

                // Ulangi proses serupa untuk page2
                const page2 = document.createElement("div");
                page2.style.position = "absolute";
                page2.style.top = "0";
                page2.style.left = "99999px";
                page2.style.width = "2000px";
                page2.style.height = "1414px";

                // Tambahkan konten untuk page2
                let materiListHTML = `
    <div style="
        display: table;
        width: 90%;
        position: absolute;
        top: 320px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 27px;
        text-align: center;
        border-collapse: collapse;
        font-weight: 500;
    ">
        <div style="display: table-header-group; background-color: #f5f5f5; font-weight: bold;">
            <div style="display: table-row;">
                <div style="display: table-cell; padding: 10px; border: 2px solid black; width: 10%;">No</div>
                <div style="display: table-cell; padding: 10px; border: 2px solid black; width: 90%;">Materi</div>
            </div>
        </div>
        <div style="display: table-row-group;">
`;

                data.materi_list.forEach((materi, index) => {
                    materiListHTML += `
        <div style="display: table-row;">
            <div style="display: table-cell; padding: 10px; border: 2px solid black;">${
                index + 1
            }</div>
            <div style="display: table-cell; padding: 10px; border: 2px solid black; text-align: left; padding-left: 10px;">
                ${materi.name || "Judul Materi"}
            </div>
        </div>
    `;
                });

                materiListHTML += `</div></div>`;

                page2.innerHTML = `
    <img src="/assets/siapppak/filesertif/bg-sertif2.png" style="width:100%; height:100%;" />
    ${materiListHTML}
`;

                document.body.appendChild(page2);
                const canvas2 = await html2canvas(page2, {
                    useCORS: true,
                    scale: 2,
                });
                pdf.addPage();
                pdf.addImage(canvas2, "JPEG", 0, 0, 2000, 1414);
                document.body.removeChild(page2);

                pdf.save(`${data.user_name || "Sertifikat"}.pdf`);
            } catch (error) {
                console.error("Gagal mengunduh sertifikat:", error);
            }
        },
        showModalAdd() {
            this.reset();

            $("#modal-form").modal("show");
        },
        edit(id) {
            this.reset();

            this.flag = "update";

            const index = this.tableConfig.feeder.data.findIndex(
                (e) => e.id == id
            );
            if (index >= 0) {
                this.single.id = this.tableConfig.feeder.data[index].id;
                this.single.name = this.tableConfig.feeder.data[index].name;

                if (
                    this.tableConfig.feeder.data[index].subkategori &&
                    this.tableConfig.feeder.data[index].subkategori.kategori &&
                    this.tableConfig.feeder.data[index].subkategori.kategori
                        .id &&
                    this.tableConfig.feeder.data[index].subkategori.kategori
                        .name
                ) {
                    this.single.kategori = {
                        id: this.tableConfig.feeder.data[index].subkategori
                            .kategori.id,
                        text: this.tableConfig.feeder.data[index].subkategori
                            .kategori.name,
                    };
                }

                if (
                    this.tableConfig.feeder.data[index].subkategori.id &&
                    this.tableConfig.feeder.data[index].subkategori.name
                ) {
                    this.single.subkategori = {
                        id: this.tableConfig.feeder.data[index].subkategori.id,
                        text: this.tableConfig.feeder.data[index].subkategori
                            .name,
                    };
                }

                $("#modal-form").modal("show");
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
            };

            if (
                this.single.filter.kategori &&
                this.single.filter.kategori.id &&
                this.single.filter.kategori.id !== "0"
            ) {
                params.id_kategori = this.single.filter.kategori.id;
            }
            if (
                this.single.filter.subkategori &&
                this.single.filter.subkategori.id &&
                this.single.filter.subkategori.id !== "0"
            ) {
                params.id_subkategori = this.single.filter.subkategori.id;
            }

            if (this.single.filter.daterange.length > 0) {
                    Object.assign(params, {
                        start_date: this.single.filter.daterange[0],
                        end_date: this.single.filter.daterange[1],
                    })
                }

            Api()
                .get(`databasepeserta`, { params })
                .then((response) => {
                    const data = response.data.data || [];
                    this.tableConfig.feeder.data = data;
                    this.tableConfig.config.total_data =
                        response.data.total || data.length;
                    this.tableConfig.config.loading = false;
                })
                .catch((error) => {
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
                "id_sub_kategori",
                this.single.subkategori ? this.single.subkategori.id : ""
            );

            // Check and append files if available
            if (this.single.modul) {
                formData.append("modul", this.single.modul);
            }
            if (this.single.materi) {
                formData.append("materi", this.single.materi);
            }
            if (this.single.video) {
                formData.append("video", this.single.video);
            }

            Api()
                .post("databasepeserta", formData, {
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
        update() {
            this.v$.$touch();
            if (this.v$.$error) {
                return false;
            }

            // Creating a new instance of FormData
            let formData = new FormData();
            formData.append("name", this.single.name);
            formData.append("id_sub_kategori", this.single.subkategori.id);

            // Adding files if they exist
            if (this.single.modul) {
                formData.append("modul", this.single.modul);
            }
            if (this.single.materi) {
                formData.append("materi", this.single.materi);
            }
            if (this.single.video) {
                formData.append("video", this.single.video);
            }

            // Using PUT to update data on the server
            Api()
                .post(`databasepeserta/${this.single.id}?_method=PUT`, formData)
                .then((response) => {
                    $("#modal-form").modal("hide");

                    this.$swal({
                        title: "Berhasil!",
                        text: "Memperbarui data subkategori",
                        icon: "success",
                    }).then((result) => {
                        this.getDataTable(); // Reload data after update
                    });
                })
                .catch((error) => {
                    this.$axiosHandleError(error);
                })
                .finally(() => {
                    this.$ewpLoadingHide();
                });
        },
        changeStatus(id) {
            this.$ewpLoadingShow();
            Api()
                .put(`databasepeserta/${id}/switch-status`)
                .then((response) => {
                    this.$toast.success("Status berhasil diubah!");
                })
                .catch((error) => {
                    this.$axiosHandleError(error);
                    this.getDataTable();
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
        getSubkategori(id_kategori) {
            const searchTerm =
                this.single.filter.subkategori &&
                typeof this.single.filter.subkategori === "string"
                    ? this.single.filter.subkategori
                    : "";

            this.pageStatus = "subkategori-load";

            const apiUrl = id_kategori
                ? `subkategori/listsDB?limit=15&search=${searchTerm}&id_kategori=${id_kategori}`
                : `subkategori/listsDB?limit=15&search=${searchTerm}`;

            Api()
                .get(apiUrl)
                .then((response) => {
                    if (response.data && response.data.data) {
                        this.list_subkategori = response.data.data.map((item) => ({
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
                        "Terjadi error saat memuat subkategori:",
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
            this.single.subkategori = {};
        },
        exportData() {
            this.$ewpLoadingShow();

            const params = {
                kategori: this.single.filter.kategori?.id || null,
                subkategori: this.single.filter.subkategori?.id || null,
                search: this.tableConfig.config.search || "",
                startdate: this.single.filter.daterange[0],
                enddate: this.single.filter.daterange[1],
            };

            Api()
                .get(`databasepeserta/export`, {
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
                        `Data Master Database Peserta.xlsx`
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
