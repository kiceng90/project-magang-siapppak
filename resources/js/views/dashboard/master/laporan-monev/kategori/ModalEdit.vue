<template>
    <dashboard-modal title="Edit Data Kategori Monev" id="modal-edit" dialog-class="modal-bs">
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
    props: ['data'],
    data: () => ({
        name: '',
        order: null,
    }),
    watch: {
        data(n, p){
            this.name = n.name;
            this.order = n.order;
        }
    },
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
                _method: 'PUT',
            }

            Api().post(`m-kategori-laporan-monev/${this.data.id}`, formData)
                .then(response => {
                    $("#modal-edit").modal('hide');
                    this.$emit('onSuccess');
                    this.reset();

                    this.$swal({
                        title: "Berhasil!",
                        text: 'Memperbarui data kategori laporan monev',
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