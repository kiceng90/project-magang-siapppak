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
                                    >Riwayat Konseling</span
                                >
                            </h3>
                            <button
                                type="button"
                                class="btn btn-sm c-primary-custom me-3"
                                v-if="isAdmin"
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
                            <a
                                href="/konsultasi"
                                target="_blank"
                                class="btn btn-sm bg-primary-custom"
                                v-if="isKlien"
                            >
                                <span class="text-white">Tambah Data</span>
                            </a>
                        </div>
                        <div class="card-body pt-5">
                            <div class="row align-items-center">
                                <div
                                    class="col-lg-2 fw-bolder mb-5"
                                    style="font-size: 14px"
                                >
                                    Keterangan Status
                                </div>
                                <div class="col-lg-10">
                                    <div class="d-flex flex-wrap">
                                        <span
                                            class="badge badge-light-primary mb-5 me-3 c-pointer"
                                            @click="
                                                onClickFilterStatus(undefined)
                                            "
                                            :class="{
                                                'badge-light-success':
                                                    filter.statusKonseling ===
                                                    undefined,
                                            }"
                                        >
                                            Semua
                                        </span>
                                        <span
                                            class="badge badge-light-primary mb-5 me-3 c-pointer"
                                            @click="onClickFilterStatus(status)"
                                            v-for="status in statusKonselingOptions"
                                            :class="{
                                                'badge-light-success':
                                                    filter.statusKonseling ===
                                                    status.value,
                                            }"
                                        >
                                            {{ status.labelStatus }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <app-datatable-serverside
                                :table_config="tableConfigKlien"
                                v-model:show_per_page="
                                    tableConfigKlien.config.show_per_page
                                "
                                v-model:search="tableConfigKlien.config.search"
                                v-model:order="tableConfigKlien.config.order"
                                v-model:sort_by="
                                    tableConfigKlien.config.sort_by
                                "
                                v-model:current_page="
                                    tableConfigKlien.config.current_page
                                "
                                @change-page="getDataTableKlien"
                                v-if="isKlien"
                            >
                                <template v-slot:body>
                                    <TableRow
                                        user-role="klien"
                                        v-for="(item, index) in tableConfigKlien
                                            .feeder.data"
                                        :item="item"
                                        :index="index"
                                        :key="index"
                                    >
                                        <template #menu>
                                            <li>
                                                <a
                                                    class="dropdown-item py-3"
                                                    href="javascript:void(0);"
                                                    @click="
                                                        showModalSeeProblem(
                                                            item
                                                        )
                                                    "
                                                    >Lihat Permasalahan</a
                                                >
                                            </li>
                                            <li
                                                v-if="
                                                    item.rating === null &&
                                                    item.status_string.includes(
                                                        'Selesai'
                                                    )
                                                "
                                            >
                                                <a
                                                    class="dropdown-item py-3"
                                                    href="javascript:void(0);"
                                                    @click="
                                                        showModalGiveRating(
                                                            item
                                                        )
                                                    "
                                                    >Rating</a
                                                >
                                            </li>
                                            <li
                                                v-if="
                                                    item.status_string.includes(
                                                        'Selesai'
                                                    )
                                                "
                                            >
                                                <a
                                                    class="dropdown-item py-3"
                                                    href="javascript:void(0);"
                                                    @click="
                                                        showModalSeeRating(item)
                                                    "
                                                    >Lihat Rating</a
                                                >
                                            </li>
                                            <li
                                                v-if="
                                                    item.status_string.includes(
                                                        'Selesai'
                                                    )
                                                "
                                            >
                                                <a
                                                    class="dropdown-item py-3"
                                                    href="javascript:void(0);"
                                                    @click="
                                                        showModalSeeResult(item)
                                                    "
                                                    >Lihat Hasil Konseling</a
                                                >
                                            </li>
                                        </template>
                                    </TableRow>
                                </template>
                            </app-datatable-serverside>
                            <app-datatable-serverside
                                :table_config="tableConfigKonselor"
                                v-model:show_per_page="
                                    tableConfigKonselor.config.show_per_page
                                "
                                v-model:search="
                                    tableConfigKonselor.config.search
                                "
                                v-model:order="tableConfigKonselor.config.order"
                                v-model:sort_by="
                                    tableConfigKonselor.config.sort_by
                                "
                                v-model:current_page="
                                    tableConfigKonselor.config.current_page
                                "
                                @change-page="getDataTableKonselor"
                                v-if="isKonselor || isPsikolog"
                            >
                                <template v-slot:body>
                                    <TableRow
                                        user-role="konselor"
                                        v-for="(
                                            item, index
                                        ) in tableConfigKonselor.feeder.data"
                                        :item="item"
                                        :index="index"
                                        :key="index"
                                    >
                                        <template #menu>
                                            <li>
                                                <a
                                                    class="dropdown-item py-3"
                                                    href="javascript:void(0);"
                                                    @click="
                                                        showModalSeeProblem(
                                                            item
                                                        )
                                                    "
                                                    >Lihat Permasalahan</a
                                                >
                                            </li>
                                            <li
                                                v-if="
                                                    item.status_string ===
                                                    'Belum Disetujui'
                                                "
                                            >
                                                <a
                                                    class="dropdown-item py-3"
                                                    href="javascript:void(0);"
                                                    @click="
                                                        onClickMenuApprove(
                                                            item.id
                                                        )
                                                    "
                                                    >Setujui</a
                                                >
                                            </li>
                                            <li
                                                v-if="
                                                    item.status_string !==
                                                        'Belum Disetujui' &&
                                                    !item.status_string.includes(
                                                        'Selesai'
                                                    )
                                                "
                                            >
                                                <a
                                                    class="dropdown-item py-3"
                                                    href="javascript:void(0);"
                                                    @click="
                                                        onClickMenuEnd(item.id)
                                                    "
                                                    >Akhiri</a
                                                >
                                            </li>
                                            <li
                                                v-if="
                                                    item.status_string ===
                                                    'Belum Disetujui'
                                                "
                                            >
                                                <a
                                                    class="dropdown-item py-3"
                                                    href="javascript:void(0);"
                                                    @click="
                                                        onClickMenuReject(
                                                            item.id
                                                        )
                                                    "
                                                    >Tolak</a
                                                >
                                            </li>
                                            <li
                                                v-if="
                                                    item.status_string !==
                                                    'Belum Disetujui'
                                                "
                                            >
                                                <a
                                                    class="dropdown-item py-3"
                                                    href="javascript:void(0);"
                                                    @click="
                                                        showModalSeeRating(item)
                                                    "
                                                    >Lihat Rating</a
                                                >
                                            </li>
                                            <li
                                                v-if="
                                                    item.status_string !==
                                                        'Belum Disetujui' &&
                                                    item.result
                                                "
                                            >
                                                <a
                                                    class="dropdown-item py-3"
                                                    href="javascript:void(0);"
                                                    @click="
                                                        showModalSeeResult(item)
                                                    "
                                                    >Lihat Hasil Konseling</a
                                                >
                                            </li>
                                            <li
                                                v-if="
                                                    item.status_string.includes(
                                                        'Selesai Dengan Rujukan'
                                                    ) &&
                                                    item.id_psikolog_volunteer &&
                                                    !item.is_psikolog_booked
                                                "
                                            >
                                                <router-link
                                                    class="dropdown-item py-3"
                                                    :to="{
                                                        name: 'booking-jadwal-konseling-psikolog',
                                                        params: {
                                                            idKonsultan:
                                                                item.id_psikolog_volunteer,
                                                            idKlien:
                                                                item.id_klien_konseling,
                                                        },
                                                    }"
                                                    target="_blank"
                                                    >Booking
                                                    Psikolog</router-link
                                                >
                                            </li>
                                            <li
                                                v-if="
                                                    item.status_string.includes(
                                                        'Selesai'
                                                    ) &&
                                                    item.id_pengaduan == null
                                                "
                                            >
                                                <a
                                                    class="dropdown-item py-3"
                                                    href="javascript:void(0);"
                                                    @click="
                                                        showModalIntegrateComplaint(
                                                            item
                                                        )
                                                    "
                                                    >Masukkan ke Pengaduan</a
                                                >
                                            </li>
                                            <li v-if="item.klien.ktp_url">
                                                <a
                                                    class="dropdown-item py-3"
                                                    href="javascript:void(0);"
                                                    @click="
                                                        showModalSeeKTP(item)
                                                    "
                                                    >Lihat KTP Klien</a
                                                >
                                            </li>
                                            <li v-if="item.klien.kk_url">
                                                <a
                                                    class="dropdown-item py-3"
                                                    href="javascript:void(0);"
                                                    @click="
                                                        showModalSeeKK(item)
                                                    "
                                                    >Lihat KK Klien</a
                                                >
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item py-3"
                                                    href="javascript:void(0);"
                                                    @click="
                                                        pdfGenerate(
                                                            item.id_klien_konseling
                                                        )
                                                    "
                                                    >Unduh Surat Pernyataan</a
                                                >
                                            </li>
                                        </template>
                                    </TableRow>
                                </template>
                            </app-datatable-serverside>
                            <app-datatable-serverside
                                :table_config="tableConfigAdmin"
                                v-model:show_per_page="
                                    tableConfigAdmin.config.show_per_page
                                "
                                v-model:search="tableConfigAdmin.config.search"
                                v-model:order="tableConfigAdmin.config.order"
                                v-model:sort_by="
                                    tableConfigAdmin.config.sort_by
                                "
                                v-model:current_page="
                                    tableConfigAdmin.config.current_page
                                "
                                @change-page="getDataTableAdmin"
                                v-if="isAdmin"
                            >
                                <template v-slot:body>
                                    <TableRow
                                        user-role="admin"
                                        v-for="(item, index) in tableConfigAdmin
                                            .feeder.data"
                                        :item="item"
                                        :index="index"
                                        :key="index"
                                    >
                                        <template #menu>
                                            <li>
                                                <a
                                                    class="dropdown-item py-3"
                                                    href="javascript:void(0);"
                                                    @click="
                                                        showModalSeeProblem(
                                                            item
                                                        )
                                                    "
                                                    >Lihat Permasalahan</a
                                                >
                                            </li>
                                            <li
                                                v-if="
                                                    item.status_string.includes(
                                                        'Selesai'
                                                    )
                                                "
                                            >
                                                <a
                                                    class="dropdown-item py-3"
                                                    href="javascript:void(0);"
                                                    @click="
                                                        showModalSeeRating(item)
                                                    "
                                                    >Lihat Rating</a
                                                >
                                            </li>
                                            <li
                                                v-if="
                                                    item.status_string.includes(
                                                        'Selesai'
                                                    )
                                                "
                                            >
                                                <a
                                                    class="dropdown-item py-3"
                                                    href="javascript:void(0);"
                                                    @click="
                                                        showModalSeeResult(item)
                                                    "
                                                    >Lihat Hasil Konseling</a
                                                >
                                            </li>
                                            <li
                                                v-if="
                                                    item.status_string.includes(
                                                        'Selesai'
                                                    ) &&
                                                    item.id_pengaduan == null
                                                "
                                            >
                                                <a
                                                    class="dropdown-item py-3"
                                                    href="javascript:void(0);"
                                                    @click="
                                                        showModalIntegrateComplaint(
                                                            item
                                                        )
                                                    "
                                                    >Masukkan ke Pengaduan</a
                                                >
                                            </li>
                                            <li v-if="item.klien.ktp_url">
                                                <a
                                                    class="dropdown-item py-3"
                                                    href="javascript:void(0);"
                                                    @click="
                                                        showModalSeeKTP(item)
                                                    "
                                                    >Lihat KTP Klien</a
                                                >
                                            </li>
                                            <li v-if="item.klien.kk_url">
                                                <a
                                                    class="dropdown-item py-3"
                                                    href="javascript:void(0);"
                                                    @click="
                                                        showModalSeeKK(item)
                                                    "
                                                    >Lihat KK Klien</a
                                                >
                                            </li>
                                        </template>
                                    </TableRow>
                                </template>
                            </app-datatable-serverside>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Container-->
        </div>
        <ModalBeriRating
            :data="dataModalBeriRating"
            @onSuccess="onSuccessBeriRating"
        />
        <ModalLihatRating
            :data="dataModalLihatRating"
            @onClose="closeModalSeeRating"
        />
        <ModalTolak :data="dataModalTolak" @onSuccess="getDataTable" />
        <ModalAkhiri :data="dataModalAkhiri" @onSuccess="getDataTable" />
        <dashboard-modal title="Lihat Hasil Konseling" id="modal-lihat-hasil">
            <div v-html="dataModalLihatHasil.result"></div>
            <template #footer>
                <button
                    class="btn btn-sm bg-second-primary-custom text-white"
                    type="button"
                    @click="closeModalSeeResult"
                >
                    OK
                </button>
            </template>
        </dashboard-modal>
        <dashboard-modal
            title="Lihat Deskripsi Permasalahan"
            id="modal-lihat-permasalahan"
        >
            <div v-html="dataModalLihatPermasalahan.description"></div>
            <template #footer>
                <button
                    class="btn btn-sm bg-second-primary-custom text-white"
                    type="button"
                    @click="closeModalSeeProblem"
                >
                    OK
                </button>
            </template>
        </dashboard-modal>
        <ModalIntegrateComplaint
            :data="dataModalIntegrateComplaint"
            @onSuccess="getDataTable"
        />
        <dashboard-modal title="Lihat KTP Klien" id="modal-lihat-ktp">
            <img
                style="width: 100%; height: auto"
                :src="dataModalLihatKTP.ktp_url"
                alt="KTP"
            />
            <template #footer>
                <button
                    class="btn btn-sm bg-second-primary-custom text-white"
                    type="button"
                    @click="closeModalSeeKTP"
                >
                    OK
                </button>
            </template>
        </dashboard-modal>
        <dashboard-modal title="Lihat KK Klien" id="modal-lihat-kk">
            <img
                style="width: 100%; height: auto"
                :src="dataModalLihatKK.kk_url"
                alt="KK"
            />
            <template #footer>
                <button
                    class="btn btn-sm bg-second-primary-custom text-white"
                    type="button"
                    @click="closeModalSeeKK"
                >
                    OK
                </button>
            </template>
        </dashboard-modal>
        <!--end::Post-->
    </dashboard-base-layout>
</template>

<script>
import StarRating from "vue-star-rating";

import TableRow from "./TableRow.vue";
import ModalAkhiri from "./ModalAkhiri.vue";
import ModalLihatRating from "./ModalLihatRating.vue";
import ModalBeriRating from "./ModalBeriRating.vue";
import ModalTolak from "./ModalTolak.vue";
import ModalIntegrateComplaint from "./ModalIntegrateComplaint.vue";

import Api from "@/services/api";

const commonColumns = [
    {
        text: "JADWAL KONSULTASI",
        sort_column: false,
        style: "text-align: left",
    },
    {
        text: "KETERANGAN",
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
];

export default {
    components: {
        StarRating,
        TableRow,
        ModalAkhiri,
        ModalBeriRating,
        ModalLihatRating,
        ModalIntegrateComplaint,
        ModalTolak,
    },
    data() {
        return {
            ROLE_KLIEN_ID: process.env.MIX_ROLE_KLIEN_ID,
            ROLE_ADMIN_ID: process.env.MIX_ROLE_ADMIN_ID,
            ROLE_KONSELOR_ID: process.env.MIX_ROLE_KONSELOR_ID,
            ROLE_PSIKOLOG_ID: process.env.MIX_ROLE_PSIKOLOG_ID,
            tableConfigKlien: {
                feeder: {
                    column: [
                        {
                            text: "NO",
                            sort_column: false,
                            style: "text-align: center",
                        },
                        {
                            text: "KONSULTAN",
                            sort_by: "jadwal_detail.jadwal.konselor.name",
                            sort_column: false,
                            style: "text-align: left",
                        },
                        ...commonColumns,
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
            tableConfigKonselor: {
                feeder: {
                    column: [
                        {
                            text: "NO",
                            sort_column: false,
                            style: "text-align: center",
                        },
                        {
                            text: "KLIEN",
                            sort_by: "klien.name",
                            sort_column: false,
                            style: "text-align: left",
                        },
                        {
                            text: "ALAMAT KLIEN",
                            sort_column: false,
                            style: "text-align: left",
                        },
                        ...commonColumns,
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
            tableConfigAdmin: {
                feeder: {
                    column: [
                        {
                            text: "NO",
                            sort_column: false,
                            style: "text-align: center",
                        },
                        {
                            text: "KLIEN",
                            sort_by: "klien.name",
                            sort_column: false,
                            style: "text-align: left",
                        },
                        {
                            text: "ALAMAT KLIEN",
                            sort_column: false,
                            style: "text-align: left",
                        },
                        {
                            text: "KONSULTAN",
                            sort_by: "jadwal_detail.jadwal.konselor.name",
                            sort_column: false,
                            style: "text-align: left",
                        },
                        ...commonColumns,
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
            inputRating: 0,
            filter: {
                statusKonseling: undefined,
            },
            dataModalLihatRating: {
                rating: null,
                review: "",
            },
            dataModalBeriRating: {
                id: null,
                rating: null,
                review: "",
            },
            dataModalTolak: {
                id: null,
            },
            dataModalAkhiri: {
                id: null,
            },
            dataModalLihatHasil: {
                result: null,
            },
            dataModalLihatPermasalahan: {
                description: null,
            },
            dataModalIntegrateComplaint: {},
            dataModalLihatKTP: {
                ktp_url: null,
            },
            dataModalLihatKK: {
                kk_url: null,
            },
        };
    },
    computed: {
        isAdmin() {
            return this.$store.state.profile.role_id == this.ROLE_ADMIN_ID;
        },
        isKlien() {
            return this.$store.state.profile.role_id == this.ROLE_KLIEN_ID;
        },
        isKonselor() {
            return this.$store.state.profile.role_id == this.ROLE_KONSELOR_ID;
        },
        isPsikolog() {
            return this.$store.state.profile.role_id == this.ROLE_PSIKOLOG_ID;
        },
        statusKonselingOptions() {
            const status = this.$store.state.enums.statusKonseling;
            return status;
        },
    },
    mounted() {
        reinitializeAllPlugin();

        this.getDataTable();
    },
    methods: {
        showModalGiveRating(item) {
            this.dataModalBeriRating = {
                id: item.id,
                rating: item.rating,
                review: item.review,
            };
            $("#modal-beri-rating").modal("show");
        },
        showModalSeeRating(item) {
            (this.dataModalLihatRating = {
                rating: item.rating,
                review: item.review,
            }),
                $("#modal-lihat-rating").modal("show");
        },
        closeModalSeeRating: () => $("#modal-lihat-rating").modal("hide"),
        showModalSeeResult(item) {
            this.$ewpLoadingShow();
            Api()
                .get(`konseling-hasil/${item.id}`)
                .then((response) => {
                    const result = response.data.data.result;
                    this.dataModalLihatHasil = {
                        result,
                    };
                    $("#modal-lihat-hasil").modal("show");
                    return;
                })
                .catch((error) => {
                    this.$axiosHandleError(error);
                })
                .finally(() => {
                    this.$ewpLoadingHide();
                });
        },
        closeModalSeeResult: () => $("#modal-lihat-hasil").modal("hide"),
        showModalReject: () => $("#modal-tolak-konsultasi").modal("show"),
        showModalEnd: () => $("#modal-akhiri-konsultasi").modal("show"),
        showModalSeeProblem(item) {
            this.dataModalLihatPermasalahan = {
                description: item.description,
            };
            $("#modal-lihat-permasalahan").modal("show");
        },
        closeModalSeeProblem: () =>
            $("#modal-lihat-permasalahan").modal("hide"),
        showModalIntegrateComplaint(item) {
            this.dataModalIntegrateComplaint = { ...item };
            $("#modal-masukkan-pengaduan").modal("show");
        },
        showModalSeeKTP(item) {
            this.dataModalLihatKTP = {
                ktp_url: item.klien.ktp_url,
            };
            $("#modal-lihat-ktp").modal("show");
        },
        closeModalSeeKTP: () => $("#modal-lihat-ktp").modal("hide"),
        showModalSeeKK(item) {
            this.dataModalLihatKK = {
                kk_url: item.klien.kk_url,
            };
            $("#modal-lihat-kk").modal("show");
        },
        closeModalSeeKK: () => $("#modal-lihat-kk").modal("hide"),
        onClickMenuApprove(id) {
            this.$ewpLoadingShow();

            Api()
                .post(`konselor-konseling-accept/${id}`, { _method: "PUT" })
                .then(() => {
                    this.$swal({
                        title: "Berhasil menyetujui!",
                        text: "Data konsultasi sudah disetujui!",
                        icon: "success",
                    }).then(() => this.getDataTable());
                })
                .catch((error) => {
                    this.$axiosHandleError(error);
                })
                .finally(() => {
                    this.$ewpLoadingHide();
                });
        },
        onClickMenuEnd(id) {
            this.dataModalAkhiri = {
                id,
            };
            this.showModalEnd();
        },
        onClickMenuReject(id) {
            this.dataModalTolak = {
                id,
            };
            this.showModalReject(id);
        },
        getDataTableAdmin() {
            this.tableConfigAdmin.config.loading = true;
            this.tableConfigAdmin.feeder.data = [];

            let params = {
                page: this.tableConfigAdmin.config.current_page,
                limit: this.tableConfigAdmin.config.show_per_page,
                sortby: this.tableConfigAdmin.config.sort_by,
                order: this.tableConfigAdmin.config.order,
                search: this.tableConfigAdmin.config.search,
                status: this.filter.statusKonseling,
            };

            Api()
                .get(`admin-konseling-history`, {
                    params,
                })
                .then((response) => {
                    let data = response.data.data.data;

                    this.tableConfigAdmin.feeder.data = data;
                    this.tableConfigAdmin.config.total_data =
                        response.data.data.total;

                    this.tableConfigAdmin.config.loading = false;
                })
                .catch((error) => {
                    this.tableConfigAdmin.config.loading = false;

                    this.tableConfigAdmin.feeder.data = [];
                    this.tableConfigAdmin.config.total_data = 0;

                    this.$axiosHandleError(error);
                });
        },
        getDataTableKlien() {
            this.tableConfigKlien.config.loading = true;
            this.tableConfigKlien.feeder.data = [];

            let params = {
                page: this.tableConfigKlien.config.current_page,
                limit: this.tableConfigKlien.config.show_per_page,
                sortby: this.tableConfigKlien.config.sort_by,
                order: this.tableConfigKlien.config.order,
                search: this.tableConfigKlien.config.search,
                status: this.filter.statusKonseling,
            };

            Api()
                .get(`klien-konseling-history`, {
                    params,
                })
                .then((response) => {
                    let data = response.data.data.data;

                    this.tableConfigKlien.feeder.data = data;
                    this.tableConfigKlien.config.total_data =
                        response.data.data.total;

                    this.tableConfigKlien.config.loading = false;
                })
                .catch((error) => {
                    this.tableConfigKlien.config.loading = false;

                    this.tableConfigKlien.feeder.data = [];
                    this.tableConfigKlien.config.total_data = 0;

                    this.$axiosHandleError(error);
                });
        },
        getDataTableKonselor() {
            this.tableConfigKonselor.config.loading = true;
            this.tableConfigKonselor.feeder.data = [];

            let params = {
                page: this.tableConfigKonselor.config.current_page,
                limit: this.tableConfigKonselor.config.show_per_page,
                sortby: this.tableConfigKonselor.config.sort_by,
                order: this.tableConfigKonselor.config.order,
                search: this.tableConfigKonselor.config.search,
                consultant_type: this.isPsikolog ? 2 : undefined,
                status: this.filter.statusKonseling,
            };

            Api()
                .get(`konselor-konseling-history`, {
                    params,
                })
                .then((response) => {
                    let data = response.data.data.data;

                    this.tableConfigKonselor.feeder.data = data;
                    this.tableConfigKonselor.config.total_data =
                        response.data.data.total;

                    this.tableConfigKonselor.config.loading = false;
                })
                .catch((error) => {
                    this.tableConfigKonselor.config.loading = false;

                    this.tableConfigKonselor.feeder.data = [];
                    this.tableConfigKonselor.config.total_data = 0;

                    this.$axiosHandleError(error);
                });
        },
        getDataTable() {
            const role_id = this.$store.state.profile.role_id;
            if (role_id == this.ROLE_ADMIN_ID) {
                this.getDataTableAdmin();
            }
            if (role_id == this.ROLE_KLIEN_ID) {
                this.getDataTableKlien();
            }
            if (
                role_id == this.ROLE_KONSELOR_ID ||
                role_id == this.ROLE_PSIKOLOG_ID
            ) {
                this.getDataTableKonselor();
            }
        },
        onSuccessBeriRating() {
            this.getDataTable();
        },
        onClickFilterStatus(status) {
            this.filter.statusKonseling = status?.value;
            this.tableConfigAdmin.config.current_page = 1;
            this.tableConfigKlien.config.current_page = 1;
            this.tableConfigKonselor.config.current_page = 1;
            this.getDataTable();
        },
        pdfGenerate(id) {
            this.$ewpLoadingShow();
            Api()
                .get(`informed-consent/${id}/cetak-pdf`, {
                    responseType: "blob",
                })
                .then((response) => {
                    const url = window.URL.createObjectURL(
                        new Blob([response.data])
                    );
                    const link = document.createElement("a");
                    link.href = url;
                    link.setAttribute("download", `Surat Pernyataan.pdf`);
                    document.body.appendChild(link);
                    link.click();
                })
                .catch((error) => {
                    this.$axiosHandleError(error);
                })
                .then(() => {
                    this.$ewpLoadingHide();
                });
        },
        exportData(){
            this.$ewpLoadingShow();
            Api().get(`/konseling-export`, {
                responseType: 'blob',
            }).then(response => {
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', `Laporan Telekonsultasi.xlsx`);
                document.body.appendChild(link);
                link.click();
            }).catch(error => {
                this.$axiosHandleError(error);
            }).then(() => {
                this.$ewpLoadingHide();
            });
        },
    },
};
</script>
