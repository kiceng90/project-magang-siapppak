<template>
    <div
        id="kt_body"
        class="bg-white header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed toolbar-tablet-and-mobile-fixed aside-enabled aside-fixed"
        style="
            --kt-toolbar-height: 55px;
            --kt-toolbar-height-tablet-and-mobile: 55px;
        "
    >
        <div class="d-flex flex-column flex-root min-h-screen">
            <div
                class="d-flex flex-column flex-column-fluid flex-center bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-cover bgi-attachment-fixed login-wrapper"
                id="page-bg"
                :style="`background-image: url('${bg_login}'); background-size: cover;`"
            >
                <div
                    class="w-100 w-md-700px bg-white rounded shadow-xs p-10 p-lg-15 mx-auto text-center"
                >
                    <h2 class="mb-5 fw-bold">Selamat Datang di Buku Tamu</h2>
                    <p class="text-muted mb-10">
                        Silakan pilih metode pengisian data buku tamu yang Anda
                        inginkan. Anda dapat mengunggah foto KTP untuk
                        otomatisasi, atau mengisi data secara manual.
                    </p>

                    <button
                        class="btn btn-primary mb-5 w-100 py-3"
                        @click="$router.push('/upload-OCR')"
                    >
                        📷 Upload Foto KTP (Otomatis)
                    </button>

                    <button
                        class="btn btn-secondary w-100 py-3"
                        @click="$router.push('/buku-tamu')"
                    >
                        📝 Input Manual
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Api from "@/services/api";

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

.min-h-screen {
    min-height: 100vh;
}
</style>
