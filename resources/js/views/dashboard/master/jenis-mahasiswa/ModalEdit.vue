<template>
    <dashboard-modal title="Edit Jenis Mahasiswa" id="modal-edit" dialog-class="modal-bs">
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
    data(){
        return {
            name: '',
        }
    },
    props: ['data'],
    watch: {
        data(n, p){
            if(n!==p){
                this.name = n.name;
            }
        }
    },
    methods: {
        reset(){
            this.name = ''
        },
        onSubmit(){
            let formData = {
                name: this.name,
            }

            this.$ewpLoadingShow();

            Api().put(`m-jenis-mahasiswa/${this.data.id}`, formData)
                .then(response => {
                    $("#modal-edit").modal('hide');
                    this.$emit('onSuccess');
                    this.reset();

                    this.$swal({
                        title: "Berhasil!",
                        text: 'Memperbarui data jenis mahasiswa',
                        icon: "success",
                    });
                })
                .catch(error => {
                    this.$axiosHandleError(error);
                }).finally(() => {
                    this.$ewpLoadingHide();
                });
        },
    }
}
</script>