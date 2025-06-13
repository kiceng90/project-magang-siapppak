<template>
    <dashboard-modal title="Tambah Jenis Mahasiswa" id="modal-tambah" dialog-class="modal-bs">
        <label class="form-label fw-bolder fs-6 mb-3">Nama</label>
        <input type="text" class="form-control mb-5" v-model="name" placeholder="Isi nama" @keydown.enter="onSubmit">
        
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
    data: () => ({
        name: '',
    }),
    methods: {
        reset(){
            this.name = ''
        },
        onSubmit(){
            this.$ewpLoadingShow();

            let formData = {
                name: this.name,
            }


            Api().post('m-jenis-mahasiswa', formData)
                .then(response => {
                    $("#modal-tambah").modal('hide');
                    this.$emit('onSuccess');
                    this.reset();

                    this.$swal({
                        title: "Berhasil!",
                        text: 'Menambahkan data jenis mahasiswa',
                        icon: "success",
                    })
                })
                .catch(error => {
                    this.$axiosHandleError(error);
                }).finally(() => {
                    this.$ewpLoadingHide();
                });
        }
    }
}
</script>