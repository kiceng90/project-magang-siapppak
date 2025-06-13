<template>
    <dashboard-modal title="Edit Data Mitra" id="modal-edit" dialog-class="modal-bs">
        <label class="form-label fw-bolder fs-6 mb-3">Kategori Mitra</label>
        <select class="form-control mb-5" placeholder="Pilih Kategori Mitra" v-model="kategoriMitra">
            <option disabled value="">-- PILIH KATEGORI MITRA --</option>
            <option v-for="item in kategoriMitraOptions" :value="item.id">{{ item.text }}</option>
        </select>
        <label class="form-label fw-bolder fs-6 mb-3">Nama</label>
        <input type="text" class="form-control mb-5" v-model="name" placeholder="Isi nama">
        <label class="form-label fw-bolder fs-6 mb-3">Alamat</label>
        <input type="text" class="form-control mb-5" v-model="address" placeholder="Isi alamat">
        <label class="form-label fw-bolder fs-6 mb-3">Phone</label>
        <input type="text" class="form-control mb-5" v-model="phone" placeholder="Isi nomor telpon">
        <label class="form-label fw-bolder fs-6 mb-3">Foto</label>
        <input type="file" class="form-control mb-5" accept="image/*" v-on:change="onChangeFoto" ref="foto">
        
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
            kategoriMitra: '',
            name: '',
            foto: null,
            address: '',
            phone: '',
        }
    },
    props: ['data', 'kategoriMitraOptions'],
    watch: {
        data(n, p){
            if(n!==p){
                this.name = n.name || ''
                this.kategoriMitra = n.id_kategori_mitra
                this.foto = n.file_photo
                this.address = n.address || ''
                this.phone = n.phone || ''
            }
        }
    },
    methods: {
        reset(){
            this.kategoriMitra = '';
            this.name = '';
            this.foto = '';
            this.address = '';
            this.phone = '';
            this.$refs.foto.value = null
        },
        onSubmit(){
            const formData = new FormData();
            formData.append('_method', 'PUT');

            formData.append('name', this.name);
            formData.append('address', this.address);
            formData.append('phone', this.phone);
            formData.append('id_kategori_mitra', this.kategoriMitra);
            formData.append('is_active', 1);
            if(this.foto){
                formData.append('foto', this.foto);
            }
            
            this.$ewpLoadingShow();

            Api().post(`mitra/${this.data.id}`, formData)
                .then(response => {
                    $("#modal-edit").modal('hide');
                    this.$emit('onSuccess');
                    this.reset();

                    this.$swal({
                        title: "Berhasil!",
                        text: 'Memperbarui data mitra',
                        icon: "success",
                    })
                })
                .catch(error => {
                    this.$axiosHandleError(error);
                }).finally(() => {
                    this.$ewpLoadingHide();
                });
        },
        onChangeFoto(e){
            const [file] = e.target.files;
            this.foto = file
        },
    },
}
</script>