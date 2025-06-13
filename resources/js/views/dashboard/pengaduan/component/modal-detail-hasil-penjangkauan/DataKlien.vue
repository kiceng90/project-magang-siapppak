<template>
    <div class="modal fade" tabindex="-1" id="modal-detail-data-klien">
        <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width:1100px">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Data Klien</h5>
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
                            <div class="p-5" style="border-radius:10px;border: 1px #E5EAEE solid">
                                <div class="row align-items-center pb-5 mb-5" style="border-bottom:1px #E5EAEE solid;">
                                    <div class="col-lg-12">
                                        <h4 class="c-primary-custom mb-8">Identitas Klien</h4>
                                    </div>
                                    <div class="col-lg-4 mb-5 text-gray-600">
                                        Nama Lengkap
                                    </div>
                                    <div class="col-lg-8 mb-5 fw-bolder">
                                        {{$noNullable(data?.name)}} 
                                    </div>
                                    <div class="col-lg-4 mb-5 text-gray-600">
                                        NIK/Nomor Identitas
                                    </div>
                                    <div class="col-lg-8 mb-5 fw-bolder">
                                        {{$noNullable(data?.nik_number ? data?.nik_number : data?.identity_number )}} &ensp;<span class="badge badge-primary ms">{{data?.is_has_nik ? 'NIK' : 'Nomor Identitas'}}</span>
                                    </div>
                                    <div class="col-lg-4 mb-5 text-gray-600">
                                        Warga Surabaya
                                    </div>
                                    <div class="col-lg-8 mb-5 fw-bolder">
                                        {{data?.is_surabaya_resident ? 'Ya' : 'Tidak'}}
                                    </div>
                                    <div class="col-lg-4 mb-5 text-gray-600">
                                        Kabupaten/Kota
                                    </div>
                                    <div class="col-lg-8 mb-5 fw-bolder">
                                        {{$noNullable(data?.is_surabaya_resident ? '-' : data?.klien_history?.kelurahan_tinggal?.kecamatan?.kabupaten?.name)}}
                                    </div>
                                    <div class="col-lg-4 mb-5 text-gray-600">
                                        Alamat Domisili
                                    </div>
                                    <div class="col-lg-4 mb-5">
                                        <div class="fw-bolder">{{$noNullable(data?.klien_history?.residence_address)}}</div>
                                        <div class="text-gray-600 pt-2">Kecamatan: <span
                                                class="text-black fw-bolder">{{$noNullable(data?.klien_history?.kelurahan_tinggal?.kecamatan?.name)}} </span></div>
                                    </div>
                                    <div class="col-lg-4 mb-5">
                                        <div class="text-gray-600">Kelurahan: <span
                                                class="text-black fw-bolder">{{$noNullable(data?.klien_history?.kelurahan_tinggal?.name)}} </span></div>
                                    </div>
                                    <div class="col-lg-4 mb-5 text-gray-600">
                                        Nomor KK
                                    </div>
                                    <div class="col-lg-8 mb-5 fw-bolder">
                                        {{$noNullable(data?.klien_history?.kk_number)}}
                                    </div>
                                    <div class="col-lg-4 mb-5 text-gray-600">
                                        Alamat KK
                                    </div>
                                    <div class="col-lg-4 mb-5">
                                        <div class="fw-bolder">{{$noNullable(data?.klien_history?.kk_address)}}</div>
                                        <div class="text-gray-600 pt-2">Kecamatan: <span
                                                class="text-black fw-bolder">{{$noNullable(data?.klien_history?.kelurahan_kk?.kecamatan?.name)}} </span></div>
                                    </div>
                                    <div class="col-lg-4 mb-5">
                                        <div class="text-gray-600">Kelurahan: <span
                                                class="text-black fw-bolder">{{$noNullable(data?.klien_history?.kelurahan_kk?.name)}} </span></div>
                                    </div>
                                    <div class="col-lg-4 mb-5 text-gray-600">
                                        No. Telepon/Whatsapp
                                    </div>
                                    <div class="col-lg-8 mb-5 fw-bolder">
                                        {{$noNullable(data?.phone_number)}}
                                    </div>
                                    <div class="col-lg-4 mb-5 text-gray-600">
                                        Tempat, Tanggal Lahir
                                    </div>
                                    <div class="col-lg-4 mb-5">
                                        <div class="fw-bolder">{{$noNullable(data?.klien_history?.kabupaten_lahir?.name)}}, {{$noNullable(data?.klien_history?.birth_date)}}</div>
                                    </div>
                                    <div class="col-lg-4 mb-5">
                                        <div class="text-gray-600">Usia: <span class="text-black fw-bolder">{{getDiffYears(data?.klien_history?.birth_date)}}
                                                Tahun</span></div>
                                    </div>
                                    <div class="col-lg-4 mb-5 text-gray-600">
                                        Kategori Klien
                                    </div>
                                    <div class="col-lg-8 mb-5 fw-bolder">
                                        <span v-if="data?.klien_history?.age_category == 1">Anak - Anak</span>
                                        <span v-else-if="data?.klien_history?.age_category == 2">Dewasa</span>
                                        <span v-else>-</span>
                                    </div>
                                    <div class="col-lg-4 mb-5 text-gray-600">
                                        Jenis Klien
                                    </div>
                                    <div class="col-lg-8 mb-5 fw-bolder">
                                        <span v-if="data?.klien_history?.physical_category == 1">Umum</span>
                                        <span v-else-if="data?.klien_history?.physical_category == 2">Disabilitas</span>
                                        <span v-else>-</span>
                                    </div>
                                    <div class="col-lg-4 mb-5 text-gray-600">
                                        Jenis Kelamin
                                    </div>
                                    <div class="col-lg-8 mb-5 fw-bolder">
                                        <span v-if="data?.klien_history?.gender == 1">Laki - Laki</span>
                                        <span v-else-if="data?.klien_history?.gender == 2">Perempuan</span>
                                        <span v-else>-</span>
                                    </div>
                                    <div class="col-lg-4 mb-5 text-gray-600">
                                        Agama
                                    </div>
                                    <div class="col-lg-8 mb-5 fw-bolder">
                                        {{$noNullable(data?.klien_history?.agama?.name)}}
                                    </div>
                                    <div class="col-lg-4 mb-5 text-gray-600">
                                        Pekerjaan
                                    </div>
                                    <div class="col-lg-8 mb-5 fw-bolder">
                                        {{$noNullable(data?.klien_history?.pekerjaan?.name)}}
                                    </div>
                                    <div class="col-lg-4 mb-5 text-gray-600">
                                        Penghasilan Perbulan
                                    </div>
                                    <div class="col-lg-8 mb-5 fw-bolder">
                                        {{$rupiahFormat(data?.klien_history?.monthly_income)}}
                                    </div>
                                    <div class="col-lg-4 mb-5 text-gray-600">
                                        Status Perkawinan
                                    </div>
                                    <div class="col-lg-8 mb-5 fw-bolder">
                                        {{$noNullable(data?.klien_history?.status_pernikahan?.name)}}
                                    </div>
                                    <div class="col-lg-4 mb-5 text-gray-600">
                                        Kepemilikan BPJS
                                    </div>
                                    <div class="col-lg-8 mb-5 fw-bolder">
                                        <span v-if="data?.klien_history?.bpjs_category == 1">PBI</span>
                                        <span v-else-if="data?.klien_history?.bpjs_category == 2">Korporasi </span>
                                        <span v-else-if="data?.klien_history?.bpjs_category == 2">Mandiri </span>
                                        <span v-else-if="data?.klien_history?.bpjs_category == 4">Lainnya </span>
                                        <span v-else>-</span>
                                    </div>
                                </div>
                                <div class="row align-items-center pb-5 mb-5" style="border-bottom:1px #E5EAEE solid;">
                                    <div class="col-lg-12">
                                        <h4 class="c-primary-custom mb-8">Pendidikan Klien</h4>
                                    </div>
                                    <div class="col-lg-4 mb-5 text-gray-600">
                                        Pendidikan
                                    </div>
                                    <div class="col-lg-4 mb-5 fw-bolder">
                                        {{$noNullable(data?.klien_history?.pendidikan_terakhir?.name)}}
                                    </div>
                                    <div class="col-lg-2 mb-5 text-gray-600">
                                        Jurusan Sekolah
                                    </div>
                                    <div class="col-lg-2 mb-5 fw-bolder">
                                        {{$noNullable(data?.klien_history?.jurusan?.name)}}
                                    </div>
                                    <div class="col-lg-4 mb-5 text-gray-600">
                                        Kelas
                                    </div>
                                    <div class="col-lg-4 mb-5 fw-bolder">
                                        {{$noNullable(data?.klien_history?.highest_class)}}
                                    </div>
                                    <div class="col-lg-2 mb-5 text-gray-600">
                                        Tahun Lulus
                                    </div>
                                    <div class="col-lg-2 mb-5 fw-bolder">
                                        {{$noNullable(data?.klien_history?.graduation_year)}}
                                    </div>
                                    <div class="col-lg-4 mb-5 text-gray-600">
                                        Nama Instansi Sekolah
                                    </div>
                                    <div class="col-lg-8 mb-5 fw-bolder">
                                        {{$noNullable(data?.klien_history?.nama_sekolah)}}
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
        
        return moment().diff(moment(value, "DD-MM-YYYY"), 'years') ? moment().diff(moment(value, "DD-MM-YYYY"),
            'years') : '-';
    }

</script>

<style scoped>

</style>
