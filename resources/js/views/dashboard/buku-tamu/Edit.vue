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
                                <div class="row align-items-center mt-5">
                                    <div class="col-lg-5">
                                        <h1>Edit Buku Tamu</h1>
                                    </div>
                                    <div
                                        class="col-lg-7 d-flex flex-wrap"
                                        style="justify-content: flex-end"
                                    >
                                        <button
                                            class="btn text-white bg-second-primary-custom"
                                            type="button"
                                            @click="update"
                                        >
                                            Simpan
                                        </button>
                                    </div>
                                </div>

                                <div
                                    class="card card-flush mt-5 mb-5 mb-xl-10"
                                    id="kt_profile_details_view"
                                >
                                    <div
                                        class="card card-xl-stretch mb-5 mb-xl-8"
                                    >
                                        <div class="card-body pt-5">
                                            <div
                                                v-if="pageStatus == 'page-load'"
                                                class="w-100 d-flex justify-content-center mt-10 mb-10"
                                            >
                                                <app-loader></app-loader>
                                            </div>
                                            <div
                                                v-show="
                                                    pageStatus != 'page-load'
                                                "
                                                class="row"
                                            >
                                                <div
                                                    class="row align-items-center pb-5 mb-5 border-bottom"
                                                >
                                                    <div
                                                        class="col-lg-3 fw-bolder mb-5"
                                                    >
                                                        Nomor
                                                        Pendaftaran(Otomatis)
                                                    </div>
                                                    <div class="col-lg-9 mb-5">
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            placeholder=""
                                                            v-model="
                                                                bukuTamu.nomor_pendaftaran
                                                            "
                                                            disabled
                                                        />
                                                    </div>
                                                </div>
                                                <div
                                                    class="row mt-5 border-bottom pb-5 align-items-center"
                                                >
                                                    <div class="col-lg-12 mb-5">
                                                        <h4
                                                            class="c-primary-custom fw-bolder pb-2"
                                                        >
                                                            Identitas Pengunjung
                                                        </h4>
                                                    </div>

                                                    <div
                                                        class="col-lg-3 mb-5 fw-bolder"
                                                        :class="
                                                            bukuTamu.nama.$error
                                                                ? 'text-danger'
                                                                : ''
                                                        "
                                                    >
                                                        Nama Lengkap
                                                    </div>
                                                    <div class="col-lg-9 mb-5">
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            placeholder="Cth: Suyonto"
                                                            v-model="
                                                                bukuTamu.nama
                                                            "
                                                        />
                                                    </div>
                                                    <div
                                                        class="col-lg-3 mb-5 fw-bolder"
                                                        :class="
                                                            bukuTamu.nik.$error
                                                                ? 'text-danger'
                                                                : ''
                                                        "
                                                    >
                                                        NIK
                                                    </div>
                                                    <div class="col-lg-9 mb-5">
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            placeholder="Cth: 35141318070200122"
                                                            v-model="
                                                                bukuTamu.nik
                                                            "
                                                        />
                                                    </div>
                                                    <div
                                                        class="col-lg-3 mb-5 fw-bolder"
                                                        :class="
                                                            bukuTamu
                                                                .tempat_lahir
                                                                .$error
                                                                ? 'text-danger'
                                                                : ''
                                                        "
                                                    >
                                                        Tempat & Tanggal Lahir
                                                    </div>
                                                    <div class="col-lg-9">
                                                        <div class="row">
                                                            <div
                                                                class="col-lg-6 mb-5"
                                                            >
                                                                <input
                                                                    type="text"
                                                                    class="form-control"
                                                                    placeholder="Cth: Surabaya"
                                                                    v-model="
                                                                        bukuTamu.tempat_lahir
                                                                    "
                                                                />
                                                            </div>
                                                            <div
                                                                class="col-lg-6 mb-5"
                                                            >
                                                                <input
                                                                    type="date"
                                                                    class="form-control"
                                                                    placeholder="Cth: Surabaya"
                                                                    v-model="
                                                                        bukuTamu.tanggal_lahir
                                                                    "
                                                                />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="col-lg-3 mb-5 fw-bolder"
                                                        :class="
                                                            bukuTamu.nik.$error
                                                                ? 'text-danger'
                                                                : ''
                                                        "
                                                    >
                                                        Jenis Kelamin
                                                    </div>
                                                    <div class="col-lg-9 mb-5">
                                                        <app-select-single
                                                            v-model="
                                                                bukuTamu.jenis_kelamin
                                                            "
                                                            :placeholder="'Pilih jenis kelamin'"
                                                            :options="[
                                                                {
                                                                    text: 'Laki-laki',
                                                                    id: 'Laki-laki',
                                                                },
                                                                {
                                                                    text: 'Perempuan',
                                                                    id: 'Perempuan',
                                                                },
                                                            ]"
                                                        >
                                                        </app-select-single>
                                                    </div>
                                                    <div
                                                        class="col-lg-3 mb-5 fw-bolder"
                                                        :class="
                                                            bukuTamu.usia
                                                                .$error
                                                                ? 'text-danger'
                                                                : ''
                                                        "
                                                    >
                                                        Usia
                                                    </div>
                                                    <div class="col-lg-9 mb-5">
                                                        <input
                                                            type="number"
                                                            class="form-control"
                                                            v-model="
                                                                bukuTamu.usia
                                                            "
                                                            disabled
                                                        />
                                                    </div>
                                                    <div
                                                        class="col-lg-3 mb-5 fw-bolder"
                                                        :class="
                                                            bukuTamu.agama.$error
                                                                ? 'text-danger'
                                                                : ''
                                                        "
                                                    >
                                                        Agama
                                                    </div>
                                                    <div class="col-lg-9 mb-5">
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            placeholder="Cth: Islam"
                                                            v-model="
                                                                bukuTamu.agama
                                                            "
                                                        />
                                                    </div>
                                                    <div
                                                        class="col-lg-3 mb-5 fw-bolder"
                                                        :class="
                                                            bukuTamu.status_perkawinan.$error
                                                                ? 'text-danger'
                                                                : ''
                                                        "
                                                    >
                                                        Status Perkawinan
                                                    </div>
                                                    <div class="col-lg-9 mb-5">
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            placeholder="Cth: Kawin"
                                                            v-model="
                                                                bukuTamu.status_perkawinan
                                                            "
                                                        />
                                                    </div>
                                                    <div
                                                        class="col-lg-3 mb-5 fw-bolder"
                                                        :class="
                                                            bukuTamu.kewarganegaraan.$error
                                                                ? 'text-danger'
                                                                : ''
                                                        "
                                                    >
                                                    Kewarganegaraan
                                                    </div>
                                                    <div class="col-lg-9 mb-5">
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            placeholder="Cth: WNI"
                                                            v-model="
                                                                bukuTamu.kewarganegaraan
                                                            "
                                                        />
                                                    </div>
                                                </div>

                                                <div
                                                    class="row mt-5 border-bottom pb-5 align-items-center"
                                                >
                                                    <div class="col-lg-12 mb-5">
                                                        <h4
                                                            class="c-primary-custom fw-bolder pb-2"
                                                        >
                                                            Alamat Pengunjung
                                                        </h4>
                                                    </div>
                                                    <div
                                                        class="col-lg-3 mb-5 fw-bolder"
                                                        :class="
                                                            bukuTamu.alamat_ktp
                                                                .$error
                                                                ? 'text-danger'
                                                                : ''
                                                        "
                                                    >
                                                        Alamat
                                                    </div>
                                                    <div class="col-lg-9 mb-5">
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            placeholder="Cth: Surabaya"
                                                            v-model="
                                                                bukuTamu.alamat_ktp
                                                            "
                                                        />
                                                    </div>
                                                    <div
                                                        class="col-lg-3 mb-5 fw-bolder"
                                                        :class="
                                                            bukuTamu
                                                                .rt_ktp
                                                                .$error
                                                                ? 'text-danger'
                                                                : ''
                                                        "
                                                    >
                                                        RT/RW
                                                    </div>
                                                    <div class="col-lg-9">
                                                        <div class="row">
                                                            <div
                                                                class="col-lg-6 mb-5"
                                                            >
                                                                <input
                                                                    type="text"
                                                                    class="form-control"
                                                                    placeholder="Cth: 14"
                                                                    v-model="
                                                                        bukuTamu.rt_ktp
                                                                    "
                                                                />
                                                            </div>
                                                            <div
                                                                class="col-lg-6 mb-5"
                                                            >
                                                                <input
                                                                    type="text"
                                                                    class="form-control"
                                                                    placeholder="Cth: 06"
                                                                    v-model="
                                                                        bukuTamu.rw_ktp
                                                                    "
                                                                />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="col-lg-3 mb-5 fw-bolder"
                                                        :class="
                                                            bukuTamu.kel_desa_ktp.$error
                                                                ? 'text-danger'
                                                                : ''
                                                        "
                                                    >
                                                        Kelurahan/Desa
                                                    </div>
                                                    <div class="col-lg-9 mb-5">
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            placeholder="Cth: Jemursari"
                                                            v-model="
                                                                bukuTamu.kel_desa_ktp
                                                            "
                                                        />
                                                    </div>
                                                    <div
                                                        class="col-lg-3 mb-5 fw-bolder"
                                                        :class="
                                                            bukuTamu.kecamatan_ktp.$error
                                                                ? 'text-danger'
                                                                : ''
                                                        "
                                                    >
                                                        Kecamatan
                                                    </div>
                                                    <div class="col-lg-9 mb-5">
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            placeholder="Cth: Gayungan"
                                                            v-model="
                                                                bukuTamu.kecamatan_ktp
                                                            "
                                                        />
                                                    </div>
                                                    <div
                                                        class="col-lg-3 mb-5 fw-bolder"
                                                        :class="
                                                            bukuTamu.kota_kabupaten_ktp.$error
                                                                ? 'text-danger'
                                                                : ''
                                                        "
                                                    >
                                                        Kota/Kabupaten
                                                    </div>
                                                    <div class="col-lg-9 mb-5">
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            placeholder="Cth: Surabaya"
                                                            v-model="
                                                                bukuTamu.kota_kabupaten_ktp
                                                            "
                                                        />
                                                    </div>
                                                    <div
                                                        class="col-lg-3 mb-5 fw-bolder"
                                                        :class="
                                                            bukuTamu.provinsi.$error
                                                                ? 'text-danger'
                                                                : ''
                                                        "
                                                    >
                                                        Provinsi
                                                    </div>
                                                    <div class="col-lg-9 mb-5">
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            placeholder="Cth: Jawa Timur"
                                                            v-model="
                                                                bukuTamu.provinsi
                                                            "
                                                        />
                                                    </div>
                                                </div>

                                                <div
                                                    class="row mt-5 border-bottom pb-5 align-items-center"
                                                >
                                                    <div class="col-lg-12 mb-5">
                                                        <h4
                                                            class="c-primary-custom fw-bolder pb-2"
                                                        >
                                                            Kebutuhan Pengunjung
                                                        </h4>
                                                    </div>

                                                    <div
                                                        class="col-lg-3 mb-5 fw-bolder"
                                                    >
                                                        Layanan
                                                    </div>
                                                    <div class="col-lg-9 mb-5">
                                                        <div class="row">
                                                            <div
                                                                v-for="layanan in daftarLayanan"
                                                                :key="
                                                                    layanan.id
                                                                "
                                                                class="col-md-4 mb-3"
                                                            >
                                                                <div
                                                                    class="form-check"
                                                                >
                                                                    <input
                                                                        type="checkbox"
                                                                        class="form-check-input"
                                                                        :id="
                                                                            'layanan-' +
                                                                            layanan.id
                                                                        "
                                                                        :value="
                                                                            layanan.id
                                                                        "
                                                                        v-model="
                                                                            bukuTamu.m_kebutuhan_layanan_id
                                                                        "
                                                                    />
                                                                    <label
                                                                        class="form-check-label"
                                                                        :for="
                                                                            'layanan-' +
                                                                            layanan.id
                                                                        "
                                                                    >
                                                                        {{
                                                                            layanan.name
                                                                        }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-5">
                                                    <div class="col-lg-12 mb-5">
                                                        <h4
                                                            class="c-primary-custom fw-bolder pb-2"
                                                        >
                                                            Foto
                                                        </h4>
                                                    </div>
                                                    <div
                                                        class="col-lg-12 mb-5 fw-bolder"
                                                    >
                                                        Unggah KTP
                                                    </div>
                                                    <div class="col-lg-12 mb-5">
                                                        <div
                                                            id="dropzone-container-1"
                                                        >
                                                            <div
                                                                class="dropzone dropzone-file-area dz-clickable"
                                                                id="dropzone-documentation-complaint"
                                                            >
                                                                <div
                                                                    class="dz-message needsclick"
                                                                    @click="
                                                                        $refs.fotoKtpInput.click()
                                                                    "
                                                                >
                                                                    <i
                                                                        class="bi bi-file-earmark-arrow-up text-primary fs-3x"
                                                                    ></i>
                                                                    <div
                                                                        class="ms-4"
                                                                    >
                                                                        <h5
                                                                            class="kt-dropzone__msg-title"
                                                                        >
                                                                            Drop
                                                                            files
                                                                            here
                                                                            or
                                                                            click
                                                                            to
                                                                            upload
                                                                        </h5>
                                                                        <span
                                                                            class="kt-dropzone__msg-desc text-primary"
                                                                        >
                                                                            Upload
                                                                            up
                                                                            to
                                                                            10
                                                                            files
                                                                            with
                                                                            the
                                                                            format
                                                                            .jpg/.jpeg/.png
                                                                        </span>
                                                                    </div>

                                                                    <!-- Input file tersembunyi -->
                                                                    <input
                                                                        ref="fotoKtpInput"
                                                                        type="file"
                                                                        accept=".jpg,.jpeg,.png"
                                                                        style="
                                                                            display: none;
                                                                        "
                                                                        @change="
                                                                            onFileChange(
                                                                                $event,
                                                                                'foto_ktp'
                                                                            )
                                                                        "
                                                                    />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="row mt-3">
                                                            <div
                                                                class="col-lg-2 col-md-4 col-sm-6 col-6 mb-5"
                                                            >
                                                                <a
                                                                    :href="
                                                                        getImageUrl(
                                                                            bukuTamu.foto_ktp_url
                                                                        )
                                                                    "
                                                                    data-fancybox="gallery"
                                                                >
                                                                    <img
                                                                        :src="
                                                                            getImageUrl(
                                                                                bukuTamu.foto_ktp_url
                                                                            )
                                                                        "
                                                                        class="w-100"
                                                                        style="
                                                                            max-width: 100%;
                                                                            height: 100px;
                                                                        "
                                                                    />
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
export default {
    data() {
        return {
            pageStatus: "standby",
            bukuTamu: {
                tgl_penerimaan: "",
                nomor_pendaftaran: "",
                nama: "",
                nik: "",
                alamat_ktp: "",
                jenis_kelamin: "",
                tempat_lahir: "",
                tanggal_lahir: "",
                usia: "",
                rt_ktp: "",
                rw_ktp: "",
                kel_desa_ktp: "",
                kecamatan_ktp: "",
                kota_kabupaten_ktp: "",
                provinsi: "",
                agama: "",
                status_perkawinan: "",
                kewarganegaraan: "",
                m_kebutuhan_layanan_id: [],
                foto_ktp_url: null,
            },
            daftarLayanan: [],
        };
    },
    computed: {
        selectedLayananText() {
            if (
                !this.bukuTamu.kebutuhan_layanan ||
                this.bukuTamu.kebutuhan_layanan.length === 0
            ) {
                return "Tidak ada layanan yang dipilih";
            }

            return this.bukuTamu.kebutuhan_layanan
                .map((item) => item.name)
                .join(", ");
        },
    },
    mounted() {
        this.fetchLayanan();
        this.fetchBukuTamuDetails();
        reinitializeAllPlugin();
    },
    methods: {
        getImageUrl(path) {
            if (!path) return null;

            if (
                typeof path === "string" &&
                (path.startsWith("blob:") || path.startsWith("http"))
            ) {
                return path;
            }

            return `/storage/${path}`;
        },
        async fetchLayanan() {
            this.pageStatus = "loading";
            try {
                const response = await Api().get(
                    "master-public/m-kebutuhan-layanan"
                );
                this.daftarLayanan = response.data.data;
                console.log("Daftar Layanan:", this.daftarLayanan);
            } catch (error) {
                console.error("Gagal mengambil data layanan:", error);
            }
        },
        onFileChange(event, field) {
            const file = event.target.files[0];
            if (file) {
                this[field] = file;

                this.bukuTamu.foto_ktp_url = URL.createObjectURL(file);
            }
        },
        update() {
            const formData = new FormData();
            formData.append("_method", "PUT");
            formData.append("nama", this.bukuTamu.nama);
            formData.append("nik", this.bukuTamu.nik);
            formData.append("tempat_lahir", this.bukuTamu.tempat_lahir);
            formData.append("tanggal_lahir", this.bukuTamu.tanggal_lahir);
            formData.append(
                "jenis_kelamin",
                this.bukuTamu.jenis_kelamin?.id || ""
            );
            formData.append("alamat_ktp", this.bukuTamu.alamat_ktp);
            formData.append("rt_ktp", this.bukuTamu.rt_ktp);
            formData.append("rw_ktp", this.bukuTamu.rw_ktp);
            formData.append("kel_desa_ktp", this.bukuTamu.kel_desa_ktp);
            formData.append("kecamatan_ktp", this.bukuTamu.kecamatan_ktp);
            formData.append(
                "kota_kabupaten_ktp",
                this.bukuTamu.kota_kabupaten_ktp
            );
            formData.append("provinsi", this.bukuTamu.provinsi);
            formData.append("agama", this.bukuTamu.agama);
            formData.append(
                "status_perkawinan",
                this.bukuTamu.status_perkawinan
            );
            formData.append("kewarganegaraan", this.bukuTamu.kewarganegaraan);
            if (this.foto_ktp) {
                formData.append("foto_ktp", this.foto_ktp);
            }

            if (
                this.bukuTamu.m_kebutuhan_layanan_id &&
                this.bukuTamu.m_kebutuhan_layanan_id.length > 0
            ) {
                this.bukuTamu.m_kebutuhan_layanan_id.forEach(
                    (layananId, index) => {
                        formData.append(
                            `m_kebutuhan_layanan_id[${index}]`,
                            layananId
                        );
                    }
                );
            }

            Api()
                .post(`buku-tamu/${this.$route.params.id}`, formData)
                .then((response) => {
                    this.$swal({
                        title: "Berhasil!",
                        text: "Perubahan berhasil",
                        icon: "success",
                    });
                    this.bukuTamu = response.data.data;
                    this.fetchBukuTamuDetails();
                })
                .catch((error) => {
                    this.$axiosHandleError(error);
                });
        },
        async fetchBukuTamuDetails() {
            this.pageStatus = "loading";
            try {
                const response = await Api().get(
                    `/buku-tamu/${this.$route.params.id}`
                );

                if (response.data.status === "success") {
                    console.log("Data dari API:", response.data.data);
                    this.bukuTamu = response.data.data;

                    // ✅ Mapping jenis_kelamin dari string ke object
                    const jk = this.bukuTamu.jenis_kelamin;
                    this.bukuTamu.jenis_kelamin =
                        [
                            { id: "Laki-laki", text: "Laki-laki" },
                            { id: "Perempuan", text: "Perempuan" },
                        ].find((opt) => opt.id === jk) || null;

                    // ✅ Mapping kebutuhan layanan ke array of id
                    console.log(
                        "m_kebutuhan_layanan_id sebelum:",
                        this.bukuTamu.m_kebutuhan_layanan_id
                    );

                    if (!Array.isArray(this.bukuTamu.m_kebutuhan_layanan_id)) {
                        if (
                            this.bukuTamu.kebutuhan_layanan &&
                            this.bukuTamu.kebutuhan_layanan.length > 0
                        ) {
                            this.bukuTamu.m_kebutuhan_layanan_id =
                                this.bukuTamu.kebutuhan_layanan.map(
                                    (item) => item.id
                                );
                        } else {
                            this.bukuTamu.m_kebutuhan_layanan_id = [];
                        }
                    }

                    console.log(
                        "m_kebutuhan_layanan_id setelah:",
                        this.bukuTamu.m_kebutuhan_layanan_id
                    );
                    console.log("daftarLayanan:", this.daftarLayanan);

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
    },
};
</script>
<style scoped>
.border-bottom {
    border-bottom: 1px #f2f2 solid !important;
}

.btn-active-selected {
    color: #ee7b33 !important;
    background: #f9ceb3 !important;
    border: 0 !important;
}
</style>
