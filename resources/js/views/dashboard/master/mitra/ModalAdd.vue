<template>
    <dashboard-modal title="Tambah Data Mitra" id="modal-tambah" dialog-class="modal-bs">
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
    props: ['kategoriMitraOptions'],
    data: () => ({
        kategoriMitra: '',
        name: '',
        foto: null,
        address: '',
        phone: '',
    }),
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
            this.$ewpLoadingShow();

            const formData = new FormData();
            formData.append('name', this.name);
            formData.append('address', this.address);
            formData.append('phone', this.phone);
            formData.append('id_kategori_mitra', this.kategoriMitra);
            formData.append('is_active', 1);
            if(this.foto){
                formData.append('foto', this.foto);
            }


            Api().post('mitra', formData)
                .then(response => {
                    $("#modal-tambah").modal('hide');
                    this.$emit('onSuccess');
                    this.reset();

                    this.$swal({
                        title: "Berhasil!",
                        text: 'Menambahkan data mitra',
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