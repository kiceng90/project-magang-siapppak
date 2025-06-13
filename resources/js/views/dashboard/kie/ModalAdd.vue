<template>
    <dashboard-modal title="Tambah Data" id="modal-tambah" dialog-class="modal-lg">
        <label class="form-label fw-bolder fs-6 mb-3">Judul</label>
        <input type="text" class="form-control mb-5" v-model="title" placeholder="Isi judul">
        <label class="form-label fw-bolder fs-6 mb-3">Deskripsi</label>
        <app-editor class="form-control" v-model:content="description" ref="editor" contentType="html"></app-editor>
        <label class="form-label fw-bolder fs-6 mb-3 mt-5">Jenis Konten</label>
        <select class="form-control mb-5" placeholder="Pilih Jenis Konten" v-model="type" v-on:change="onChangeType">
            <option disabled value="">-- PILIH JENIS KONTEN --</option>
            <option v-for="item in contentTypeOptions" :value="item.id">{{ item.text }}</option>
        </select>
        <label v-if="type != ''" class="form-label fw-bolder fs-6 mb-3">Konten</label>
        <input v-if="type == enumType.GAMBAR.value" type="file" class="form-control" v-on:change="onChangeImage" accept="image/*" ref="file_image">
        <input v-if="type == enumType.PDF.value" type="file" class="form-control" v-on:change="onChangePdf" accept="application/pdf" ref="file_pdf">
        <input v-if="type == enumType.VIDEO.value" type="text" class="form-control mb-5" v-model="url_video_youtube" placeholder="Url video">
        <small v-if="type == enumType.GAMBAR.value || type == enumType.PDF.value" class="form-text text-muted mb-5 d-inline-block">
            Maksimal ukuran file yang dapat diunggah adalah 5 Mb.
        </small>
        <div class="row">
            <div class="col-lg-8">
                <label class="form-label fw-bolder fs-6 mb-3">Thumbnail</label>
                <input type="file" class="form-control" v-on:change="onThumbnailChange" accept="image/*" ref="thumbnail">
                <small class="form-text text-muted mb-5 d-inline-block">
                    Maksimal ukuran file yang dapat diunggah adalah 5 Mb.
                </small>
            </div>
            <div class="col-lg-4" v-if="previewThumbnailSrc != null">
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
    data(){
        return {
            type: '',
            title: '',
            description: '',
            file_thumbnail: null,
            file_image: null,
            file_pdf: null,
            url_video_youtube: '',
            previewThumbnailSrc: null,
        }
    },
    methods: {
        resetContentFiles(){
            if(this.$refs.file_image?.value) this.$refs.file_image.value = null;
            if(this.$refs.file_pdf?.value) this.$refs.file_pdf.value = null;
        },
        reset(){
            this.type = '';
            this.title = '';
            this.description = this.$refs.editor.setHTML('');
            this.file_thumbnail = null;
            this.file_image = null;
            this.file_pdf = null;
            this.url_video_youtube = '';
            this.previewThumbnailSrc = null;
            this.resetContentFiles();
            
            this.$refs.thumbnail.value = null;
        },
        onSubmit(){
            this.$ewpLoadingShow();

            const formData = new FormData();
            formData.append('title', this.title);
            formData.append('type', this.type);
            formData.append('file_thumbnail', this.file_thumbnail);
            formData.append('is_active', 1);

            if(this.file_image) formData.append('file_image', this.file_image);
            if(this.url_video_youtube) formData.append('url_video_youtube', this.url_video_youtube);
            if(this.file_pdf) formData.append('pdf', this.file_pdf);
            if(this.description) formData.append('description', this.description);

            Api().post('kie', formData)
                .then(response => {
                    $("#modal-tambah").modal('hide');
                    this.$emit('onSuccess');
                    this.reset();

                    this.$swal({
                        title: "Berhasil!",
                        text: 'Menambahkan data kie',
                        icon: "success",
                    })
                })
                .catch(error => {
                    this.$axiosHandleError(error);
                }).finally(() => {
                    this.$ewpLoadingHide();
                });
        },
        onThumbnailChange(e){
            const [file] = e.target.files

            this.file_thumbnail = file
            this.previewThumbnailSrc = URL.createObjectURL(file)
        },
        onChangeImage(e){
            this.file_image = e.target.files[0]
        },
        onChangePdf(e){
            this.file_pdf = e.target.files[0]
        },
        onChangeType(){
            this.resetContentFiles()
        }
    },
    computed: {
        contentTypeOptions(){
            return this.$store.state.enums.optionsJenisKie
        },
        enumType(){
            return this.$store.state.enums.jenisKie
        }
    }
}
</script>