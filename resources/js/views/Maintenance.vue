<template>
    <div
        id="kt_body"
        class="bg-white header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed toolbar-tablet-and-mobile-fixed aside-enabled aside-fixed"
        style="
            --kt-toolbar-height: 55px;
            --kt-toolbar-height-tablet-and-mobile: 55px;
        "
    >
        <div class="d-flex flex-column flex-root">
            <div
                class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed login-wrapper"
                id="page-bg"
                :style="`background-size: cover;background-image: url('${bg_login}')`"
            >
                <div
                    class="col-lg-4 d-flex"
                    style="justify-content: flex-start; margin: 24px"
                >
                    <!-- <button
                        type="button"
                        class="btn"
                        style="background-color: #fff8dd"
                        @click="$router.back()"
                    >
                        <span class="text-warning d-flex">
                            <svg
                                width="22"
                                height="22"
                                viewBox="0 0 22 22"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    opacity="0.3"
                                    d="M17.4166 10.0846C17.9228 10.0846 18.3333 10.495 18.3333 11.0013C18.3333 11.5076 17.9228 11.918 17.4166 11.918H10.0833C9.57699 11.918 9.16658 11.5076 9.16658 11.0013C9.16658 10.495 9.57699 10.0846 10.0833 10.0846H17.4166Z"
                                    fill="#FFA800"
                                />
                                <path
                                    d="M11.6481 15.8531C12.0061 16.2111 12.0061 16.7915 11.6481 17.1495C11.2901 17.5075 10.7097 17.5075 10.3517 17.1495L4.85174 11.6495C4.50471 11.3025 4.49257 10.7437 4.8242 10.3819L9.86586 4.88189C10.208 4.5087 10.7878 4.48349 11.161 4.82558C11.5342 5.16767 11.5594 5.74752 11.2173 6.12072L6.76871 10.9737L11.6481 15.8531Z"
                                    fill="#FFA800"
                                />
                            </svg>
                            Kembali
                        </span>
                    </button> -->
                </div>
                <div
                    class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20"
                >
                    <a href="javascript:void(0);" class="mb-8 mt-8">
                        <div class="d-flex justify-content-center">
                            <div>
                                <img
                                    alt="Logo"
                                    class="me-3"
                                    :src="`${$assetUrl()}extends/img/logo-pemkot-new.png`"
                                    style="width: 120px"
                                />
                            </div>
                            <div>
                                <img
                                    alt="Logo"
                                    :src="`${$assetUrl()}siapppak/images/logo-with-text.png`"
                                    style="width: 250px"
                                />
                            </div>
                        </div>
                        <div
                            class="text-center pt-8 pb-1 text-dark fw-bolder"
                            style="
                                max-width: 550px;
                                display: block;
                                margin: auto;
                            "
                        >
                            <h4>
                                Dinas Pemberdayaan Perempuan dan Perlindungan
                                Anak serta Pengendalian Penduduk dan Keluarga
                                Berencana (DP3APPKB) Kota Surabaya
                            </h4>
                        </div>
                    </a>

                    <div
                        class="w-lg-450px bg-white rounded shadow-xs p-10 p-lg-15 mx-auto text-center"
                    >
                        <h1 class="mb-3 text-dark fw-1">
                            Situs Sedang Dalam Perawatan
                        </h1>
                        <p class="text-gray-600">
                            Mohon maaf atas ketidaknyamanan ini. Kami sedang
                            melakukan pembaruan sistem untuk memberikan layanan
                            yang lebih baik.
                        </p>
                        <p class="text-gray-600">
                            Silakan kembali lagi nanti atau hubungi kami untuk
                            informasi lebih lanjut.
                        </p>
                    </div>
                </div>
                <div class="d-flex flex-center flex-column-auto p-10"></div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            bg_login: this.$assetUrl() + "extends/img/bg-login.png",
        };
    },
};
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
    background-color: #ee7b33 !important;
}
</style>
