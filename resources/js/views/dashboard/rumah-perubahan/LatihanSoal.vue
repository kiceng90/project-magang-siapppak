<template>
    <div>
        <div class="d-flex flex-column flex-root">
            <app-navbar></app-navbar>
            <div id="main-content">
                <div class="post d-flex flex-column-fluid" id="kt_post">
                    <div id="kt_content_container" class="container-xxl">
                        <div class="quiz-header">
                            <h5 class="quiz-title">Latihan Soal</h5>
                            <h5 class="quiz-subtitle">"{{ name }}"</h5>
                        </div>
                        <div class="quiz-container" v-if="questions.length > 0">
                            <div class="sidebar col-3">
                                <div class="timer">
                                    <div class="row align-items-center">
                                        <div class="col-9">Waktu Tersisa:</div>
                                        <div class="col-3">
                                            <span :class="timeClass"
                                                >{{ minutes }}:{{
                                                    seconds
                                                }}</span
                                            >
                                        </div>
                                    </div>
                                </div>
                                <div class="question-nav">
                                    <div
                                        v-for="(question, index) in questions"
                                        :key="index"
                                        :class="[
                                            'question-number',
                                            currentQuestionIndex === index
                                                ? 'active'
                                                : '',
                                            question.answered ? 'answered' : '',
                                        ]"
                                        @click="goToQuestion(index)"
                                    >
                                        {{ index + 1 }}
                                    </div>
                                </div>
                                <div class="finish">
                                    <button
                                        class="finish-btn"
                                        @click="showFinishModal = true"
                                    >
                                        Selesai
                                    </button>
                                </div>
                            </div>
                            <div class="question-content col-9">
                                <div class="question">
                                    <div class="row">
                                        <div class="col-1">
                                            {{ currentQuestionIndex + 1 }}.
                                        </div>
                                        <div class="col-11">
                                            <span
                                                v-html="
                                                    questions[
                                                        currentQuestionIndex
                                                    ].question
                                                "
                                            ></span>
                                        </div>
                                    </div>
                                    <div
                                        v-if="
                                            questions[currentQuestionIndex]
                                                .options.length > 0
                                        "
                                    >
                                        <div
                                            v-for="(option, idx) in questions[
                                                currentQuestionIndex
                                            ].options"
                                            :key="idx"
                                            :class="[
                                                'option',
                                                option.selected
                                                    ? 'selected'
                                                    : '',
                                            ]"
                                            @click="
                                                selectOption(
                                                    currentQuestionIndex,
                                                    idx
                                                )
                                            "
                                        >
                                            {{ option.label }}.
                                            {{ option.text }}
                                        </div>
                                    </div>
                                    <div v-else>
                                        <p>Pilihan jawaban tidak tersedia.</p>
                                    </div>
                                </div>

                                <div class="nav-buttons">
                                    <button
                                        @click="prevQuestion"
                                        :disabled="currentQuestionIndex === 0"
                                    >
                                        Sebelumnya
                                    </button>
                                    <button
                                        v-if="
                                            currentQuestionIndex <
                                            questions.length - 1
                                        "
                                        @click="nextQuestion"
                                    >
                                        Selanjutnya
                                    </button>
                                    <button
                                        v-else
                                        @click="showFinishModal = true"
                                    >
                                        Selesai
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div v-else>
                            <p>Loading questions...</p>
                        </div>
                    </div>
                </div>
            </div>

            <div
                :class="['modal', 'fade', { show: showFinishModal }]"
                tabindex="-1"
                v-if="showFinishModal"
                style="display: block"
            >
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Konfirmasi Selesai</h5>
                            <div
                                class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                                @click="showFinishModal = false"
                                aria-label="Close"
                            >
                                <span class="svg-icon-2x">
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
                        <div class="modal-body">
                            <p>
                                Apakah Anda yakin ingin menyelesaikan latihan
                                ini?
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-sm btn-light me-4"
                                @click="showFinishModal = false"
                            >
                                Batal
                            </button>
                            <button
                                @click="confirmFinishQuiz"
                                class="btn btn-sm bg-second-primary-custom text-white"
                                type="button"
                            >
                                Selesai
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <app-scroll-top></app-scroll-top>
    </div>
</template>

<script>
export default {
    data() {
        return {
            timeLeft: 1800, // Waktu tersisa dalam detik
            interval: null, // Timer interval
            currentQuestionIndex: 0, // Indeks pertanyaan yang aktif
            showFinishModal: false, // Modal konfirmasi selesai
            questions: [], // Daftar pertanyaan dan opsi jawaban
            name: "", // Nama materi/soal
            temporaryAnswers: [], // Menyimpan jawaban sementara (dengan skor)
        };
    },
    computed: {
        minutes() {
            return String(Math.floor(this.timeLeft / 60)).padStart(2, "0");
        },
        seconds() {
            return String(this.timeLeft % 60).padStart(2, "0");
        },
        timeClass() {
            return this.timeLeft < 30 ? "time-low" : "";
        },
    },
    methods: {
        // async submitAnswers() {
        //     const idJawaban = localStorage.getItem("idJawaban"); // Retrieve ID from localStorage
        //     if (!idJawaban) {
        //         console.error("ID Jawaban not found in localStorage.");
        //         return;
        //     }

        //     try {
        //         const response = await axios.post(
        //             "/api/rumahperubahan-detailjawaban/submit-answers",
        //             {
        //                 id_jawaban: idJawaban, // Include ID jawaban
        //                 answers: this.temporaryAnswers, // Temporary answers
        //             },
        //             {
        //                 headers: {
        //                     Authorization: `Bearer ${localStorage.getItem(
        //                         "dp5a-token"
        //                     )}`, // Ensure the token is valid
        //                     Accept: "application/json",
        //                 },
        //             }
        //         );
        //         console.log("Jawaban berhasil dikirim:", response.data);
        //         this.$router.push({
        //             name: "rumahperubahan-hasillatihansoal",
        //             params: { id: idJawaban },
        //         }); // Redirect after submission
        //     } catch (error) {
        //         console.error("Error submitting answers:", error);
        //     }
        // },
        async submitAnswers() {
            const idJawaban = localStorage.getItem("idJawaban"); // Retrieve ID from localStorage
            if (!idJawaban) {
                console.error("ID Jawaban not found in localStorage.");
                this.$swal({
                    title: "Error",
                    text: "ID Jawaban tidak ditemukan, silahkan coba lagi",
                    icon: "error",
                });
                return;
            }

            try {
                // Show loading indicator
                this.$ewpLoadingShow();
                
                console.log("Submitting answers with ID Jawaban:", idJawaban);
                console.log("Temporary answers:", this.temporaryAnswers);

                const response = await axios.post(
                    "/api/rumahperubahan-detailjawaban/submit-answers",
                    {
                        id_jawaban: idJawaban, // Include ID jawaban
                        answers: this.temporaryAnswers, // Temporary answers
                    },
                    {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem(
                                "dp5a-token"
                            )}`, // Ensure the token is valid
                            Accept: "application/json",
                        },
                    }
                );
                
                console.log("Response from submit-answers:", response.data);
                
                if (response.data && response.data.success) {
                    // Update status jawaban to is_done and is_selesai = true
                    await this.updateJawabanStatus(idJawaban);
                    
                    // Navigate to results page
                    this.$router.push({
                        name: "rumahperubahan-hasillatihansoal",
                        params: { id: idJawaban },
                    });
                    // this.$router.push(`dashboard/rumahperubahan-hasillatihansoal/${idJawaban}`);
                } else {
                    throw new Error("Failed to submit answers: " + (response.data?.message || "Unknown error"));
                }
            } catch (error) {
                console.error("Error submitting answers:", error);
                this.$swal({
                    title: "Error",
                    text: error.response?.data?.message || "Terjadi kesalahan saat mengirim jawaban",
                    icon: "error",
                });
            } finally {
                // Hide loading indicator
                this.$ewpLoadingHide();
            }
        },
        
        async updateJawabanStatus(idJawaban) {
            try {
                console.log("Updating jawaban status for ID:", idJawaban);
                const response = await axios.put(
                    `/api/rumahperubahan-jawaban/${idJawaban}/complete`,
                    {},
                    {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem("dp5a-token")}`,
                            Accept: "application/json",
                        },
                    }
                );
                
                console.log("Update jawaban status response:", response.data);
                return response.data;
            } catch (error) {
                console.error("Error updating jawaban status:", error);
                throw error;
            }
        },        async fetchMateri() {
            const idMateri = this.$route.params.id; // Ambil ID materi dari route
            try {
                const response = await axios.get(
                    `/api/m-materi-rumah-perubahan/getMateri/${idMateri}`,
                    {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem(
                                "dp5a-token"
                            )}`,
                        },
                    }
                );
                this.name = response.data.name; // Ambil nama materi dari response
            } catch (error) {
                console.error("Error fetching materi data:", error);
            }
        },
        async fetchQuestions() {
            const idMateri = this.$route.params.id;
            try {
                const response = await axios.get(
                    `/api/m-soal-rumah-perubahan/latihanSoal/${idMateri}`,
                    {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem(
                                "dp5a-token"
                            )}`,
                        },
                    }
                );
                if (response.data && Array.isArray(response.data)) {
                    this.questions = response.data.map((soal) => ({
                        id: soal.id,
                        question: soal.name || "Pertanyaan tidak tersedia",
                        options:
                            soal.pilihan_jawaban &&
                            soal.pilihan_jawaban.length > 0
                                ? soal.pilihan_jawaban.map((jawaban) => ({
                                    id: jawaban.id,
                                    label: jawaban.abjad || "-",
                                    text:
                                        jawaban.pilihan ||
                                        "Pilihan tidak tersedia",
                                    selected: false,
                                    is_active: jawaban.is_active,
                                    skor: jawaban.is_active ? soal.skor : 0,
                                }))
                                : [
                                    {
                                        label: "-",
                                        text: "Tidak ada pilihan jawaban",
                                        selected: false,
                                        is_active: false,
                                          skor: 0, // Skor 0 jika tidak ada jawaban
                                    },
                                ],
                        answered: false,
                    }));
                } else {
                    console.error(
                        "Invalid API response structure:",
                        response.data
                    );
                    this.questions = [];
                }
            } catch (error) {
                console.error("Error fetching questions:", error);
                this.questions = [];
            }
        },
        goToQuestion(index) {
            this.currentQuestionIndex = index;
        },
        selectOption(questionIndex, optionIndex) {
            // Reset semua opsi jawaban untuk pertanyaan ini
            this.questions[questionIndex].options.forEach((option) => {
                option.selected = false;
            });

            // Tandai pilihan yang dipilih
            const selectedOption =
                this.questions[questionIndex].options[optionIndex];
            selectedOption.selected = true;
            this.questions[questionIndex].answered = true;

            // Simpan jawaban sementara dengan skor
            const existingAnswerIndex = this.temporaryAnswers.findIndex(
                (answer) => answer.id_soal === this.questions[questionIndex].id
            );
            if (existingAnswerIndex !== -1) {
                this.temporaryAnswers[existingAnswerIndex] = {
                    id_soal: this.questions[questionIndex].id,
                    id_pilihan_jawaban: selectedOption.id,
                    skor: selectedOption.is_active ? selectedOption.skor : 0, // Simpan skor
                };
            } else {
                this.temporaryAnswers.push({
                    id_soal: this.questions[questionIndex].id,
                    id_pilihan_jawaban: selectedOption.id,
                    skor: selectedOption.is_active ? selectedOption.skor : 0, // Simpan skor
                });
            }
        },
        prevQuestion() {
            if (this.currentQuestionIndex > 0) {
                this.currentQuestionIndex -= 1;
            }
        },
        nextQuestion() {
            if (this.currentQuestionIndex < this.questions.length - 1) {
                this.currentQuestionIndex += 1;
            }
        },
        // confirmFinishQuiz() {
        //     this.showFinishModal = false;
        //     this.submitAnswers(); // Kirim jawaban ketika selesai
        // },
        confirmFinishQuiz() {
            this.showFinishModal = false;
            
            // Calculate the total score
            let totalScore = 0;
            this.temporaryAnswers.forEach(answer => {
                totalScore += answer.skor;
            });
            
            console.log("Total score calculated:", totalScore);
            
            // Submit answers with the total score
            this.submitAnswers().catch(err => {
                console.error("Failed to submit quiz:", err);
                this.$swal({
                    title: "Error",
                    text: "Gagal menyelesaikan kuis. Silakan coba lagi.",
                    icon: "error",
                });
            });
        },
        startTimer() {
            this.interval = setInterval(() => {
                if (this.timeLeft > 0) {
                    this.timeLeft--;
                } else {
                    clearInterval(this.interval);
                    this.showFinishModal = true;
                }
            }, 1000);
        },
    },
    mounted() {
        reinitializeAllPlugin();
        this.startTimer();
        this.fetchMateri();
        this.fetchQuestions().then(() => {
            console.log("Questions loaded:", this.questions);
        });
    },

    beforeUnmount() {
        clearInterval(this.interval);
    },
};
</script>

<style scoped>
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

.modal-footer {
    display: flex;
    justify-content: center;
}

.bg-second-primary-custom {
    background-color: #ff5c5c;
}

#kt_content_container {
    margin-top: 80px;
}

.quiz-header {
    text-align: center;
    margin-bottom: 20px;
}

.quiz-title {
    font-size: 15px;
    margin: 0;
}

.quiz-subtitle {
    font-size: 15px;
}

.quiz-container {
    display: flex;
    gap: 20px;
}

.sidebar {
    width: 25%;
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.timer {
    background-color: #fdd3d0;
    padding: 7px 20px;
    border-radius: 8px;
    font-weight: bold;
    margin-bottom: 20px;
    font-size: 13px;
}

.timer .row .col-3 span {
    font-size: 14px;
    font-weight: bold;
    color: #17451a;
    transition: color 0.5s ease-in-out;
}

.timer .row .col-3 span.time-low {
    color: #b8001f;
}

.question-nav {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    justify-content: center;
    gap: 10px;
}

.question-number {
    width: 45px;
    height: 45px;
    box-shadow: 0 0 7px rgba(0, 0, 0, 0.8);
    background-color: #f2f2f2;
    margin-bottom: 20px;
    border-radius: 8px;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}

.question-number.answered {
    background-color: #fffbeb;
    color: #e5a000;
}

.question .row .col-11 {
    margin-left: -60px;
}

.finish {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.finish-btn {
    background-color: #ffb45b;
    padding: 7px 14px;
    border-radius: 8px;
    color: white;
    font-weight: bold;
    cursor: pointer;
    border: none;
    font-size: 11px;
}

.question-content {
    width: 75%;
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.question {
    font-weight: 600;
}

.question p {
    margin-bottom: 20px;
}

.option {
    font-weight: 500;
    padding: 7px 10px;
    margin-bottom: 20px;
    box-shadow: 0 0 8px rgba(0, 0, 0, 0.2);
    border: 1.5px solid black;
    border-radius: 4px;
    margin-bottom: 14px;
    cursor: pointer;
    display: flex;
    align-items: center;
}

.option.selected {
    background-color: #cee0f0;
    border: 1.5px solid black;
}

.nav-buttons {
    display: flex;
    justify-content: space-between;
}

.nav-buttons button {
    margin-top: 10px;
    padding: 10px 20px;
    background-color: #fff4dd;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);
    color: #e07417;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: bold;
}

.nav-buttons button:disabled {
    background-color: #ddd;
    cursor: not-allowed;
}

/* Responsive adjustments */
@media (max-width: 992px) {
    .quiz-container {
        flex-direction: column;
    }

    /* Sidebar tetap 4 kolom dalam 1 baris */
    .sidebar {
        width: 100%;
    }

    .question-nav {
        grid-template-columns: repeat(4, 1fr);
    }

    .question-number {
        width: 80px;
        height: 80px;
        font-size: 1.9rem;
    }

    .question-content {
        width: 100%;
    }

    .question .row .col-11 {
        margin-left: -45px;
    }
}

@media (max-width: 768px) {
    .question-number {
        width: 65px;
        height: 65px;
        font-size: 0.9rem;
    }

    .question .row .col-11 {
        margin-left: -45px;
    }
}

@media (max-width: 480px) {
    .question-number {
        width: 55px;
        height: 55px;
        font-size: 1.35rem;
    }

    .question .row .col-11 {
        margin-left: -15px;
    }
}
</style>
