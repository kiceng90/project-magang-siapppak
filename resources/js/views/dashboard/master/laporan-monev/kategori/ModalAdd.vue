<template>
    <dashboard-modal title="Tambah Data Kategori Monev" id="modal-tambah" dialog-class="modal-bs">
        <label class="form-label fw-bolder fs-6 mb-3">Nama</label>
        <input type="text" class="form-control mb-5" v-model="name" placeholder="Isi nama">
        <label class="form-label fw-bolder fs-6 mb-3">Order</label>
        <input type="number" min="0" class="form-control mb-5" v-model="order" placeholder="Urutan Sub Kategori">
        
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
        order: null,
    }),
    methods: {
        reset(){
            this.name = '';
            this.order = null;
        },
        onSubmit(){
            this.$ewpLoadingShow();

            let formData = {
                name: this.name,
                order: this.order,
            }


            Api().post('m-kategori-laporan-monev', formData)
                .then(response => {
                    $("#modal-tambah").modal('hide');
                    this.$emit('onSuccess');
                    this.reset();

                    this.$swal({
                        title: "Berhasil!",
                        text: 'Menambahkan data kategori laporan monev',
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