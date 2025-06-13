<template>
    <div>
        <div class="head my-5">
            <div class="row pt-5 mt-4">
                <div class="col-12">
                    <div class="d-flex flex-wrap">
                        <div class="" style="border-right:1px solid grey;padding-right:10px;">
                            <h4>Detail Pengaduan</h4>
                        </div>
                        <div>
                            &ensp;<span class="text-muted">
                                <a href="javascript:void(0)" @click="$router.push({name:'pengaduan'})" class="text-muted"
                                    style="text-decoration:none;">Pengaduan</a>
                                - Detail Data
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row align-items-center mt-5">
            <div class="col-lg-5">
                <h1>Detail Pengaduan</h1>
            </div>
            <div class="col-lg-7 d-flex flex-wrap" style="justify-content:flex-end;">
                <button type="button" class="btn" style="background-color:#fff8dd;" @click="$router.push({name:'pengaduan'})">
                    <span class="text-warning d-flex">
                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
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
        </div>
        <div class="d-flex justify-content-center flex-wrap mb-10 mt-5" v-if="dataDetail">
            <a href="javascript:void(0)" style="font-size:15px;border-radius:5px" class="text-gray-800 py-2 px-4"
                @click="flagTab = 'identitas-klien'"
                :class="flagTab == 'identitas-klien' ? 'bg-primary-custom text-white' : ''">Identitas Klien</a>
            <a
                href="javascript:void(0)" style="font-size:15px;border-radius:5px" class="text-gray-800 py-2 px-4"
                @click="flagTab = 'penjangkauan';getOutreachComplaint()"
                :class="flagTab == 'penjangkauan' ? 'bg-primary-custom text-white' : ''">Penjangkauan</a>
            <a href="javascript:void(0)" style="font-size:15px;border-radius:5px" class="text-gray-800 py-2 px-4"
                @click="flagTab = 'kebutuhan-intervensi'"
                :class="flagTab == 'kebutuhan-intervensi' ? 'bg-primary-custom text-white' : ''">Kebutuhan
                Intervensi</a>           
            <a href="javascript:void(0)" style="font-size:15px;border-radius:5px" class="text-gray-800 py-2 px-4"
                @click="flagTab = 'intervensi-opd'"
                :class="flagTab == 'intervensi-opd' ? 'bg-primary-custom text-white' : ''">Intervensi OPD</a>
        </div>
        <div class="card card-flush mt-5 mb-5 mb-xl-10" id="kt_profile_details_view"
            v-if="flagTab == 'identitas-klien'">
            <div class="card card-xl-stretch py-10" v-if="loaderDataDetail == true">
                <div class="d-flex align-items-center justify-content-center w-100">
                    <app-loader></app-loader>
                </div>
            </div>
            <div class="card card-xl-stretch mb-5 mb-xl-8" v-else>
                <div class="card-header border-0 pt-5 align-items-center">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder text-dark mb-2" style="font-size:20px !important;">Identitas
                            Klien<span class="c-primary-custom ps-3">{{dataDetail?.identitas_klien?.nama}} ({{dataDetail?.identitas_klien?.inisial_klien}})</span><span
                                :class="`badge ${dataDetail?.status?.label_status} ms-3`">{{dataDetail?.status?.status}}</span></span>
                    </h3>
                </div>
                <div class="card-body pt-5">
                    <div class="d-flex flex-wrap">
                        <a href="javascript:void(0)" @click="flagTabIdentitasClient = 'identitas-klien'"
                            :class="flagTabIdentitasClient == 'identitas-klien' ? 'active' : ''"
                            class="nav-tab-custom-x">Identitas Klien</a>
                        <a href="javascript:void(0)" @click="flagTabIdentitasClient = 'keluarga'"
                            :class="flagTabIdentitasClient == 'keluarga' ? 'active' : ''" class="nav-tab-custom-x">Data
                            Keluarga</a>
                    </div>
                    <template v-if="loaderDataIdentitas && flagTabIdentitasClient == 'identitas-klien'">
                        <div class="d-flex align-items-center justify-content-center w-100">
                            <app-loader></app-loader>
                        </div>
                    </template>
                    <template v-else>
                        <div class="row mt-8 align-items-center" v-if="flagTabIdentitasClient == 'identitas-klien'">                       
                            <div class="col-lg-4 mb-5 text-gray-600">
                                Nama Lengkap (Inisial)
                            </div>
                            <div class="col-lg-8 mb-5 fw-bolder">
                                {{$noNullable(dataIdentitas?.name)}} ({{$noNullable(dataIdentitas?.initial_name)}})
                            </div>
                            <div class="col-lg-4 mb-5 text-gray-600">
                                NIK/Nomor Identitas
                            </div>
                            <div class="col-lg-8 mb-5 fw-bolder">
                                {{dataIdentitas?.is_has_nik ? dataIdentitas?.nik_number : dataIdentitas?.identity_number}}&ensp;<span class="badge badge-primary ms">{{dataIdentitas?.is_has_nik ? 'NIK' : 'Nomor Identitas'}}</span>
                            </div>
                            <div class="col-lg-4 mb-5 text-gray-600">
                                Warga Surabaya
                            </div>
                            <div class="col-lg-8 mb-5 fw-bolder">
                                {{dataIdentitas?.is_surabaya_resident == true ? 'Ya' : 'Tidak'}}
                            </div>
                            <div class="col-lg-4 mb-5 text-gray-600">
                                Kabupaten/Kota
                            </div>
                            <div class="col-lg-8 mb-5 fw-bolder">
                                {{$noNullable(dataIdentitas?.klien_history?.kelurahan_tinggal?.kecamatan?.kabupaten?.name)}}
                            </div>
                            <div class="col-lg-4 mb-5 text-gray-600">
                                Alamat Domisili
                            </div>
                            <div class="col-lg-4 mb-5">
                                <div class="fw-bolder">{{$noNullable(dataIdentitas?.klien_history?.residence_address)}}</div>
                                <div class="text-gray-600 pt-2">Kecamatan: <span class="text-black fw-bolder">{{$noNullable(dataIdentitas?.klien_history?.kelurahan_tinggal?.kecamatan?.name)}} </span>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-5">
                                <div class="text-gray-600">Kelurahan: <span class="text-black fw-bolder">{{$noNullable(dataIdentitas?.klien_history?.kelurahan_tinggal?.name)}} </span>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-5 text-gray-600">
                                Nomor KK
                            </div>
                            <div class="col-lg-8 mb-5 fw-bolder">
                                {{$noNullable(dataIdentitas?.klien_history?.kk_number)}}
                            </div>
                            <div class="col-lg-4 mb-5 text-gray-600">
                                Alamat KK
                            </div>
                            <div class="col-lg-4 mb-5">
                                <div class="fw-bolder">{{$noNullable(dataIdentitas?.klien_history?.kk_address)}}</div>
                                <div class="text-gray-600 pt-2">Kecamatan: <span class="text-black fw-bolder">{{$noNullable(dataIdentitas?.klien_history?.kelurahan_kk?.kecamatan?.name)}} </span>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-5">
                                <div class="text-gray-600">Kelurahan: <span class="text-black fw-bolder">{{$noNullable(dataIdentitas?.klien_history?.kelurahan_kk?.name)}} </span>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-5 text-gray-600">
                                No. Telepon/Whatsapp
                            </div>
                            <div class="col-lg-8 mb-5 fw-bolder">
                                {{$noNullable(dataIdentitas?.phone_number)}}
                            </div>
                            <div class="col-lg-4 mb-5 text-gray-600">
                                Tempat, Tanggal Lahir
                            </div>
                            <div class="col-lg-4 mb-5">
                                <div class="fw-bolder">{{$noNullable(dataIdentitas?.klien_history?.kabupaten_lahir?.name)}}, {{$moment(dataIdentitas?.klien_history?.birth_date,'DD-MM-YYYY').locale('id').format('DD MMMM YYYY') ?? '-'}}</div>
                            </div>
                            <div class="col-lg-4 mb-5">
                                <div class="text-gray-600">Usia: <span class="text-black fw-bolder">{{getUmur(dataIdentitas?.klien_history?.birth_date)}} Tahun</span></div>
                            </div>
                            <div class="col-lg-4 mb-5 text-gray-600">
                                Kategori Klien
                            </div>
                            <div class="col-lg-8 mb-5 fw-bolder">
                                <span v-if="dataIdentitas?.klien_history?.age_category == 1">Anak - Anak</span>
                                <span v-else-if="dataIdentitas?.klien_history?.age_category == 1">Dewasa</span>
                                <span v-else>-</span>                                
                            </div>
                            <div class="col-lg-4 mb-5 text-gray-600">
                                Jenis Klien
                            </div>
                            <div class="col-lg-8 mb-5 fw-bolder">
                                <span v-if="dataIdentitas?.klien_history?.physical_category == 1">Umum</span>
                                <span v-else-if="dataIdentitas?.klien_history?.physical_category == 1">Disabilitas</span>
                                <span v-else>-</span>                              
                            </div>
                            <div class="col-lg-4 mb-5 text-gray-600">
                                Jenis Kelamin
                            </div>
                            <div class="col-lg-8 mb-5 fw-bolder">
                                <span v-if="dataIdentitas?.klien_history?.gender == 1">Laki - Laki</span>
                                <span v-else-if="dataIdentitas?.klien_history?.gender == 1">Perempuan</span>
                                <span v-else>-</span>                                    
                            </div>
                            <div class="col-lg-4 mb-5 text-gray-600">
                                Agama
                            </div>
                            <div class="col-lg-8 mb-5 fw-bolder">
                                {{$noNullable(dataIdentitas?.klien_history?.agama?.name)}}
                            </div>
                            <div class="col-lg-4 mb-5 text-gray-600">
                                Pekerjaan
                            </div>
                            <div class="col-lg-8 mb-5 fw-bolder">
                                {{$noNullable(dataIdentitas?.klien_history?.pekerjaan?.name)}}
                            </div>
                            <div class="col-lg-4 mb-5 text-gray-600">
                                Penghasilan Perbulan
                            </div>
                            <div class="col-lg-8 mb-5 fw-bolder">
                                {{$noNullable(dataIdentitas?.klien_history?.monthly_income)}}
                            </div>
                            <div class="col-lg-4 mb-5 text-gray-600">
                                Status Perkawinan
                            </div>
                            <div class="col-lg-8 mb-5 fw-bolder">
                                {{$noNullable(dataIdentitas?.klien_history?.status_pernikahan?.name)}}
                            </div>
                            <div class="col-lg-4 mb-5 text-gray-600">
                                Kepemilikan BPJS
                            </div>
                            <div class="col-lg-8 mb-5 fw-bolder">
                                {{kepemilikanBpjs(dataIdentitas?.klien_history?.bpjs_category)}}
                            </div>
                        </div>
                        <div class="row align-items-center pb-5 mb-5" v-if="flagTabIdentitasClient == 'identitas-klien'"
                            style="border-bottom:1px #E5EAEE solid;">
                            <div class="col-lg-12">
                                <h4 class="c-primary-custom mb-8">Pendidikan Klien</h4>
                            </div>
                            <div class="col-lg-4 mb-5 text-gray-600">
                                Pendidikan
                            </div>
                            <div class="col-lg-4 mb-5 fw-bolder">
                                {{$noNullable(dataIdentitas?.klien_history?.pendidikan_terakhir?.name)}}
                            </div>
                            <div class="col-lg-2 mb-5 text-gray-600">
                                Jurusan Sekolah
                            </div>
                            <div class="col-lg-2 mb-5 fw-bolder">
                                {{$noNullable(dataIdentitas?.klien_history?.jurusan?.name)}}
                            </div>
                            <div class="col-lg-4 mb-5 text-gray-600">
                                Kelas
                            </div>
                            <div class="col-lg-4 mb-5 fw-bolder">
                                {{$noNullable(dataIdentitas?.klien_history?.highest_class)}}
                            </div>
                            <div class="col-lg-2 mb-5 text-gray-600">
                                Tahun Lulus
                            </div>
                            <div class="col-lg-2 mb-5 fw-bolder">
                                {{$noNullable(dataIdentitas?.klien_history?.graduation_year)}}
                            </div>
                            <div class="col-lg-4 mb-5 text-gray-600">
                                Nama Instansi Sekolah
                            </div>
                            <div class="col-lg-8 mb-5 fw-bolder">
                                {{$noNullable(dataIdentitas?.klien_history?.nama_sekolah)}}
                            </div>
                        </div>
                    </template>
                    <template v-if="loaderDataKeluarga && flagTabIdentitasClient == 'keluarga'">
                        <div class="d-flex align-items-center justify-content-center w-100">
                            <app-loader></app-loader>
                        </div>
                    </template>
                    <template v-else>
                        <div class="text-gray-600 pt-5" v-if="dataDetail && dataKeluarga.keluarga_klien.length == 0">Tidak ada data keluarga yang ditambahkan</div>
                        <div class="mt-8" v-if="flagTabIdentitasClient == 'keluarga'">
                            <div class="row align-items-center pb-5 mb-5" v-for="(context, index) in dataKeluarga.keluarga_klien">
                                <div class="col-lg-12">
                                    <h4 class="c-primary-custom mb-8">Keluarga {{index + 1}}</h4>
                                </div>
                                <div class="col-lg-4 mb-5 text-gray-600">
                                    Hubungan dengan Klien
                                </div>
                                <div class="col-lg-8 mb-5 fw-bolder">
                                    {{$noNullable(context?.hubungan?.name)}}
                                </div>
                                <div class="col-lg-4 mb-5 text-gray-600">
                                    Nama Lengkap
                                </div>
                                <div class="col-lg-8 mb-5 fw-bolder">
                                    {{$noNullable(context?.name)}}
                                </div>
                                <div class="col-lg-4 mb-5 text-gray-600">
                                    NIK
                                </div>
                                <div class="col-lg-8 mb-5 fw-bolder">
                                    {{$noNullable(context?.nik_number)}}
                                </div>
                                <div class="col-lg-4 mb-5 text-gray-600">
                                    Nomor KK
                                </div>
                                <div class="col-lg-8 mb-5 fw-bolder">
                                    {{$noNullable(context.kk_number)}}
                                </div>
                                <div class="col-lg-4 mb-5 text-gray-600">
                                    No. Telepon/Whatsapp
                                </div>
                                <div class="col-lg-8 mb-5 fw-bolder">
                                    {{$noNullable(context?.phone_number)}}
                                </div>
                                <div class="col-lg-4 mb-5 text-gray-600">
                                    Alamat KK
                                </div>
                                <div class="col-lg-8 mb-5">
                                    <div class="fw-bolder">{{$noNullable(context?.kk_address)}}, Kel. {{$noNullable(context?.kelurahan_kk?.name)}}, Kec. {{$noNullable(context?.kelurahan_kk?.kecamatan?.name)}}, Kab. {{$noNullable(context?.kelurahan_kk?.kecamatan?.kabupaten?.name)}}</div>
                                </div>
                                <div class="col-lg-4 mb-5 text-gray-600">
                                    Alamat Domisili
                                </div>
                                <div class="col-lg-8 mb-5">
                                    <div class="fw-bolder">{{$noNullable(context?.residence_address)}}, Kel. {{$noNullable(context?.kelurahan_tinggal?.name)}}, Kec. {{$noNullable(context?.kelurahan_tinggal?.kecamatan?.name)}}, Kab. {{$noNullable(context?.kelurahan_tinggal?.kecamatan?.kabupaten?.name)}}</div>
                                </div>
                                <div class="col-lg-4 mb-5 text-gray-600">
                                    Pekerjaan
                                </div>
                                <div class="col-lg-4 mb-5">
                                    <div class="fw-bolder">{{$noNullable(context?.pekerjaan?.name)}}</div>
                                </div>
                                <div class="col-lg-2 mb-5 text-gray-600">
                                    Sifat Pekerjaan
                                </div>
                                <div class="col-lg-2 mb-5 fw-bolder">
                                    {{$noNullable(context?.work_type)}}
                                </div>
                                <div class="col-lg-4 mb-5 text-gray-600">
                                    Penghasilan Per Bulan
                                </div>
                                <div class="col-lg-8 mb-5 fw-bolder">
                                    {{$noNullable(context?.monthly_income)}}
                                </div>
                                <div class="col-lg-4 mb-5 text-gray-600">
                                    Agama
                                </div>
                                <div class="col-lg-8 mb-5 fw-bolder">
                                    {{$noNullable(context?.agama?.name)}}
                                </div>
                                <div class="col-lg-4 mb-5 text-gray-600">
                                    Tempat, Tanggal Lahir
                                </div>
                                <div class="col-lg-4 mb-5 fw-bolder">
                                    {{$noNullable(context?.kabupaten_lahir?.name)}}, {{$moment(context?.birth_date,'DD-MM-YYYY').locale('id').format('DD MMMM YYYY') ?? '-'}}
                                </div>
                                <div class="col-lg-2 mb-5 text-gray-600">
                                    Usia
                                </div>
                                <div class="col-lg-2 mb-5 fw-bolder">
                                    {{getUmur(context?.birth_date)}} Tahun
                                </div>
                                <div class="col-lg-4 mb-5 text-gray-600">
                                    Kepemilikan BPJS
                                </div>
                                <div class="col-lg-8 mb-5 fw-bolder">
                                    {{kepemilikanBpjs(context?.bpjs_category)}}
                                </div>
                            </div>
                            <h4 class="c-primary-custom mb-8">Data Saudara</h4>
                            <div class="text-gray-600" v-if="dataKeluarga.saudara_klien.length == 0">Tidak ada data saudara yang ditambahkan</div>
                            <div class="row">
                                <template v-for="(context, index) in dataKeluarga.saudara_klien">
                                    <div class="col-lg-4 mb-5 text-gray-600">
                                        Saudara {{index + 1}}/Anak ke {{index + 1}}
                                    </div>
                                    <div class="col-lg-8 mb-5 fw-bolder">
                                        {{$noNullable(context?.name)}}
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
        <div class="card card-flush mt-5 mb-5 mb-xl-10" id="kt_profile_details_view"
            v-if="flagTab == 'kebutuhan-intervensi'">
            <div class="card card-xl-stretch py-10" v-if="loaderDataIntervensiOpd == true">
                <div class="d-flex justify-content-center align-items-center">
                    <app-loader></app-loader>
                </div>
            </div>
            <div class="card card-xl-stretch mb-5 mb-xl-8" v-else>
                <div class="card-header border-0 pt-5 align-items-center">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder text-dark mb-2" style="font-size:20px !important;">Kebutuhan
                            Intervensi<span class="c-primary-custom ps-3">{{$noNullable(dataDetail?.identitas_klien?.nama)}} ({{$noNullable(dataDetail?.identitas_klien?.inisial_klien)}})</span><span :class="`badge ${dataDetail?.status?.label_status} ms-3`">{{$noNullable(dataDetail?.status?.status)}}</span></span>
                    </h3>
                </div>
                <div class="card-body pt-5">
                    <template v-for="(context, index) in dataIntervensiOpd">
                        <h4 class="c-primary-custom fw-bolder pb-2">Pelayanan {{index + 1}}</h4>
                        <div class="row">
                            <div class="col-lg-4 text-gray-600 mb-5">
                                Kebutuhan
                            </div>
                            <div class="col-lg-8 fw-bolder mb-5">
                                {{$noNullable(context?.kebutuhan?.name)}}
                            </div>
                            <div class="col-lg-4 text-gray-600 mb-5">
                                OPD
                            </div>
                            <div class="col-lg-8 fw-bolder mb-5">
                                {{$noNullable(context?.opd?.name)}}
                            </div>
                            <div class="col-lg-4 text-gray-600 mb-5">
                                Pelayanan Yang Diberikan
                            </div>
                            <div class="col-lg-8 fw-bolder mb-5">
                                {{$noNullable(context?.intervensi?.name)}}
                            </div>                       
                        </div>
                    </template>

                </div>
            </div>
        </div>
        <div class="card card-flush mt-5 mb-5 mb-xl-10" id="kt_profile_details_view" v-if="flagTab == 'intervensi-opd'">
            <div class="card card-xl-stretch py-10" v-if="loaderDataIntervensiOpd == true">
                <div class="d-flex align-items-cente justify-content-center">
                    <app-loader></app-loader>
                </div>
            </div>
            <div class="card card-xl-stretch mb-5 mb-xl-8" v-else>
                <div class="card-header border-0 pt-5 align-items-center">
                    <div class="row w-100">
                        <div class="col-lg-12">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bolder text-dark mb-2"
                                    style="font-size:20px !important;">Data Intervensi OPD<span class="c-primary-custom ps-3">{{dataDetail?.identitas_klien?.nama}} ({{dataDetail?.identitas_klien?.inisial_klien}})</span><span :class="`badge ${dataDetail?.status?.label_status} ms-3`">{{dataDetail?.status?.status}}</span></span>
                            </h3>
                        </div>                  
                    </div>
                </div>
                <div class="card-body pt-5">
                    <template v-for="(context, index) in dataIntervensiOpd">
                        <div class="row mb-5">
                            <div class="col-lg-8">
                                <h4 class="c-primary-custom fw-bolder pb-1">Pelayanan {{index + 1}}  {{$noNullable(context?.kebutuhan?.name)}}</h4>
                                <div class="text-gray-600">Pelayanan Yang Diberikan <span class="text-black fw-bolder"> {{$noNullable(context?.intervensi?.name)}}</span></div>
                                <span :class="`badge badge-light-info mb-3 mt-3`" v-if="context.realisasi_draft_status">Proses Intervensi</span>
                                <span :class="`badge badge-success mt-3 mb-3`" v-else>Selesai</span>
                            </div>
                            <div class="col-lg-4 d-flex justify-content-end flex-wrap align-items-center d-flex" v-if="context.realisasi_intervensi.length > 0">
                                <button type="button" class="btn btn-sm me-3 c-second-primary-custom"
                                @click="confirmCompleteInterventionActivityOpd(context.id)"  v-if="context.realisasi_draft_status"
                                style="background:#FFF4DD !important">Akhiri Kegiatan</button>
                                <button type="button" class="btn btn-sm text-white bg-second-primary-custom" v-if="context.realisasi_draft_status"
                                    @click="showModalAddInterventionActivityOpd(context.id)">Tambah Data</button>
                            </div>
                            <div class="col-lg-12">
                                  <div class="d-flex flex-column justify-content-center align-items-center mb-5"
                                    v-if="context.realisasi_intervensi.length == 0">
                                    <img :src="`${$assetUrl()}extends/img/empty.png`" />
                                    <div class="text-gray-600 pt-5">Belum ada kegiatan intervensi yang ditambahkan.</div>
                                    <button @click="showModalAddInterventionActivityOpd(context.id)" type="button"
                                        class="btn btn-sm mt-3 text-white bg-second-primary-custom">Tambah Data</button>
                                </div>
                                <div class="timeline-custom mt-1">
                                    <div class="container-timeline-custom right-timeline-custom" v-for="(detail, index) in context.realisasi_intervensi">
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
                                                {{$noNullable(detail?.name)}}
                                            </h2>
                                            <div class="text-gray-600 mb-3">{{$moment(detail.created_at,'DD-MM-YYYYY H:mm').locale('id').format('dddd, DD MMMM YYYY (H:mm)')}} oleh <span
                                                    class="text-black fw-bolder">{{$noNullable(detail?.created_by?.opd?.name)}}</span></div>
                                            <div class="p-3" style="border: 1px dashed #E4E6EF;border-radius:12px;">
                                                <div class="row">
                                                    <div class="col-lg-12 my-1 col-md-12">{{$noNullable(detail?.description)}}</div>
                                                    <div class="col-lg-12">
                                                        <div class="row mt-3">
                                                            <div class="col-lg-2 col-md-3 col-sm-6 col-6 mb-5" v-for="(file,index) in detail.file ?? []">
                                                                <a :href="file?.path"
                                                                    data-fancybox="gallery"><img
                                                                        :src="file?.path"
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
                        </div>                                          
                    </template>
                  
                </div>
            </div>
        </div>


        <template v-if="flagTab == 'penjangkauan'">
            <div class="card card-flush mt-5 mb-5 mb-xl-10" id="kt_profile_details_view">
                <div v-if="$store.state.complaint.outreachComplaint.loading"
                    class="w-100 d-flex justify-content-center mt-10 mb-10">
                    <app-loader></app-loader>
                </div>
                <div class="card card-xl-stretch mb-5 mb-xl-8" v-else>
                    <div class="card-header border-0 pt-5 align-items-center">
                        <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bolder text-dark mb-2"
                                    style="font-size:20px !important;">Detail Penjangkauan<span class="c-primary-custom ps-3">{{dataDetail?.identitas_klien?.nama}} ({{dataDetail?.identitas_klien?.inisial_klien}})</span><span :class="`badge ${dataDetail?.status?.label_status} ms-3`">{{dataDetail?.status?.status}}</span></span>
                            </h3>
                    </div>
                    <div class="card-body pt-5">
                        <h4 class="c-primary-custom fw-bolder pb-2">Penjadwalan</h4>
                        <div class="row">
                            <div class="col-lg-4 text-gray-600 mb-5">
                                Hari, Tanggal, Jam
                            </div>
                            <div class="col-lg-8 fw-bolder mb-5">
                                {{$moment($store.state.complaint.outreachComplaint.plan.datetime, 'DD-MM-YYYY HH:mm').locale('id').format('DD MMMM YYYY  HH:mm')}}
                            </div>
                            <div class="col-lg-4 text-gray-600 mb-5">
                                Tempat
                            </div>
                            <div class="col-lg-8 fw-bolder mb-5">
                                {{$noNullable($store.state.complaint.outreachComplaint.plan.place)}}
                            </div>
                            <div class="col-lg-4 text-gray-600 mb-5">
                                Alamat
                            </div>
                            <div class="col-lg-8 fw-bolder mb-5">
                                {{$noNullable($store.state.complaint.outreachComplaint.plan.address)}}
                            </div>
                        </div>
                        <h4 class="c-primary-custom fw-bolder pb-2">Tim Outreach Yang Bertugas</h4>
                        <div class="row align-items-center">
                            <template v-for="(context, index) in $store.state.complaint.outreachComplaint.konselorTeam">
                                <div class="col-lg-4 text-gray-600 mb-5">
                                    Konselor {{index + 1}}
                                </div>
                                <div class="col-lg-8 fw-bolder mb-5">
                                    <div class="d-flex align-items-center">
                                        <img class="me-3" :src="context.konselor ? context.konselor.foto : ''"
                                            style="width:50px;height:50px;border-radius:5px;">
                                        <div>{{$noNullable(context.konselor ? context.konselor.name : '-')}}</div>
                                    </div>
                                </div>
                            </template>
                        </div>
                        <div v-if="$store.state.complaint.detailComplaint.status.id == 6" class="mt-5 pt-8"
                            style="border-top:1px #f2f2 solid">
                            <h4 class="text-danger fw-bolder pb-2">Hasil Penjangkauan Di Revisi</h4>
                            <div class="row">
                                <div class="col-lg-4 text-gray-600 mb-5">
                                    Keterangan Pengembalian
                                </div>
                                <div class="col-lg-8 mb-5 fw-bolder">
                                    {{$noNullable($store.state.complaint.outreachComplaint.lastRollbackNote)}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-flush mt-5 mb-5 mb-xl-10" id="kt_profile_details_view">
                <div v-if="$store.state.complaint.outreachComplaint.loading"
                    class="w-100 d-flex justify-content-center mt-10 mb-10">
                    <app-loader></app-loader>
                </div>
                <div class="card card-xl-stretch mb-5 mb-xl-8" v-else>
                    <div class="card-header border-0 pt-5 align-items-center justify-content-between flex-wrap">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bolder text-dark mb-2" style="font-size:20px !important;">Detail
                                Hasil Penjangkauan</span>
                        </h3>
                    </div>
                    <div class="card-body pt-5">
                        <div v-if="!$store.state.complaint.outreachComplaint.result.pendampingan"
                            class="alert alert-dismissible bg-light-warning d-flex flex-column flex-sm-row p-5 align-items-center mb-10">
                            <!--begin::Icon-->
                            <span class="svg-icon svg-icon-2hx svg-icon-warning me-4 mb-5 mb-sm-0">

                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.3"
                                        d="M29.3346 16.0003C29.3346 8.63653 23.3651 2.66699 16.0013 2.66699C8.63751 2.66699 2.66797 8.63653 2.66797 16.0003C2.66797 23.3641 8.63751 29.3337 16.0013 29.3337C23.3651 29.3337 29.3346 23.3641 29.3346 16.0003Z"
                                        fill="#FFC700" />
                                    <path
                                        d="M14.668 14.667V21.3337C14.668 22.07 15.2649 22.667 16.0013 22.667C16.7377 22.667 17.3346 22.07 17.3346 21.3337V14.667C17.3346 13.9306 16.7377 13.3337 16.0013 13.3337C15.2649 13.3337 14.668 13.9306 14.668 14.667Z"
                                        fill="#FFC700" />
                                    <path
                                        d="M16.0013 9.33333C15.2649 9.33333 14.668 9.93029 14.668 10.6667C14.668 11.403 15.2649 12 16.0013 12C16.7377 12 17.3346 11.403 17.3346 10.6667C17.3346 9.93029 16.7377 9.33333 16.0013 9.33333Z"
                                        fill="#FFC700" />
                                </svg>

                            </span>
                            <div class="d-flex flex-column pe-0 pe-sm-10">
                                <!--begin::Title-->
                                <h4 class="fw-bold">Klien Tidak Bersedia Didampingi</h4>
                            </div>
                        </div>
                        <div class="accordion" id="kt_accordion_1">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="kt_accordion_1_header_1">
                                    <button class="accordion-button fs-4 fw-semibold" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_1"
                                        aria-expanded="true" aria-controls="kt_accordion_1_body_1">
                                        Detail Kasus Klien
                                    </button>
                                </h2>

                                <div id="kt_accordion_1_body_1" class="accordion-collapse collapse show"
                                    aria-labelledby="kt_accordion_1_header_1" data-bs-parent="#kt_accordion_1">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-lg-2 text-gray-600 mb-5">
                                                Tipe Kasus
                                            </div>
                                            <div class="col-lg-10 mb-5 fw-bolder">
                                                <span
                                                    v-if="$store.state.complaint.outreachComplaint.result.caseType == 1">Kasus
                                                    Lama</span>
                                                <span
                                                    v-else-if="$store.state.complaint.outreachComplaint.result.caseType ==2">Kasus
                                                    Baru</span>
                                                <span v-else>-</span>
                                            </div>
                                            <div class="col-lg-2 text-gray-600 mb-5">
                                                Tipe Pemasalahan
                                            </div>
                                            <div class="col-lg-10 mb-5 fw-bolder">
                                                {{$noNullable($store.state.complaint.outreachComplaint.result.problemType)}}
                                            </div>
                                            <div class="col-lg-2 text-gray-600 mb-5">
                                                Kategori Kasus
                                            </div>
                                            <div class="col-lg-10 mb-5 fw-bolder">
                                                {{$noNullable($store.state.complaint.outreachComplaint.result.caseCategory)}}
                                            </div>
                                            <div class="col-lg-2 text-gray-600 mb-5">
                                                Jenis Kasus
                                            </div>
                                            <div class="col-lg-10 mb-5 fw-bolder">
                                                {{$noNullable($store.state.complaint.outreachComplaint.result.caseSpecies)}}
                                            </div>
                                            <div class="col-lg-2 text-gray-600 mb-5">
                                                Lokasi Kasus
                                            </div>
                                            <div class="col-lg-10 mb-5 fw-bolder">
                                                {{$noNullable($store.state.complaint.outreachComplaint.result.caseLocation)}}
                                            </div>
                                            <div class="col-lg-2 text-gray-600 mb-5">
                                                Uraian Singkat Permasalahan
                                            </div>
                                            <div class="col-lg-10 mb-5 fw-bolder">
                                                {{$noNullable($store.state.complaint.outreachComplaint.result.note)}}
                                            </div>
                                            <div class="col-lg-2 text-gray-600 mb-5">
                                                Tanggal & Waktu Kejadian
                                            </div>
                                            <div class="col-lg-10 mb-5 fw-bolder">
                                                {{$noNullable($store.state.complaint.outreachComplaint.result.datetime)}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion mt-5" id="kt_accordion_2">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="kt_accordion_2_header_1">
                                    <button class="accordion-button fs-4 fw-semibold" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#kt_accordion_2_body_1"
                                        aria-expanded="true" aria-controls="kt_accordion_2_body_1">
                                        Dokumen Penyelesaian Kasus
                                    </button>
                                </h2>

                                <div id="kt_accordion_2_body_1" class="accordion-collapse collapse show"
                                    aria-labelledby="kt_accordion_2_header_1" data-bs-parent="#kt_accordion_2">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <template
                                                v-if="$store.state.complaint.outreachComplaint.result.pendampingan">
                                                <div class="col-lg-2 text-gray-600 mb-5">
                                                    Berita Acara Pendampingan Klien
                                                </div>
                                                <div class="col-lg-10">
                                                    <div class="row">
                                                        <div class="col-lg-3 col-md-6 mb-5"
                                                            v-for="(context, index) in $store.state.complaint.outreachComplaint.result.files.berita_acara_pendampingan">
                                                            <a v-if="context.isImage" :href="context.path"
                                                                data-fancybox="gallery">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="me-3">
                                                                        <img :src="$assetUrl() + 'extends/img/ic_files_img.png'"
                                                                            style="width:35px;" />
                                                                    </div>
                                                                    <div>
                                                                        <div class="fw-bolder text-primary"
                                                                            style="word-break: break-word;">
                                                                            {{$noNullable(context.name)}}</div>
                                                                        <div class="text-gray-500">
                                                                            {{$formatBytes(context.size)}}</div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                            <a :href="context.path" target="_blank" v-else>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="me-3">
                                                                        <img :src="$assetUrl() + 'extends/img/ic_files_pdf.png'"
                                                                            style="width:35px;" />
                                                                    </div>
                                                                    <div>
                                                                        <div class="fw-bolder text-primary"
                                                                            style="word-break: break-word;">
                                                                            {{$noNullable(context.name)}}</div>
                                                                        <div class="text-gray-500">
                                                                            {{$formatBytes(context.size)}}</div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 text-gray-600 mb-5">
                                                    Surat Pernyataan Klien Bersedia (Informed Consent)
                                                </div>
                                                <div class="col-lg-10">
                                                    <div class="row"
                                                        v-if="$store.state.complaint.outreachComplaint.result.files.surat_pernyataan_klien">
                                                        <div class="col-lg-12 col-md-12 mb-5">
                                                            <a v-if="$store.state.complaint.outreachComplaint.result.files.surat_pernyataan_klien.isImage"
                                                                :href="$store.state.complaint.outreachComplaint.result.files.surat_pernyataan_klien.path"
                                                                data-fancybox="gallery">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="me-3">
                                                                        <img :src="$assetUrl() + 'extends/img/ic_files_img.png'"
                                                                            style="width:35px;" />
                                                                    </div>
                                                                    <div>
                                                                        <div class="fw-bolder text-primary"
                                                                            style="word-break: break-word;">
                                                                            {{$noNullable($store.state.complaint.outreachComplaint.result.files.surat_pernyataan_klien.name)}}
                                                                        </div>
                                                                        <div class="text-gray-500">
                                                                            {{$formatBytes($store.state.complaint.outreachComplaint.result.files.surat_pernyataan_klien.size)}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                            <a :href="$store.state.complaint.outreachComplaint.result.files.surat_pernyataan_klien.path"
                                                                target="_blank" v-else>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="me-3">
                                                                        <img :src="$assetUrl() + 'extends/img/ic_files_pdf.png'"
                                                                            style="width:35px;" />
                                                                    </div>
                                                                    <div>
                                                                        <div class="fw-bolder text-primary"
                                                                            style="word-break: break-word;">
                                                                            {{$noNullable($store.state.complaint.outreachComplaint.result.files.surat_pernyataan_klien.name)}}
                                                                        </div>
                                                                        <div class="text-gray-500">
                                                                            {{$formatBytes($store.state.complaint.outreachComplaint.result.files.surat_pernyataan_klien.size)}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 text-gray-600 mb-5">
                                                    Surat Pernyataan Telah Selesai Pendampingan
                                                </div>
                                                <div class="col-lg-10">
                                                    <div class="row"
                                                        v-if="$store.state.complaint.outreachComplaint.result.files.surat_pernyataan_selesai_pendampingan">
                                                        <div class="col-lg-12 col-md-12 mb-5">
                                                            <a v-if="$store.state.complaint.outreachComplaint.result.files.surat_pernyataan_selesai_pendampingan.isImage"
                                                                :href="$store.state.complaint.outreachComplaint.result.files.surat_pernyataan_selesai_pendampingan.path"
                                                                data-fancybox="gallery">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="me-3">
                                                                        <img :src="$assetUrl() + 'extends/img/ic_files_img.png'"
                                                                            style="width:35px;" />
                                                                    </div>
                                                                    <div>
                                                                        <div class="fw-bolder text-primary"
                                                                            style="word-break: break-word;">
                                                                            {{$noNullable($store.state.complaint.outreachComplaint.result.files.surat_pernyataan_selesai_pendampingan.name)}}
                                                                        </div>
                                                                        <div class="text-gray-500">
                                                                            {{$formatBytes($store.state.complaint.outreachComplaint.result.files.surat_pernyataan_selesai_pendampingan.size)}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                            <a :href="$store.state.complaint.outreachComplaint.result.files.surat_pernyataan_selesai_pendampingan.path"
                                                                target="_blank" v-else>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="me-3">
                                                                        <img :src="$assetUrl() + 'extends/img/ic_files_pdf.png'"
                                                                            style="width:35px;" />
                                                                    </div>
                                                                    <div>
                                                                        <div class="fw-bolder text-primary"
                                                                            style="word-break: break-word;">
                                                                            {{$noNullable($store.state.complaint.outreachComplaint.result.files.surat_pernyataan_selesai_pendampingan.name)}}
                                                                        </div>
                                                                        <div class="text-gray-500">
                                                                            {{$formatBytes($store.state.complaint.outreachComplaint.result.files.surat_pernyataan_selesai_pendampingan.size)}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                            <template v-else>
                                                <div class="col-lg-2 text-gray-600 mb-5">
                                                    Surat Pernyataan Klien Tidak Bersedia Didampingi
                                                </div>
                                                <div class="col-lg-10">
                                                    <div class="row"
                                                        v-if="$store.state.complaint.outreachComplaint.result.files.surat_pernyataan_tidak_bersedia_didampingi">
                                                        <div class="col-lg-12 col-md-12 mb-5">
                                                            <a v-if="$store.state.complaint.outreachComplaint.result.files.surat_pernyataan_tidak_bersedia_didampingi.isImage"
                                                                :href="$store.state.complaint.outreachComplaint.result.files.surat_pernyataan_tidak_bersedia_didampingi.path"
                                                                data-fancybox="gallery">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="me-3">
                                                                        <img :src="$assetUrl() + 'extends/img/ic_files_img.png'"
                                                                            style="width:35px;" />
                                                                    </div>
                                                                    <div>
                                                                        <div class="fw-bolder text-primary"
                                                                            style="word-break: break-word;">
                                                                            {{$noNullable($store.state.complaint.outreachComplaint.result.files.surat_pernyataan_tidak_bersedia_didampingi.name)}}
                                                                        </div>
                                                                        <div class="text-gray-500">
                                                                            {{$formatBytes($store.state.complaint.outreachComplaint.result.files.surat_pernyataan_tidak_bersedia_didampingi.size)}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                            <a :href="$store.state.complaint.outreachComplaint.result.files.surat_pernyataan_tidak_bersedia_didampingi.path"
                                                                target="_blank" v-else>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="me-3">
                                                                        <img :src="$assetUrl() + 'extends/img/ic_files_pdf.png'"
                                                                            style="width:35px;" />
                                                                    </div>
                                                                    <div>
                                                                        <div class="fw-bolder text-primary"
                                                                            style="word-break: break-word;">
                                                                            {{$noNullable($store.state.complaint.outreachComplaint.result.files.surat_pernyataan_tidak_bersedia_didampingi.name)}}
                                                                        </div>
                                                                        <div class="text-gray-500">
                                                                            {{$formatBytes($store.state.complaint.outreachComplaint.result.files.surat_pernyataan_tidak_bersedia_didampingi.size)}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="c-primary-custom fw-bolder pt-5" style="font-size:18px">Hasil Penjangkauan</div>
                        <div class="text-gray-600">Berikut ini merupakan hasil penjangkauan ke klien</div>
                        <div class="timeline-custom mt-10">
                            <div class="container-timeline-custom right-timeline-custom"
                                v-for="context in single.listDataOutreachComplete">
                                <template v-if="showPreparatorStep(context.id)">
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
                                            {{context.text}}&ensp;<span v-if="context.status == 'done'"
                                                class="badge badge-success">Selesai</span>
                                            <span v-if="context.status == 'waiting'" class="badge badge-danger">Belum
                                                Diinput</span>
                                            <span v-if="context.status == 'draft'"
                                                class="badge badge-secondary">Draft</span>
                                        </h2>
                                        <div v-if="context.status == 'done' || context.status == 'draft'"
                                            class="text-gray-600 mb-3">Diperbarui:
                                            {{$moment(context.datetime).locale('id').format('DD MMMM YYYY  HH:mm:ss')}}
                                            oleh
                                            <span class="text-black fw-bolder">{{$noNullable(context.konselor)}}</span>
                                        </div>
                                        <div v-if="context.status == 'waiting'" class="text-gray-600 mb-3">Data belum
                                            ditambahkan oleh <span class="text-black fw-bolder">Konselor</span></div>
                                        <div class="p-3" style="border: 1px dashed #E4E6EF;border-radius:12px;">
                                            <div class="row align-items-center">
                                                <div class="col-lg-6 my-1 col-md-6">
                                                    {{context.desc}}
                                                </div>
                                                <div class="col-lg-6 my-1 col-md-6 justify-content-end text-right">
                                                    <button v-if="context.status == 'done'"
                                                        @click="detailOutreachComplete(context.id)"
                                                        class="btn btn-success btn-sm" type="button">Lihat
                                                        Detail</button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <div class="modal fade" tabindex="-1" id="modal-form-kegiatan-intervensi-opd">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Data Kegiatan Intervensi</h5>
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
                        <div class="row align-items-center">
                            <div class="col-lg-12 fw-bolder mb-2" :class="v$.formDatas.nama.$error ? 'text-danger' : ''">
                                Nama Kegiatan
                            </div>
                            <div class="col-lg-12 mb-5">
                                <input type="text" class="form-control" placeholder="Cth:Konseling Awal" v-model="formDatas.nama" />
                                <div v-if="v$.formDatas.nama.$error" class="text-danger">Nama Kegiatan tidak boleh kosong!
                                </div>
                            </div>
                            <div class="col-lg-12 fw-bolder mb-2" :class="v$.formDatas.deskripsi.$error ? 'text-danger' : ''">
                                Deskripsi Kegiatan
                            </div>
                            <div class="col-lg-12 mb-5">
                                <textarea class="form-control" rows="5" placeholder="Ketik disini..." v-model="formDatas.deskripsi"></textarea>
                                <div v-if="v$.formDatas.deskripsi.$error" class="text-danger">Deskripsi Kegiatan tidak boleh kosong!
                                </div>
                            </div>
                            <div class="col-lg-12 fw-bolder mb-2">
                                Unggah Foto Kegiatan
                            </div>
                            <div class="col-lg-12 mb-5">
                                <div id="dropzone-container-1">
                                    <div class="dropzone dropzone-file-area dz-clickable"
                                        id="dropzone-form-intervention-activity">
                                        <div class="dz-message needsclick">
                                            <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                            <div class="ms-4">
                                                <h5 class="kt-dropzone__msg-title">Drop files here or
                                                    click
                                                    to upload</h5>
                                                <span class="kt-dropzone__msg-desc text-primary">
                                                    Upload up to 10 files with the format .jpg/.jpeg/.png
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-sm bg-second-primary-custom text-white" type="button"
                            @click="saveInterventionActivityOpd">
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <app-pengaduan-data-keluarga-klien :data="$store.state.complaint.outreachComplaint.result.clientFamily">
        </app-pengaduan-data-keluarga-klien>
        <app-pengaduan-data-klien :data="$store.state.complaint.outreachComplaint.result.client.data">
        </app-pengaduan-data-klien>
        <app-pengaduan-data-pelaku :data="$store.state.complaint.outreachComplaint.result.perpetrator">
        </app-pengaduan-data-pelaku>
        <app-pengaduan-dokumen-pendukung :data="$store.state.complaint.outreachComplaint.result.supportingDocuments">
        </app-pengaduan-dokumen-pendukung>
        <app-pengaduan-harapan-klien-dan-keluarga :data="$store.state.complaint.outreachComplaint.result.hopeClient">
        </app-pengaduan-harapan-klien-dan-keluarga>
        <app-pengaduan-kondisi-klien :data="$store.state.complaint.outreachComplaint.result.clientCondition">
        </app-pengaduan-kondisi-klien>
        <app-pengaduan-kronologi-kejadian :data="$store.state.complaint.outreachComplaint.result.cronologyIncident">
        </app-pengaduan-kronologi-kejadian>
        <app-pengaduan-langkah-yang-diambil
            :data="$store.state.complaint.outreachComplaint.result.stepsThatHaveBeenTaken.data">
        </app-pengaduan-langkah-yang-diambil>
        <app-pengaduan-rencana-analis-kebutuhan-klien
            :data="$store.state.complaint.outreachComplaint.result.clientNeedsAnalysisPlan.data">
        </app-pengaduan-rencana-analis-kebutuhan-klien>
        <app-pengaduan-rencana-rujukan-kebutuhan-klien
            :data="$store.state.complaint.outreachComplaint.result.clientNeedsReferralPlan.data">
        </app-pengaduan-rencana-rujukan-kebutuhan-klien>
        <app-pengaduan-situasi-keluarga :data="$store.state.complaint.outreachComplaint.result.familySituation">
        </app-pengaduan-situasi-keluarga>

        <app-pengaduan-detail-hasil-intervensi-opd
            :data="$store.state.complaint.realizationPlanningInteventionOpd.data">
        </app-pengaduan-detail-hasil-intervensi-opd>
    </div>
</template>

<script>
    import Api from "@/services/api";
    import useVuelidate from '@vuelidate/core'
    import {
        required
    } from '@vuelidate/validators'

    import DataKeluargaKlien from "@/views/dashboard/pengaduan/component/modal-detail-hasil-penjangkauan/DataKeluargaKlien.vue";
    import DataKlien from "@/views/dashboard/pengaduan/component/modal-detail-hasil-penjangkauan/DataKlien.vue";
    import DataPelaku from "@/views/dashboard/pengaduan/component/modal-detail-hasil-penjangkauan/DataPelaku.vue";
    import DokumenPendukung from "@/views/dashboard/pengaduan/component/modal-detail-hasil-penjangkauan/DokumenPendukung.vue";
    import HarapanKlienDanKeluarga from "@/views/dashboard/pengaduan/component/modal-detail-hasil-penjangkauan/HarapanKlienDanKeluarga.vue";
    import KondisiKlien from "@/views/dashboard/pengaduan/component/modal-detail-hasil-penjangkauan/KondisiKlien.vue";
    import KronologiKejadian from "@/views/dashboard/pengaduan/component/modal-detail-hasil-penjangkauan/KronologiKejadian.vue";
    import LangkahYangTelahDilakukan from "@/views/dashboard/pengaduan/component/modal-detail-hasil-penjangkauan/LangkahYangTelahDilakukan.vue";
    import RencanaAnalisKebutuhanKlien from "@/views/dashboard/pengaduan/component/modal-detail-hasil-penjangkauan/RencanaAnalisKebutuhanKlien.vue";
    import RencanaRujukanKebutuhanKlien from "@/views/dashboard/pengaduan/component/modal-detail-hasil-penjangkauan/RencanaRujukanKebutuhanKlien.vue";
    import SituasiKeluarga from "@/views/dashboard/pengaduan/component/modal-detail-hasil-penjangkauan/SituasiKeluarga.vue";

    import DetailHasilIntervensiOpd from "@/views/dashboard/pengaduan/component/ModalHasilIntervensiOpd.vue";
    export default {
        components: {
            'app-pengaduan-data-keluarga-klien': DataKeluargaKlien,
            'app-pengaduan-data-klien': DataKlien,
            'app-pengaduan-data-pelaku': DataPelaku,
            'app-pengaduan-dokumen-pendukung': DokumenPendukung,
            'app-pengaduan-harapan-klien-dan-keluarga': HarapanKlienDanKeluarga,
            'app-pengaduan-kondisi-klien': KondisiKlien,
            'app-pengaduan-kronologi-kejadian': KronologiKejadian,
            'app-pengaduan-langkah-yang-diambil': LangkahYangTelahDilakukan,
            'app-pengaduan-rencana-analis-kebutuhan-klien': RencanaAnalisKebutuhanKlien,
            'app-pengaduan-rencana-rujukan-kebutuhan-klien': RencanaRujukanKebutuhanKlien,
            'app-pengaduan-situasi-keluarga': SituasiKeluarga,
            'app-pengaduan-detail-hasil-intervensi-opd': DetailHasilIntervensiOpd,
        },
        data() {
            return {
                v$: useVuelidate(),
                pageStatus: 'standby',
                flagTab: 'identitas-klien',
                flagTabIdentitasClient: 'identitas-klien',
                single: {
                    listActivityInterventionOpd: [],
                    formActivityInterventionOpd: {
                        dropzoneUpload: null
                    },
                    listDataOutreachComplete: [{
                            id: 'data-klien',
                            text: 'Data Klien',
                            datetime: '',
                            konselor: '',
                            status: 'waiting',
                            desc: 'Masukkan informasi detail identitas klien hingga alamat.',
                        },
                        {
                            id: 'data-pelaku',
                            text: 'Data Pelaku',
                            datetime: '',
                            konselor: '',
                            status: 'waiting',
                            desc: 'Masukkan informasi detail identitas pelaku hingga alamat.',
                        },
                        {
                            id: 'data-keluarga-klien',
                            text: 'Data Keluarga Klien',
                            datetime: '',
                            konselor: '',
                            status: 'waiting',
                            desc: 'Masukkan informasi detail identitas keluarga klien terkait ayah, ibu dan saudara-saudara.',
                        },
                        {
                            id: 'situasi-keluarga',
                            text: 'Situasi Keluarga',
                            datetime: '',
                            konselor: '',
                            status: 'waiting',
                            desc: 'Deskripsikan kondisi situasi keluarga pada saat kejadian dan saat ini.',
                        },
                        {
                            id: 'kronologi-kejadian',
                            text: 'Kronologi Kejadian',
                            datetime: '',
                            konselor: '',
                            status: 'waiting',
                            desc: 'Deskripsikan kronologis kejadian secara lengkap.',
                        },
                        {
                            id: 'harapan-klien-dan-keluarga',
                            text: 'Harapan Klien dan Keluarga',
                            datetime: '',
                            konselor: '',
                            status: 'waiting',
                            desc: 'Deskripsikan harapan yang diinginkan oleh klien dan keluarga dari kejadian ini. ',
                        },
                        {
                            id: 'kondisi-klien',
                            text: 'Kondisi Klien',
                            datetime: '',
                            konselor: '',
                            status: 'waiting',
                            desc: 'Masukkan informasi detail kondisi klien terkait kondisi fisik, psikologis dst.',
                        },
                        {
                            id: 'rencana-analis-kebutuhan-klien',
                            text: 'Rencana Analis Kebutuhan Klien Oleh DP3KAPPKB',
                            datetime: '',
                            konselor: '',
                            status: 'waiting',
                            desc: 'Masukkan detail rencana rujukan yang akan diberikan kepada klien.',
                        },
                        {
                            id: 'rencana-rujukan-kebutuhan-klien',
                            text: 'Rencana Rujukan Kebutuhan Klien',
                            datetime: '',
                            konselor: '',
                            status: 'waiting',
                            desc: 'Masukkan detail rencana rujukan yang akan diberikan kepada klien.',
                        },
                        {
                            id: 'langkah-yang-telah-dilakukan',
                            text: 'Langkah yang Telah Dilakukan',
                            datetime: '',
                            konselor: '',
                            status: 'waiting',
                            desc: 'Masukkan informasi pelayanan yang telah diberikan dari instansi terkait.'
                        },
                        {
                            id: 'dokumen-pendukung',
                            text: 'Dokumen Pendukung',
                            datetime: '',
                            konselor: '',
                            status: 'waiting',
                            desc: 'Unggah dokumen pendukung antara lain foto klien, KK, KTP, tempat tinggal dsb.',
                        }
                    ]

                },
                loaderDataDetail: true,
                loaderDataIdentitas: true,
                loaderDataKeluarga: true,                
                loaderDataIntervensiOpd: true,
                dropzone: '',
                dataDetail: false,
                dataIdentitas: {},
                dataKeluarga: {
                    keluarga_klien: [],
                    saudara_klien: []
                },
                dataIntervensiOpd: {},                
                formDatas:{
                    id: '',
                    nama: '',
                    deskripsi: '',
                    foto:[]
                },
            }
        },
        mounted() {
            reinitializeAllPlugin();
            this.initDropzone();
            this.getDetail();            
        },
        validations() {
            return {
                formDatas: {
                    nama: {
                        required
                    },
                    deskripsi: {
                        required
                    }
                },                
            }
        },
        methods: {
            showModalAddInterventionActivityOpd(id) {
                this.reset();

                this.formDatas.id = id;
                $("#modal-form-kegiatan-intervensi-opd").modal('show');
            },
            reset(){

                this.v$.$reset();
                
                this.formDatas.nama = '';
                this.formDatas.deskripsi = '';

                this.dropzone.removeAllFiles(true);
                this.dropzone.files = [];
            },
            saveInterventionActivityOpd() {

                this.v$.$touch();
                if (this.v$.$error) {
                    return false;
                }

                this.$ewpLoadingShow();

                let idIntervensi = this.formDatas.id;
                let formData = new FormData();
                let filesUpload = []
                if (!$.isEmptyObject(this.dropzone.files)) {
                    for (let file in this.dropzone.files) {
                        filesUpload.push(this.dropzone.files[file])
                    }
                }
            
                formData.append('nama', this.formDatas?.nama);
                formData.append('deskripsi', this.formDatas?.deskripsi);

                if (filesUpload.length > 0) {
                    for (let x = 0; x < filesUpload.length; x++) {
                        let fileX = filesUpload[x]
                        formData.append(`foto[${x}]`,fileX);
                    }
                }

                Api().post(`pengaduan/realisasi-intervensi/${idIntervensi}`, formData)
                    .then(response => {
                        $("#modal-form").modal('hide');
                        $(".modal").modal('hide');
                        this.$ewpLoadingHide();
                        this.$swal({
                            title: "Berhasil!",
                            text: 'Data berhasil disimpan',
                            icon: "success",
                        }).then(result => {
                            this.getInterventionOpd(this.dataDetail.penjangkauan_id);
                        });
                    })
                    .catch(error => {
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.$ewpLoadingHide();
                    });
            },
            confirmCompleteInterventionActivityOpd(id) {
                this.$swal({
                    title: 'Akhiri Intervensi?',
                    text: "Kegiatan intervensi yang sudah diakhiri dianggap sudah selesai",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#F64E60',
                    cancelButtonColor: '#FFFFFF',
                    cancelButtonTextColor: "black",
                    confirmButtonText: 'Ya, Akhiri',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.$ewpLoadingShow();
                        Api().post(`pengaduan/realisasi-intervensi/${id}/akhiri`)
                            .then(response => {
                                $("#modal-form").modal('hide');
                                $(".modal").modal('hide');
                                this.$ewpLoadingHide();
                                this.$swal({
                                    title: "Berhasil!",
                                    text: 'Data berhasil disimpan',
                                    icon: "success",
                                }).then(result => {
                                    this.getInterventionOpd(this.dataDetail.penjangkauan_id);
                                });
                            })
                            .catch(error => {
                                this.$axiosHandleError(error);
                            }).then(() => {
                                this.$ewpLoadingHide();
                            });
                    }
                });

            },
            initDropzone() {
                const that = this;
                this.dropzone = new Dropzone(
                    "#dropzone-form-intervention-activity", {
                        url: "/",
                        dictCancelUpload: "Cancel",
                        maxFilesize: 20,
                        parallelUploads: 1,
                        uploadMultiple: false,
                        maxFiles: 10,
                        addRemoveLinks: true,
                        acceptedFiles: '.png,.jpg,.jpeg',
                        autoProcessQueue: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="token"]').attr('content'),
                            Authorization: 'Bearer '+ localStorage.getItem('dp5a-token'),
                        },
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
                    });
            },
            getDetail(){//id_pengaduan                
                Api().get(`pengaduan/${this.$route.params.id}`)
                    .then(response => {

                        let data = response.data.data;
                        this.dataDetail = data;
                        this.getIdentitasKlien(data.penjangkauan_id);
                        this.getInterventionOpd(data.penjangkauan_id);
                        this.getKeluarga(data.penjangkauan_id);          
                    })
                    .catch(error => {                        
                        this.$axiosHandleError(error);
                    }).then(response => {
                        this.loaderDataDetail = false;
                    });
            },
            getIdentitasKlien(id){//id_penjangkauan
                Api().get(`penjangkauan/${id}/klien`)
                    .then(response => {

                        let data = response.data.data;
                        this.dataIdentitas = data.klien;
                    })
                    .catch(error => {
                        this.$axiosHandleError(error);
                    })
                    .then(response => {
                        this.loaderDataIdentitas = false;
                    });
            },
            getKeluarga(id){//
                Api().get(`penjangkauan/${id}/keluarga_klien`)
                    .then(response => {

                        let data = response.data.data;
                        this.dataKeluarga = data;                                        
                    })
                    .catch(error => {
                      
                        this.$axiosHandleError(error);
                    }).then(response => {
                        this.loaderDataKeluarga = false;
                    });
            },
            getInterventionOpd(id){//id_penjangkauan
                this.loaderDataIntervensiOpd = true;
                Api().get(`penjangkauan/${id}/rencana_intervensi`)
                    .then(response => {                        
                        let data = response.data.data.rencana_intervensi;
                        this.dataIntervensiOpd = data;                 
                        if(this.dataIntervensiOpd.length > 0){
                            const checkExisting = this.dataIntervensiOpd.filter((e) => e.realisasi_draft_status);
                            if(checkExisting.length == 0){
                                this.dataDetail.status.status = 'Intervensi Selesai';
                                this.dataDetail.status.label_status = 'badge-light-success';
                            }
                        }
                    })
                    .catch(error => {                      
                        this.$axiosHandleError(error);
                    })
                    .then(response => {
                        this.loaderDataIntervensiOpd = false;
                    });
            },
        
            getUmur(tglLahir){
                return this.$moment().diff(this.$moment(tglLahir, "DD-MM-YYYY"), 'years') ? this.$moment().diff(this.$moment(tglLahir, "DD-MM-YYYY"), 'years') : '-';
            },
            kepemilikanBpjs(bpjsCategory){
                if(bpjsCategory == 1){
                    return 'PBI'
                }
                else if(bpjsCategory == 2){
                    return 'Korporasi'
                }
                else if(bpjsCategory == 3){
                    return 'Mandiri'
                }
                else if(bpjsCategory == 4){
                    return 'Lainnya'
                }
            },

            getOutreachComplaint() {
                this.$store.dispatch('complaint/getDetailComplaintOutreach', this.dataDetail.penjangkauan_id).then((res) => {
                    if (res.status == 200 || res.status == 201) {

                        let context = res.data.data;

                        this.single.listDataOutreachComplete[0].status = this.getStatusOutreachResult(context
                            .klien_draft_status);
                        this.single.listDataOutreachComplete[0].datetime = context.klien_updated_at;
                        this.single.listDataOutreachComplete[0].konselor = context.klien_updated_by;

                        this.single.listDataOutreachComplete[1].status = this.getStatusOutreachResult(context
                            .pelaku_draft_status);
                        this.single.listDataOutreachComplete[1].datetime = context.pelaku_updated_at;
                        this.single.listDataOutreachComplete[1].konselor = context.pelaku_updated_by;

                        this.single.listDataOutreachComplete[2].status = this.getStatusOutreachResult(context
                            .keluarga_klien_draft_status);
                        this.single.listDataOutreachComplete[2].datetime = context.keluarga_klien_updated_at;
                        this.single.listDataOutreachComplete[2].konselor = context.keluarga_klien_updated_by;

                        this.single.listDataOutreachComplete[3].status = this.getStatusOutreachResult(context
                            .situasi_keluarga_draft_status);
                        this.single.listDataOutreachComplete[3].datetime = context.situasi_keluarga_updated_at;
                        this.single.listDataOutreachComplete[3].konselor = context.situasi_keluarga_updated_by;

                        this.single.listDataOutreachComplete[4].status = this.getStatusOutreachResult(context
                            .kronologi_kejadian_draft_status);
                        this.single.listDataOutreachComplete[4].datetime = context
                            .kronologi_kejadian_updated_at;
                        this.single.listDataOutreachComplete[4].konselor = context
                            .kronologi_kejadian_updated_by;

                        this.single.listDataOutreachComplete[5].status = this.getStatusOutreachResult(context
                            .harapan_klien_draft_status);
                        this.single.listDataOutreachComplete[5].datetime = context.harapan_klien_updated_at;
                        this.single.listDataOutreachComplete[5].konselor = context.harapan_klien_updated_by;

                        this.single.listDataOutreachComplete[6].status = this.getStatusOutreachResult(context
                            .kondisi_klien_draft_status);
                        this.single.listDataOutreachComplete[6].datetime = context.kondisi_klien_updated_at;
                        this.single.listDataOutreachComplete[6].konselor = context.kondisi_klien_updated_by;

                        this.single.listDataOutreachComplete[7].status = this.getStatusOutreachResult(context
                            .analisis_dp3kappkb_draft_status);
                        this.single.listDataOutreachComplete[7].datetime = context
                            .analisis_dp3kappkb_updated_at;
                        this.single.listDataOutreachComplete[7].konselor = context
                            .analisis_dp3kappkb_updated_by;

                        this.single.listDataOutreachComplete[8].status = this.getStatusOutreachResult(context
                            .rencana_intervensi_draft_status);
                        this.single.listDataOutreachComplete[8].datetime = context
                            .rencana_intervensi_updated_at;
                        this.single.listDataOutreachComplete[8].konselor = context
                            .rencana_intervensi_updated_by;

                        this.single.listDataOutreachComplete[9].status = this.getStatusOutreachResult(context
                            .langkah_dilakukan_draft_status);
                        this.single.listDataOutreachComplete[9].datetime = context.langkah_dilakukan_updated_at;
                        this.single.listDataOutreachComplete[9].konselor = context.langkah_dilakukan_updated_by;

                        this.single.listDataOutreachComplete[10].status = this.getStatusOutreachResult(context
                            .dokumen_pendukung_draft_status);
                        this.single.listDataOutreachComplete[10].datetime = context
                            .dokumen_pendukung_updated_at;
                        this.single.listDataOutreachComplete[10].konselor = context
                            .dokumen_pendukung_updated_by;

                        return true;
                    } else {
                        this.$axiosHandleError(res);
                    }
                })
            },
            detailOutreachComplete(id) {
                let urlFunction = '';
                if (id == 'situasi-keluarga') {
                    urlFunction = 'complaint/getDetailComplaintOutreachFamilySituation';
                } else if (id == 'kronologi-kejadian') {
                    urlFunction = 'complaint/getDetailComplaintOutreachCronologyIncident';
                } else if (id == 'harapan-klien-dan-keluarga') {
                    urlFunction = 'complaint/getDetailComplaintOutreachHopeClient';
                } else if (id == 'kondisi-klien') {
                    urlFunction = 'complaint/getDetailComplaintOutreachClientCondition';
                } else if (id == 'dokumen-pendukung') {
                    urlFunction = 'complaint/getDetailComplaintOutreachSupportingDocuments';
                } else if (id == 'data-pelaku') {
                    urlFunction = 'complaint/getDetailComplaintOutreachPerpetrator';
                } else if (id == 'data-keluarga-klien') {
                    urlFunction = 'complaint/getDetailComplaintOutreachClientFamily';
                } else if (id == 'data-klien') {
                    urlFunction = 'complaint/getDetailComplaintOutreachClient';
                } else if (id == 'rencana-analis-kebutuhan-klien') {
                    urlFunction = 'complaint/getDetailComplaintOutreachClientNeedsAnalysisPlan';
                } else if (id == 'rencana-rujukan-kebutuhan-klien') {
                    urlFunction = 'complaint/getDetailComplaintOutreachClientNeedsReferralPlan';
                } else if (id == 'langkah-yang-telah-dilakukan') {
                    urlFunction = 'complaint/getDetailComplaintOutreachStepsThatHaveBeenTaken';
                } else {
                    $("#modal-detail-" + id).modal('show');
                    return false;
                }

                this.$ewpLoadingShow();
                this.$store.dispatch(urlFunction, this.dataDetail.penjangkauan_id).then((
                    res) => {
                    this.$ewpLoadingHide();
                    if (res.status == 200 || res.status == 201) {
                        $("#modal-detail-" + id).modal('show');
                    } else {
                        this.$axiosHandleError(res);
                    }
                });

            },
            getStatusOutreachResult(status) {
                if (status === null) {
                    return 'waiting';
                } else {
                    if (status) {
                        return 'draft'
                    } else {
                        return 'done';
                    }
                }
            },
            showPreparatorStep(id) {
                if (id == 'data-pelaku') {
                    if (this.$store.state.complaint.outreachComplaint.result.draftStatus) {
                        return true;
                    } else {
                        return this.$store.state.complaint.outreachComplaint.result.needPreparator;
                    }
                } else {
                    return true;
                }
            }
        },
    }

</script>

<style scoped>
    .nav-tab-custom-x {
        padding: 10px;
        color: #a1a5b7;
        font-size: 15px;
    }

    .nav-tab-custom-x.active {
        border-bottom: 2px #EE7B33 solid;
        color: #EE7B33 !important;
        font-weight: 500;
    }

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
