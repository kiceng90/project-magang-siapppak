<template>
    <div id="kt_body"
        class="bg-white header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed toolbar-tablet-and-mobile-fixed aside-enabled aside-fixed"
        style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">
        <div class="d-flex flex-column flex-root">
            <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed login-wrapper"
                id="page-bg" :style="`background-size: cover;background-image: url('${bg_login}')`">
                <div class="col-lg-4 d-flex" style="justify-content:flex-start; margin: 24px;">
                    <button type="button" class="btn" style="background-color:#fff8dd;"
                        @click="$router.back()">
                        <span class="text-warning d-flex">
                            <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.3"
                                    d="M17.4166 10.0846C17.9228 10.0846 18.3333 10.495 18.3333 11.0013C18.3333 11.5076 17.9228 11.918 17.4166 11.918H10.0833C9.57699 11.918 9.16658 11.5076 9.16658 11.0013C9.16658 10.495 9.57699 10.0846 10.0833 10.0846H17.4166Z"
                                    fill="#FFA800" />
                                <path
                                    d="M11.6481 15.8531C12.0061 16.2111 12.0061 16.7915 11.6481 17.1495C11.2901 17.5075 10.7097 17.5075 10.3517 17.1495L4.85174 11.6495C4.50471 11.3025 4.49257 10.7437 4.8242 10.3819L9.86586 4.88189C10.208 4.5087 10.7878 4.48349 11.161 4.82558C11.5342 5.16767 11.5594 5.74752 11.2173 6.12072L6.76871 10.9737L11.6481 15.8531Z"
                                    fill="#FFA800" />
                            </svg>
                            Kembali
                        </span>
                    </button>
                </div>
                <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">

                    <a href="javascript:void(0);" class="mb-8 mt-8">
                        <div class="d-flex justify-content-center">
                            <div><img alt="Logo" class="me-3" :src="`${$assetUrl()}extends/img/logo-pemkot-new.png`"
                                    style="width:120px" /></div>
                            <div><img alt="Logo" :src="`${$assetUrl()}siapppak/images/logo-with-text.png`"
                                    style="width:250px" /></div>
                        </div>
                        <div class="text-center pt-8 pb-1 text-dark fw-bolder" style="max-width:550px;display:block;margin:auto;">
                            <h4>
                                Dinas Pemberdayaan  Perempuan dan Perlindungan Anak serta Pengendalian Penduduk dan Keluarga Berencana (DP3APPKB) Kota Surabaya
                            </h4>
                        </div>
                    </a>

                    <div class="w-lg-450px bg-white rounded shadow-xs p-10 p-lg-15 mx-auto">

                        <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" action="#">

                            <div class="text-center mb-10">
                                <h1 class="text-dark mb-3">Masuk</h1>

                                <div class="text-gray-500 fw-bold fs-4">Masukkan username dan password </div>
                            </div>

                            <div class="fv-row mb-6">
                                <label class="form-label fs-6 text-gray-500"
                                    :class="v$.single.username.$error ? 'text-danger' : ''">Username</label>
                                <input v-model="single.username" class="form-control form-control-lg" type="text"
                                    id="username" autocomplete="off" @keyup.enter="login" />
                                <div v-if="v$.single.username.$error" class="text-danger"> Username tidak boleh kosong!
                                </div>
                            </div>
                            <div class="fv-row mb-6">
                                <div class="d-flex flex-stack justify-content-between mb-2 align-items-center">
                                    <label class="form-label text-gray-500 fs-6 mb-0"
                                        :class="v$.single.password.$error ? 'text-danger' : ''">Password</label>
                                </div>
                                <input v-model="single.password" @keyup.enter="login"
                                    class="form-control form-control-lg" :type="hidePassword ? 'password' : 'text'"
                                    id="password" autocomplete="off" />
                                <i id="icon-password" class="icon-password" @click="showHidePassword"
                                    :class="hidePassword ? 'fa fa-eye' : 'fa fa-eye-slash'"></i>
                                <div v-if="v$.single.password.$error" class="text-danger"> Panjang minimal 6 karakter!
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mt-5 mb-3">
                                <vue-recaptcha ref="recaptcha" :sitekey="RECAPTCHA_APIKEY" @verify="verifyMethod"
                                    @expired="expiredMethod"></vue-recaptcha>
                            </div>

                            <div class="text-center">
                                <button type="button" id="kt_sign_in_submit"
                                    class="btn btn-lg me-3 my-2 px-16 bg-primary-custom"
                                    :disabled="disabledButton || !single.captcha" @click="login">
                                    <span v-if="pageStatus != 'form-login'"
                                        class="indicator-label text-white">Masuk</span>
                                    <span v-if="pageStatus == 'form-login'" class="indicator-progress text-white">Please
                                        wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                            </div>
                            <hr/>

                            <div class="text-center mt-5" style="font-size: 15px;">
                                <div class="mb-2">Belum punya akun?</div>
                                <div class="d-flex">
                                    <router-link 
                                        :to="{ name: 'registrasi-konseling', query: {pathTo: this.$route.query.pathTo} }"
                                        class="ms-2 btn btn-sm btn-info">Buat Akun Konsultasi</router-link>
                                    <router-link
                                    :to="{ name: 'registrasi-mahasiswa', query: {pathTo: this.$route.query.pathTo} }"
                                    class="ms-2 btn btn-sm btn-info">Buat Akun Mahasiswa</router-link>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="d-flex flex-center flex-column-auto p-10">
                </div>

            </div>

        </div>
    </div>
</template>

<script>
    import {
        VueRecaptcha
    } from 'vue-recaptcha';
    import Api from "@/services/api";
    import useVuelidate from '@vuelidate/core'
    import {
        required,
        minLength
    } from '@vuelidate/validators'

    export default {
        components: { VueRecaptcha },
        data() {
            return {
                bg_login: this.$assetUrl() + 'extends/img/bg-login.png',
                RECAPTCHA_APIKEY: process.env.MIX_RECAPTCHA_APIKEY,
                v$: useVuelidate(),
                pageStatus: 'standby',
                disabledButton: false,
                hidePassword: true,
                single: {
                    username: '',
                    password: '',
                    captcha: ''
                }
            }
        },
        validations() {
            return {
                single: {
                    username: {
                        required
                    },
                    password: {
                        required,
                        minLength: minLength(6)
                    }
                },
            }
        },
        methods: {
            showHidePassword() {
                this.hidePassword = !this.hidePassword
            },
            verifyMethod(response) {
                this.single.captcha = response;
            },
            expiredMethod() {
                this.single.captcha = '';
            },

            login() {

                if (!this.single.captcha) {
                    return false;
                }
                this.v$.$touch();
                if (this.v$.$error) {
                    return false;
                }

                if(this.disabledButton){
                    return false;
                }

                this.pageStatus = "form-login";
                this.disabledButton = true;

                let formData = {
                    username: this.single.username,
                    password: this.single.password,
                    recaptcha: this.single.captcha
                }

                Api().post('login', formData)
                    .then(response => {
                        this.$store.commit('profile/SET_PROFILE_DATA', null);
                        localStorage.setItem('dp5a-token', response.data.data.token.access_token);

                        let roleID = response.data.data.user.id_role;

                        if (process.env.MIX_ROLE_ADMIN_ID == roleID) {
                            this.$router.replace({
                                name: 'dashboard'
                            })
                        } 
                        else if (process.env.MIX_ROLE_KABID_ID == roleID) {
                            this.$router.replace({
                                name: 'dashboard'
                            })
                        } 
                        else if (process.env.MIX_ROLE_KADIS_ID == roleID) {
                            this.$router.replace({
                                name: 'pengaduan'
                            })
                        } 
                        else if (process.env.MIX_ROLE_KONSELOR_ID == roleID) {
                            this.$router.replace({
                                name: 'dashboard'
                            })
                        } 
                        else if (process.env.MIX_ROLE_SUBKORD_ID == roleID) {
                            this.$router.replace({
                                name: 'dashboard'
                            })
                        } 
                        else if (process.env.MIX_ROLE_OPD_ID == roleID) {
                            this.$router.replace({
                                name: 'pengaduan'
                            })
                        } 
                        else if (process.env.MIX_ROLE_HOTLINE_ID == roleID) {
                            this.$router.replace({
                                name: 'cek-pengaduan'
                            })
                        } 
                        else if (process.env.MIX_ROLE_ASISTEN_ID == roleID) {
                            this.$router.replace({
                                name: 'dashboard'
                            })
                        } 
                        else if (process.env.MIX_ROLE_KECAMATAN_ID == roleID) {
                            this.$router.replace({
                                name: 'd-puspaga'
                            })
                        } 
                        else if (process.env.MIX_ROLE_KELURAHAN_ID == roleID) {
                            this.$router.replace({
                                name: 'd-satgas-ppa'
                            })
                        }
                        else if (process.env.MIX_ROLE_PSIKOLOG_ID == roleID) {
                            this.$router.replace({
                                name: 'dashboard'
                            })
                        } 
                        else if (process.env.MIX_ROLE_MAHASISWA_ID == roleID) {
                            this.$router.replace({
                                name: 'kegiatan-mahasiswa'
                            })
                        } 
                        else if (process.env.MIX_ROLE_FASILITATOR_ID == roleID) {
                            this.$router.replace({
                                name: 'kegiatan-fasilitator'
                            })
                        } 
                        else if (process.env.MIX_ROLE_PENULIS_KONTEN_ID == roleID) {
                            this.$router.replace({
                                name: 'dashboard'
                            })
                        } 
                        else if (process.env.MIX_ROLE_KLIEN_ID == roleID) {
                            if(this.$route.query.pathTo){
                                this.$router.replace({
                                    path: this.$route.query.pathTo
                                })
                            }
                            else{
                                this.$router.replace({
                                    name: 'riwayat-konseling'
                                })
                            }
                        }
                    })
                    .catch(error => {
                        grecaptcha.reset()
                        this.single.captcha = '';
                        this.disabledButton = false;
                        this.pageStatus = "standby";
                        if (error.response && error.response.status == 404) {
                            this.$swal({
                                title: "Oopss...",
                                icon: "error",
                                text: 'User tidak ditemukan/password salah/tidak aktif',
                                showCancelButton: false,
                                confirmButtonColor: "#3085d6",
                                cancelButtonColor: "#d33",
                                confirmButtonText: "Ok",
                            });
                        } else {
                            this.$axiosHandleError(error);
                        }
                    });
            }
        },
        computed: {

        },
        mounted() {
            reinitializeAllPlugin();
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

    .form-check.form-check-solid .form-check-input:checked {
        background-color: #EE7B33 !important;
    }

</style>
