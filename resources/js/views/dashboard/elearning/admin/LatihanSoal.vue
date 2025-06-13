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
                                                    >Latihan Soal</span
                                                >
                                            </h3>
                                            <button
                                                type="button"
                                                class="btn btn-sm bg-primary-custom"
                                                @click="showModalAdd"
                                            >
                                                <span class="text-white"
                                                    >Tambah Data</span
                                                >
                                            </button>
                                        </div>
                                        <div class="card-body pt-5">
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
                                                        ) in filteredData"
                                                        :key="context.id"
                                                    >
                                                        <td class="text-center">
                                                            {{ index + 1 }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ context.name }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ context.skor }}
                                                        </td>
                                                        <td class="text-center">
                                                            <div
                                                                class="text-center w-100"
                                                            >
                                                                <div
                                                                    class="form-check form-switch form-check-custom form-check-solid justify-content-center"
                                                                >
                                                                    <input
                                                                        class="form-check-input h-20px w-40px"
                                                                        type="checkbox"
                                                                        value="1"
                                                                        :checked="
                                                                            context.is_active
                                                                        "
                                                                        @click="
                                                                            changeStatus(
                                                                                context.id
                                                                            )
                                                                        "
                                                                    />
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <div
                                                                class="dropdown"
                                                                style="
                                                                    position: static !important;
                                                                "
                                                            >
                                                                <button
                                                                    class="btn btn-secondary btn-xs dropdown-toggle"
                                                                    type="button"
                                                                    data-bs-toggle="dropdown"
                                                                    style="
                                                                        padding: 5px
                                                                            10px !important;
                                                                    "
                                                                    aria-expanded="false"
                                                                >
                                                                    Aksi
                                                                </button>
                                                                <ul
                                                                    class="dropdown-menu"
                                                                >
                                                                    <li>
                                                                        <router-link
                                                                            class="dropdown-item py-3"
                                                                            :to="{
                                                                                name: 'detaillatihansoal',
                                                                                params: {
                                                                                    id: context.id,
                                                                                },
                                                                            }"
                                                                        >
                                                                            Detail
                                                                        </router-link>
                                                                    </li>
                                                                    <li>
                                                                        <a
                                                                            class="dropdown-item py-3"
                                                                            href="javascript:void(0);"
                                                                            @click="
                                                                                edit(
                                                                                    context.id
                                                                                )
                                                                            "
                                                                        >
                                                                            Edit
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

        <div class="modal fade" tabindex="-1" id="modal-form">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content" :key="flag">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{
                                flag === "insert"
                                    ? "Tambah Data Latihan Soal"
                                    : "Edit Data Latihan Soal"
                            }}
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>

                    <div class="modal-body">
                        <!-- Soal -->
                        <!-- Soal dengan Text Editor -->
                        <div class="mb-5">
                            <label
                                class="form-label fw-bolder fs-6"
                                :class="v$.single.name.$error ? 'text-danger' : ''"
                            >
                                Soal
                            </label>
                            <app-editor
                                class="form-control"
                                v-model:content="single.name"
                                ref="editor"
                                contentType="html">
                            </app-editor>
                            <div v-if="v$.single.name.$error" class="text-danger">
                                Soal tidak boleh kosong!
                            </div>
                        </div>
                        <div class="mb-5">
                            <label
                                class="form-label fw-bolder fs-6"
                                :class="
                                    v$.single.skor.$error ? 'text-danger' : ''
                                "
                            >
                                Skor
                            </label>
                            <input
                                class="form-control"
                                placeholder="Masukkan soal"
                                v-model="single.skor"
                                autocomplete="off"
                                rows="2"
                            ></input>
                            <div
                                v-if="v$.single.skor.$error"
                                class="text-danger"
                            >
                                Soal tidak boleh kosong!
                            </div>
                        </div>

                        <!-- Pilihan Jawaban -->
                        <div class="mb-5">
                            <label class="form-label fw-bolder fs-6"
                                >Pilihan Jawaban</label
                            >
                            <p class="text-muted">
                                Pilih jawaban yang benar dengan menandai tombol
                                bulat di salah satu opsi.
                            </p>
                        </div>

                        <!-- Pilihan Jawaban Iterasi -->
                        <div
                            v-for="(pilihan, index) in single.pilihan_jawaban"
                            :key="index"
                            class="mb-5"
                        >
                            <div class="d-flex align-items-center mb-1">
                                <div class="row">
                                    <div class="col-1">
                                        <label class="form-label fw-bold me-3">
                                            {{ getAbjad(index) }}
                                        </label>
                                    </div>
                                    <div class="col-11">
                                        <div class="form-check form-switch">
                                            <input
                                                class="form-check-input"
                                                name="pilihanjawaban"
                                                type="checkbox"
                                                v-model="pilihan.is_active"
                                            />
                                            <span class="form-check-label"
                                                >tandai sebagai jawaban
                                                benar</span
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10"><input
                                class="form-control"
                                type="text"
                                v-model="pilihan.pilihan"
                                placeholder="Isi jawaban"
                                autocomplete="off"
                            />
                            <div
                                v-if="v$.single.name.$error"
                                class="text-danger"
                            >
                                Pilihan jawaban {{ getAbjad(index) }} tidak
                                boleh kosong!
                            </div>
                        </div>
                                <div class="col-md-2">
                                    <button
                                class="btn btn-danger"
                                @click="removePilihanJawaban(index)"
                            >
                                Hapus
                            </button>
                        </div>
                            </div>
                        </div>

                        <button
                            type="button"
                            class="btn btn-primary"
                            @click="addPilihanJawaban"
                        >
                            Tambah Jawaban
                        </button>
                    </div>

                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-light"
                            data-bs-dismiss="modal"
                        >
                            Batal
                        </button>
                        <button
                            v-if="flag === 'insert'"
                            type="button"
                            class="btn btn-sm bg-primary-custom"
                            @click="save">
                            <span class="text-white"
                                >Simpan</span
                            >
                        </button>
                        <button
                            v-if="flag === 'update'"
                            @click="update"
                            class="btn btn-primary"
                        >
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Api from "@/services/api";
import useVuelidate from "@vuelidate/core";
import { required, sameAs, requiredIf, minLength } from "@vuelidate/validators";

export default {
    props: ["id"],
    data() {
        return {
            v$: useVuelidate(),
            pageStatus: "standby",
            flag: "insert",
            single: {
                id: "",
                name: "",
                skor: "",
                pilihan_jawaban: [],
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
                            text: "SOAL",
                            sort_by: "name",
                            sort_column: true,
                            style: "text-align: center",
                        },
                        {
                            text: "SKOR",
                            sort_by: "skor",
                            sort_column: true,
                            style: "text-align: center",
                        },
                        {
                            text: "STATUS",
                            sort_by: "is_active",
                            sort_column: true,
                            style: "text-align: center",
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
    validations() {
        return {
            single: {
                name: { required },
                skor: { required },
                pilihan_jawaban: {
                    $each: {
                        pilihan: { required },
                        is_active: { required },
                    },
                },
            },
        };
    },
    computed: {
        filteredData() {
            return this.tableConfig.feeder.data.filter(
                (item) => item.id_materi === parseInt(this.id)
            );
        },
    },
    mounted() {
        reinitializeAllPlugin();
        this.getDataTable();
    },
    methods: {
        showModalAdd() {
            this.reset();
            this.flag = "insert";
            $("#modal-form").modal("show");
        },

        edit(id) {
            this.reset(); // Reset data untuk memastikan modal dalam keadaan bersih
            this.flag = "update"; // Set flag ke mode update
            this.pageStatus = "loading"; // Tambahkan status loading

            // Panggil API untuk mengambil soal berdasarkan ID
            Api()
                .get(`soal/${id}`)
                .then((response) => {
                    const soal = response.data.data;

                    // Isi data ke objek `single`
                    this.single.id = soal.id;
                    this.single.name = soal.name;
                    this.single.skor = soal.skor;
                    this.single.pilihan_jawaban = (soal.pilihan_jawaban || []).sort(
                        (a, b) => a.abjad.localeCompare(b.abjad)
                    );
                    // Tampilkan modal
                    $("#modal-form").modal("show");
                })
                .catch((error) => {
                    // Tampilkan pesan jika soal tidak ditemukan
                    this.$swal({
                        title: "Gagal!",
                        text: "Soal tidak ditemukan.",
                        icon: "error",
                    });
                })
                .finally(() => {
                    this.pageStatus = "standby"; // Kembali ke status standby
                });
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
                id_materi: this.id,
            };
            Api()
                .get("soal", { params })
                .then((response) => {
                    this.tableConfig.feeder.data = response.data.data;
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

        update() {
            this.v$.$touch();
            if (this.v$.$error) return false;

            this.$ewpLoadingShow();

            const formData = {
                id_materi: this.id,
                name: this.single.name,
                skor: this.single.skor,
                pilihan_jawaban: this.single.pilihan_jawaban.map(
                    (jawaban, index) => ({
                        abjad: String.fromCharCode(65 + index),
                        pilihan: jawaban.pilihan,
                        is_active: jawaban.is_active,
                    })
                ),
            };

            Api()
                .put(`soal/${this.single.id}`, formData)
                .then(() => {
                    $("#modal-form").modal("hide");
                    this.$swal({
                        title: "Berhasil!",
                        text: "Data soal berhasil diperbarui.",
                        icon: "success",
                    }).then(() => this.getDataTable(this.id));
                })
                .catch(this.$axiosHandleError)
                .finally(this.$ewpLoadingHide);
        },

        save() {
            this.v$.$touch();
            if (this.v$.$error) return false;

            this.$ewpLoadingShow();

            const formData = {
                id_materi: this.id,
                name: this.single.name,
                skor: this.single.skor,
                pilihan_jawaban: this.single.pilihan_jawaban.map(
                    (jawaban, index) => ({
                        abjad: String.fromCharCode(65 + index),
                        pilihan: jawaban.pilihan,
                        is_active: jawaban.is_active,
                    })
                ),
            };

            Api()
                .post("soal", formData)
                .then(() => {
                    $("#modal-form").modal("hide");
                    this.$swal({
                        title: "Berhasil!",
                        text: "Menambahkan data soal",
                        icon: "success",
                    }).then(() => {
                        this.tableConfig.config.current_page = 1;
                        this.getDataTable(this.id);
                    });
                })
                .catch(this.$axiosHandleError)
                .finally(this.$ewpLoadingHide);
        },

        getAbjad(index) {
            return String.fromCharCode(65 + index);
        },

        addPilihanJawaban() {
            this.single.pilihan_jawaban.push({ pilihan: "", is_active: false });
        },

        removePilihanJawaban(index) {
            this.single.pilihan_jawaban.splice(index, 1);
        },

        reset() {
            this.v$.$reset();
            this.flag = "insert";
            this.single = {
                id: null,
                name: "",
                skor: "",
                pilihan_jawaban: [],
            };

        },

        changeStatus(id) {
            this.$ewpLoadingShow();
            Api()
                .put(`soal/${id}/switch-status`)
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
