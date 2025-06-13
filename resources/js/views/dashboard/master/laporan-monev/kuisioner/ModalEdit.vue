<template>
    <dashboard-modal title="Edit Data Kuisioner Laporan Monev" id="modal-edit" dialog-class="modal-bs">
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
        <template v-if="category.id">
            <label class="form-label fw-bolder fs-6 mb-3">Sub Kategori</label>
            <app-select-single
                v-model="subcategory"
                :placeholder="'Pilih Sub Kategori'"
                :loading="pageStatus == 'subcategory-load'"
                :options="list_subcategory"
                :serverside="true"
                @change-search="getSubcategory"
                class="mb-5"
            />
        </template>
        <label class="form-label fw-bolder fs-6 mb-3">Pertanyaan</label>
        <input type="text" class="form-control mb-5" v-model="question" placeholder="Isi pertanyaan">
        <label class="form-label fw-bolder fs-6 mb-3">Kode</label>
        <input type="text" class="form-control mb-5" v-model="key" placeholder="Kode input yang unik">
        <label class="form-label fw-bolder fs-6 mb-3">Tipe Input</label>
        <select class="form-select mb-5" v-model="inputType">
            <option value="" disabled>PILIH TIPE INPUT</option>
            <option v-for="opt in optionsLaporanMonevKuesionerInputType" :value="opt.id">{{ opt.text }}</option>
        </select>
        <template v-if="inputType == laporanMonevKuesionerInputType.RADIO.value">
            <label class="form-label fw-bolder fs-6 mb-3">Opsi Input</label>
            <textarea type="text" class="form-control mb-5" v-model="inputOptions" placeholder="Isi nama" rows="3"></textarea>
        </template>
        <label class="form-label fw-bolder fs-6 mb-3">Order</label>
        <input type="number" min="0" class="form-control mb-5" v-model="order" placeholder="Urutan Sub Kategori">
        <label class="form-label fw-bolder fs-6 mb-3">Validasi</label>
        <input type="text" min="0" class="form-control" v-model="validationRules" placeholder="Validasi input, ex: required|string" aria-describedby="passwordHelpBlock">
        <small id="passwordHelpBlock" class="form-text text-muted mb-5">
           Validasi-validasi yang ada bisa dilihat <a target="_blank" href="https://laravel.com/docs/9.x/validation">di sini</a>
        </small>
        <label class="form-label fw-bolder fs-6 mb-4 mt-5">Kecualikan dari export data?</label>
        <div class="form-check form-switch mb-6">
            <input class="form-check-input" type="checkbox" role="switch" id="is_active" v-model="is_excluded_export">
            <label class="form-check-label" for="is_active">Ya</label>
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
    data: () => ({
        question: '',
        order: null,
        inputType: '',
        inputOptions: '',
        validationRules: '',
        category: {},
        list_category: [],
        subcategory: {},
        list_subcategory: [],
        pageStatus: 'standby',
        is_excluded_export: false,
        key: '',
    }),
    watch: {
        data(n, p){
            this.question = n.question;
            this.order = n.order;
            this.inputType = n.input_type;
            this.inputOptions = n.input_options;
            this.subcategory = {id:n.sub_kategori.id, text:n.sub_kategori.name};
            this.category = {id:n.sub_kategori.kategori.id, text:n.sub_kategori.kategori.name};
            this.validationRules = n.validation_rules;
            this.is_excluded_export = n.is_excluded_export;
            this.key = n.key;
        }
    },
    methods: {
        reset(){
            this.question = '';
            this.order = null;
            this.inputType = null;
            this.inputOptions = '';
            this.validationRules = '';
            this.key = '';
            this.is_excluded_export = false;
        },
        onSubmit(){
            this.$ewpLoadingShow();

            let formData = {
                id_sub_kategori_laporan_monev: this.subcategory.id,
                question: this.question,
                input_type: this.inputType,
                input_options: this.inputOptions,
                validation_rules: this.validationRules,
                order: this.order,
                key: this.key,
                is_excluded_export: this.is_excluded_export,
                _method: 'PUT',
            }

            Api().post(`m-kuesioner-laporan-monev/${this.data.id}`, formData)
                .then(response => {
                    $("#modal-edit").modal('hide');
                    this.$emit('onSuccess');
                    this.reset();

                    this.$swal({
                        title: "Berhasil!",
                        text: 'Memperbarui data kuisioner laporan monev',
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
            },
        getSubcategory(keyword, limit) {

                this.pageStatus = 'subcategory-load';

                Api().get(`m-sub-kategori-laporan-monev/lists?limit=${limit}&search=${keyword}&id_kategori_laporan_monev=${this.category.id}`)
                    .then(response => {

                        this.list_subcategory = [];

                        for (let i = 0; i < response.data.data.length; i++) {
                            this.list_subcategory.push({
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
            },
    },
    computed: {
        optionsLaporanMonevKuesionerInputType(){
            return this.$store.state.enums.optionsLaporanMonevKuesionerInputType;
        },
        laporanMonevKuesionerInputType(){
            return this.$store.state.enums.laporanMonevKuesionerInputType;
        },
    }
}
</script>