<template>
    <div>
        <audio
            ref="backgroundMusic"
            :src="
                score < 80
                    ? '/assets/siapppak/music/fail.mp3'
                    : '/assets/siapppak/music/success.mp3'
            "
            autoplay
        ></audio>
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
                                <div
                                    class="card card-flush mt-5 mb-5 mb-xl-10"
                                    id="kt_profile_details_view"
                                >
                                    <div
                                        class="card-body pt-6"
                                        id="start-content"
                                    >
                                        <div class="score-section text-center">
                                            <div class="judul mb-10">
                                                <h2>E-Learning PUSPAGA</h2>
                                                <p class="subtitle">
                                                    Keterampilan dasar
                                                    konseling, bantuan psikologi
                                                    awal dan dukungan sosial
                                                    (PFA)
                                                </p>
                                            </div>

                                            <div
                                                class="score-circle"
                                                :class="scoreColor"
                                            >
                                                <span>{{ score }}</span>
                                            </div>
                                            <p
                                                v-if="score >= 80"
                                                class="message"
                                            >
                                                Hebat! Setiap usaha yang kamu
                                                lakukan <br />
                                                adalah langkah menuju
                                                kesuksesan.
                                            </p>
                                            <p v-else class="message">
                                                Masih ada kesempatan untuk jadi
                                                lebih baik. <br />
                                                Tetap Semangat!
                                            </p>

                                            <div class="button-group">
                                                <button
                                                    class="button"
                                                    @click="navigateToLearning"
                                                >
                                                    Lanjutkan Belajar
                                                </button>
                                                <button
                                                    class="button"
                                                    @click="
                                                        showConfirmModal = true
                                                    "
                                                >
                                                    Coba Lagi
                                                </button>

                                                <div
                                                    :class="[
                                                        'modal',
                                                        'fade',
                                                        {
                                                            show: showConfirmModal,
                                                        },
                                                    ]"
                                                    tabindex="-1"
                                                    v-if="showConfirmModal"
                                                    style="display: block"
                                                >
                                                    <div
                                                        class="modal-dialog modal-dialog-centered"
                                                    >
                                                        <div
                                                            class="modal-content"
                                                        >
                                                            <div
                                                                class="modal-header"
                                                            >
                                                                <h5
                                                                    class="modal-title"
                                                                >
                                                                    Konfirmasi
                                                                    Ulang
                                                                    Latihan
                                                                </h5>
                                                                <div
                                                                    class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                                                                    @click="
                                                                        showConfirmModal = false
                                                                    "
                                                                    aria-label="Close"
                                                                >
                                                                    <span
                                                                        class="svg-icon-2x"
                                                                    >
                                                                        <svg
                                                                            width="32"
                                                                            height="32"
                                                                            viewBox="0 0 32 32"
                                                                            fill="none"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                        >
                                                                            <path
                                                                                d="M17.88 15.9996L23.6134 10.2796C23.8644 10.0285 24.0055 9.688 24.0055 9.33293C24.0055 8.97786 23.8644 8.63733 23.6134 8.38626C23.3623 8.13519 23.0218 7.99414 22.6667 7.99414C22.3116 7.99414 21.9711 8.13519 21.72 8.38626L16 14.1196L10.28 8.38626C10.029 8.13519 9.68844 7.99414 9.33337 7.99414C8.97831 7.99414 8.63778 8.13519 8.38671 8.38626C8.13564 8.63733 7.99459 8.97786 7.99459 9.33293C7.99459 9.688 8.13564 10.0285 8.38671 10.2796L14.12 15.9996L8.38671 21.7196C8.26174 21.8435 8.16254 21.991 8.09485 22.1535C8.02716 22.316 7.99231 22.4902 7.99231 22.6663C7.99231 22.8423 8.02716 23.0166 8.09485 23.179C8.16254 23.3415 8.26174 23.489 8.38671 23.6129C8.51066 23.7379 8.65813 23.8371 8.8206 23.9048C8.98308 23.9725 9.15736 24.0073 9.33337 24.0073C9.50939 24.0073 9.68366 23.9725 9.84614 23.9048C10.0086 23.8371 10.1561 23.7379 10.28 23.6129L16 17.8796L21.72 23.6129C21.844 23.7379 21.9915 23.8371 22.1539 23.9048C22.3164 23.9725 22.4907 24.0073 22.6667 24.0073C22.8427 24.0073 23.017 23.9725 23.1795 23.9048C23.342 23.8371 23.4894 23.7379 23.6134 23.6129C23.7383 23.489 23.8375 23.3415 23.9052 23.179C23.9729 23.0166 24.0078 22.8423 24.0078 22.6663C24.0078 22.4902 23.9729 22.316 23.9052 22.1535C23.8375 21.991 23.7383 21.8435 23.6134 21.7196L17.88 15.9996Z"
                                                                                fill="black"
                                                                            />
                                                                        </svg>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="modal-body"
                                                            >
                                                                <p>
                                                                    Apakah Anda
                                                                    yakin ingin
                                                                    mengulangi
                                                                    latihan ini?
                                                                </p>
                                                            </div>
                                                            <div
                                                                class="modal-footer"
                                                            >
                                                                <button
                                                                    type="button"
                                                                    class="btn btn-sm btn-light me-4"
                                                                    @click="
                                                                        showConfirmModal = false
                                                                    "
                                                                >
                                                                    Batal
                                                                </button>
                                                                <button
                                                                    @click="
                                                                        confirmRetryQuiz
                                                                    "
                                                                    class="btn btn-sm bg-second-primary-custom text-white"
                                                                    type="button"
                                                                >
                                                                    Coba Lagi
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="summary-table mt-10">
                                            <h4>Ringkasan Nilai Latihan</h4>
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            Waktu Pengerjaan
                                                        </th>
                                                        <th>Nilai</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr
                                                        v-for="item in data"
                                                        :key="item.id"
                                                    >
                                                        <td>
                                                            {{
                                                                formatTanggal(
                                                                    item.tanggal
                                                                )
                                                            }}
                                                        </td>
                                                        <td>
                                                            {{ item.nilai }}
                                                        </td>
                                                        <td>
                                                            <img
                                                                class="icon-status"
                                                                :src="
                                                                    item.nilai >
                                                                    80
                                                                        ? '/assets/siapppak/img/success.png'
                                                                        : '/assets/siapppak/img/fail.png'
                                                                "
                                                            />
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
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

<script>
import confetti from "canvas-confetti";
export default {
    data() {
        return {
            data: [],
            showConfirmModal: false,
            score: "",
        };
    },
    computed: {
        scoreColor() {
            return this.score < 80 ? "score-low" : "score-high";
        },
    },
    mounted() {
        this.launchConfetti();
        reinitializeAllPlugin();
        this.hasilLatihanSoal();
        this.historyLatihanSoal();
    },
    methods: {
        formatTanggal(tanggal) {
            const hari = [
                "Minggu",
                "Senin",
                "Selasa",
                "Rabu",
                "Kamis",
                "Jumat",
                "Sabtu",
            ];
            const bulan = [
                "Januari",
                "Februari",
                "Maret",
                "April",
                "Mei",
                "Juni",
                "Juli",
                "Agustus",
                "September",
                "Oktober",
                "November",
                "Desember",
            ];

            const date = new Date(tanggal);
            const namaHari = hari[date.getDay()];
            const tanggalNum = date.getDate();
            const namaBulan = bulan[date.getMonth()];
            const tahun = date.getFullYear();

            const jam = String(date.getHours()).padStart(2, "0");
            const menit = String(date.getMinutes()).padStart(2, "0");

            return `${namaHari}, ${tanggalNum} ${namaBulan} ${tahun}; ${jam}:${menit}`;
        },
        async hasilLatihanSoal() {
            const idJawaban = this.$route.params.id;
            try {
                const response = await axios.get(
                    `/api/Detail-jawaban/hasil-latihan-soal/${idJawaban}`,
                    {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem(
                                "dp5a-token"
                            )}`,
                        },
                    }
                );
                this.score = response.data.skor;
            } catch (error) {
                console.error("Error fetching jawaban data:", error);
            }
        },
        async historyLatihanSoal() {
            const idJawaban = this.$route.params.id;
            try {
                const response = await axios.get(
                    `/api/Detail-jawaban/history-latihan-soal/${idJawaban}`,
                    {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem(
                                "dp5a-token"
                            )}`,
                        },
                    }
                );
                this.data = response.data.map((history) => ({
                    tanggal: history.created_at,
                    nilai: history.skor,
                }));
            } catch (error) {
                console.error("Error fetching history data:", error);
            }
        },
        launchConfetti() {
            const duration = 4000;
            const end = Date.now() + duration;

            const frame = () => {
                confetti({
                    particleCount: 10,
                    startVelocity: 30,
                    spread: 60,
                    angle: 90,
                    origin: { x: Math.random(), y: 0 },
                    colors:
                        this.score >= 80
                            ? ["#FFC700", "#FF0000", "#2E3192", "#41BBC7"]
                            : "",
                    shapes:
                        this.score >= 80 ? ["circle", "square"] : ["square"],
                });

                if (Date.now() < end) {
                    requestAnimationFrame(frame);
                }
            };
            frame();
        },
        async navigateToLearning() {
            const idJawaban = this.$route.params.id;
            try {
                const response = await axios.get(
                    `/api/Detail-jawaban/lanjut-belajar/${idJawaban}`,
                    {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem(
                                "dp5a-token"
                            )}`,
                        },
                    }
                );
                const idSubKategori = response.data.id;
                this.$router.push({
                    name: "elearningpuspaga-subkategori",
                    params: { id: idSubKategori },
                });
            } catch (error) {
                console.error("Gagal mendapatkan id sub kategori:", error);
            }
        },
        async confirmRetryQuiz() {
            this.showConfirmModal = false;
            const idJawaban = this.$route.params.id;

            try {
                const response = await axios.get(
                    `/api/Detail-jawaban/hasil-latihan-soal/${idJawaban}`,
                    {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem(
                                "dp5a-token"
                            )}`,
                        },
                    }
                );

                const idMateri = response.data.id_materi; // Ambil `id_materi` dari respons

                // Contoh logika untuk menentukan route berdasarkan kondisi tertentu
                if (response.data.jenis_materi == "modul") {
                    this.$router.push({
                        name: "elearningpuspaga-materi-modul",
                        params: { id: idMateri },
                    });
                } else if (response.data.jenis_materi == "video") {
                    this.$router.push({
                        name: "elearningpuspaga-materi-video",
                        params: { id: idMateri },
                    });
                } else {
                    console.error("Jenis materi tidak dikenal");
                    alert("Terjadi kesalahan, jenis materi tidak ditemukan.");
                }
            } catch (error) {
                console.error("Gagal mendapatkan data materi:", error);
                alert("Terjadi kesalahan saat memuat data. Silakan coba lagi.");
            }
        },
    },
};
</script>

<style scoped>
.score-section {
    text-align: center;
    padding: 20px;
    background-image: url("/assets/siapppak/img/nilai.jpg");
    min-height: 500px;
    height: auto;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: scroll;
    color: #fff;
    border-radius: 4px;
    overflow: hidden;
}

.subtitle {
    color: black;
}

.score-circle {
    display: inline-block;
    width: 150px;
    height: 150px;
    background-color: #e4a05f;
    border-radius: 50%;
    font-size: 50px;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 20px auto;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
}

.score-circle.score-high {
    background-color: #adbcf7;
    color: #fff4dd;
}

.score-circle.score-low {
    background-color: #fe8282;
    color: #fff4dd;
}

.message {
    margin-top: 10px;
    font-weight: 500;
    color: black;
}

.button-group {
    margin-top: 15px;
}

.button-group button {
    margin: 5px;
    border-radius: 5px;
    color: #ee7b33;
    background-color: #fff4dd;
    font-size: 12px;
    font-weight: bold;
    padding: 10px 20px;
    border: none;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.3);
    transition: background-color 0.3s, color 0.3s;
}

.button-group button:hover {
    background-color: #ee7b33;
    color: #fff;
}

.summary-table {
    margin-top: 20px;
}

.summary-table h4 {
    font-weight: 500;
}

.summary-table .table {
    width: 100%;
    margin-top: 10px;
    background-color: #fff4dd;
    color: black;
    border-radius: 4px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
}

.summary-table .table th {
    font-weight: 600;
}

.summary-table .table th:first-child,
.summary-table .table td:first-child {
    padding-left: 20px;
}

.summary-table .table tbody tr {
    border-bottom: 1px solid #ccc;
    border-top: 1px solid #ccc;
}

.summary-table .table tbody tr:last-child {
    border-bottom: none;
}

.summary-table .table thead {
    background-color: #e4a05f;
    color: #fff;
}

.summary-table .table tbody {
    background-color: #fff4dd;
    color: black;
}

td img.icon-status {
    height: 70px;
    width: 70px;
}

.modal.fade {
    background: rgba(0, 0, 0, 0.5);
    opacity: 0;
    transform: translateY(-20px);
    transition: opacity 0.4s ease, transform 0.4s ease;
}

.modal.fade.show {
    opacity: 1;
    transform: translateY(0);
}

.modal-dialog-centered {
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-content {
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    max-width: 300px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease;
}

.modal-body {
    color: black;
}

.modal-footer {
    display: flex;
    justify-content: center;
}

@media (max-width: 1200px) {
    .score-section {
        min-height: 400px;
        padding: 15px;
    }
}

@media (max-width: 768px) {
    .score-section {
        min-height: 300px;
    }

    .score-circle {
        width: 120px;
        height: 120px;
        font-size: 48px;
    }

    .button-group button {
        font-size: 10px;
        padding: 8px 16px;
    }

    .summary-table h4 {
        font-size: 1.2rem;
    }

    .summary-table .table {
        font-size: 0.9rem;
    }
}

@media (max-width: 576px) {
    .score-section {
        max-width: 300px;
        padding: 0 20px;
    }

    .message {
        font-size: 0.9rem;
    }

    .button-group button {
        width: 100%;
        margin-bottom: 10px;
    }

    .summary-table .table th,
    .summary-table .table td {
        padding: 10px;
    }
}

@media (max-width: 480px) {
    .score-section {
        background-size: contain;
        background-position: top;
        padding: 20px;
        min-height: 300px;
    }

    .judul p.subtitle {
        font-size: 10px;
    }
}
</style>
