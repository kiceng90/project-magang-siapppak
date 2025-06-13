<template>
    <div class="modal fade" tabindex="-1" id="modal-detail-data-keluarga-klien">
        <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width:1100px">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Data Keluarga Klien</h5>
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
                            <div class="p-5 mb-8" style="border-radius:10px;border: 1px #E5EAEE solid">
                                <div class="row align-items-center pb-5 mb-5"
                                    v-for="(context, index) in data ? data.family : []"
                                    style="border-bottom:1px #E5EAEE solid;">
                                    <div class="col-lg-12">
                                        <h4 class="c-primary-custom mb-8">Keluarga {{index + 1}}</h4>
                                    </div>
                                    <div class="col-lg-4 mb-5 text-gray-600">
                                        Hubungan dengan Klien
                                    </div>
                                    <div class="col-lg-8 mb-5 fw-bolder">
                                        {{$noNullable(context.relationship)}}
                                    </div>
                                    <div class="col-lg-4 mb-5 text-gray-600">
                                        Nama Lengkap
                                    </div>
                                    <div class="col-lg-8 mb-5 fw-bolder">
                                        {{$noNullable(context.name)}}
                                    </div>
                                    <div class="col-lg-4 mb-5 text-gray-600">
                                        NIK
                                    </div>
                                    <div class="col-lg-8 mb-5 fw-bolder">
                                        {{$noNullable(context.nik)}}
                                    </div>
                                    <div class="col-lg-4 mb-5 text-gray-600">
                                        Nomor KK
                                    </div>
                                    <div class="col-lg-8 mb-5 fw-bolder">
                                        {{$noNullable(context.kk)}}
                                    </div>
                                    <div class="col-lg-4 mb-5 text-gray-600">
                                        No. Telepon/Whatsapp
                                    </div>
                                    <div class="col-lg-8 mb-5 fw-bolder">
                                        {{$noNullable(context.phoneNumber)}}
                                    </div>
                                    <div class="col-lg-4 mb-5 text-gray-600">
                                        Alamat KK
                                    </div>
                                    <div class="col-lg-8 mb-5">
                                        <div class="fw-bolder"> {{$noNullable(context.addressKK)}}, Kel.
                                            {{$noNullable(context.villageKK)}}, Kec.
                                            {{$noNullable(context.subDistrictKK)}}</div>
                                    </div>
                                    <div class="col-lg-4 mb-5 text-gray-600">
                                        Alamat Domisili
                                    </div>
                                    <div class="col-lg-8 mb-5">
                                        <div class="fw-bolder">{{$noNullable(context.addressDomicile)}}, Kel.
                                            {{$noNullable(context.villageDomicile)}} Kec.
                                            {{$noNullable(context.subDistrictDomicile)}}</div>
                                    </div>
                                    <div class="col-lg-4 mb-5 text-gray-600">
                                        Pekerjaan
                                    </div>
                                    <div class="col-lg-4 mb-5">
                                        <div class="fw-bolder">{{$noNullable(context.proffesion)}}</div>
                                    </div>
                                    <div class="col-lg-2 mb-5 text-gray-600">
                                        Sifat Pekerjaan
                                    </div>
                                    <div class="col-lg-2 mb-5 fw-bolder">
                                        {{$noNullable(context.typeProffesion)}}
                                    </div>
                                    <div class="col-lg-4 mb-5 text-gray-600">
                                        Penghasilan Per Bulan
                                    </div>
                                    <div class="col-lg-8 mb-5 fw-bolder">
                                        Rp {{$rupiahFormat(context.monthlyIncome)}}
                                    </div>
                                    <div class="col-lg-4 mb-5 text-gray-600">
                                        Agama
                                    </div>
                                    <div class="col-lg-8 mb-5 fw-bolder">
                                        {{$noNullable(context.religion)}}
                                    </div>
                                    <div class="col-lg-4 mb-5 text-gray-600">
                                        Tempat, Tanggal Lahir
                                    </div>
                                    <div class="col-lg-4 mb-5 fw-bolder">
                                        {{$noNullable(context.placeOfBirth)}},
                                        {{context.dateOfBirth ? $moment(context.dateOfBirth,'DD-MM-YYYY').locale('id').format('DD MMMM YYYY') : '-'}}
                                    </div>
                                    <div class="col-lg-2 mb-5 text-gray-600">
                                        Usia
                                    </div>
                                    <div class="col-lg-2 mb-5 fw-bolder">
                                        {{getDiffYears($moment(context.dateOfBirth,'DD-MM-YYYY').format('YYYY-MM-DD'))}}
                                        Tahun
                                    </div>
                                    <div class="col-lg-4 mb-5 text-gray-600">
                                        Kepemilikan BPJS
                                    </div>
                                    <div class="col-lg-8 mb-5 fw-bolder">
                                        <span v-if="context.bpjs_category == 1">PBI</span>
                                        <span v-if="context.bpjs_category == 2">Korporasi</span>
                                        <span v-if="context.bpjs_category == 3">Mandiri</span>
                                        <span v-if="context.bpjs_category == 4">Tidak Punya</span>
                                    </div>
                                     <!-- Bagian Pendidikan Terakhir -->
                                    <!-- <h4 class="c-primary-custom pb-5" v-if="pageStatus != 'page-load'">
                                        Pendidikan Terakhir</h4>
                                    <div class="row align-items-center" v-if="pageStatus != 'page-load'">
                                        <div class="col-lg-3 mb-5 fw-bolder"
                                            :class="v$.single.lastEducation.$error ? 'text-danger' : ''">
                                            Pendidikan
                                        </div>
                                        <div class="col-lg-3 mb-5">
                                            <app-select-single v-model="single.lastEducation"
                                                :placeholder="'Pilih pendidikan'" :options="listEducation"
                                                :serverside="true" :loading="pageStatus == 'education-load'"
                                                @change-search="getLatestEducation">
                                            </app-select-single>
                                            <div v-if="v$.single.lastEducation.$error" class="text-danger">
                                                Pendidikan tidak boleh kosong!
                                            </div>
                                        </div>
                                        <div class="col-lg-3 mb-5 fw-bolder">
                                            Jurusan Sekolah (Opsional)
                                        </div>
                                        <div class="col-lg-3 mb-5">
                                            <app-select-single v-model="single.schoolMajors"
                                                :placeholder="'Pilih jurusan sekolah'"
                                                :options="listSchoolMajors" :serverside="true"
                                                :loading="pageStatus == 'school-major-load'"
                                                @change-search="getSchoolMajors">
                                            </app-select-single>
                                        </div>
                                        <div class="col-lg-3 mb-5 fw-bolder">
                                            Kelas (Opsional)
                                        </div>
                                        <div class="col-lg-3 mb-5">
                                            <app-select-single v-model="single.classEducation"
                                                :placeholder="'Pilih kelas'" :options="listClassEducation"
                                                :serverside="false">
                                            </app-select-single>
                                        </div>
                                        <div class="col-lg-3 mb-5 fw-bolder">
                                            Tahun Lulus (Opsional)
                                        </div>
                                        <div class="col-lg-3 mb-5">
                                            <app-datepicker type="year" placeholder="Pilih tanggal"
                                                :format="'YYYY'" :value-type="'YYYY'"
                                                v-model:value="single.graduationYear">
                                            </app-datepicker>
                                        </div>
                                        <div class="col-lg-3 mb-5 fw-bolder">
                                            Nama Instansi Sekolah (Opsional)
                                        </div>
                                        <div class="col-lg-9 mb-5">
                                            <input type="text" class="form-control"
                                                placeholder="Cth: SD 1 Surabaya" v-model="single.schoolName" />
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                            <div class="p-5" style="border-radius:10px;border: 1px #E5EAEE solid">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h4 class="c-primary-custom mb-8">Data Saudara</h4>
                                    </div>
                                    <template v-for="(context, index) in data ? data.sibling : []">
                                        <div class="col-lg-4 mb-5 text-gray-600">
                                            Saudara {{index + 1}}/Anak ke {{index + 1}}
                                        </div>
                                        <div class="col-lg-8 mb-5 fw-bolder">
                                            {{$noNullable(context.name)}}
                                        </div>
                                    </template>
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
    import moment from "moment";
    const props = defineProps({
        data: {
            required: false,
        },
    })

    function getDiffYears(value) {
        if (!value) {
            return '-';
        }
        
        return moment().diff(moment(value, "YYYY-MM-DD"), 'years') ? moment().diff(moment(value, "YYYY-MM-DD"),
            'years') : '-';
    }

</script>

<style scoped>

</style>
