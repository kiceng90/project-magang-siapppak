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
                                    v-model="ktp.nama"
                                    placeholder="Cth: Supratno"
                                    class="form-control"
                                    type="text"
                                    autocomplete="off"
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
                                    v-model="ktp.nik"
                                    placeholder="Cth: 3514131709010002"
                                    class="form-control"
                                    type="text"
                                    autocomplete="off"
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
                                        v-model="ktp.tempat_lahir"
                                        placeholder="Cth: Surabaya"
                                        class="form-control"
                                        type="text"
                                        autocomplete="off"
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
                                        v-model="ktp.tanggal_lahir"
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
                                <app-select-single
                                    v-model="ktp.jenis_kelamin"
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

                            <!-- Alamat KTP -->
                            <div class="fv-row mb-6">
                                <label class="form-label fs-6 text-gray-700"
                                    >Alamat KTP</label
                                >
                                <textarea
                                    v-model="ktp.alamat_ktp"
                                    placeholder="Cth: Pagesangan"
                                    class="form-control"
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
                                        v-model="ktp.rt_ktp"
                                        placeholder="Cth: 005"
                                        class="form-control"
                                        type="text"
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
                                        v-model="ktp.rw_ktp"
                                        placeholder="Cth: 001"
                                        class="form-control"
                                        type="text"
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
                                    v-model="ktp.kel_desa_ktp"
                                    placeholder="Cth: Jemursari"
                                    class="form-control"
                                    type="text"
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
                                    v-model="ktp.kecamatan_ktp"
                                    placeholder="Cth: Kebosari"
                                    class="form-control"
                                    type="text"
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
                                    v-model="ktp.kota_kabupaten_ktp"
                                    placeholder="Cth: Surabaya"
                                    class="form-control"
                                    type="text"
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
                                    v-model="ktp.provinsi"
                                    placeholder="Cth: Jawa Timur"
                                    class="form-control"
                                    type="text"
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
                                    v-model="ktp.agama"
                                    placeholder="Cth: Islam"
                                    class="form-control"
                                    type="text"
                                />
                                <div v-if="errors.agama" class="text-danger">
                                    {{ errors.agama }}
                                </div>
                            </div>

                            <!-- Pekerjaan -->
                            <div class="fv-row mb-6">
                                <label class="form-label fs-6 text-gray-700"
                                    >Pekerjaan</label
                                >
                                <input
                                    v-model="ktp.pekerjaan"
                                    placeholder="Cth: Pedagang"
                                    class="form-control"
                                    type="text"
                                />
                            </div>

                            <!-- Status Perkawinan -->
                            <div class="fv-row mb-6">
                                <label class="form-label fs-6 text-gray-700"
                                    >Status Perkawinan</label
                                >
                                <input
                                    v-model="ktp.status_perkawinan"
                                    placeholder="Cth: Kawin"
                                    class="form-control"
                                    type="text"
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
                                    v-model="ktp.kewarganegaraan"
                                    placeholder="Cth: WNI"
                                    class="form-control"
                                    type="text"
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

                                <!-- Preview -->
                                <div v-if="previewFotoKTP" class="mb-3">
                                    <p class="text-muted small">
                                        Preview dari:
                                        {{ getImageUrl(previewFotoKTP) }}
                                    </p>
                                    <img
                                        :src="getImageUrl(previewFotoKTP)"
                                        alt="Preview Foto KTP"
                                        class="img-thumbnail"
                                        style="max-height: 200px"
                                        @error="handleImageError"
                                    />
                                </div>

                                <input
                                    type="file"
                                    @change="onFileChange($event, 'foto_ktp')"
                                    class="form-control"
                                    accept="image/*"
                                />
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
</template>

<script>
import Api from "@/services/api";

export default {
    data() {
        return {
            bg_login: this.$assetUrl() + "extends/img/bg-login.png",
            ktp: {
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
                pekerjaan: "",
                foto_ktp: null,
                foto_ktp_url: null,
            },
            m_kebutuhan_layanan_id: [],
            daftarLayanan: [],
            previewFotoKTP: null,
            errors: {},
        };
    },
    methods: {
        handleImageError(e) {
            console.warn("Gagal load gambar: ", e.target.src);
            e.target.src = "/assets/img/no-image.png"; // Ganti dengan fallback image kamu
        },
        getImageUrl(path) {
            if (!path) return null;

            if (typeof path === "string") {
                if (
                    path.startsWith("http") ||
                    path.startsWith("blob:") ||
                    path.startsWith("/storage/")
                ) {
                    return path;
                }

                return `/storage/${path.replace(/^\/?storage\//, "")}`;
            }

            return null;
        },
        async fetchKTPDetail() {
            const id = this.$route.params.id;
            try {
                const response = await Api().get(`public/buku-tamu-OCR/${id}`);
                const data = response.data.data;

                // Pertama, isi semua data kecuali jenis_kelamin
                this.ktp = {
                    ...data,
                    alamat_ktp: data.alamat_ktp || "",
                    rt_ktp: data.rt_ktp || "",
                    rw_ktp: data.rw_ktp || "",
                    tanggal_lahir: data.tanggal_lahir
                        ? new Date(data.tanggal_lahir).toLocaleDateString(
                              "en-CA"
                          )
                        : "",
                    foto_ktp: null,
                };

                // Set preview foto KTP
                this.previewFotoKTP =
                    data.foto_ktp_url || data.foto_ktp || null;

                // Terakhir, tangani jenis_kelamin secara terpisah
                // Ini dilakukan setelah semua data lain sudah di-assign
                if (data.jenis_kelamin) {
                    const jk = data.jenis_kelamin.toUpperCase();
                    this.ktp.jenis_kelamin =
                        jk === "LAKI-LAKI"
                            ? { id: "Laki-laki", text: "Laki-laki" }
                            : jk === "PEREMPUAN"
                            ? { id: "Perempuan", text: "Perempuan" }
                            : {};
                } else {
                    // Jika null, tetapkan objek kosong yang valid untuk komponen
                    this.ktp.jenis_kelamin = {};
                }
            } catch (error) {
                this.$axiosHandleError(error);
            }
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
            if (file) {
                this.ktp[field] = file;

                const reader = new FileReader();
                reader.onload = (e) => {
                    this.previewFotoKTP = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        },
        capitalizeWords(str) {
            if (!str) return "";
            return str
                .toLowerCase()
                .replace(/\b\w/g, (char) => char.toUpperCase());
        },
        async onSubmit() {
            this.errors = {}; // Reset errors
            const ktp = this.ktp;

            if (!ktp.nama) this.errors.nama = "Nama wajib diisi";
            if (!ktp.nik) this.errors.nik = "NIK wajib diisi";
            if (!ktp.tempat_lahir)
                this.errors.tempat_lahir = "Tempat lahir wajib diisi";
            if (!ktp.tanggal_lahir)
                this.errors.tanggal_lahir = "Tanggal lahir wajib diisi";
            if (!ktp.jenis_kelamin || !ktp.jenis_kelamin.id)
                this.errors.jenis_kelamin = "Jenis kelamin wajib dipilih";
            if (!ktp.alamat_ktp)
                this.errors.alamat_ktp = "Alamat KTP wajib diisi";
            if (!ktp.rt_ktp) this.errors.rt_ktp = "RT wajib diisi";
            if (!ktp.rw_ktp) this.errors.rw_ktp = "RW wajib diisi";
            if (!ktp.kel_desa_ktp)
                this.errors.kel_desa_ktp = "Kelurahan/Desa wajib diisi";
            if (!ktp.kecamatan_ktp)
                this.errors.kecamatan_ktp = "Kecamatan wajib diisi";
            if (!ktp.kota_kabupaten_ktp)
                this.errors.kota_kabupaten_ktp = "Kota/Kabupaten wajib diisi";
            if (!ktp.provinsi) this.errors.provinsi = "Provinsi wajib diisi";
            if (!ktp.agama) this.errors.agama = "Agama wajib diisi";
            if (!ktp.status_perkawinan)
                this.errors.status_perkawinan = "Status perkawinan wajib diisi";
            if (!ktp.kewarganegaraan)
                this.errors.kewarganegaraan = "Kewarganegaraan wajib diisi";
            if (
                !this.m_kebutuhan_layanan_id ||
                this.m_kebutuhan_layanan_id.length === 0
            ) {
                this.errors.m_kebutuhan_layanan_id =
                    "Minimal satu kebutuhan layanan harus dipilih";
            }

            // Kalau ada error, tampilkan alert dan stop submit
            if (Object.keys(this.errors).length > 0) {
                this.$swal({
                    title: "Perhatian",
                    text: "Harap lengkapi semua data wajib.",
                    icon: "warning",
                });
                return;
            }

            // Kalau valid, lanjut submit
            this.$ewpLoadingShow();
            const formData = new FormData();

            formData.append("ktp_id", this.$route.params.id);
            formData.append("nama", this.capitalizeWords(ktp.nama));
            formData.append("nik", ktp.nik);
            formData.append(
                "tempat_lahir",
                this.capitalizeWords(ktp.tempat_lahir)
            );
            formData.append("tanggal_lahir", ktp.tanggal_lahir);
            formData.append("jenis_kelamin", ktp.jenis_kelamin?.id || "");
            formData.append("alamat_ktp", this.capitalizeWords(ktp.alamat_ktp));
            formData.append("rt_ktp", ktp.rt_ktp);
            formData.append("rw_ktp", ktp.rw_ktp);
            formData.append(
                "kel_desa_ktp",
                this.capitalizeWords(ktp.kel_desa_ktp)
            );
            formData.append(
                "kecamatan_ktp",
                this.capitalizeWords(ktp.kecamatan_ktp)
            );
            formData.append(
                "kota_kabupaten_ktp",
                this.capitalizeWords(ktp.kota_kabupaten_ktp)
            );
            formData.append("provinsi", this.capitalizeWords(ktp.provinsi));
            formData.append("agama", this.capitalizeWords(ktp.agama));
            formData.append(
                "status_perkawinan",
                this.capitalizeWords(ktp.status_perkawinan)
            );
            formData.append("kewarganegaraan", ktp.kewarganegaraan);

            this.m_kebutuhan_layanan_id.forEach((id, index) => {
                formData.append(`m_kebutuhan_layanan_id[${index}]`, id);
            });

            if (ktp.foto_ktp) {
                formData.append("foto_ktp", ktp.foto_ktp);
            } else if (ktp.foto_ktp_url) {
                const response = await fetch(
                    this.getImageUrl(ktp.foto_ktp_url)
                );
                const blob = await response.blob();
                const fileType = blob.type || "image/jpeg";
                const fileName = "foto_ktp." + fileType.split("/")[1];
                const file = new File([blob], fileName, { type: fileType });
                formData.append("foto_ktp", file);
            }

            Api()
                .post("public/buku-tamu", formData)
                .then(() => {
                    this.$swal({
                        title: "Berhasil!",
                        text: "Buku Tamu berhasil dikirim",
                        icon: "success",
                    }).then(() => {
                        setTimeout(() => {
                            this.$router.replace({ name: "pilihan" });
                        }, 100);
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
        this.fetchKTPDetail();
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
