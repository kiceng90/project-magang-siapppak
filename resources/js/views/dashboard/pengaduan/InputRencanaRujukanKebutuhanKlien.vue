<template>
    <div>
        <div class="d-flex flex-column flex-root">
            <div class="page d-flex flex-row flex-column-fluid">
                <app-sidebar></app-sidebar>
                <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                    <app-navbar></app-navbar>
                    <!-- isi contentnya ya -->

                    <div id="main-content">
                        <!--begin::Post-->
                        <div class="post d-flex flex-column-fluid" id="kt_post">
                            <!--begin::Container-->
                            <div id="kt_content_container" class="container-xxl">
                                <div class="head my-5">
                                    <div class="row pt-5 mt-4">
                                        <div class="col-12">
                                            <div class="d-flex flex-wrap">
                                                <div class="" style="border-right:1px solid grey;padding-right:10px;">
                                                    <h4>Data Klien</h4>
                                                </div>
                                                <div>
                                                    &ensp;
                                                    <span class="text-muted">
                                                        <router-link :to="{ name: 'pengaduan' }" class="text-muted" style="text-decoration:none;">
                                                            Pengaduan
                                                        </router-link>
                                                        - 
                                                        <a href="javascript:void(0)" @click="$router.back()" class="text-muted" style="text-decoration:none;">
                                                            Detail Pengaduan
                                                        </a>
                                                        - Data Klien
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-center mt-5">
                                    <div class="col-lg-5">
                                        <h1>Rencana Rujukan Kebutuhan Klien</h1>
                                    </div>
                                    <div class="col-lg-7 d-flex flex-wrap" style="justify-content:flex-end;">
                                        <button type="button" class="btn me-3" style="background-color:#fff8dd;" @click="$router.push({ name: 'pengaduan', params: { id: this.$route.params.id }, query: { flag: 'penjangkauan' } })">
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
                                        <div class="dropdown" v-if="$store.state.profile.role_id == ROLE_KONSELOR_ID">
                                            <button class="btn text-white bg-second-primary-custom dropdown-toggle"
                                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                Simpan
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item py-3" href="javascript:void(0);"
                                                        @click="save(1)">Draft</a>
                                                </li>
                                                <li><a class="dropdown-item py-3" href="javascript:void(0);"
                                                        @click="confirmPublishSave()">Publish</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <button class="btn text-white bg-second-primary-custom"
                                            @click="confirmPublishSave()" v-else>
                                            Simpan
                                        </button>
                                    </div>
                                </div>
                                <div class="card card-flush mt-5 mb-5 mb-xl-10">
                                    <div class="card card-xl-stretch mb-5 mb-xl-8">
                                        <div class="card-body pt-5">
                                            <div v-if="pageStatus == 'page-load'"
                                                class="w-100 d-flex justify-content-center mt-10 mb-10">
                                                <app-loader></app-loader>
                                            </div>
                                            <div v-show="pageStatus != 'page-load'" class="row align-items-center">
                                                <div class="col-lg-12">
                                                    <div>
                                                        <template v-for="(context, index) in single.listService" :key="index">
                                                            <div class="row mb-5 pb-5" v-show="context.is_active" style="border-bottom:1px #ddd dashed">
                                                                <div class="col-lg-12">
                                                                    <div
                                                                        class="d-flex justify-content-between align-items-center my-5">
                                                                        <h4 class="c-primary-custom">Pelayanan
                                                                            {{getNumbered(index)}}
                                                                        </h4>
                                                                        <button v-if="getNumbered(index) > 0"
                                                                            @click="removeServiceData(index)"
                                                                            class="btn btn-light-danger"
                                                                            type="button">Hapus
                                                                            Item</button>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3 mb-5 fw-bolder">
                                                                    Kebutuhan
                                                                </div>
                                                                <div class="col-lg-9 mb-5">
                                                                    <app-select-single v-model="context.need"
                                                                        :placeholder="'Pilih Kebutuhan'"
                                                                        :options="listNeed"
                                                                        :loading="pageStatus == 'need-load'"
                                                                        :serverside="true" @change-search="getNeed">
                                                                    </app-select-single>
                                                                </div>
                                                                <div class="col-lg-3 mb-5 fw-bolder">
                                                                    OPD/Instansi Rujukan
                                                                </div>
                                                                <div class="col-lg-9 mb-5">
                                                                    <app-select-single v-model="context.opd"
                                                                        :placeholder="'Pilih OPD'" :options="listOpd"
                                                                        :loading="pageStatus == 'opd-load'"
                                                                        :serverside="true" @change-search="getOpd">
                                                                    </app-select-single>
                                                                </div>
                                                                <div class="col-lg-3 mb-5 fw-bolder">
                                                                    Pelayanan Yang Diberikan(Intervensi)
                                                                </div>
                                                                <div class="col-lg-9 mb-5">
                                                                    <app-select-single v-model="context.intervensi"
                                                                        :placeholder="'Pilih Intervensi'"
                                                                        :disabled="!context.opd.id"
                                                                        :options="listIntervensi"
                                                                        :loading="pageStatus == 'intervensi-load'"
                                                                        :serverside="true"
                                                                        @change-search="(keyword, limit) => getIntervensi(keyword, limit, context.opd.id)">
                                                                    </app-select-single>
                                                                </div>
                                                                <div class="col-lg-3 mb-5 fw-bolder d-none">
                                                                    Deskripsi Pelayanan Yang Diberikan
                                                                </div>
                                                                <div class="col-lg-9 mb-5 d-none">
                                                                    <textarea class="form-control" rows="3"
                                                                        v-model="context.note"
                                                                        placeholder="Ketik disini"></textarea>
                                                                </div>
                                                                <div class="col-lg-3 mb-5 fw-bolder d-none">
                                                                    Dokumen Pendukung
                                                                </div>
                                                                <div class="col-lg-9 mb-5 d-none">

                                                                    <div class="dropzone dropzone-file-area dz-clickable"
                                                                        :id="`dropzone-${context.randomString}`">
                                                                        <div class="dz-message needsclick">
                                                                            <i
                                                                                class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                                                            <div class="ms-4">
                                                                                <h5 class="kt-dropzone__msg-title">Drop
                                                                                    files here or
                                                                                    click
                                                                                    to upload</h5>
                                                                                <span
                                                                                    class="kt-dropzone__msg-desc text-primary">
                                                                                    Upload up to 10 files with the
                                                                                    format
                                                                                    .jpg/.jpeg/.png/.pdf
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mt-5">
                                                                        <div class="col-lg-4 col-md-6 mb-5 d-flex justify-content-between align-items-center" v-for="(contextX, indexX) in context.documentExisting" :key="indexX">
                                                                            <a v-if="contextX.isImage"
                                                                                :href="contextX.path"
                                                                                data-fancybox="gallery">
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="me-3">
                                                                                        <img :src="$assetUrl() + 'extends/img/ic_files_img.png'"
                                                                                            style="width:35px;" />
                                                                                    </div>
                                                                                    <div>
                                                                                        <div class="fw-bolder text-primary"
                                                                                            style="word-break: break-word;">
                                                                                            {{$noNullable(contextX.name)}}
                                                                                        </div>
                                                                                        <div class="text-gray-500">
                                                                                            {{$formatBytes(contextX.size)}}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </a>
                                                                            <a :href="contextX.path" target="_blank"
                                                                                v-else>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="me-3">
                                                                                        <img :src="$assetUrl() + 'extends/img/ic_files_pdf.png'"
                                                                                            style="width:35px;" />
                                                                                    </div>
                                                                                    <div>
                                                                                        <div class="fw-bolder text-primary"
                                                                                            style="word-break: break-word;">
                                                                                            {{$noNullable(contextX.name)}}
                                                                                        </div>
                                                                                        <div class="text-gray-500">
                                                                                            {{$formatBytes(contextX.size)}}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </a>
                                                                            <div><i @click="context.documentExisting.splice(indexX, 1)"
                                                                                    class="fa fa-times text-danger"
                                                                                    style="font-size:20px;cursor:pointer;"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </template>

                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <button class="btn btn-success mb-10" type="button"
                                                        @click="appendServiceData(null)"><i
                                                            class="fa fa-plus"></i>&ensp;Tambah Pelayanan</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
    export default {
        data() {
            return {
                ROLE_ADMIN_ID: process.env.MIX_ROLE_ADMIN_ID,
                ROLE_KABID_ID: process.env.MIX_ROLE_KABID_ID,
                ROLE_KADIS_ID: process.env.MIX_ROLE_KADIS_ID,
                ROLE_KONSELOR_ID: process.env.MIX_ROLE_KONSELOR_ID,
                ROLE_SUBKORD_ID: process.env.MIX_ROLE_SUBKORD_ID,
                ROLE_OPD_ID: process.env.MIX_ROLE_OPD_ID,
                ROLE_HOTLINE_ID: process.env.MIX_ROLE_HOTLINE_ID,
                ROLE_ASISTEN_ID: process.env.MIX_ROLE_ASISTEN_ID,
                ROLE_KELURAHAN_ID: process.env.MIX_ROLE_KELURAHAN_ID,
                ROLE_KECAMATAN_ID: process.env.MIX_ROLE_KECAMATAN_ID,
                pageStatus: 'standby',
                listNeed: [],
                listOpd: [],
                listIntervensi: [],
                single: {
                    listService: [],
                }
            }

        },
        mounted() {
            reinitializeAllPlugin();

            this.pageStatus = 'page-load';

            this.$store.dispatch('complaint/getDetailComplaintOutreachClientNeedsReferralPlan', this.$route.params
                .idPenjangkauan).then((res) => {
                if (res.status == 200 || res.status == 201) {
                    for (let i = 0; i < res.data.data.rencana_intervensi.length; i++) {
                        setTimeout(() => {
                            this.appendServiceData(res.data.data.rencana_intervensi[i]);
                        }, 100);

                    }
                } else {
                    this.$axiosHandleError(res);
                }

                setTimeout(() => {
                    this.pageStatus = 'standby';
                }, 1000);
            });
        },
        beforeRouteLeave(to, from, next) {

            for (let i = 0; i < this.single.listService.length; i++) {
                this.single.listService[i].dropzoneUpload.destroy();
            }
            next();
        },
        methods: {
            appendServiceData(fromDB = null) {
                let that = this;

                let randomString = this.generateString(25);

                this.single.listService.push({
                    id: fromDB ? fromDB.id : '',
                    need: fromDB && fromDB.kebutuhan ? {
                        id: fromDB.kebutuhan.id,
                        text: fromDB.kebutuhan.name,
                    } : {},
                    opd: fromDB && fromDB.opd ? {
                        id: fromDB.opd.id,
                        text: fromDB.opd.name,
                    } : {},
                    intervensi: fromDB && fromDB.intervensi ? {
                        id: fromDB.intervensi.id,
                        text: fromDB.intervensi.name,
                    } : {},
                    dropzoneUpload: null,
                    randomString: randomString,
                    documentExisting: fromDB ? fromDB.file ? fromDB.file : [] : [],
                    is_active: true,
                    note: fromDB ? fromDB.description : ''
                })

                const index = this.single.listService.length - 1;
                setTimeout(() => {
                    if (this.single.listService[index]) {
                        this.single.listService[index].dropzoneUpload =
                            new Dropzone(
                                `#dropzone-${randomString}`, {
                                    url: "/",
                                    dictCancelUpload: "Cancel",
                                    maxFilesize: 20,
                                    parallelUploads: 1,
                                    uploadMultiple: false,
                                    maxFiles: 10,
                                    addRemoveLinks: true,
                                    acceptedFiles: '.png,.jpg,.jpeg,.pdf',
                                    autoProcessQueue: false,
                                    init: function () {
                                        this.on("error", function (file) {
                                            if (!file.accepted) {
                                                this.removeFile(file);
                                                that.$swal('Silahkan periksa file Anda lagi');
                                            } else if (file.status == 'error') {
                                                this.removeFile(file);
                                                that.$swal('Terjadi kesalahan koneksi');
                                            }
                                        });

                                        this.on('resetFiles', function (file) {
                                            this.removeAllFiles();
                                        });
                                    },
                                })
                    }
                }, 1);

            },
            removeServiceData(index) {
                this.single.listService[index].is_active = false;

            },
            generateString(length) {
                let result = '';
                const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                const charactersLength = characters.length;
                for (let i = 0; i < length; i++) {
                    result += characters.charAt(Math.floor(Math.random() * charactersLength));
                }

                return result;
            },
            getNumbered(index) {
                let listActive = this.single.listService.filter((e) => e.is_active);

                let main = this.single.listService[index];

                return listActive.findIndex((e) => e.randomString == main.randomString) + 1;
            },
            confirmPublishSave() {
                if (this.$store.state.profile.role_id != this.ROLE_KONSELOR_ID) {
                    this.save(2);
                    return false;
                }

                this.$swal({
                    title: 'Publish Survey?',
                    text: "Data yang telah di publish tidak bisa di edit lagi",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#F64E60',
                    cancelButtonColor: '#FFFFFF',
                    cancelButtonTextColor: "black",
                    confirmButtonText: 'Ya, Publish',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.save(2);
                    }
                });
            },
            save(tipe_simpan) {

                let formData = new FormData()

                formData.append('tipe_simpan', tipe_simpan);

                let dataService = this.single.listService.filter((e) => e.is_active);

                for (var i = 0; i < dataService.length; i++) {
                    if (tipe_simpan == 2) {
                        if (!dataService[i].need.id) {
                            this.$toast.error("Kebutuhan pada data pelayanan " + (i + 1) +
                                ' tidak boleh kosong!');
                            return false;
                        }

                        if (!dataService[i].opd.id) {
                            this.$toast.error("OPD pada data pelayanan " + (i + 1) +
                                ' tidak boleh kosong!');
                            return false;
                        }

                        if (!dataService[i].intervensi.id) {
                            this.$toast.error("Intervensi pada data pelayanan " + (i + 1) +
                                ' tidak boleh kosong!');
                            return false;
                        }


                        // if (!dataService[i].note) {
                        //     this.$toast.error("Deskripsi Pelayanan Yang Diberikan pada data pelayanan " + (i + 1) +
                        //         ' tidak boleh kosong!');
                        //     return false;
                        // }
                    }





                    // let filesUpload = []
                    // if (!$.isEmptyObject(dataService[i].dropzoneUpload.files)) {
                    //     for (let file in dataService[i].dropzoneUpload.files) {
                    //         filesUpload.push(dataService[i].dropzoneUpload.files[file])
                    //     }
                    // }

                    // if (filesUpload && filesUpload.length > 0) {
                    //     for (let x = 0; x < filesUpload.length; x++) {
                    //         let fileX = filesUpload[x]
                    //         formData.append('rencana_intervensi[' + i + '][file][]', fileX);
                    //     }
                    // }

                    // if (dataService[i].documentExisting) {
                    //     for (let x = 0; x < dataService[i].documentExisting.length; x++) {
                    //         formData.append('rencana_intervensi[' + i + '][file_exsisting][]', dataService[i]
                    //             .documentExisting[x]
                    //             .id);
                    //     }
                    // }

                    if (dataService[i].id) {
                        formData.append('rencana_intervensi[' + i + '][id]', dataService[i].id);
                    }

                    if (dataService[i].need.id) {
                        formData.append('rencana_intervensi[' + i + '][id_kebutuhan]', dataService[i].need.id);
                    }

                    if (dataService[i].opd.id) {
                        formData.append('rencana_intervensi[' + i + '][id_opd]', dataService[i].opd.id);
                    }

                    if (dataService[i].intervensi.id) {
                        formData.append('rencana_intervensi[' + i + '][id_intervensi]', dataService[i].intervensi.id);
                    }

                    // if (dataService[i].note) {
                    //     formData.append('rencana_intervensi[' + i + '][deskripsi]', dataService[i].note);
                    // }
                }
                this.$ewpLoadingShow();
                Api().post('penjangkauan/' + this.$route.params.idPenjangkauan + '/rencana_intervensi', formData)
                    .then(response => {
                        this.$swal({
                            title: "Berhasil!",
                            text: this.$store.state.profile.role_id == this.ROLE_KONSELOR_ID ?
                                tipe_simpan == 2 ? 'Data berhasil dipublish' :
                                'Data berhasil disimpan sebagai draft. Anda masih bisa mengubahnya dilain waktu' :
                                'Data berhasil disimpan',
                            icon: "success",
                        }).then(result => {
                            this.$router.push({
                                name: 'pengaduan',
                                params: { id: this.$route.params.id },
                                query: {
                                    flag: 'penjangkauan'
                                }
                            });
                        });
                    })
                    .catch(error => {
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.$ewpLoadingHide();
                    });
            },
            getNeed(keyword, limit) {

                this.pageStatus = 'need-load';


                Api().get(`m-kebutuhan/lists?limit=${limit}&search=${keyword}`)
                    .then(response => {
                        this.listNeed = [];
                        for (let i = 0; i < response.data.data.length; i++) {
                            this.listNeed.push({
                                id: response.data.data[i].id,
                                text: response.data.data[i].name,
                            });
                        }

                    })
                    .catch(error => {
                        this.listNeed = [];
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.pageStatus = 'standby';
                    })
            },
            getOpd(keyword, limit) {

                this.pageStatus = 'opd-load';


                Api().get(`m-opd/lists?limit=${limit}&search=${keyword}`)
                    .then(response => {
                        this.listOpd = [];
                        for (let i = 0; i < response.data.data.length; i++) {
                            this.listOpd.push({
                                id: response.data.data[i].id,
                                text: response.data.data[i].name,
                            });
                        }

                    })
                    .catch(error => {
                        this.listOpd = [];
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.pageStatus = 'standby';
                    })
            },
            getIntervensi(keyword, limit, opdId) {

                this.pageStatus = 'intervensi-load';


                Api().get(`m-intervensi/lists?limit=${limit}&search=${keyword}&id_opd=${opdId}`)
                    .then(response => {
                        this.listIntervensi = [];
                        for (let i = 0; i < response.data.data.length; i++) {
                            this.listIntervensi.push({
                                id: response.data.data[i].id,
                                text: response.data.data[i].name,
                            });
                        }

                    })
                    .catch(error => {
                        this.listIntervensi = [];
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.pageStatus = 'standby';
                    })
            },
        }
    }

</script>

<style scoped>

</style>
