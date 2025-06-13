<template>
    <div id="kt_body"
        class="bg-white header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed toolbar-tablet-and-mobile-fixed aside-enabled aside-fixed"
        style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">
        <div class="d-flex flex-column flex-root">

            <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed login-wrapper"
                id="page-bg" :style="`background-size: cover;background-image: url('${bg_login}')`">
                <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-30">
                    <div class="w-100 w-md-450px bg-white rounded shadow-xs p-10 p-lg-15 mx-auto">

                        <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" action="#">

                            <div class="text-center mb-10">
                                <h1 class="text-dark mb-3">Registrasi Mahasiswa</h1>
                            </div>

                            <div class="fv-row mb-6">
                                <label class="form-label fs-6 text-gray-500" :class="{'text-danger': v$.name.$error}">Nama Lengkap</label>
                                <input v-model="name" class="form-control form-control-lg" type="text" autocomplete="off" />
                                <div v-if="v$.name.$error" class="text-danger">Wajib diisi</div>
                            </div>
                            <div class="fv-row mb-6">
                                <label class="form-label fs-6 text-gray-500" :class="{'text-danger': v$.email.$error}">Email</label>
                                <input v-model="email" class="form-control form-control-lg" type="email" autocomplete="off" />
                                <div v-if="v$.email.$error" class="text-danger">Wajib diisi dan berupa email yang valid</div>
                            </div>
                            <div class="fv-row mb-6">
                                <label class="form-label fs-6 text-gray-500" :class="{'text-danger': v$.nik.$error}">NIK</label>
                                <input v-model="nik" class="form-control form-control-lg" type="text" autocomplete="off" maxlength="16" />
                                <div v-if="v$.nik.$error" class="text-danger">Wajib diisi dan harus 16 nomor</div>
                            </div>
                            <div class="fv-row mb-6">
                                <label class="form-label fs-6 text-gray-500" :class="{'text-danger': v$.nim.$error}">NIM</label>
                                <input v-model="nim" class="form-control form-control-lg" type="text" autocomplete="off" maxlength="16" />
                                <div v-if="v$.nim.$error" class="text-danger">Wajib diisi dan harus 16 nomor</div>
                            </div>
                            <div class="fv-row mb-6">
                                <label class="form-label fs-6 text-gray-500" :class="{'text-danger': v$.tempatLahir.$error}">Tempat Lahir</label>
                                <app-select-single v-model="tempatLahir"
                                    :placeholder="'Pilih kota/kabupaten'"
                                    :show_button_clear="false"
                                    :options="tempatLahirOptions" :serverside="true"
                                    :loading="pageStatus == 'tempat-lahir-load'"
                                    @change-search="getTempatLahir"
                                >
                                </app-select-single>
                                <div v-if="v$.tempatLahir.$error" class="text-danger">Wajib diisi</div>
                            </div>
                            <div class="fv-row mb-6">
                                <label class="form-label fs-6 text-gray-500" :class="{'text-danger': v$.tanggalLahir.$error}">Tanggal Lahir</label>
                                <input v-model="tanggalLahir" class="form-control form-control-lg" type="date" />
                                <div v-if="v$.tanggalLahir.$error" class="text-danger">Wajib diisi</div>
                            </div>
                            <div class="fv-row mb-6">
                                <label class="form-label fs-6 text-gray-500" :class="{'text-danger': v$.whatsapp.$error}">No. HP (Whatsapp)</label>
                                <input v-model="whatsapp" class="form-control form-control-lg" type="text" autocomplete="off" />
                                <div v-if="v$.whatsapp.$error" class="text-danger">Wajib diisi</div>
                            </div>
                            <div class="fv-row mb-6">
                                <label class="form-label fs-6 text-gray-500" :class="{'text-danger': v$.statusMahasiswa.$error}">Status Mahasiswa</label>
                                <app-select-single v-model="statusMahasiswa"
                                    :placeholder="'Pilih Status'"
                                    :show_button_clear="false"
                                    :options="statusMahasiswaOptions" :serverside="true"
                                    :loading="pageStatus == 'status-mahasiswa-load'"
                                    @change-search="getStatusMahasiswa"
                                >
                                </app-select-single>
                                <div v-if="v$.statusMahasiswa.$error" class="text-danger">Wajib diisi</div>
                            </div>
                            <div class="fv-row mb-6">
                                <label class="form-label fs-6 text-gray-500" :class="{'text-danger': v$.jenisMahasiswa.$error}">Jenis Mahasiswa</label>
                                <app-select-single v-model="jenisMahasiswa"
                                    :placeholder="'Pilih Jenis'"
                                    :show_button_clear="false"
                                    :options="jenisMahasiswaOptions" :serverside="true"
                                    :loading="pageStatus == 'jenis-mahasiswa-load'"
                                    @change-search="getJenisMahasiswa"
                                >
                                </app-select-single>
                                <div v-if="v$.jenisMahasiswa.$error" class="text-danger">Wajib diisi</div>
                            </div>
                            <div class="fv-row mb-6">
                                <label class="form-label fs-6 text-gray-500" :class="{'text-danger': v$.jurusan.$error}">Jurusan</label>
                                <app-select-single v-model="jurusan"
                                    :placeholder="'Pilih jurusan'"
                                    :show_button_clear="false"
                                    :options="jurusanOptions" :serverside="true"
                                    :loading="pageStatus == 'jurusan-load'"
                                    @change-search="getJurusan"
                                >
                                </app-select-single>
                                <div v-if="v$.jurusan.$error" class="text-danger">Wajib diisi</div>
                            </div>
                            <div class="fv-row mb-6">
                                <label class="form-label fs-6 text-gray-500" :class="{'text-danger': v$.semester.$error}">Semester</label>
                                <input v-model="semester" class="form-control form-control-lg" type="number" autocomplete="off" />
                                <div v-if="v$.semester.$error" class="text-danger">Wajib diisi</div>
                            </div>
                            <div class="fv-row mb-6">
                                <label class="form-label fs-6 text-gray-500" :class="{'text-danger': v$.ipk.$error}">IPK Terakhir</label>
                                <input v-model="ipk" class="form-control form-control-lg" type="number" autocomplete="off" />
                                <div v-if="v$.ipk.$error" class="text-danger">Wajib diisi</div>
                            </div>
                            <div class="fv-row mb-6">
                                <label class="form-label fs-6 text-gray-500" :class="{'text-danger': v$.asalUniversitas.$error}">Asal Universitas</label>
                                <app-select-single v-model="asalUniversitas"
                                    :placeholder="'Pilih asal universitas'"
                                    :show_button_clear="false"
                                    :options="asalUniversitasOptions" :serverside="true"
                                    :loading="pageStatus == 'asal-universitas-load'"
                                    @change-search="getAsalUniversitas"
                                >
                                </app-select-single>
                                <div v-if="v$.asalUniversitas.$error" class="text-danger">Wajib diisi</div>
                            </div>

                            <h4 class="border-bottom mb-6 pt-2">Alamat KTP</h4>
                            <div class="fv-row mb-6">
                                <label class="form-label fs-6 text-gray-500" :class="{'text-danger': v$.address.$error}">Alamat</label>
                                <textarea v-model="address" class="form-control form-control-lg" type="text" autocomplete="off" placeholder="Alamat lengkap"></textarea>
                                <div v-if="v$.address.$error" class="text-danger">Wajib diisi</div>
                            </div>
                            <div class="row mb-6">
                                <div class="col-6">
                                    <label class="form-label fs-6 text-gray-500" :class="{'text-danger': v$.rt.$error}">RT</label>
                                    <input v-model="rt" class="form-control form-control-lg" type="number" min="1" autocomplete="off" placeholder="Nomor RT"/>
                                    <div v-if="v$.rt.$error" class="text-danger">Wajib diisi dengan nomor</div>
                                </div>
                                <div class="col-6">
                                    <label class="form-label fs-6 text-gray-500" :class="{'text-danger': v$.rw.$error}">RW</label>
                                    <input v-model="rw" class="form-control form-control-lg" type="number" min="1" autocomplete="off" placeholder="Nomor RW"/>
                                    <div v-if="v$.rw.$error" class="text-danger">Wajib diisi dengan nomor</div>
                                </div>
                            </div>
                            <div class="fv-row mb-6">
                                <label class="form-label fs-6 text-gray-500" :class="{'text-danger': v$.city.$error}">Asal Kota</label>
                                <app-select-single v-model="city"
                                    :placeholder="'Pilih kota/kabupaten'"
                                    :show_button_clear="false"
                                    :options="cityOptions" :serverside="true"
                                    :loading="pageStatus == 'city-load'"
                                    @change-search="getCity"
                                    @option-change="reset(['kecamatan', 'kelurahan'])"
                                >
                                </app-select-single>
                                <div v-if="v$.city.$error" class="text-danger">Wajib diisi</div>
                            </div>
                            <div class="fv-row mb-6">
                                <label class="form-label fs-6 text-gray-500" :class="{'text-danger': v$.kecamatan.$error}">Kecamatan</label>
                                <app-select-single v-model="kecamatan"
                                    :placeholder="'Pilih kecamatan'"
                                    :show_button_clear="false"
                                    :options="kecamatanOptions" :serverside="true"
                                    :loading="pageStatus == 'kecamatan-load'"
                                    @change-search="getKecamatan"
                                    @option-change="reset(['kelurahan'])"
                                    :disabled="disabledKecamatan"
                                >
                                </app-select-single>
                                <div v-if="v$.kecamatan.$error" class="text-danger">Wajib diisi</div>
                            </div>
                            <div class="fv-row mb-6">
                                <label class="form-label fs-6 text-gray-500" :class="{'text-danger': v$.kelurahan.$error}">Kelurahan</label>
                                <app-select-single v-model="kelurahan"
                                    :placeholder="'Pilih kelurahan'"
                                    :show_button_clear="false"
                                    :options="kelurahanOptions" :serverside="true"
                                    :loading="pageStatus == 'kelurahan-load'"
                                    @change-search="getKelurahan"
                                    :disabled="disabledKelurahan"
                                >
                                </app-select-single>
                                <div v-if="v$.kelurahan.$error" class="text-danger">Wajib diisi</div>
                            </div>

                            
                            <h4 class="border-bottom mb-6 pt-2">Alamat Domisili</h4>
                            <div class="form-check mb-6">
                                <input class="form-check-input" type="checkbox" v-model="domisiliSameKTP" id="domisiliSameKTP">
                                <label class="form-check-label" for="domisiliSameKTP">
                                    Alamat Domisili sama dengan Alamat KTP
                                </label>
                            </div>
                            <template v-if="!domisiliSameKTP">
                                <div class="fv-row mb-6">
                                    <label class="form-label fs-6 text-gray-500" :class="{'text-danger': v$.domisili.address.$error}">Alamat</label>
                                    <textarea v-model="domisili.address" class="form-control form-control-lg" type="text" autocomplete="off" placeholder="Alamat lengkap"></textarea>
                                    <div v-if="v$.domisili.address.$error" class="text-danger">Wajib diisi</div>
                                </div>
                                <div class="row mb-6">
                                    <div class="col-6">
                                        <label class="form-label fs-6 text-gray-500" :class="{'text-danger': v$.domisili.rt.$error}">RT</label>
                                        <input v-model="domisili.rt" class="form-control form-control-lg" type="number" min="1" autocomplete="off" placeholder="Nomor RW"/>
                                        <div v-if="v$.domisili.rt.$error" class="text-danger">Wajib diisi dengan nomor</div>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label fs-6 text-gray-500" :class="{'text-danger': v$.domisili.rw.$error}">RW</label>
                                        <input v-model="domisili.rw" class="form-control form-control-lg" type="number" min="1" autocomplete="off" placeholder="Nomor RT"/>
                                        <div v-if="v$.domisili.rw.$error" class="text-danger">Wajib diisi dengan nomor</div>
                                    </div>
                                </div>
                                <div class="fv-row mb-6">
                                    <label class="form-label fs-6 text-gray-500" :class="{'text-danger': v$.domisili.city.$error}">Asal Kota</label>
                                    <app-select-single v-model="domisili.city"
                                        :placeholder="'Pilih kota/kabupaten'"
                                        :show_button_clear="false"
                                        :options="cityDomisiliOptions" :serverside="true"
                                        :loading="pageStatus == 'city-domisili-load'"
                                        @change-search="getCityDomisili"
                                        @option-change="reset(['kecamatan-domisili', 'kelurahan-domisili'])"
                                    >
                                    </app-select-single>
                                    <div v-if="v$.domisili.city.$error" class="text-danger">Wajib diisi</div>
                                </div>
                                <div class="fv-row mb-6">
                                    <label class="form-label fs-6 text-gray-500" :class="{'text-danger': v$.domisili.kecamatan.$error}">Kecamatan</label>
                                    <app-select-single v-model="domisili.kecamatan"
                                        :placeholder="'Pilih kecamatan'"
                                        :show_button_clear="false"
                                        :options="kecamatanDomisiliOptions" :serverside="true"
                                        :loading="pageStatus == 'kecamatan-domisili-load'"
                                        @change-search="getKecamatanDomisili"
                                        @option-change="reset(['kelurahan-domisili'])"
                                        :disabled="disabledKecamatanDomisili"
                                    >
                                    </app-select-single>
                                    <div v-if="v$.domisili.kecamatan.$error" class="text-danger">Wajib diisi</div>
                                </div>
                                <div class="fv-row mb-6">
                                    <label class="form-label fs-6 text-gray-500" :class="{'text-danger': v$.domisili.kelurahan.$error}">Kelurahan</label>
                                    <app-select-single v-model="domisili.kelurahan"
                                        :placeholder="'Pilih kelurahan'"
                                        :show_button_clear="false"
                                        :options="kelurahanDomisiliOptions" :serverside="true"
                                        :loading="pageStatus == 'kelurahan-domisili-load'"
                                        @change-search="getKelurahanDomisili"
                                        :disabled="disabledKelurahanDomisili"
                                    >
                                    </app-select-single>
                                    <div v-if="v$.domisili.kelurahan.$error" class="text-danger">Wajib diisi</div>
                                </div>
                            </template>
                            <div class="fv-row mb-6">
                                <label class="form-label fs-6 text-gray-500" :class="{'text-danger': v$.foto.$error}">Unggah Foto Anda</label>
                                <input class="form-control form-control-lg" type="file" accept="image/*" v-on:change="onChangeFoto"/>
                                <div v-if="v$.foto.$error" class="text-danger">Wajib diisi</div>
                            </div>
                            <div class="fv-row mb-6">
                                <label class="form-label fs-6 text-gray-500" :class="{'text-danger': v$.fotoKTP.$error}">Unggah Foto KTP</label>
                                <input class="form-control form-control-lg" type="file" accept="image/*" v-on:change="onChangeKTP"/>
                                <div v-if="v$.fotoKTP.$error" class="text-danger">Wajib diisi</div>
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
                                    class="btn btn-lg my-2 px-16 bg-primary-custom" @click="onSubmit">
                                    <span class="indicator-label text-white">Daftar</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
            <ModalPernyataan :data="dataModalPernyataan" @onSubmit="register"/>
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
    email,
    requiredIf,
} from '@vuelidate/validators'

import ModalPernyataan from "./ModalPernyataan.vue";

export default {
    components: {ModalPernyataan},
    setup(){
        return {
            v$: useVuelidate(),
        }
    },
    data(){
        return {
            bg_login: this.$assetUrl() + 'extends/img/bg-login.png',
            cityOptions: [],
            kecamatanOptions: [],
            kelurahanOptions: [],
            cityDomisiliOptions: [],
            kecamatanDomisiliOptions: [],
            kelurahanDomisiliOptions: [],
            tempatLahirOptions: [],
            statusMahasiswaOptions: [],
            jenisMahasiswaOptions: [],
            asalUniversitasOptions: [],
            jurusanOptions: [],
            pageStatus: 'standby',
            name: '',
            nik: '',
            nim: '',
            tanggalLahir: '',
            tempatLahir: {},
            statusMahasiswa: {},
            jenisMahasiswa: {},
            jurusan: {},
            semester: '',
            ipk: '',
            asalUniversitas: {},
            city: {},
            kecamatan: {},
            kelurahan: {},
            rw: null,
            rt: null,
            address: '',
            whatsapp: null,
            email: '',
            username: '',
            password: '',
            passwordConfirm: '',
            hidePassword: true,
            hidePasswordConfirm: true,
            domisiliSameKTP: false,
            domisili: {
                city: {},
                kecamatan: {},
                kelurahan: {},
                rw: null,
                rt: null,
                address: '',
            },
            foto: null,
            fotoKTP: null,
            tandaTangan: null,
            dataModalPernyataan: {},
        }
    },
    validations(){
        return {
            name: { required },
            username: { required },
            nik: { required, numeric, minLength: minLength(16), maxLength: maxLength(16), },
            whatsapp: { required, numeric },
            email: { required, email },
            nim: {required},
            tanggalLahir: {required},
            tempatLahir: { required },
            statusMahasiswa: { required },
            jenisMahasiswa: {  },
            jurusan: { required },
            semester: { required, numeric },
            ipk: { required },
            asalUniversitas: { required },
            city: { required },
            kecamatan: { required },
            kelurahan: { required },
            rw: {required, numeric},
            rt: {required, numeric},
            address: {required},
            foto: {required},
            fotoKTP: {required},
            tandaTangan: {required},
            password: { required, minLength: minLength(6) },
            passwordConfirm: { required, minLength: minLength(6), sameAsPassword: sameAs(this.password), },
            domisili: {  
                city: { required: requiredIf(()=>!this.domisiliSameKTP) },
                kecamatan: { required: requiredIf(()=>!this.domisiliSameKTP) },
                kelurahan: { required: requiredIf(()=>!this.domisiliSameKTP) },
                rw: { required: requiredIf(()=>!this.domisiliSameKTP), numeric},
                rt: { required: requiredIf(()=>!this.domisiliSameKTP), numeric},
                address: { required: requiredIf(()=>!this.domisiliSameKTP)},
            }
        }
    },
    methods: {
        showHidePassword() {
            this.hidePassword = !this.hidePassword
        },
        showHidePasswordConfirm() {
            this.hidePasswordConfirm = !this.hidePasswordConfirm
        },
        onSubmit(){
            const ttd = this.$refs.tandaTangan.saveSignature();

            this.tandaTangan = ttd.data;

            this.v$.$touch();
            if (this.v$.$error) {
                return false;
            }

            this.dataModalPernyataan = {
                name: this.name,
                email: this.email,
                nik: this.nik,
                statusMahasiswa: this.statusMahasiswa.text,
                jenisMahasiswa: this.jenisMahasiswa.text,
                jurusan: this.jurusan.text,
                semester: this.semester,
                ipk: this.ipk,
                asalUniversitas: this.asalUniversitas.text,
                address: this.address,
                rt: this.rt,
                rw: this.rw,
                kelurahan: this.kelurahan.text,
                kecamatan: this.kecamatan.text,
                city: this.city.text,
                foto: URL.createObjectURL(this.foto),
                tandaTangan: ttd.data,
                city: this.domisiliSameKTP ? this.city.text : this.domisili.city.text,
            }
            $("#modal-pernyataan").modal('show');
        },
        register(){
            $("#modal-pernyataan").modal('hide');
            this.$ewpLoadingShow();

            const ttd = this.$refs.tandaTangan.saveSignature();

            const formData = new FormData();

            formData.set('name', this.name);
            formData.set('username', this.username);
            formData.set('password', this.password);
            formData.set('password_confirmation', this.password);

            formData.set('id_kabupaten_lahir', this.city.id);
            formData.set('id_pendidikan_terakhir', this.statusMahasiswa.id);
            formData.set('id_jenis_mahasiswa', this.jenisMahasiswa.id);
            formData.set('id_jurusan', this.jurusan.id);
            formData.set('id_instansi_pendidikan', this.asalUniversitas.id);
            formData.set('id_kelurahan_kk', this.kelurahan.id);
            
            formData.set('email', this.email);
            formData.set('nim', this.nim);
            formData.set('nik', this.nik);
            formData.set('birth_date', this.tanggalLahir);
            formData.set('phone', this.whatsapp);
            formData.set('semester', this.semester);
            formData.set('ipk', this.ipk);
            formData.set('kk_address', this.address);
            formData.set('kk_rw', this.rw);
            formData.set('kk_rt', this.rt);
            formData.set('status', 3); // belum bertugas
            formData.set('is_active', 1);

            if(this.domisiliSameKTP){
                formData.set('id_kelurahan_domisili', this.kelurahan.id);
                formData.set('domicile_address', this.address);
                formData.set('domicile_rw', this.rw);
                formData.set('domicile_rt', this.rt);
            }else{
                formData.set('id_kelurahan_domisili', this.domisili.kelurahan.id);
                formData.set('domicile_address', this.domisili.address);
                formData.set('domicile_rw', this.domisili.rw);
                formData.set('domicile_rt', this.domisili.rt);
            }

            formData.set('file_foto', this.foto);
            formData.set('file_ktp', this.fotoKTP);
            formData.set('file_ttd', this.tandaTangan);

            Api().post('public/mahasiswa-register', formData)
                .then(response => {

                    this.$swal({
                        title: "Berhasil!",
                        text: 'Registrasi Mahasiswa, Silahkan login',
                        icon: "success",
                    });

                    this.$router.replace({
                        name: 'login'
                    })
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
            this.getSelectList(`public/list-kabupaten?limit=${limit}&search=${keyword}`, 'cityOptions', 'city-load');
        },
        getTempatLahir(keyword, limit) {
            this.getSelectList(`public/list-kabupaten?limit=${limit}&search=${keyword}`, 'tempatLahirOptions', 'tempat-lahir-load');
        },
        getKecamatan(keyword, limit) {
            this.getSelectList(`public/list-kecamatan?limit=${limit}&search=${keyword}&id_kabupaten=${this.city.id}`, 'kecamatanOptions', 'kecamatan-load');
        },
        getKelurahan(keyword, limit) {
            this.getSelectList(`public/list-kelurahan?limit=${limit}&search=${keyword}&id_kecamatan=${this.kecamatan.id}`, 'kelurahanOptions', 'kelurahan-load');
        },
        getCityDomisili(keyword, limit) {
            this.getSelectList(`public/list-kabupaten?limit=${limit}&search=${keyword}`, 'cityDomisiliOptions', 'city-domisili-load');
        },
        getKecamatanDomisili(keyword, limit) {
            this.getSelectList(`public/list-kecamatan?limit=${limit}&search=${keyword}&id_kabupaten=${this.domisili.city.id}`, 'kecamatanDomisiliOptions', 'kecamatan-domisili-load');
        },
        getKelurahanDomisili(keyword, limit) {
            this.getSelectList(`public/list-kelurahan?limit=${limit}&search=${keyword}&id_kecamatan=${this.domisili.kecamatan.id}`, 'kelurahanDomisiliOptions', 'kelurahan-domisili-load');
        },
        getJenisMahasiswa(keyword, limit) {
            this.getSelectList(`public/list-jenis-mahasiswa?limit=${limit}&search=${keyword}`, 'jenisMahasiswaOptions', 'jenis-mahasiswa-load');
        },
        getStatusMahasiswa(keyword, limit) {
            this.getSelectList(`public/list-pendidikan-terakhir?limit=${limit}&search=${keyword}`, 'statusMahasiswaOptions', 'status-mahasiswa-load');
        },
        getAsalUniversitas(keyword, limit) {
            this.getSelectList(`public/list-instansi-pendidikan?limit=${limit}&search=${keyword}`, 'asalUniversitasOptions', 'asal-universitas-load');
        },
        getJurusan(keyword, limit) {
            this.getSelectList(`public/list-jurusan?limit=${limit}&search=${keyword}`, 'jurusanOptions', 'jurusan-load');
        },
        reset(arrayField=[]){
            if(arrayField.includes('kecamatan')){
                this.kecamatan = {}
            }
            if(arrayField.includes('kelurahan')){
                this.kelurahan = {}
            }
            if(arrayField.includes('kecamatan-domisili')){
                this.domisili.kecamatan = {}
            }
            if(arrayField.includes('kelurahan-domisili')){
                this.domisili.kelurahan = {}
            }
        },
        onChangeFoto(e){
            const [file] = e.target.files;
            this.foto = file;
        },
        onChangeKTP(e){
            const [file] = e.target.files;
            this.fotoKTP = file;
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
        disabledKecamatanDomisili(){
            return !this.domisili.city?.id
        },
        disabledKelurahanDomisili(){
            return !this.domisili.kecamatan?.id
        },
    },
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