<template>
    <div id="kt_body"
        class="bg-white header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed toolbar-tablet-and-mobile-fixed aside-enabled aside-fixed"
        style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">
        <div class="d-flex flex-column flex-root">

            <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed login-wrapper"
                id="page-bg" :style="`background-size: cover;background-image: url('${bg_login}')`">
                <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
                    <div class="w-100 w-md-450px bg-white rounded shadow-xs p-10 p-lg-15 mx-auto">

                        <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" action="#">

                            <div class="text-center mb-10">
                                <h1 class="text-dark mb-3">Registrasi Warga</h1>
                            </div>

                            <div class="fv-row mb-6">
                                <label class="form-label fs-6 text-gray-500" :class="{'text-danger': v$.name.$error}">Nama Lengkap (sesuai KTP)</label>
                                <input v-model="name" class="form-control form-control-lg" type="text" autocomplete="off" />
                                <div v-if="v$.name.$error" class="text-danger">Wajib diisi</div>
                            </div>
                            <div class="fv-row mb-6">
                                <label class="form-label fs-6 text-gray-500" :class="{'text-danger': v$.nik.$error}">NIK (sesuai KTP)</label>
                                <input v-model="nik" class="form-control form-control-lg" type="text" autocomplete="off" maxlength="16" />
                                <div v-if="v$.nik.$error" class="text-danger">Wajib diisi dan harus 16 nomor</div>
                            </div>
                            <div class="fv-row mb-6">
                                <label class="form-label fs-6 text-gray-500" :class="{'text-danger': v$.city.$error}">Asal Kota (Sesuai KTP)</label>
                                <app-select-single v-model="city"
                                    :placeholder="'Pilih kota/kabupaten'"
                                    :show_button_clear="false"
                                    :options="cityOptions" :serverside="true"
                                    :loading="pageStatus == 'city-load'"
                                    @change-search="getCity"
                                    @option-change="reset(['kecamatan', 'kelurahan', 'rt', 'rw', 'address'])"
                                >
                                </app-select-single>
                                <div v-if="v$.city.$error" class="text-danger">Wajib diisi</div>
                            </div>
                            <div class="fv-row mb-6">
                                <label class="form-label fs-6 text-gray-500" :class="{'text-danger': v$.kecamatan.$error}">Kecamatan (Sesuai KTP)</label>
                                <app-select-single v-model="kecamatan"
                                    :placeholder="'Pilih kecamatan'"
                                    :show_button_clear="false"
                                    :options="kecamatanOptions" :serverside="true"
                                    :loading="pageStatus == 'kecamatan-load'"
                                    @change-search="getKecamatan"
                                    @option-change="reset(['kelurahan', 'rt', 'rw', 'address'])"
                                    :disabled="disabledKecamatan"
                                >
                                </app-select-single>
                                <div v-if="v$.kecamatan.$error" class="text-danger">Wajib diisi</div>
                            </div>
                            <div class="fv-row mb-6">
                                <label class="form-label fs-6 text-gray-500" :class="{'text-danger': v$.kelurahan.$error}">Kelurahan (Sesuai KTP)</label>
                                <app-select-single v-model="kelurahan"
                                    :placeholder="'Pilih kelurahan'"
                                    :show_button_clear="false"
                                    :options="kelurahanOptions" :serverside="true"
                                    :loading="pageStatus == 'kelurahan-load'"
                                    @change-search="getKelurahan"
                                    @option-change="reset(['rt', 'rw', 'address'])"
                                    :disabled="disabledKelurahan"
                                >
                                </app-select-single>
                                <div v-if="v$.kelurahan.$error" class="text-danger">Wajib diisi</div>
                            </div>
                            <div class="fv-row mb-6">
                                <label class="form-label fs-6 text-gray-500" :class="{'text-danger': v$.rt.$error}">RT (Sesuai KTP)</label>
                                <input v-model="rt" class="form-control form-control-lg" type="number" min="1" autocomplete="off" :disabled="disabledRTRW" placeholder="Nomor RT"/>
                                <div v-if="v$.rt.$error" class="text-danger">Wajib diisi dengan nomor</div>
                            </div>
                            <div class="fv-row mb-6">
                                <label class="form-label fs-6 text-gray-500" :class="{'text-danger': v$.rw.$error}">RW (Sesuai KTP)</label>
                                <input v-model="rw" class="form-control form-control-lg" type="number" min="1" autocomplete="off" :disabled="disabledRTRW" placeholder="Nomor RW"/>
                                <div v-if="v$.rw.$error" class="text-danger">Wajib diisi dengan nomor</div>
                            </div>
                            <div class="fv-row mb-6">
                                <label class="form-label fs-6 text-gray-500" :class="{'text-danger': v$.address.$error}">Alamat (Sesuai KTP)</label>
                                <textarea v-model="address" class="form-control form-control-lg" type="text" autocomplete="off" placeholder="Alamat lengkap"></textarea>
                                <div v-if="v$.address.$error" class="text-danger">Wajib diisi</div>
                            </div>
                            <div class="fv-row mb-6">
                                <label class="form-label fs-6 text-gray-500" :class="{'text-danger': v$.fotoKTP.$error}">Unggah KTP</label>
                                <input class="form-control form-control-lg" type="file" accept="image/*" v-on:change="onChangeKTP"/>
                                <div v-if="v$.fotoKTP.$error" class="text-danger">Wajib diisi</div>
                            </div>
                            <div class="fv-row mb-6">
                                <label class="form-label fs-6 text-gray-500" :class="{'text-danger': v$.fileKK.$error}">Unggah KK</label>
                                <input class="form-control form-control-lg" type="file" accept="image/*" v-on:change="onChangeKK"/>
                                <div v-if="v$.fileKK.$error" class="text-danger">Wajib diisi</div>
                            </div>
                            <div class="fv-row mb-6">
                                <label class="form-label fs-6 text-gray-500" :class="{'text-danger': v$.whatsapp.$error}">Nomor Whatsapp</label>
                                <input v-model="whatsapp" class="form-control form-control-lg" type="text" autocomplete="off" />
                                <div v-if="v$.whatsapp.$error" class="text-danger">Wajib diisi</div>
                            </div>
                            <div class="fv-row mb-6">
                                <label class="form-label fs-6 text-gray-500" :class="{'text-danger': v$.email.$error}">Email</label>
                                <input v-model="email" class="form-control form-control-lg" type="email" autocomplete="off" />
                                <div v-if="v$.email.$error" class="text-danger">Wajib diisi dan berupa email yang valid</div>
                            </div>
                            <div class="fv-row mb-6">
                                <label class="form-label fs-6 text-gray-500" :class="{'text-danger': v$.tandaTangan.$error}">Tanda Tangan</label>
                                <signature-pad ref="tandaTangan" height="200px" class="form-control" style="padding: 0!important;" />
                                <div v-if="v$.tandaTangan.$error" class="text-danger">Wajib diisi</div>
                                <div class="d-flex mt-2">
                                    <button class="btn btn-sm btn-secondary" @click="undoSignature" type="button">Undo</button>
                                </div>
                            </div>
                            <div class="fv-row mb-6">
                                <label class="form-label fs-6 text-gray-500" :class="{'text-danger': v$.username.$error}">Username</label>
                                <input v-model="username" class="form-control form-control-lg" type="text" autocomplete="off" />
                                <div v-if="v$.username.$error" class="text-danger">Wajib diisi</div>
                            </div>
                            <div class="fv-row mb-6">
                                <div class="d-flex flex-stack justify-content-between mb-2 align-items-center">
                                    <label class="form-label text-gray-500 fs-6 mb-0" :class="{'text-danger': v$.password.$error}">Password</label>
                                </div>
                                <input v-model="password"
                                    class="form-control form-control-lg" :type="hidePassword ? 'password' : 'text'"
                                    id="password" autocomplete="off" />
                                <i id="icon-password" class="icon-password" @click="showHidePassword"
                                    :class="hidePassword ? 'fa fa-eye' : 'fa fa-eye-slash'"></i>
                                <div v-if="v$.password.$error" class="text-danger">Panjang minimal 8 karakter!</div>
                            </div>
                            <div class="fv-row mb-6">
                                <div class="d-flex flex-stack justify-content-between mb-2 align-items-center">
                                    <label class="form-label text-gray-500 fs-6 mb-0" :class="{'text-danger': v$.passwordConfirm.$error}">Konfirmasi Password</label>
                                </div>
                                <input v-model="passwordConfirm"
                                    class="form-control form-control-lg" :type="hidePasswordConfirm ? 'password' : 'text'"
                                    id="password-confirm" autocomplete="off" />
                                <i id="icon-password" class="icon-password" @click="showHidePasswordConfirm"
                                    :class="hidePasswordConfirm ? 'fa fa-eye' : 'fa fa-eye-slash'"></i>
                                <div v-if="v$.passwordConfirm.$error" class="text-danger">Panjang minimal 8 karakter! dan sama dengan input password</div>
                            </div>

                            <div class="text-center">
                                <button type="button" id="kt_sign_in_submit"
                                    class="btn btn-lg my-2 px-16 bg-primary-custom" @click="register">
                                    <span class="indicator-label text-white">Daftar</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

        </div>
    </div>
</template>

<script>
import Api from "@/services/api";

import useVuelidate from '@vuelidate/core'
import {
    required,
    sameAs,
    minLength,
    maxLength,
    numeric,
    email
} from '@vuelidate/validators'

export default {
    setup(){
        return {
            v$: useVuelidate(),
        }
    },
    data(){
        return {
            bg_login: this.$assetUrl() + 'extends/img/bg-login.png',
            name: '',
            nik: '',
            city: {},
            kecamatan: {},
            kelurahan: {},
            rw: null,
            rt: null,
            address: '',
            fotoKTP: null,
            fileKK: null,
            tandaTangan: null,
            whatsapp: null,
            email: '',
            username: '',
            password: '',
            passwordConfirm: '',
            hidePassword: true,
            hidePasswordConfirm: true,
            cityOptions: [],
            kecamatanOptions: [],
            kelurahanOptions: [],
            pageStatus: 'standby',
        }
    },
    validations(){
        return {
            name: { required },
            username: { required },
            nik: { required, numeric, minLength: minLength(16), maxLength: maxLength(16), },
            whatsapp: { required, numeric },
            email: { required, email },
            city: { required },
            kecamatan: { required },
            kelurahan: { required },
            rw: {required, numeric},
            rt: {required, numeric},
            address: {required},
            fotoKTP: {required},
            fileKK: {required},
            tandaTangan: {required},
            password: { required, minLength: minLength(6) },
            passwordConfirm: { required, minLength: minLength(6), sameAsPassword: sameAs(this.password), },
        }
    },
    methods: {
        showHidePassword() {
            this.hidePassword = !this.hidePassword
        },
        showHidePasswordConfirm() {
            this.hidePasswordConfirm = !this.hidePasswordConfirm
        },
        register(){
            this.$ewpLoadingShow();

            const ttd = this.$refs.tandaTangan.saveSignature();

            this.tandaTangan = ttd.data;

            this.v$.$touch();
            if (this.v$.$error) {
                return false;
            }

            const formValues = {
                name: this.name,
                username: this.username,
                password: this.password,
                
                nik: this.nik,
                phone: this.whatsapp,
                email: this.email,
                is_active: 1,
                id_kabupaten: this.city.id,
                id_kelurahan: this.kelurahan.id,
                rt: this.rt,
                rw: this.rw,
                address: this.address,
                password_confirmation: this.passwordConfirm,
            }
            let formData = new FormData()
            
            formData.set('file_ktp', this.fotoKTP);
            formData.set('file_kk', this.fileKK);
            formData.set('file_ttd', this.tandaTangan);

            Object.entries(formValues).forEach(([key, value])=>{
                formData.set(key, value)
            })

            Api().post('public/klien-konseling-register', formData)
                .then(response => {

                    this.$swal({
                        title: "Berhasil!",
                        text: 'Registrasi klien konseling',
                        icon: "success",
                    });

                    if(this.$route.query?.pathTo){
                        this.$router.replace({
                            name: 'login',
                            query: {
                                pathTo : this.$route.query.pathTo,
                            }
                        })
                    }else{
                        this.$router.replace({
                            name: 'login'
                        })
                    }
                })
                .catch(error => {
                    this.$axiosHandleError(error);
                }).finally(() => {
                    this.$ewpLoadingHide();
                });
        },
        getSelectList(url, listKey, pageStatus = 'select-load') {
            this.pageStatus = pageStatus

            Api().get(url)
                .then(response => {

                    this[listKey] = [];

                    for (let i = 0; i < response.data.data.length; i++) {
                        this[listKey].push({
                            id: response.data.data[i].id,
                            text: response.data.data[i].name,
                        });
                    }
                })
                .catch(error => {
                    this[listKey] = [];
                    this.$axiosHandleError(error);
                }).finally(() => {
                    this.pageStatus = 'standby';
                })
        },
        getCity(keyword, limit) {
            this.getSelectList(`public/list-kabupaten?limit=${limit}&search=${keyword}&is_surabaya=true`, 'cityOptions', 'city-load');
        },
        getKecamatan(keyword, limit) {
            this.getSelectList(`public/list-kecamatan?limit=${limit}&search=${keyword}&id_kabupaten=${this.city.id}`, 'kecamatanOptions', 'kecamatan-load');
        },
        getKelurahan(keyword, limit) {
            this.getSelectList(`public/list-kelurahan?limit=${limit}&search=${keyword}&id_kecamatan=${this.kecamatan.id}`, 'kelurahanOptions', 'kelurahan-load');
        },
        reset(arrayField=[]){
            if(arrayField.includes('kecamatan')){
                this.kecamatan = {}
            }
            if(arrayField.includes('kelurahan')){
                this.kelurahan = {}
            }
            if(arrayField.includes('rt')){
                this.rt = null;
            }
            if(arrayField.includes('rw')){
                this.rw = null
            }
            if(arrayField.includes('address')){
                this.address = ''
            }
        },
        onChangeKTP(e){
            const [file] = e.target.files;
            this.fotoKTP = file;
        },
        onChangeKK(e){
            const [file] = e.target.files;
            this.fileKK = file;
        },
        undoSignature(){
            this.$refs.tandaTangan.undoSignature();
        }
    },
    computed: {
        disabledKecamatan(){
            return !this.city?.id
        },
        disabledKelurahan(){
            return !this.kecamatan?.id
        },
        disabledRTRW(){
            return !this.kelurahan?.id
        },
    }
}
</script>

<style scoped>
    .icon-password {
        cursor: pointer;
        float: right;
        position: relative;
        bottom: 32px;
        right: 10px;
        font-size: 20px;
    }

</style>