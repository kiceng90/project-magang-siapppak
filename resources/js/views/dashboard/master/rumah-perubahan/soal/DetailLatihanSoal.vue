<template>
    <div>
        <div class="d-flex flex-column flex-root">
            <div class="page d-flex flex-row flex-column-fluid">
                <app-sidebar></app-sidebar>
                <div
                    class="wrapper d-flex flex-column flex-row-fluid"
                    id="kt_wrapper"
                >
                    <app-navbar></app-navbar>
                    <!-- isi contentnya ya -->
                    <div id="main-content">
                        <!--begin::Post-->
                        <div class="post d-flex flex-column-fluid" id="kt_post">
                            <!--begin::Container-->
                            <div
                                id="kt_content_container"
                                class="container-xxl"
                            >
                                <!-- start -->
                                <div>
                                    <div class="head my-5">
                                        <div class="row pt-5 mt-4">
                                            <div class="col-12">
                                                <div class="d-flex flex-wrap">
                                                    <div
                                                        class=""
                                                        style="
                                                            border-right: 1px
                                                                solid grey;
                                                            padding-right: 10px;
                                                        "
                                                    >
                                                        <h4>
                                                            Detail Latihan Soal
                                                        </h4>
                                                    </div>
                                                    <div>
                                                        &ensp;
                                                        <span
                                                            class="text-muted"
                                                        >
                                                            <a
                                                                href="javascript:void(0)"
                                                                @click="
                                                                    $router.push(
                                                                        {
                                                                            name: 'rumahperubahan-latihansoal',
                                                                        }
                                                                    )
                                                                "
                                                                class="text-muted"
                                                                style="
                                                                    text-decoration: none;
                                                                "
                                                            >
                                                                Latihan Soal
                                                            </a>
                                                            - Detail Data
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mt-5">
                                        <div class="col-lg-8">
                                            <h1>Detail Latihan Soal</h1>
                                        </div>
                                        <div
                                            class="col-lg-4 d-flex"
                                            style="justify-content: flex-end"
                                        >
                                            <button
                                                type="button"
                                                class="btn"
                                                style="
                                                    background-color: #fff8dd;
                                                "
                                                @click="
                                                    $router.push({
                                                        name: 'rumahperubahan-latihansoal',
                                                    })
                                                "
                                            >
                                                <span
                                                    class="text-warning d-flex"
                                                >
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
                                            </button>
                                        </div>
                                    </div>
                                    <div
                                        class="card card-flush mt-5 mb-5 mb-xl-10"
                                        id="kt_profile_details_view"
                                    >
                                        <div
                                            v-if="
                                                $store.state.complaint
                                                    .detailComplaint.loading
                                            "
                                            class="w-100 d-flex justify-content-center mt-10 mb-10"
                                        >
                                            <app-loader></app-loader>
                                        </div>
                                        <div
                                            class="card card-xl-stretch mb-5 mb-xl-8"
                                            v-else
                                        >
                                            <div class="card-body pt-5">
                                                <h4
                                                    class="c-primary-custom fw-bolder pb-2"
                                                >
                                                    Detail Data Soal
                                                </h4>
                                                <div class="row">
                                                    <div
                                                        class="col-lg-1 text-gray-600 mb-5"
                                                    >
                                                        Soal
                                                    </div>
                                                    <div
                                                        v-html="soal.name"
                                                        class="col-lg-11 fw-bolder mb-5"
                                                    >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body pt-5">
                                                <h4
                                                    class="c-primary-custom fw-bolder pb-2"
                                                >
                                                    Detail Pilihan Jawaban
                                                </h4>
                                                <div
                                                    class="row"
                                                    v-for="(
                                                        jawaban, index
                                                    ) in pilihan_jawaban"
                                                    :key="index"
                                                >
                                                    <div
                                                        class="col-lg-1 text-gray-600 mb-5"
                                                    >
                                                        <span
                                                            :class="{
                                                                'option-active':
                                                                    jawaban.is_active,
                                                            }"
                                                        >
                                                            {{ jawaban.abjad }}
                                                        </span>
                                                    </div>
                                                    <div
                                                        class="col-lg-11 fw-bolder mb-5"
                                                    >
                                                        {{ jawaban.pilihan }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end -->
                            </div>
                            <!--end::Container-->
                        </div>
                        <!--end::Post-->
                    </div>
                    <!-- end of content -->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Page-->
        </div>
        <app-scroll-top></app-scroll-top>
    </div>
</template>

<script>
import Api from "@/services/api";
import useVuelidate from "@vuelidate/core";
import { required, requiredIf } from "@vuelidate/validators";

export default {
    data() {
        return {
            soal: {
                name: "", // Nama soal
            },
            pilihan_jawaban: [], // Pilihan jawaban untuk soal
        };
    },
    mounted() {
        reinitializeAllPlugin();
        this.getData();
    },
    methods: {
        getData() {
            Api()
                .get(`m-soal-rumah-perubahan/${this.$route.params.id}`)
                .then((res) => {
                    if (res?.data?.data) {
                        const data = res.data.data;
                        this.soal.name = data.name;

                        // Map pilihan jawaban dengan abjad dan is_active
                        this.pilihan_jawaban = data.pilihan_jawaban.map(
                            (jawaban, index) => ({
                                abjad: String.fromCharCode(65 + index),
                                pilihan: jawaban.pilihan,
                                is_active: jawaban.is_active,
                            })
                        );
                    }
                })
                .catch((err) => {
                    console.error("Error fetching data:", err);
                });
        },
    },
};
</script>

<style scoped>
.option-active {
    margin-left: -6px;
    display: inline-block;
    width: 24px;
    height: 24px;
    border: 2px solid #ffa800;
    border-radius: 50%;
    text-align: center;
    line-height: 20px;
    font-weight: bold;
    background-color: #fff8dd;
    color: #ffa800;
}
</style>
