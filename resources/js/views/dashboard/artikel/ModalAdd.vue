<template>
    <dashboard-modal title="Tambah Data" id="modal-tambah" dialog-class="modal-lg">
        <!-- <label class="form-label fw-bolder fs-6 mb-3">NIM</label>
        <input type="text" class="form-control mb-5" v-model="nim" placeholder="Isi NIM" @blur="fetchDataByNIM"> -->
        <div class="mb-5">
            <label class="form-label fw-bolder fs-6 mb-3">NIM</label>
            <div class="input-group">
                <input
                    type="text"
                    class="form-control"
                    v-model="nim"
                    placeholder="Isi NIM"
                />
                <button
                    type="button"
                    class="btn bg-second-primary-custom text-white"
                    @click="fetchDataByNIM"
                >
                    Cari
                </button>
            </div>
        </div>
        <label class="form-label fw-bolder fs-6 mb-3">Nama Penulis</label>
        <input type="text" class="form-control mb-5" v-model="nama_mahasiswa" placeholder="Isi Nama Penulis" readonly>
        <label class="form-label fw-bolder fs-6 mb-3">Kecamatan Tugas</label>
        <input type="text" class="form-control mb-5" v-model="kecamatan_puspaga" placeholder="Isi Kecamatan" readonly>
        <label class="form-label fw-bolder fs-6 mb-3">Judul</label>
        <input type="text" class="form-control mb-5" v-model="title" placeholder="Isi judul">
        <label class="form-label fw-bolder fs-6 mb-3">Narasi Artikel</label>
        <app-editor class="form-control" v-model:content="description" ref="editor" contentType="html"></app-editor>
        
        <div class="row">
            <div class="col-lg-8">
                <label class="form-label fw-bolder fs-6 mb-3">Thumbnail</label>
                <input type="file" class="form-control" @change="onThumbnailChange" accept="image/*" ref="thumbnail">
                <small class="form-text text-muted mb-5 d-inline-block">
                    Maksimal ukuran file yang dapat diunggah adalah 2 Mb.
                </small>
            </div>
            <div class="col-lg-4" v-if="previewThumbnailSrc">
                <label class="form-label fw-bolder fs-6 mb-3">Preview Thumbnail</label>
                <img class="rounded mb-5" width="100" height="100" style="object-fit: cover;" :src="previewThumbnailSrc" alt="Thumbnail">
            </div>
        </div>
        
        <template #footer>
            <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
            <button class="btn btn-sm bg-second-primary-custom text-white" type="button" @click="onSubmit">
                Simpan
            </button>
        </template>
    </dashboard-modal>
</template>

<script>
import Api from "@/services/api";

export default {
    data() {
        return {
            title: '',
            description: '',
            nim: '',
            nama_mahasiswa: '',
            kecamatan_puspaga: '',
            file_thumbnail: null,
            previewThumbnailSrc: null,
        };
    },
    methods: {
        reset() {
            this.title = '';
            this.description = '';
            this.nim = '';
            this.nama_mahasiswa = '';
            this.kecamatan_puspaga = '';
            this.file_thumbnail = null;
            this.previewThumbnailSrc = null;
            if (this.$refs.thumbnail) this.$refs.thumbnail.value = null;
        },
        fetchDataByNIM() {
            if (!this.nim || !/^\d+$/.test(this.nim)) {
                this.$swal({
                    title: "Error!",
                    text: "Format NIM tidak valid.",
                    icon: "error",
                });
                return;
            }

            this.$ewpLoadingShow();
            Api().get(`lookup/mahasiswa?nim=${this.nim}`)
                .then((response) => {
                    if (response.data.success) {
                        const { nama_mahasiswa, kecamatan_puspaga } = response.data.data;
                        this.nama_mahasiswa = nama_mahasiswa;
                        this.kecamatan_puspaga = kecamatan_puspaga;
                    } else {
                        this.nama_mahasiswa = '';
                        this.kecamatan_puspaga = '';
                        this.$swal({
                            title: "Error!",
                            text: "Data mahasiswa tidak ditemukan.",
                            icon: "error",
                        });
                    }
                })
                .catch((error) => {
                    console.error(error);
                    this.$swal({
                        title: "Error!",
                        text: "Terjadi kesalahan saat mengambil data.",
                        icon: "error",
                    });
                })
                .finally(() => {
                    this.$ewpLoadingHide();
                });
        },

        onThumbnailChange(e) {
            const [file] = e.target.files;
            this.file_thumbnail = file;
            this.previewThumbnailSrc = URL.createObjectURL(file);
        },
        onSubmit() {
            this.$ewpLoadingShow();
            const formData = new FormData();
            formData.append("title", this.title);
            formData.append("nim", this.nim);
            formData.append("nama_mahasiswa", this.nama_mahasiswa);
            formData.append("kecamatan_puspaga", this.kecamatan_puspaga);
            formData.append("description", this.description);
            formData.append("file_thumbnail", this.file_thumbnail);
            formData.append('is_active', 1);

            Api().post("artikel", formData)
                .then((response) => {
                    this.$swal({
                        title: "Berhasil!",
                        text: "Data artikel berhasil disimpan.",
                        icon: "success",
                    });
                    this.reset();
                })
                .catch((error) => {
                    this.$swal({
                        title: "Error!",
                        text: "Gagal menyimpan data.",
                        icon: "error",
                    });
                    console.error(error);
                })
                .finally(() => {
                    this.$ewpLoadingHide();
                });
        },
    },
};
</script>
