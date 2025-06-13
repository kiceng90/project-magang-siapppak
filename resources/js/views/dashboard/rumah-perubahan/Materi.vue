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

                    <div id="main-content">
                        <div class="post d-flex flex-column-fluid" id="kt_post">
                            <div
                                id="kt_content_container"
                                class="container-xxl"
                            >
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <button
                                                class="btn btn-link p-0"
                                                type="button"
                                                @click="() => navigateTo('rumah-perubahan')"
                                            >
                                                Rumah Perubahan
                                            </button>
                                        </li>
                                        <li
                                            class="breadcrumb-item active"
                                            aria-current="page"
                                        >
                                            {{ materiName }}
                                        </li>
                                    </ol>
                                </nav>
                                <div
                                    class="card card-flush mt-5 mb-5 mb-xl-10"
                                    id="kt_profile_details_view"
                                >
                                    <div
                                        class="card-body pt-6"
                                        id="start-content"
                                    >
                                        <div
                                            class="d-flex justify-content-between align-items-center mb-3"
                                        >
                                            <h3 class="card-title">
                                                {{ materiName }}
                                            </h3>
                                            <button
                                                type="button"
                                                class="btn btn-custom"
                                                @click="goBack"
                                            >
                                                <span
                                                    class="text-warning d-flex"
                                                >
                                                    <svg
                                                        width="18"
                                                        height="18"
                                                        viewBox="0 0 18 18"
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
                                        <p class="description">
                                            Selamat datang! Selamat mengerjakan Tes yang telah disediakan dengan sungguh-sungguh
                                        </p>

                                        <!-- Materi Section -->
                                        <div class="materi-section">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h1 class="mb-3">Materi</h1>
                                                    <div
                                                        class="card-soal"
                                                        v-for="(materi, index) in materiList"
                                                        :key="index"
                                                    >
                                                        <div
                                                            class="d-flex justify-content-between align-items-center"
                                                        >
                                                            <div class="col-10">
                                                                <span class="namamateri">
                                                                    {{ index + 1 }}. {{ materi.name }}
                                                                </span>
                                                            </div>
                                                            <div class="col-2">
                                                                <button
                                                                    @click="showModalPenghuni(materi.id)"
                                                                    class="btn btn-sm bg-second-primary-custom text-white"
                                                                    type="button"
                                                                >
                                                                    Mulai
                                                                </button>
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
                    </div>
                </div>
            </div>
        </div>

        <app-scroll-top></app-scroll-top>

        <!-- Modal Pengisian Data Penghuni -->
        <div class="modal fade" tabindex="-1" id="modal-penghuni">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Data Penghuni</h5>
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
                        <div class="mb-5">
                            <label class="form-label fw-bolder fs-6"
                                :class="v$.penghuni.nama.$error ? 'text-danger' : ''">Nama</label>
                            <input class="form-control" type="text" placeholder="Masukkan nama lengkap"
                                autocomplete="off" v-model="penghuni.nama" />
                            <div v-if="v$.penghuni.nama.$error" class="text-danger">Nama tidak boleh kosong!</div>
                        </div>
                        <div class="mb-5">
                            <label class="form-label fw-bolder fs-6"
                                :class="v$.penghuni.nik.$error ? 'text-danger' : ''">NIK</label>
                            <input class="form-control" type="text" placeholder="Masukkan NIK"
                                autocomplete="off" v-model="penghuni.nik" />
                            <div v-if="v$.penghuni.nik.$error" class="text-danger">NIK tidak boleh kosong!</div>
                        </div>
                        <div class="mb-5">
                            <label class="form-label fw-bolder fs-6"
                                :class="v$.penghuni.id_kabupaten.$error ? 'text-danger' : ''">Kabupaten</label>
                            <app-select-single v-model="penghuni.id_kabupaten" :placeholder="'Pilih Kabupaten'"
                                :loading="pageStatus == 'kabupaten-load'" :options="list_kabupaten" :serverside="true"
                                @change-search="getKabupaten">
                            </app-select-single>
                            <div v-if="v$.penghuni.id_kabupaten.$error" class="text-danger">Kabupaten tidak boleh kosong!</div>
                        </div>
                        <div class="mb-5">
                            <label class="form-label fw-bolder fs-6"
                                :class="v$.penghuni.id_kecamatan.$error ? 'text-danger' : ''">Kecamatan</label>
                            <app-select-single v-model="penghuni.id_kecamatan" :placeholder="'Pilih Kecamatan'"
                                :loading="pageStatus == 'kecamatan-load'" :options="list_kecamatan" :serverside="true"
                                @change-search="getKecamatan">
                            </app-select-single>
                            <div v-if="v$.penghuni.id_kecamatan.$error" class="text-danger">Kecamatan tidak boleh kosong!</div>
                        </div>
                        <div class="mb-5">
                            <label class="form-label fw-bolder fs-6"
                                :class="v$.penghuni.id_kelurahan.$error ? 'text-danger' : ''">Kelurahan</label>
                            <app-select-single v-model="penghuni.id_kelurahan" :placeholder="'Pilih Kelurahan'"
                                :loading="pageStatus == 'kelurahan-load'" :options="list_kelurahan" :serverside="true"
                                @change-search="getKelurahan">
                            </app-select-single>
                            <div v-if="v$.penghuni.id_kelurahan.$error" class="text-danger">Kelurahan tidak boleh kosong!</div>
                        </div>
                        <div class="mb-5">
                            <label class="form-label fw-bolder fs-6"
                                :class="v$.penghuni.alamat.$error ? 'text-danger' : ''">Alamat</label>
                            <textarea class="form-control" placeholder="Masukkan alamat lengkap"
                                v-model="penghuni.alamat" rows="3"></textarea>
                            <div v-if="v$.penghuni.alamat.$error" class="text-danger">Alamat tidak boleh kosong!</div>
                        </div>
                        <div class="mb-5">
                            <label class="form-label fw-bolder fs-6"
                                :class="v$.penghuni.no_telepon.$error ? 'text-danger' : ''">No. Telepon</label>
                            <input class="form-control" type="text" placeholder="Masukkan nomor telepon"
                                autocomplete="off" v-model="penghuni.no_telepon" />
                            <div v-if="v$.penghuni.no_telepon.$error" class="text-danger">No. Telepon tidak boleh kosong!</div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
                        <button @click="submitPenghuni" class="btn btn-sm bg-second-primary-custom text-white" type="button">
                            Lanjutkan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import useVuelidate from '@vuelidate/core';
import { required } from '@vuelidate/validators';

export default {
    setup() {
        return {
            v$: useVuelidate(),
        }
    },
    data() {
        return {
            materiList: [],   // Menyimpan daftar materi
            materiName: "",   // Nama materi
            kategoriName: "", // Nama kategori (jika diperlukan)
            kategoriId: "",   // ID kategori
            currentMateriId: "", // ID materi yang dipilih
            pageStatus: 'standby',
            list_kabupaten: [],
            list_kecamatan: [],
            list_kelurahan: [],
            penghuni: {
                nama: "",
                nik: "",
                id_kabupaten: {},
                id_kecamatan: {},
                id_kelurahan: {},
                alamat: "",
                no_telepon: ""
            }
        };
    },
    validations() {
        return {
            penghuni: {
                nama: { required },
                nik: { required },
                id_kabupaten: { required },
                id_kecamatan: { required },
                id_kelurahan: { required },
                alamat: { required },
                no_telepon: { required }
            }
        }
    },
    methods: {
        navigateTo(routeName, params = {}) {
            this.$router.push({ name: routeName, params });
        },
        goBack() {
            this.$router.go(-1);
        },
        async fetchKategori() {
            const idKategori = this.$route.params.id;  // Ambil parameter 'id' dari URL
            try {
                const response = await axios.get(
                    `/api/m-kategori-rumah-perubahan/getKategori/${idKategori}`,
                    {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem("dp5a-token")}`,  // Kirim token
                        },
                    }
                );
                // Proses respons untuk kategori
                this.kategoriId = response.data.id;
                this.materiName = response.data.name;  // Menetapkan nama kategori
            } catch (error) {
                console.error("Error fetching category data:", error);
            }
        },
        async fetchMateries() {
            const idMateri = this.$route.params.id;
            try {
                const response = await axios.get(
                    `/api/m-materi-rumah-perubahan/getMateris/${idMateri}`,
                    {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem(
                                "dp5a-token"
                            )}`,
                        },
                    }
                );
                this.materiList = response.data.map((materi) => ({
                    id: materi.id,
                    name: materi.name,
                    isCompleted: materi.isCompleted,
                }));
            } catch (error) {
                console.error("Error fetching materi data:", error);
            }
        },
        showModalPenghuni(materiId) {
            this.resetPenghuni();
            this.currentMateriId = materiId;
            $("#modal-penghuni").modal('show');
        },
        async submitPenghuni() {
            this.v$.$touch();
            if (this.v$.$error) {
                return false;
            }
            
            try {
                // Show loading indicator
                this.$ewpLoadingShow();
                
                // Prepare data for API request
                const data = {
                    id_materi: this.currentMateriId,
                    nama: this.penghuni.nama,
                    nik: this.penghuni.nik,
                    id_kabupaten: this.penghuni.id_kabupaten.id,
                    id_kecamatan: this.penghuni.id_kecamatan.id,
                    id_kelurahan: this.penghuni.id_kelurahan.id,
                    alamat: this.penghuni.alamat,
                    no_telepon: this.penghuni.no_telepon
                };
                
                // Create a new answer entry with resident data
                const jawabanResponse = await axios.post("/api/rumahperubahan-jawaban", data, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem("dp5a-token")}`,
                    },
                });

                // Get the ID from the response
                const idJawaban = jawabanResponse.data?.data?.id;
                console.log("ID Jawaban berhasil dibuat:", idJawaban);

                if (idJawaban) {
                    // Save `idJawaban` in localStorage
                    localStorage.setItem("idJawaban", idJawaban);
                    
                    // Close modal
                    $("#modal-penghuni").modal('hide');

                    // Navigate directly to the quiz view
                    this.$router.push({
                        name: "rumahperubahan-latihansoal",
                        params: { id: this.currentMateriId },
                    });
                } else {
                    throw new Error("Failed to create jawaban record");
                }
            } catch (error) {
                console.error("Error submitting resident data:", error);
                this.$swal({
                    title: "Kesalahan",
                    text: error.response?.data?.message || "Terjadi kesalahan saat menyimpan data penghuni",
                    icon: "error",
                });
            } finally {
                // Hide loading indicator
                this.$ewpLoadingHide();
            }
        },
        resetPenghuni() {
            this.v$.$reset();
            this.penghuni = {
                nama: "",
                nik: "",
                id_kabupaten: {},
                id_kecamatan: {},
                id_kelurahan: {},
                alamat: "",
                no_telepon: ""
            };
        },
        async goToLatihanSoal(materiId) {
            const idMateri = materiId;
            const data = {
                id_materi: idMateri,
                nama: this.penghuni.nama,
                nik: this.penghuni.nik,
                id_kabupaten: this.penghuni.id_kabupaten.id,
                id_kecamatan: this.penghuni.id_kecamatan.id,
                id_kelurahan: this.penghuni.id_kelurahan.id,
                alamat: this.penghuni.alamat,
                no_telepon: this.penghuni.no_telepon
            };

            try {
                // Show loading
                this.$ewpLoadingShow();
                
                // Create a new answer entry with resident data
                const jawabanResponse = await axios.post("/api/rumahperubahan-jawaban", data, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem(
                            "dp5a-token"
                        )}`, // Ensure the token is in localStorage
                    },
                });

                const idJawaban = jawabanResponse.data?.data?.id; // Extract the ID of the answer
                console.log("ID Jawaban berhasil dibuat:", idJawaban);

                if (idJawaban) {
                    // Save `idJawaban` in localStorage
                    localStorage.setItem("idJawaban", idJawaban);

                    // Redirect to the quiz view with the materi ID
                    this.$router.push({
                        name: "rumahperubahan-latihansoal", // Replace with your route name
                        params: { id: idMateri },
                    });
                }
            } catch (error) {
                console.error(
                    "Error during startQuiz:",
                    error.response?.data || error
                );
                // Show error message to user
                this.$swal({
                    title: "Kesalahan",
                    text: error.response?.data?.message || "Terjadi kesalahan saat memulai latihan",
                    icon: "error",
                });
            } finally {
                // Hide loading
                this.$ewpLoadingHide();
            }
        },
        getKabupaten(keyword, limit) {
            this.pageStatus = 'kabupaten-load';
            
            axios.get(`/api/m-kabupaten/lists?limit=${limit}&search=${keyword}`, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem("dp5a-token")}`,
                },
            })
                .then(response => {
                    this.list_kabupaten = [];
                    for (let i = 0; i < response.data.data.length; i++) {
                        this.list_kabupaten.push({
                            id: response.data.data[i].id,
                            text: response.data.data[i].name,
                        });
                    }
                })
                .catch(error => {
                    console.error("Error fetching kabupaten data:", error);
                }).then(() => {
                    this.pageStatus = 'standby';
                });
        },
        getKecamatan(keyword, limit) {
            this.pageStatus = 'kecamatan-load';
            
            const params = {};
            if (this.penghuni.id_kabupaten && this.penghuni.id_kabupaten.id) {
                params.id_kabupaten = this.penghuni.id_kabupaten.id;
            }
            
            axios.get(`/api/m-kecamatan/lists?limit=${limit}&search=${keyword}`, {
                params,
                headers: {
                    Authorization: `Bearer ${localStorage.getItem("dp5a-token")}`,
                },
            })
                .then(response => {
                    this.list_kecamatan = [];
                    for (let i = 0; i < response.data.data.length; i++) {
                        this.list_kecamatan.push({
                            id: response.data.data[i].id,
                            text: response.data.data[i].name,
                        });
                    }
                })
                .catch(error => {
                    console.error("Error fetching kecamatan data:", error);
                }).then(() => {
                    this.pageStatus = 'standby';
                });
        },
        getKelurahan(keyword, limit) {
            this.pageStatus = 'kelurahan-load';
            
            const params = {};
            if (this.penghuni.id_kecamatan && this.penghuni.id_kecamatan.id) {
                params.id_kecamatan = this.penghuni.id_kecamatan.id;
            }
            
            axios.get(`/api/m-kelurahan/lists?limit=${limit}&search=${keyword}`, {
                params,
                headers: {
                    Authorization: `Bearer ${localStorage.getItem("dp5a-token")}`,
                },
            })
                .then(response => {
                    this.list_kelurahan = [];
                    for (let i = 0; i < response.data.data.length; i++) {
                        this.list_kelurahan.push({
                            id: response.data.data[i].id,
                            text: response.data.data[i].name,
                        });
                    }
                })
                .catch(error => {
                    console.error("Error fetching kelurahan data:", error);
                }).then(() => {
                    this.pageStatus = 'standby';
                });
        }
    },
    async mounted() {
        await this.fetchKategori();  // Ambil kategori berdasarkan ID
        await this.fetchMateries();  // Ambil materi berdasarkan ID
        reinitializeAllPlugin();  // Inisialisasi plugin jika diperlukan
    },
};
</script>

<style scoped>
.breadcrumb {
    display: flex;
    align-items: center;
    list-style: none;
    padding: 0;
    margin: 0;
    font-size: 0.95rem;
}

.breadcrumb-item {
    display: flex;
    align-items: center;
}

.breadcrumb-item:not(:last-child)::after {
    content: "|";
    color: #6c757d;
    padding: 0 0.5rem;
    font-size: 1.1rem;
}

.breadcrumb-item button {
    color: #ee7b33;
    text-decoration: none;
    font-weight: 500;
}

.breadcrumb-item.active {
    color: #6c757d;
}

p.description {
    color: grey;
    line-height: 1.6;
    padding: 10px 0;
    font-size: 1rem;
}

.btn-custom {
    background-color: #fff8dd;
}

.d-flex span.namamateri {
    font-size: 0.95rem;
    font-weight: 500;
}

.materi-section {
    padding: 20px 0;
}

.card-soal {
    box-shadow: 0 5px rgba(0, 0, 0, 0.2);
    border-radius: 8px;
    background-color: #f4f4f4ed;
    padding: 15px 25px;
    margin-bottom: 20px;
    transition: all 0.3s ease;
}

.card-soal:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px rgba(0, 0, 0, 0.2);
}

.btn.btn-outline {
    width: 80px;
    transition: all 0.2s ease;
}

.btn-custom-completed {
    border: 0.15rem solid #f19a4f;
    color: #f19a4f;
    padding: 5px 16px;
    font-size: 0.875rem;
    font-weight: 700;
}

.btn-custom-pending {
    border: 0.15rem solid #ff5c67;
    color: #ff5c67;
    padding: 5px 16px;
    font-size: 0.875rem;
    font-weight: 700;
}

.btn-custom-completed:hover,
.btn-custom-pending:hover {
    background-color: rgba(0, 0, 0, 0.05) !important;
    transform: scale(1.05);
}

@media (max-width: 1024px) {
    .breadcrumb {
        font-size: 0.9rem;
    }

    .btn-custom {
        padding: 5px 10px;
        font-size: 0.85rem;
    }

    .card-soal {
        padding: 12px 20px;
    }
}

@media (max-width: 768px) {
    .breadcrumb {
        font-size: 0.85rem;
    }

    p.description {
        font-size: 0.9rem;
    }

    .btn-custom {
        font-size: 0.8rem;
        padding: 5px 8px;
    }

    .card-soal span.namamateri {
        font-size: 0.85rem;
    }

    .btn-custom-completed,
    .btn-custom-pending {
        font-size: 0.8rem;
        width: 75px;
    }
}

@media (max-width: 480px) {
    .breadcrumb {
        font-size: 0.8rem;
    }

    p.description {
        font-size: 0.85rem;
        padding: 8px 0;
    }

    .btn-custom {
        font-size: 0.75rem;
        padding: 4px 6px;
    }

    .card-soal {
        padding: 10px 15px;
    }

    .card-soal span.namamateri {
        font-size: 0.8rem;
    }

    .btn-custom-completed,
    .btn-custom-pending {
        font-size: 0.7rem;
        width: 70px;
        padding: 4px 8px;
    }
}
</style>