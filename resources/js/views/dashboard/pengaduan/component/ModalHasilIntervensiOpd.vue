<template>
    <div class="modal fade" tabindex="-1" id="modal-detail-hasil-intervensi-opd">
        <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width:1100px">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hasil Intervensi OPD</h5>
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

                    <div class="timeline-custom mt-10">

                        <div class="container-timeline-custom right-timeline-custom" v-for="ctx in data">
                            <div class="container-timeline-custom-circle">

                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.7"
                                        d="M11.8 5.2L17.7 8.6V15.4L11.8 18.8L5.90001 15.4V8.6L11.8 5.2ZM11.8 2C11.5 2 11.2 2.1 11 2.2L3.8 6.4C3.3 6.7 3 7.3 3 7.9V16.2C3 16.8 3.3 17.4 3.8 17.7L11 21.9C11.3 22 11.5 22.1 11.8 22.1C12.1 22.1 12.4 22 12.6 21.9L19.8 17.7C20.3 17.4 20.6 16.8 20.6 16.2V7.9C20.6 7.3 20.3 6.7 19.8 6.4L12.6 2.2C12.4 2.1 12.1 2 11.8 2Z"
                                        fill="#50CD89" />
                                    <path
                                        d="M11.7984 8.7002L8.89844 10.3002V13.7002L11.7984 15.3002L14.6984 13.7002V10.3002L11.7984 8.7002Z"
                                        fill="#50CD89" />
                                </svg>
                            </div>
                            <div class="content-timeline-custom">
                                <h2 class="fw-bolder">
                                    {{$noNullable(ctx.name)}}
                                </h2>
                                <div class="text-gray-600 mb-3">
                                    {{$noNullable(ctx.created_at)}} oleh
                                    <span class="text-black fw-bolder">{{$noNullable(ctx.created_by?.opd?.name)}}</span></div>
                                <div class="p-3" style="border: 1px dashed #E4E6EF;border-radius:12px;">
                                    <div class="row">
                                        <div class="col-lg-12 my-1 col-md-12">
                                            {{$noNullable(ctx.description)}}
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="row mt-3">
                                                <div class="col-lg-2 col-md-3 col-sm-6 col-6 mb-5"
                                                    v-for="fileX in ctx.file">
                                                    <a :href="fileX.path" data-fancybox="gallery"><img :src="fileX.path"
                                                            class="w-100" style="max-width:100%;" /></a>
                                                </div>
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
    .text-white {
        color: #fff !important;
    }

    .text-black {
        color: #000 !important
    }

    .card-header-penugasan .card-title {
        max-width: 320px !important;
    }

    @media(max-width:1100px) {
        .card-header-penugasan {
            flex-wrap: wrap !important;
        }
    }

    @media(max-width:991px) {
        .card-header-penugasan .right-column {
            flex-wrap: wrap;
        }
    }



    /* The actual timeline (the vertical ruler) */
    .timeline-custom {
        position: relative;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* The actual timeline (the vertical ruler) */
    .timeline-custom::after {
        content: '';
        position: absolute;
        width: 2px;
        border: 1px #f2f2f2 dashed;
        top: 0;
        bottom: 0;
        left: 28px;
        margin-left: -3px;
    }

    /* Container around content */
    .container-timeline-custom {
        padding: 10px 40px;
        position: relative;
        background-color: inherit;
        width: 100%;
    }

    /* The circles on the timeline */
    .container-timeline-custom-circle {
        position: absolute;
        display: block;
        background-size: 40px 40px;
        height: 40px;
        width: 40px;
        left: -18px;
        top: 0;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #F5F8FA;
        border-radius: 100px;
    }

    /* Place the container to the left */
    .left-timeline-custom {
        right: 0;
    }

    /* Place the container to the right */
    .right-timeline-custom {
        left: 25px;
    }

    /* Add arrows to the left container (pointing right) */
    .left-timeline-custom::before {
        content: " ";
        height: 0;
        position: absolute;
        top: 22px;
        width: 0;
        z-index: 1;
        right: 30px;
        border: medium solid white;
        border-width: 10px 0 10px 10px;
        border-color: transparent transparent transparent white;
    }

    /* Fix the circle for containers on the right side */
    .right-timeline-custom::after {
        left: -16px;
    }

    /* The actual content */
    .content-timeline-custom {
        padding: 0;
        background-color: white;
        position: relative;
        border-radius: 6px;
    }

</style>
