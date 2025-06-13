<template>
    <dashboard-modal title="Edit Data Sub Kategori Monev" id="modal-edit" dialog-class="modal-bs">
        <label class="form-label fw-bolder fs-6 mb-3">Kategori</label>
        <app-select-single
            v-model="category"
            :placeholder="'Pilih Kategori'"
            :loading="pageStatus == 'category-load'"
            :options="list_category"
            :serverside="true"
            @change-search="getCategory"
            class="mb-5"
        />
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
        category: {},
        order: null,
        list_category: [],
        pageStatus: 'standby',
    }),
    watch: {
        data(n, p){
            this.name = n.name;
            this.order = n.order;
            this.category = {id: n.kategori.id, text: n.kategori.name};
        }
    },
    methods: {
        reset(){
            this.name = '';
            this.order = null;
            this.category = {};
        },
        onSubmit(){
            this.$ewpLoadingShow();

            let formData = {
                name: this.name,
                order: this.order,
                id_kategori_laporan_monev: this.category.id,
                _method: 'PUT',
            }

            Api().post(`m-sub-kategori-laporan-monev/${this.data.id}`, formData)
                .then(response => {
                    $("#modal-edit").modal('hide');
                    this.$emit('onSuccess');
                    this.reset();

                    this.$swal({
                        title: "Berhasil!",
                        text: 'Memperbarui data sub kategori laporan monev',
                        icon: "success",
                    })
                })
                .catch(error => {
                    this.$axiosHandleError(error);
                }).finally(() => {
                    this.$ewpLoadingHide();
                });
        },
        getCategory(keyword, limit) {

                this.pageStatus = 'category-load';

                Api().get(`m-kategori-laporan-monev/lists?limit=${limit}&search=${keyword}`)
                    .then(response => {

                        this.list_category = [];

                        for (let i = 0; i < response.data.data.length; i++) {
                            this.list_category.push({
                                id: response.data.data[i].id,
                                text: response.data.data[i].name,
                            });
                        }

                    })
                    .catch(error => {
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.pageStatus = 'standby';
                    })
            }
    }
}
</script>