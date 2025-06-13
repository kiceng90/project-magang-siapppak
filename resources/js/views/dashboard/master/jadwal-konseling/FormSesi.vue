<template>
    <div class="border rounded p-5 mb-5">
        <div class="form-group row mb-5">
            <label :for="`sesi-${data.id}-start`" class="col-sm-5 col-form-label">Sesi Awal Konsultasi</label>
            <div class="col-sm-7">
                <input type="time" class="form-control" :id="`sesi-${data.id}-start`" v-model="data.start">
            </div>
        </div>
        <div class="form-group row mb-5">
            <label :for="`sesi-${data.id}-end`" class="col-sm-5 col-form-label">Sesi Akhir Konsultasi</label>
            <div class="col-sm-7">
                <input type="time" class="form-control" :id="`sesi-${data.id}-end`" v-model="data.end">
            </div>
        </div>
        <div class="form-group row mb-5">
            <label :for="`sesi-${data.id}-category`" class="col-sm-5 col-form-label">Kategori Konsultasi</label>
            <div class="col-sm-7">
                <select class="form-control" placeholder="Pilih Kategori Konseling" :id="`sesi-${data.id}-category`" v-model="data.category">
                    <option disabled value="">-- PILIH KATEGORI KONSELING --</option>
                    <option v-for="o in kategoriKonselingOptions" :value="o.id">{{ o.text }}</option>
                </select>
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <button class="btn btn-sm btn-light" type="button" @click="onDelete">
                Hapus Sesi
            </button>
            <template v-if="isDataChanged">
                <button v-if="data.isNew" class="btn btn-sm bg-second-primary-custom text-white ms-2" type="button" @click="onSave">
                    Simpan
                </button>
                <button v-else class="btn btn-sm bg-second-primary-custom text-white ms-2" type="button" @click="onUpdate">
                    Ubah
                </button>
            </template>
        </div>
    </div>
</template>

<script>
import Api from "@/services/api";

export default {
    props: ['item', 'id_jadwal_konseling', 'kategoriKonselingOptions'],
    data(){
        return {
            data: {...this.item},
        };
    },
    methods: {
        onUpdate(){
            this.$ewpLoadingShow();

            let formData = {
                _method: 'PUT',
                id_jadwal_konseling: this.id_jadwal_konseling,
                start_time: this.data.start,
                end_time: this.data.end,
                id_kategori_konseling: this.data.category,
                is_active: true,
            }

            Api().post(`m-jadwal-konseling-detail/${this.data.id}`, formData)
                .then(response => {
                    this.$emit('onSuccess');

                    this.$swal({
                        title: "Berhasil!",
                        text: 'Memperbarui data sesi',
                        icon: "success",
                    })
                })
                .catch(error => {
                    this.$axiosHandleError(error);
                }).finally(() => {
                    this.$ewpLoadingHide();
                });
        },
        onSave(){
            this.$ewpLoadingShow();

            let formData = {
                id_jadwal_konseling: this.id_jadwal_konseling,
                start_time: this.data.start,
                end_time: this.data.end,
                id_kategori_konseling: this.data.category,
                is_active: true,
            }

            Api().post(`m-jadwal-konseling-detail`, formData)
                .then(response => {
                    this.$emit('onSuccess');

                    this.$swal({
                        title: "Berhasil!",
                        text: 'Menambah data sesi',
                        icon: "success",
                    })
                    
                    this.data.isNew = false;
                })
                .catch(error => {
                    this.$axiosHandleError(error);
                }).finally(() => {
                    this.$ewpLoadingHide();
                });
        },
        onDelete(){
            if(this.data.isNew){
                this.$emit('onRemoveSession');
            }else{
                Api().delete(`m-jadwal-konseling-detail/${this.data.id}`)
                    .then(response => {
                        this.$emit('onRemoveSession');
                        this.$emit('onSuccess');

                        this.$swal({
                            title: "Berhasil!",
                            text: 'Menghapus data sesi',
                            icon: "success",
                        })
                    })
                    .catch(error => {
                        this.$axiosHandleError(error);
                    }).finally(() => {
                        this.$ewpLoadingHide();
                    });
            }
        },
    },
    computed: {
        isDataChanged(){
            return this.data.start !== this.item.start || this.data.end !== this.item.end || this.data.category !== this.item.category
        }
    }
}
</script>