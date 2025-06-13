<template>
    <dashboard-modal title="Edit Data" id="modal-edit" dialog-class="modal-lg">
        <div class="mb-5">
            <label class="form-label fw-bolder fs-6 mb-3">NIM</label>
            <input type="text" class="form-control" v-model="nim" readonly placeholder="Isi NIM" />
        </div>
        <label class="form-label fw-bolder fs-6 mb-3">Nama Penulis</label>
        <input type="text" class="form-control mb-5" v-model="nama_mahasiswa" readonly placeholder="Isi Nama Penulis" />
        <label class="form-label fw-bolder fs-6 mb-3">Kecamatan Tugas</label>
        <input type="text" class="form-control mb-5" v-model="kecamatan_puspaga" readonly placeholder="Isi Kecamatan" />
        <label class="form-label fw-bolder fs-6 mb-3">Judul</label>
        <input type="text" class="form-control mb-5" v-model="title" placeholder="Isi judul" />
        <label class="form-label fw-bolder fs-6 mb-3">Narasi Artikel</label>
        <app-editor class="form-control" v-model:content="description" ref="editor" contentType="html"></app-editor>
        
        <div class="row">
            <div class="col-lg-8">
                <label class="form-label fw-bolder fs-6 mb-3">Thumbnail</label>
                <input type="file" class="form-control" @change="onThumbnailChange" accept="image/*" ref="thumbnail" />
                <small class="form-text text-muted mb-5">Maksimal ukuran file yang dapat diunggah adalah 2 Mb.</small>
            </div>
            <div class="col-lg-4" v-if="previewThumbnailSrc">
                <label class="form-label fw-bolder fs-6 mb-3">Preview Thumbnail</label>
                <img :src="previewThumbnailSrc" class="rounded mb-5" width="100" height="100" style="object-fit: cover;" alt="Thumbnail" />
            </div>
        </div>
        
        <template #footer>
            <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
            <button class="btn btn-sm bg-second-primary-custom text-white" type="button" @click="onSubmit">Simpan</button>
        </template>
    </dashboard-modal>
</template>

<script>
import Api from "@/services/api";

export default {
    props: ['data'],
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
    watch: {
        data(newData) {
            if (newData) {
                this.title = newData.title || '';
                this.nim = newData.nim || '';
                this.nama_mahasiswa = newData.nama_mahasiswa || '';
                this.kecamatan_puspaga = newData.kecamatan_puspaga || '';
                this.description = newData.description || '';
                this.previewThumbnailSrc = newData.file_thumbnail || null;
            }
        },
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
        onSubmit() {
            this.$ewpLoadingShow();

            const formData = new FormData();
            formData.append('_method', 'PUT');
            formData.append('title', this.title);
            formData.append('nim', this.nim);
            formData.append('nama_mahasiswa', this.nama_mahasiswa);
            formData.append('kecamatan_puspaga', this.kecamatan_puspaga);
            formData.append('description', this.description);
            formData.append('is_active', 1);

            if (this.file_thumbnail) {
                formData.append('file_thumbnail', this.file_thumbnail);
            }

            Api().post(`artikel/${this.data.id}`, formData)
                .then(() => {
                    this.$emit('onSuccess');
                    this.reset();
                    $("#modal-edit").modal('hide');
                    this.$swal({
                        title: "Berhasil!",
                        text: "Data artikel berhasil diperbarui.",
                        icon: "success",
                    });
                })
                .catch((error) => {
                    const message = error.response?.data?.message || 'Gagal memperbarui data.';
                    this.$swal({
                        title: "Error!",
                        text: message,
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
    },
};
</script>
