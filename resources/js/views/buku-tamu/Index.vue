<template>
    <div
        id="kt_body"
        class="bg-white header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed toolbar-tablet-and-mobile-fixed aside-enabled aside-fixed"
        style="
            --kt-toolbar-height: 55px;
            --kt-toolbar-height-tablet-and-mobile: 55px;
        "
    >
        <div class="d-flex flex-column flex-root">
            <div
                class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed login-wrapper"
                id="page-bg"
                :style="`background-size: cover;background-image: url('${bg_login}')`"
            >
                <div
                    class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-30"
                >
                    <div
                        class="w-100 w-md-700px bg-white rounded shadow-xs p-10 p-lg-15 mx-auto"
                    >
                        <form
                            class="form w-100"
                            novalidate="novalidate"
                            id="kt_sign_in_form"
                            action="#"
                        >
                            <div class="text-center mb-10">
                                <h1 class="text-dark mb-3">Buku Tamu</h1>
                            </div>

                            <!-- Nama Lengkap -->
                            <div class="fv-row mb-6">
                                <label class="form-label fs-6 text-gray-700"
                                    >Nama Lengkap</label
                                >
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Cth: Suyonto"
                                    v-model="nama"
                                />
                                <div v-if="errors.nama" class="text-danger">
                                    {{ errors.nama }}
                                </div>
                            </div>

                            <!-- NIK -->
                            <div class="fv-row mb-6">
                                <label class="form-label fs-6 text-gray-700"
                                    >NIK</label
                                >
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Cth: 35141318070200122"
                                    v-model="nik"
                                />
                                <div v-if="errors.nik" class="text-danger">
                                    {{ errors.nik }}
                                </div>
                            </div>

                            <div class="row mb-6">
                                <!-- Tempat Lahir -->
                                <div class="col-6">
                                    <label class="form-label fs-6 text-gray-700"
                                        >Tempat Lahir</label
                                    >
                                    <input
                                        v-model="tempat_lahir"
                                        class="form-control"
                                        type="text"
                                        placeholder="Cth: Surabaya"
                                    />
                                    <div
                                        v-if="errors.tempat_lahir"
                                        class="text-danger"
                                    >
                                        {{ errors.tempat_lahir }}
                                    </div>
                                </div>
                                <!-- Tanggal Lahir -->
                                <div class="col-6">
                                    <label class="form-label fs-6 text-gray-700"
                                        >Tanggal Lahir</label
                                    >
                                    <input
                                        v-model="tanggal_lahir"
                                        class="form-control"
                                        type="date"
                                    />
                                    <div
                                        v-if="errors.tanggal_lahir"
                                        class="text-danger"
                                    >
                                        {{ errors.tanggal_lahir }}
                                    </div>
                                </div>
                            </div>

                            <!-- Jenis Kelamin -->
                            <div class="fv-row mb-6">
                                <label class="form-label fs-6 text-gray-700"
                                    >Jenis Kelamin</label
                                >
                                <div>
                                    <app-select-single
                                        v-model="jenis_kelamin"
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
                                    <div
                                        v-if="errors.jenis_kelamin"
                                        class="text-danger"
                                    >
                                        {{ errors.jenis_kelamin }}
                                    </div>
                                </div>
                            </div>

                            <!-- Alamat KTP -->
                            <div class="fv-row mb-6">
                                <label class="form-label fs-6 text-gray-700"
                                    >Alamat KTP</label
                                >
                                <textarea
                                    v-model="alamat_ktp"
                                    class="form-control"
                                    placeholder="Cth: Surabaya"
                                ></textarea>
                                <div
                                    v-if="errors.alamat_ktp"
                                    class="text-danger"
                                >
                                    {{ errors.alamat_ktp }}
                                </div>
                            </div>

                            <div class="row mb-6">
                                <!-- RT & RW -->
                                <div class="col-6">
                                    <label class="form-label fs-6 text-gray-700"
                                        >RT</label
                                    >
                                    <input
                                        v-model="rt_ktp"
                                        class="form-control"
                                        type="text"
                                        placeholder="Cth: 001"
                                    />
                                    <div
                                        v-if="errors.rt_ktp"
                                        class="text-danger"
                                    >
                                        {{ errors.rt_ktp }}
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label class="form-label fs-6 text-gray-700"
                                        >RW</label
                                    >
                                    <input
                                        v-model="rw_ktp"
                                        class="form-control"
                                        type="text"
                                        placeholder="Cth: 002"
                                    />
                                    <div
                                        v-if="errors.rw_ktp"
                                        class="text-danger"
                                    >
                                        {{ errors.rw_ktp }}
                                    </div>
                                </div>
                            </div>

                            <!-- Kelurahan/Desa, Kecamatan, Kota/Ka upaten -->
                            <div class="fv-row mb-6">
                                <label class="form-label fs-6 text-gray-700"
                                    >Kelurahan/Desa</label
                                >
                                <input
                                    v-model="kel_desa_ktp"
                                    class="form-control"
                                    type="text"
                                    placeholder="Cth: Jemursari"
                                />
                                <div
                                    v-if="errors.kel_desa_ktp"
                                    class="text-danger"
                                >
                                    {{ errors.kel_desa_ktp }}
                                </div>
                            </div>
                            <div class="fv-row mb-6">
                                <label class="form-label fs-6 text-gray-700"
                                    >Kecamatan</label
                                >
                                <input
                                    v-model="kecamatan_ktp"
                                    class="form-control"
                                    type="text"
                                    placeholder="Cth: Pagesangan"
                                />
                                <div
                                    v-if="errors.kecamatan_ktp"
                                    class="text-danger"
                                >
                                    {{ errors.kecamatan_ktp }}
                                </div>
                            </div>
                            <div class="fv-row mb-6">
                                <label class="form-label fs-6 text-gray-700"
                                    >Kota/Kabupaten</label
                                >
                                <input
                                    v-model="kota_kabupaten_ktp"
                                    class="form-control"
                                    type="text"
                                    placeholder="Cth: Surabaya"
                                />
                                <div
                                    v-if="errors.kota_kabupaten_ktp"
                                    class="text-danger"
                                >
                                    {{ errors.kota_kabupaten_ktp }}
                                </div>
                            </div>

                            <!-- Provinsi -->
                            <div class="fv-row mb-6">
                                <label class="form-label fs-6 text-gray-700"
                                    >Provinsi</label
                                >
                                <input
                                    v-model="provinsi"
                                    class="form-control"
                                    type="text"
                                    placeholder="Cth: Jawa Timur"
                                />
                                <div v-if="errors.provinsi" class="text-danger">
                                    {{ errors.provinsi }}
                                </div>
                            </div>

                            <!-- Agama -->
                            <div class="fv-row mb-6">
                                <label class="form-label fs-6 text-gray-700"
                                    >Agama</label
                                >
                                <input
                                    v-model="agama"
                                    class="form-control"
                                    type="text"
                                    placeholder="Cth: Islam"
                                />
                                <div v-if="errors.agama" class="text-danger">
                                    {{ errors.agama }}
                                </div>
                            </div>

                            <!-- Status Perkawinan -->
                            <div class="fv-row mb-6">
                                <label class="form-label fs-6 text-gray-700"
                                    >Status Perkawinan</label
                                >
                                <input
                                    v-model="status_perkawinan"
                                    class="form-control"
                                    type="text"
                                    placeholder="Cth: Kawin"
                                />
                                <div
                                    v-if="errors.status_perkawinan"
                                    class="text-danger"
                                >
                                    {{ errors.status_perkawinan }}
                                </div>
                            </div>

                            <!-- Status Kewarganegaraan -->
                            <div class="fv-row mb-6">
                                <label class="form-label fs-6 text-gray-700"
                                    >Kewarganegaraan</label
                                >
                                <input
                                    v-model="kewarganegaraan"
                                    class="form-control"
                                    type="text"
                                    placeholder="Cth: WNI"
                                />
                                <div
                                    v-if="errors.kewarganegaraan"
                                    class="text-danger"
                                >
                                    {{ errors.kewarganegaraan }}
                                </div>
                            </div>

                            <!-- Kebutuhan Layanan (Multiple Checkbox) -->
                            <div class="fv-row mb-6">
                                <label class="form-label fs-6 text-gray-700"
                                    >Kebutuhan Layanan</label
                                >
                                <div class="col-lg-12 mb-5">
                                    <div class="row">
                                        <div
                                            v-for="layanan in daftarLayanan"
                                            :key="layanan.id"
                                            class="col-md-4 mb-3"
                                        >
                                            <div class="form-check">
                                                <input
                                                    type="checkbox"
                                                    class="form-check-input"
                                                    :id="
                                                        'layanan-' + layanan.id
                                                    "
                                                    :value="layanan.id"
                                                    v-model="
                                                        m_kebutuhan_layanan_id
                                                    "
                                                />
                                                <label
                                                    class="form-check-label"
                                                    :for="
                                                        'layanan-' + layanan.id
                                                    "
                                                >
                                                    {{ layanan.name }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        v-if="errors.m_kebutuhan_layanan_id"
                                        class="text-danger mt-2"
                                    >
                                        {{ errors.m_kebutuhan_layanan_id }}
                                    </div>
                                </div>
                            </div>

                            <!-- Upload Foto KTP -->
                            <div class="fv-row mb-6">
                                <label class="form-label fs-6 text-gray-700"
                                    >Foto KTP</label
                                >
                                <p class="text-muted mb-2">
                                    Silakan pilih foto KTP yang sudah ada di
                                    perangkat Anda. Format yang didukung: JPG,
                                    PNG.
                                </p>
                                <!-- Baris dengan dua kolom (input file di kiri, tombol kamera di kanan) -->
                                <div class="d-flex align-items-center mb-6">
                                    <!-- Kolom Kiri: Input File -->
                                    <div class="me-3 flex-grow-1">
                                        <input
                                            type="file"
                                            @change="
                                                onFileChange($event, 'foto_ktp')
                                            "
                                            class="form-control form-control-lg"
                                        />
                                    </div>

                                    <!-- Kolom Kanan: Tombol Kamera (dengan ikon) -->
                                    <div>
                                        <button
                                            type="button"
                                            class="btn btn-light-primary btn-sm"
                                            @click="openCameraModal"
                                        >
                                            <!-- Ikon Kamera (gunakan FontAwesome atau library ikon lain) -->
                                            <i class="fas fa-camera"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Preview -->
                                <div v-if="preview_ktp" class="mt-3">
                                    <label class="form-label d-block"
                                        >Preview:</label
                                    >
                                    <img
                                        :src="preview_ktp"
                                        class="img-thumbnail"
                                        style="max-width: 300px"
                                    />
                                </div>
                            </div>

                            <div class="text-center">
                                <button
                                    type="button"
                                    id="kt_sign_in_submit"
                                    class="btn btn-lg my-2 px-16 bg-primary-custom"
                                    @click="onSubmit"
                                >
                                    <span class="indicator-label text-white"
                                        >Submit</span
                                    >
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Kamera Ambil Foto KTP -->
    <div
        v-if="showCameraModal"
        class="modal fade show d-block"
        tabindex="-1"
        style="background-color: rgba(0, 0, 0, 0.5)"
    >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ambil Foto KTP dari Kamera</h5>
                    <button
                        type="button"
                        class="btn-close"
                        @click="closeCameraModal"
                    ></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted mb-2">
                        Gunakan kamera perangkat Anda untuk mengambil foto KTP
                        secara langsung.
                    </p>

                    <!-- Video dan Overlay -->
                    <div class="position-relative mb-3">
                        <video
                            ref="videoRef"
                            autoplay
                            class="rounded border w-100"
                            style="max-height: 400px"
                        ></video>

                        <!-- Overlay panduan posisi KTP -->
                        <div
                            class="position-absolute top-0 start-0 w-100 h-100"
                            style="pointer-events: none"
                        >
                            <!-- Area Foto KTP -->
                            <div
                                class="position-absolute"
                                style="
                                    top: 32%;
                                    left: 63%;
                                    width: 13%;
                                    height: 26%;
                                    border: 2px dashed #ff5733;
                                    border-radius: 6px;
                                "
                                title="Posisi Foto KTP"
                            ></div>

                            <!-- Area Data KTP -->
                            <div
                                class="position-absolute"
                                style="
                                    top: 25%;
                                    left: 25%;
                                    width: 32%;
                                    height: 50%;
                                    border: 2px dashed #28a745;
                                    border-radius: 6px;
                                "
                                title="Posisi Data KTP"
                            ></div>
                        </div>
                    </div>

                    <!-- Tombol Ambil Foto -->
                    <div class="text-end">
                        <button
                            class="btn btn-secondary me-2"
                            @click="closeCameraModal"
                        >
                            Batal
                        </button>
                        <button class="btn btn-primary" @click="takePhoto">
                            Ambil Foto
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Api from "@/services/api";

export default {
    data() {
        return {
            bg_login: this.$assetUrl() + "extends/img/bg-login.png",
            nama: "",
            nik: "",
            tempat_lahir: "",
            tanggal_lahir: "",
            usia: "",
            jenis_kelamin: "",
            alamat_ktp: "",
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
            daftarLayanan: [],
            foto_ktp: null,
            preview_ktp: null,
            showCameraModal: false,
            stream: null,
            errors: {},
        };
    },
    methods: {
        async openCameraModal() {
            this.showCameraModal = true;
            try {
                this.stream = await navigator.mediaDevices.getUserMedia({
                    video: true,
                });
                this.$refs.videoRef.srcObject = this.stream;
            } catch (error) {
                alert("Tidak dapat mengakses kamera.");
                this.showCameraModal = false;
            }
        },
        closeCameraModal() {
            this.showCameraModal = false;
            if (this.stream) {
                this.stream.getTracks().forEach((track) => track.stop());
            }
        },
        takePhoto() {
            const video = this.$refs.videoRef;
            const canvas = document.createElement("canvas");
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;

            const ctx = canvas.getContext("2d");
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

            canvas.toBlob((blob) => {
                const file = new File([blob], "foto_ktp.png", {
                    type: "image/png",
                });
                this.foto_ktp = file;
                this.preview_ktp = URL.createObjectURL(blob);
                this.closeCameraModal();
            });
        },
        async fetchLayanan() {
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
            this[field] = file;

            if (field === "foto_ktp" && file) {
                this.preview_ktp = URL.createObjectURL(file);
            }
        },
        async onSubmit() {
            this.errors = {}; // reset errors

            // Validasi field wajib
            if (!this.nama) this.errors.nama = "Nama wajib diisi";
            if (!this.nik) this.errors.nik = "NIK wajib diisi";
            if (!this.tempat_lahir)
                this.errors.tempat_lahir = "Tempat lahir wajib diisi";
            if (!this.tanggal_lahir)
                this.errors.tanggal_lahir = "Tanggal lahir wajib diisi";
            if (!this.jenis_kelamin)
                this.errors.jenis_kelamin = "Jenis kelamin wajib dipilih";
            if (!this.alamat_ktp)
                this.errors.alamat_ktp = "Alamat KTP wajib diisi";
            if (!this.rt_ktp) this.errors.rt_ktp = "RT wajib diisi";
            if (!this.rw_ktp) this.errors.rw_ktp = "RW wajib diisi";
            if (!this.kel_desa_ktp)
                this.errors.kel_desa_ktp = "Kelurahan/Desa wajib diisi";
            if (!this.kecamatan_ktp)
                this.errors.kecamatan_ktp = "Kecamatan wajib diisi";
            if (!this.kota_kabupaten_ktp)
                this.errors.kota_kabupaten_ktp = "Kota/Kabupaten wajib diisi";
            if (!this.provinsi) this.errors.provinsi = "Provinsi wajib diisi";
            if (!this.agama) this.errors.agama = "Agama wajib diisi";
            if (!this.status_perkawinan)
                this.errors.status_perkawinan = "Status perkawinan wajib diisi";
            if (!this.kewarganegaraan)
                this.errors.kewarganegaraan = "Kewarganegaraan wajib diisi";
            if (
                !this.m_kebutuhan_layanan_id ||
                this.m_kebutuhan_layanan_id.length === 0
            ) {
                this.errors.m_kebutuhan_layanan_id =
                    "Minimal satu kebutuhan layanan harus dipilih";
            }

            // Kalau ada error, tampilkan alert dan hentikan submit
            if (Object.keys(this.errors).length > 0) {
                this.$swal({
                    title: "Perhatian",
                    text: "Harap lengkapi semua data wajib.",
                    icon: "warning",
                });
                return;
            }

            // Kalau valid, baru submit
            this.$ewpLoadingShow();
            const formData = new FormData();
            formData.append("nama", this.nama);
            formData.append("nik", this.nik);
            formData.append("tempat_lahir", this.tempat_lahir);
            formData.append("tanggal_lahir", this.tanggal_lahir);
            formData.append("jenis_kelamin", this.jenis_kelamin?.id || "");
            formData.append("alamat_ktp", this.alamat_ktp);
            formData.append("rt_ktp", this.rt_ktp);
            formData.append("rw_ktp", this.rw_ktp);
            formData.append("kel_desa_ktp", this.kel_desa_ktp);
            formData.append("kecamatan_ktp", this.kecamatan_ktp);
            formData.append("kota_kabupaten_ktp", this.kota_kabupaten_ktp);
            formData.append("provinsi", this.provinsi);
            formData.append("agama", this.agama);
            formData.append("status_perkawinan", this.status_perkawinan);
            formData.append("kewarganegaraan", this.kewarganegaraan);
            this.m_kebutuhan_layanan_id.forEach((id, index) => {
                formData.append(`m_kebutuhan_layanan_id[${index}]`, id);
            });

            if (this.foto_ktp) {
                formData.append("foto_ktp", this.foto_ktp);
            }

            Api()
                .post("public/buku-tamu", formData)
                .then(() => {
                    this.$swal({
                        title: "Berhasil!",
                        text: "Buku Tamu berhasil dikirim",
                        icon: "success",
                    }).then(async () => {
                        await this.$router.replace({ name: "pilihan" });
                        window.location.reload();
                    });
                })
                .catch((error) => {
                    this.$axiosHandleError(error);
                })
                .finally(() => {
                    this.$ewpLoadingHide();
                });
        },
    },
    mounted() {
        this.fetchLayanan();
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
