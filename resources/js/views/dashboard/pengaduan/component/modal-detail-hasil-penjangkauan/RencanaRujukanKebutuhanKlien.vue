<template>
    <div class="modal fade" tabindex="-1" id="modal-detail-rencana-rujukan-kebutuhan-klien">
        <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width:1100px">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Rencana Rujukan Kebutuhan Klien</h5>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <span class="svg-icon-2x">

                            <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M17.88 15.9996L23.6134 10.2796C23.8644 10.0285 24.0055 9.688 24.0055 9.33293C24.0055 8.97786 23.8644 8.63733 23.6134 8.38626C23.3623 8.13519 23.0218 7.99414 22.6667 7.99414C22.3116 7.99414 21.9711 8.13519 21.72 8.38626L16 14.1196L10.28 8.38626C10.029 8.13519 9.68844 7.99414 9.33337 7.99414C8.97831 7.99414 8.63778 8.13519 8.38671 8.38626C8.13564 8.63733 7.99459 8.97786 7.99459 9.33293C7.99459 9.688 8.13564 10.0285 8.38671 10.2796L14.12 15.9996L8.38671 21.7196C8.26174 21.8435 8.16254 21.991 8.09485 22.1535C8.02716 22.316 7.99231 22.4902 7.99231 22.6663C7.99231 22.8423 8.02716 23.0166 8.09485 23.179C8.16254 23.3415 8.26174 23.489 8.38671 23.6129C8.51066 23.7379 8.65813 23.8371 8.8206 23.9048C8.98308 23.9725 9.15736 24.0073 9.33337 24.0073C9.50939 24.0073 9.68366 23.9725 9.84614 23.9048C10.0086 23.8371 10.1561 23.7379 10.28 23.6129L16 17.8796L21.72 23.6129C21.844 23.7379 21.9915 23.8371 22.1539 23.9048C22.3164 23.9725 22.4907 24.0073 22.6667 24.0073C22.8427 24.0073 23.017 23.9725 23.1795 23.9048C23.342 23.8371 23.4894 23.7379 23.6134 23.6129C23.7383 23.489 23.8375 23.3415 23.9052 23.179C23.9729 23.0166 24.0078 22.8423 24.0078 22.6663C24.0078 22.4902 23.9729 22.316 23.9052 22.1535C23.8375 21.991 23.7383 21.8435 23.6134 21.7196L17.88 15.9996Z"
                                    fill="black" />
                            </svg>

                        </span>
                    </div>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5 mb-8" style="border-radius:10px;border: 1px #E5EAEE dashed"
                                v-for="(context, index) in data">
                                <div class="row align-items-center pb-5 mb-5">
                                    <div class="col-lg-12">
                                        <h4 class="c-primary-custom mb-8">Pelayanan {{index + 1}}</h4>
                                    </div>
                                    <div class="col-lg-4 mb-5 text-gray-600">
                                        Kebutuhan
                                    </div>
                                    <div class="col-lg-8 mb-5 fw-bolder">
                                        {{$noNullable(context.kebutuhan?.name)}}
                                    </div>
                                    <div class="col-lg-4 mb-5 text-gray-600">
                                        OPD
                                    </div>
                                    <div class="col-lg-8 mb-5 fw-bolder">
                                        {{$noNullable(context.opd?.name)}}
                                    </div>
                                    <div class="col-lg-4 mb-5 text-gray-600">
                                        Pelayanan Yang Diberikan
                                    </div>
                                    <div class="col-lg-8 mb-5 fw-bolder">
                                        {{$noNullable(context.intervensi?.name)}}
                                    </div>
                                    <div class="col-lg-4 mb-5 text-gray-600 d-none">
                                        Deskripsi Pelayanan Yang Diberikan
                                    </div>
                                    <div class="col-lg-8 mb-5 fw-bolder d-none">
                                        {{$noNullable(context.description)}}
                                    </div>
                                    <div class="col-lg-4 mb-5 text-gray-600 d-none">
                                        Dokumen Pendukung
                                    </div>
                                    <div class="col-lg-8 mb-5 d-none">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-6 mb-5" v-for="file in context.file">
                                                <a v-if="file.isImage" :href="file.path" data-fancybox="gallery">
                                                    <div class="d-flex align-items-center">
                                                        <div class="me-3">
                                                            <img :src="$assetUrl() + 'extends/img/ic_files_img.png'"
                                                                style="width:35px;" />
                                                        </div>
                                                        <div>
                                                            <div class="fw-bolder text-primary"
                                                                style="word-break: break-word;">
                                                                {{$noNullable(file.name)}}
                                                            </div>
                                                            <div class="text-gray-500">
                                                                {{$formatBytes(file.size)}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a :href="file.path" target="_blank" v-else>
                                                    <div class="d-flex align-items-center">
                                                        <div class="me-3">
                                                            <img :src="$assetUrl() + 'extends/img/ic_files_pdf.png'"
                                                                style="width:35px;" />
                                                        </div>
                                                        <div>
                                                            <div class="fw-bolder text-primary"
                                                                style="word-break: break-word;">
                                                                {{$noNullable(file.name)}}
                                                            </div>
                                                            <div class="text-gray-500">
                                                                {{$formatBytes(file.size)}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>             
                                            </div>                       
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    const props = defineProps({
        data: {            
            required: false,            
        },
    })
    

</script>

<style scoped>

</style>
