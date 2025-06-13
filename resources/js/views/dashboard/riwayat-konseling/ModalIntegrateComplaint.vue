<template>
    <dashboard-modal title="Masukkan ke Pengaduan" id="modal-masukkan-pengaduan" dialog-class="modal-bs">
        <label class="form-label fw-bolder fs-6 mb-3">Dokumentasi Konseling</label>
        <div id="dropzone-container-1">
            <div class="dropzone dropzone-file-area dz-clickable" id="dropzone-documentation-complaint">
                <div class="dz-message needsclick">
                    <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                    <div class="ms-4">
                        <h5 class="kt-dropzone__msg-title">Drop files here or click to upload</h5>
                        <span class="kt-dropzone__msg-desc text-primary">
                            Upload up to 10 files with the format .jpg/.jpeg/.png
                        </span>
                    </div>
                </div>
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
    props: ['data'],
    data(){
        return {
            ROLE_ADMIN_ID: process.env.MIX_ROLE_ADMIN_ID,
            ROLE_KONSELOR_ID: process.env.MIX_ROLE_KONSELOR_ID,
            dropzoneUpload: null,
        }
    },
    methods: {
        onSubmit(){
            const files = []
            if (!$.isEmptyObject(this.dropzoneUpload.files)) {
                for (let file in this.dropzoneUpload.files) {
                    files.push(this.dropzoneUpload.files[file])
                }
            }

            const formData = new FormData();
            formData.set('tanggal_pengaduan', this.data.date + " " + this.data.jadwal_detail.start_time + ":00");
            formData.set('uraian_singkat_permasalahan', this.data.description);
            files.forEach(img=>{
                formData.append('dokumentasi[]', img);
            })

            formData.set('nama_lengkap_pelapor', this.data.klien.name);
            formData.set('nik_pelapor', +this.data.klien.nik);
            formData.set('no_telepon_pelapor', this.data.klien.phone);
            if(this.data.klien.kabupaten.name === 'Surabaya'){
                formData.set('warga_surabaya_pelapor', 1);
            }
            formData.set('id_kabupaten_pelapor', this.data.klien.id_kabupaten);
            formData.set('alamat_pelapor', this.data.klien.address);

            formData.set('client_type', 2);
            formData.set('id_klien', this.data.klien.id);
            formData.set('nama_lengkap_klien', this.data.klien.name);
            formData.set('inisial_klien', this.data.klien.name);
            if(this.data.klien.nik){
                formData.set('nik_klien', +this.data.klien.nik);
                formData.set('is_has_nik', 1);
            }
            if(this.data.klien.kabupaten.name === 'Surabaya'){
                formData.set('warga_surabaya_klien', 1);
            }
            formData.set('id_kabupaten_klien', this.data.klien.id_kabupaten);
            formData.set('no_telepon_klien', this.data.klien.phone);
            formData.set('alamat_klien', this.data.klien.address);
            formData.set('id_kelurahan_klien', this.data.klien.id_kelurahan);

            formData.set('id_konseling', this.data.id);

            this.$ewpLoadingShow();

            let url = 'konselor-pengaduan-integrate';

            if(this.isAdmin){
                url = 'admin-pengaduan-integrate';
            }

            Api().post(url, formData)
                .then(() => {
                    $('#modal-masukkan-pengaduan').modal('hide');
                    this.dokumentasi = [];
                    this.$emit('onSuccess');
                    this.$swal({
                        title: "Berhasil!",
                        text: 'Memasukkan data konseling ke Pengaduan',
                        icon: "success",
                    });
                    this.reset();
                })
                .catch(error => {
                    this.$axiosHandleError(error);
                }).finally(() => {
                    this.$ewpLoadingHide();
                });
        },
        reset(){
            if(this.dropzoneUpload){
                this.dropzoneUpload.removeAllFiles(true);
                this.dropzoneUpload.files = [];
            }
        },
        initDropzone() {
            const that = this;
            this.dropzoneUpload = new Dropzone(
                "#dropzone-documentation-complaint", {
                    url: "/",
                    dictCancelUpload: "Cancel",
                    maxFilesize: 20,
                    parallelUploads: 1,
                    uploadMultiple: false,
                    maxFiles: 10,
                    addRemoveLinks: true,
                    acceptedFiles: '.png,.jpg,.jpeg',
                    autoProcessQueue: false,
                    init: function () {
                        this.on("error", function (file) {
                            if (!file.accepted) {
                                this.removeFile(file);
                                that.$swal('Silahkan periksa file Anda lagi');
                            } else if (file.status == 'error') {
                                this.removeFile(file);
                                that.$swal('Terjadi kesalahan koneksi');
                            }
                        });

                        this.on('resetFiles', function (file) {
                            this.removeAllFiles();
                        });
                    },
                });
        }
    },
    computed:{
        isAdmin(){
            return this.$store.state.profile.role_id == this.ROLE_ADMIN_ID;
        },
    },
    mounted(){
        this.initDropzone();
    }
}
</script>