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
                :style="`background-size: cover; background-image: url('${bg_login}')`"
            >
                <div
                    class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-30"
                >
                    <div
                        class="w-100 w-md-700px bg-white rounded shadow-xs p-10 p-lg-15 mx-auto"
                    >
                        <h3 class="mb-6 text-center">Unggah Foto KTP</h3>

                        <!-- Upload dari File -->
                        <div class="mb-6">
                            <label class="form-label fw-bold"
                                >Upload Foto KTP dari File</label
                            >
                            <p class="text-muted mb-2">
                                Silakan pilih foto KTP yang sudah ada di
                                perangkat Anda. Format yang didukung: JPG, PNG.
                            </p>
                            <input
                                type="file"
                                accept="image/*"
                                @change="onFileChange"
                                class="form-control"
                            />
                        </div>

                        <!-- Ambil Foto dari Kamera -->
                        <div class="mb-6">
                            <label class="form-label fw-bold"
                                >Ambil Foto KTP dari Kamera</label
                            >
                            <p class="text-muted mb-2">
                                Gunakan kamera perangkat Anda untuk mengambil
                                foto KTP secara langsung.
                            </p>
                            <div class="position-relative mb-2">
                                <video
                                    ref="videoRef"
                                    autoplay
                                    class="rounded border w-100"
                                    style="max-height: 300px"
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

                            <button
                                class="btn btn-light-primary btn-sm"
                                @click="takePhoto"
                            >
                                Ambil Foto
                            </button>
                        </div>

                        <!-- Preview Gambar -->
                        <div v-if="previewImage" class="mb-6">
                            <label class="form-label fw-bold"
                                >Preview Gambar</label
                            >
                            <img
                                :src="previewImage"
                                class="img-thumbnail w-100"
                            />
                        </div>

                        <!-- Tombol Upload -->
                        <div class="text-center mt-4">
                            <button
                                class="btn btn-success"
                                :disabled="!imageBlob"
                                @click="uploadKTP"
                            >
                                Submit
                            </button>
                        </div>
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
            imageBlob: null,
            previewImage: null,
            videoRef: null,
            stream: null,
        };
    },
    methods: {
        onFileChange(e) {
            const file = e.target.files[0];
            if (file && file.type.startsWith("image/")) {
                this.imageBlob = file;
                this.previewImage = URL.createObjectURL(file);
            }
        },
        async startCamera() {
            try {
                this.stream = await navigator.mediaDevices.getUserMedia({
                    video: true,
                });
                this.$refs.videoRef.srcObject = this.stream;
            } catch (err) {
                console.error("Gagal akses kamera:", err);
            }
        },
        takePhoto() {
            const video = this.$refs.videoRef;

            const videoWidth = video.videoWidth;
            const videoHeight = video.videoHeight;

            // Buat canvas dengan ukuran penuh video
            const canvas = document.createElement("canvas");
            canvas.width = videoWidth;
            canvas.height = videoHeight;

            const context = canvas.getContext("2d");

            // Gambar seluruh video ke canvas (tanpa crop)
            context.drawImage(video, 0, 0, videoWidth, videoHeight);

            // Simpan hasilnya ke blob
            canvas.toBlob((blob) => {
                this.imageBlob = blob;
                this.previewImage = URL.createObjectURL(blob);
            }, "image/jpeg");
        },
        async uploadKTP() {
            if (!this.imageBlob) return;

            this.$ewpLoadingShow();
            const formData = new FormData();

            const file = new File([this.imageBlob], "ktp.jpg", {
                type: "image/jpeg",
            });
            formData.append("image", file);

            try {
                const response = await Api().post(
                    "public/upload-OCR",
                    formData
                );

                const ktpId = response.data?.data?.id;

                if (ktpId) {
                    this.$swal({
                        title: "Berhasil!",
                        text: "Upload KTP berhasil",
                        icon: "success",
                    });

                    this.$router.replace({
                        name: "buku-tamu-OCR",
                        params: { id: ktpId },
                    });
                } else {
                    throw new Error("ID tidak ditemukan di respons");
                }
            } catch (error) {
                this.$axiosHandleError(error);
            } finally {
                this.$ewpLoadingHide();
            }
        },
    },
    mounted() {
        this.startCamera();
    },
    beforeDestroy() {
        if (this.stream) {
            this.stream.getTracks().forEach((track) => track.stop());
        }
    },
};
</script>

<style scoped>
video {
    width: 100%;
    border-radius: 10px;
    border: 1px solid #ccc;
}
</style>

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
