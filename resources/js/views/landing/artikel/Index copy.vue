<template>
    <div>
        <div class="pu_site_page">
            <!-- Header -->
            <app-header></app-header>

            <!-- Breadcrumb Section -->
            <section
                class="pu_beadcrumb_part"
                :data-bg-img="`${$assetUrl()}siapppak/images/windowkie.jpg`"
                :style="`background: url(${$assetUrl()}siapppak/images/windowkie.jpg) center center / cover no-repeat;`"
            >
                <div class="container custom_container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="pu_breadcrumb_inner_content">
                                <h2 class="sub_title">ARTIKEL</h2>
                                <h1 class="title">Perempuan dan Anak</h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pu_beadcrumb_shape"></div>
            </section>

            <!-- Articles Section -->
            <section class="pu_blog_post padding_bottom pu_single_page_wrapper">
                <div class="container custom_container">
                    <div class="row">
                        <!-- Featured Article -->
                        <div class="col-lg-6" v-if="articles.length > 0">
                            <div class="card featured-article">
                                <img
                                    :src="articles[0].image"
                                    :alt="articles[0].title"
                                    class="card-img-top"
                                />
                                <div class="card-body">
                                    <h4 class="card-title">{{ articles[0].title }}</h4>
                                    <p class="card-text text-truncate">
                                        {{ articles[0].description }}
                                    </p>
                                    <router-link :to="`/artikel/${articles.id}`">Baca Selengkapnya</router-link>
                                    <!-- <a
                                        :href="articles[0].url"
                                        class="btn btn-link text-danger"
                                    >
                                        Baca Sekarang
                                        <i class="bi bi-chevron-double-right"></i>
                                    </a> -->
                                </div>
                            </div>
                        </div>

                        <!-- Articles List -->
                        <div class="col-lg-6" v-if="articles.length > 1">
                            <h5 class="mb-4 fw-bold">Artikel Terpopuler</h5>
                            <div
                                v-for="(article, index) in articles.slice(1)"
                                :key="index"
                                class="d-flex mb-3 align-items-start"
                            >
                                <img
                                    :src="article.image"
                                    :alt="article.title"
                                    class="thumbnail me-3"
                                />
                                <div>
                                    <h6 class="mb-1">
                                        {{ article.title }}
                                    </h6>
                                    <!-- <router-link :to="`/artikel/${artikel.id}`">Baca Selengkapnya</router-link> -->
                                    <a
                                        :href="article.url"
                                        class="btn btn-link text-danger p-0"
                                    >
                                        Baca Sekarang
                                        <i
                                            class="bi bi-chevron-double-right">
                                        </i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- No Articles Available -->
                        <div v-else class="text-center">
                            <p>Belum ada artikel tersedia.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Footer -->
            <app-footer></app-footer>
        </div>
    </div>
</template>

<script>
import Api from "@/services/api";

export default {
    data() {
        return {
            articles: [], // Stores articles fetched from API
        };
    },
    methods: {
        // Fetch articles from API
        fetchArticles() {
            const params = {
                // type: "", // Optionally filter article types
                page: 1, // Default to page 1
                limit: 10, // Adjust limit as needed
            };

            Api()
                .get("public/artikelpublic") // Adjust endpoint based on your API
                .then((response) => {
                    // Map data from response to match expected structure
                    this.articles = response.data.data.map((item) => ({
                        id: item.id,
                        title: item.title,
                        description: item.description,
                        image: item.file_thumbnail || "https://via.placeholder.com/600x400",
                    }));
                })
                .catch((error) => {
                    console.error("Failed to fetch articles:", error);
                    this.articles = []; // Reset articles if error occurs
                });
        },
    },
    mounted() {
        // Call fetchArticles when the component mounts
        this.fetchArticles();
    },
};
</script>

<style>
/* Featured Article Card */
.featured-article {
    border: none;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    overflow: hidden;
}

.featured-article img {
    object-fit: cover;
    height: 250px;
    width: 100%;
}

.featured-article .card-body {
    padding: 1rem 1.5rem;
}

.featured-article .card-title {
    font-size: 1.5rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
}

.featured-article .card-text {
    font-size: 1rem;
    color: #666;
    line-height: 1.5;
}

/* Popular Articles */
.thumbnail {
    width: 120px;
    height: 80px;
    object-fit: cover;
    border-radius: 5px;
}

h6 {
    font-size: 1rem;
    font-weight: 600;
    color: #333;
}

.btn-link {
    font-size: 0.875rem;
    font-weight: 600;
    text-decoration: none;
}

.btn-link i {
    font-size: 0.75rem;
    margin-left: 5px;
}
</style>
