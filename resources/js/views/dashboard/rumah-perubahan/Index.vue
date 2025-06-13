<template>
    <div>
        <div class="d-flex flex-column flex-root">
            <div class="page d-flex flex-row flex-column-fluid">
                <app-sidebar></app-sidebar>
                <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                    <app-navbar></app-navbar>
                    <div id="main-content" class="rumah-perubahan-container">
                        <div class="post d-flex flex-column-fluid" id="kt_post">
                            <div id="kt_content_container" class="container-xxl">
                                <div class="card card-flush mt-5 mb-5 mb-xl-10" id="kt_profile_details_view">
                                    <div class="card card-xl-stretch">
                                        <div class="card-body pt-1" id="start-content">
                                            <div class="hero-section">
                                                <div class="row align-items-center">
                                                    <div class="col-md-5">
                                                        <!-- Enhanced Logo -->
                                                        <img
                                                            :src="getImageUrl('logorumper.png')"
                                                            alt="Logo E-Learning"
                                                            class="logo-img animate-fade-in"
                                                        />
                                                    </div>
                                                    <div class="col-md-7">
                                                        <h2 class="hero-title animate-slide-up">Rumah Perubahan</h2>
                                                        <p class="hero-description animate-slide-up">
                                                            Rumah Perubahan adalah tempat pembinaan dan pendampingan bagi anak yang terlibat dalam permasalahan sosial,
                                                            memberikan kesempatan untuk transformasi positif dan pengembangan tanggung jawab sosial.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="categories-section">
                                                <div class="text-center mb-5">
                                                    <h1 class="section-title animate-fade-in">Kategori Pengerjaan</h1>
                                                    <p class="section-subtitle animate-slide-up">
                                                        Pilih kategori tes sesuai kebutuhan anda.
                                                    </p>
                                                </div>

                                                <div class="row g-4">
                                                    <div
                                                        v-for="(card, index) in cards"
                                                        :key="index"
                                                        class="col-md-3 col-sm-6"
                                                    >
                                                        <div
                                                            class="category-card"
                                                            :class="{ 'card-disabled': card.disabled }"
                                                            @click="!card.disabled && navigateToCategory(card.id)"
                                                        >
                                                            <div class="category-card-inner">
                                                                <div class="category-card-image">
                                                                    <!-- Check if Image Exists or Use Pretest/Posttest Images -->
                                                                    <img
                                                                        v-if="card.image"
                                                                        :src="getImageUrl(card.image)"
                                                                        :alt="card.name"
                                                                        class="img-fluid"
                                                                    />
                                                                    <div v-else class="category-placeholder">
                                                                        <i class="fas fa-folder-open"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="category-card-content">
                                                                    <h3 class="category-title">{{ card.name }}</h3>
                                                                    <p class="category-quote">
                                                                        {{ card.kutipan || 'Mulai pengerjaan tesmu di sini' }}
                                                                    </p>
                                                                </div>
                                                                <div
                                                                    v-if="card.disabled"
                                                                    class="category-lock-overlay"
                                                                >
                                                                    <i class="fas fa-lock"></i>
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
        </div>
        <app-scroll-top></app-scroll-top>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            cards: [],
            showModal: false,
        };
    },
    mounted() {
        this.fetchCategories();
        this.initAnimations();
        reinitializeAllPlugin(); // Maintained from original code
    },
    methods: {
        navigateToCategory(id) {
            this.$router.push({
                name: "rumahperubahan-materi",
                params: { id },
            });
        },
        async fetchCategories() {
            try {
                const response = await axios.get(`/api/m-kategori-rumah-perubahan/getKategoris`, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem("dp5a-token")}`,
                    },
                });
                console.log("Respons API Kategori:", response.data);

                if (Array.isArray(response.data)) {
                    this.cards = response.data.map((category) => ({
                        id: category.id,
                        name: category.name,
                        image: category.image ? category.image : this.getDefaultImage(category.id),
                        kutipan: category.kutipan,
                        disabled: category.disabled || false
                    }));
                } else {
                    console.error("Data kategori tidak dalam bentuk array:", response.data);
                }
            } catch (error) {
                console.error("Gagal mengambil data kategori:", error);
            }
        },
        getImageUrl(path) {
            return `/assets/siapppak/img/${path}`;
        },
        getDefaultImage(categoryId) {
            // Use pretest or posttest images based on the category ID
            if (categoryId === 1) {
                return 'pretes.png'; // Adjust according to your categories
            } else if (categoryId === 2) {
                return 'posttes.png'; // Adjust according to your categories
            }
            return ''; // Default case (no image)
        },
        initAnimations() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                    }
                });
            }, {
                threshold: 0.1
            });

            document.querySelectorAll('.animate-fade-in, .animate-slide-up').forEach(el => {
                observer.observe(el);
            });
        },
        closeModal() {
            this.showModal = false;
        },
    },
};
</script>

<style scoped>
:root {
    --primary-color: #00a175;
    --secondary-color: #f85c9b;
    --background-color: #f4f7f6;
    --text-color: #333;
    --card-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.rumah-perubahan-container {
    background-color: var(--background-color);
    font-family: 'Inter', sans-serif;
    color: var(--text-color);
}

.hero-section {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: black;
    padding: 2rem;
    margin-bottom: 2rem;
    border-radius: 10px;
    box-shadow: var(--card-shadow);
}

.logo-img {
    max-width: 250px;
    transition: transform 0.3s ease;
}

.hero-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.hero-description {
    font-size: 1rem;
    line-height: 1.6;
    opacity: 0.9;
}

.categories-section {
    padding: 1rem 0;
}

.section-title {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--primary-color);
    margin-bottom: 1rem;
}

.section-subtitle {
    color: #666;
    font-size: 1rem;
}

.category-card {
    position: relative;
    cursor: pointer;
    transition: all 0.3s ease;
    perspective: 1000px;
    height: 100%;
}

.category-card:hover {
    transform: translateY(-10px);
}

.category-card-inner {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: var(--card-shadow);
    transition: transform 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.category-card-image {
    height: 200px;
    overflow: hidden;
}

.category-card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.category-card:hover .category-card-image img {
    transform: scale(1.1);
}

.category-placeholder {
    height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: var(--background-color);
    color: var(--primary-color);
    font-size: 3rem;
}

.category-card-content {
    padding: 1rem;
    text-align: center;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.category-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: var(--primary-color);
    margin-bottom: 0.5rem;
}

.category-quote {
    font-size: 0.9rem;
    color: #666;
}

.category-lock-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2rem;
}

.card-disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

/* Animation Styles */
.animate-fade-in,
.animate-slide-up {
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.6s ease, transform 0.6s ease;
}

.animate-fade-in.is-visible,
.animate-slide-up.is-visible {
    opacity: 1;
    transform: translateY(0);
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .hero-section {
        padding: 1rem;
    }

    .hero-title {
        font-size: 1.5rem;
    }

    .category-card {
        margin-bottom: 1rem;
    }
}
</style>