<template>
    <div>
        <div class="pu_site_page">
            <app-header></app-header>

            <section
                class="pu_beadcrumb_part"
                :style="`background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url(${$assetUrl()}siapppak/images/windowkie.jpg) center center / cover no-repeat;`"
            >
                <div class="container text-center">
                    <br>
                    <h2 class="sub_title">ARTIKEL</h2>
                    <h1 class="title">Perempuan dan Anak</h1>
                </div>
            </section>

            <section class="pu_blog_post">
                <div class="container">
                    <div class="row mb-4">
                        <div class="col-12">
                            <input
                                type="text"
                                class="form-control"
                                v-model="search"
                                placeholder="Cari artikel..."
                                @input="fetchArticles"
                            />
                        </div>
                    </div>
                    <div class="row">
                        <div v-for="(article, index) in articles" :key="index" class="col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="card article-card shadow-lg">
                                <div class="card-img-wrapper">
                                    <img
                                        :src="article.image"
                                        :alt="article.title"
                                        class="card-img-top"
                                    />
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">{{ article.title }}</h5>
                                    <p class="card-text">{{ article.description }}</p>
                                    <div class="meta d-flex justify-content-between align-items-center">
                                        <span class="date">{{ formatDate(article.date) }}</span>
                                        <router-link :to="`/artikel/${article.id}`" class="btn btn-primary btn-sm">Read More</router-link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pagination-container text-center mt-4">
                        <ul class="pagination justify-content-center">
                            <li
                                class="page-item"
                                :class="{ disabled: pagination.current_page === 1 }"
                            >
                                <a
                                    href="#"
                                    class="page-link"
                                    @click.prevent="changePage(pagination.current_page - 1)"
                                    aria-label="Previous"
                                >
                                    &laquo;
                                </a>
                            </li>

                            <li
                                v-for="page in generatePageNumbers()"
                                :key="page"
                                class="page-item"
                                :class="{ active: pagination.current_page === page }"
                            >
                                <a
                                    href="#"
                                    class="page-link"
                                    @click.prevent="changePage(page)"
                                >
                                    {{ page }}
                                </a>
                            </li>

                            <li
                                class="page-item"
                                :class="{ disabled: pagination.current_page === pagination.last_page }"
                            >
                                <a
                                    href="#"
                                    class="page-link"
                                    @click.prevent="changePage(pagination.current_page + 1)"
                                    aria-label="Next"
                                >
                                    &raquo;
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>

            <app-footer></app-footer>
        </div>
    </div>
</template>

<script>
import Api from "@/services/api";

export default {
    data() {
        return {
            articles: [],
            pagination: {
                current_page: 1,
                last_page: 1,
            },
            search: "",
        };
    },
    methods: {
        fetchArticles() {
            const params = {
                page: this.pagination.current_page,
                limit: 12,
                is_active: true,
                search: this.search,
            };

            Api()
                .get(`public/artikelpublic`,{ params })
                .then((response) => {
                    this.articles = response.data.data.map((item) => ({
                        id: item.id,
                        title: item.title,
                        description: item.description.substring(0, 20) + "...", 
                        image: item.file_thumbnail || "https://via.placeholder.com/600x400",
                        date: item.created_at || "Unknown Date",
                    }));
                    this.pagination = {
                        current_page: response.data.current_page,
                        last_page: response.data.last_page,
                        next_page_url: response.data.next_page_url,
                        prev_page_url: response.data.prev_page_url,
                    };
                })
                .catch((error) => {
                    console.error("Failed to fetch articles:", error);
                });
        },
        formatDate(date) {
            const options = { year: "numeric", month: "long", day: "numeric" };
            return new Date(date).toLocaleDateString("id-ID", options);
        },
        changePage(page) {
            if (page >= 1 && page <= this.pagination.last_page) {
                this.pagination.current_page = page;
                this.fetchArticles();
            }
        },
        generatePageNumbers() {
            const start = Math.max(1, this.pagination.current_page - 2); 
            const end = Math.min(
                this.pagination.last_page,
                this.pagination.current_page + 2
            ); 
            const pages = [];
            for (let i = start; i <= end; i++) {
                pages.push(i);
            }
            return pages;
        },    },
        mounted() {
            this.fetchArticles();
        },
};
</script>

<style scoped>

.pu_blog_post input.form-control {
    border-radius: 5px;
    padding: 10px;
    font-size: 1rem;
    margin-bottom: 20px;
}

/* Breadcrumb Section */
.pu_beadcrumb_part {
    padding: 60px 0;
    color: #fff;
}

.pu_beadcrumb_part .sub_title {
    font-size: 1.5rem;
    font-weight: 300;
    text-transform: uppercase;
    color: #f1f1f1;
}

.pu_beadcrumb_part .title {
    font-size: 3rem;
    font-weight: 700;
    color: #fff;
}

/* Articles Section */
.pu_blog_post {
    background-color: #f9f9f9;
    padding: 50px 0;
}

.article-card {
    border-radius: 10px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.article-card:hover {
    transform: translateY(-5px);
    box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.2);
}

.card-img-wrapper {
    border-radius: 10px 10px 0 0;
    overflow: hidden;
}

.card-img-top {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.card-body {
    padding: 15px;
}

.card-title {
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 10px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.card-text {
    font-size: 0.95rem;
    color: #666;
    line-height: 1.5;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.meta {
    font-size: 0.85rem;
    color: #999;
}

.pagination-container .pagination {
    list-style: none;
    display: inline-flex;
    padding: 0;
    margin: 0;
    gap: 5px;
}

.pagination-container .page-item {
    display: inline-block;
}

.pagination-container .page-item.disabled .page-link {
    background: #f8f9fa;
    color: #ccc;
    pointer-events: none;
    border: 1px solid #ddd;
}

.pagination-container .page-item.active .page-link {
    background: #007bff;
    color: #fff;
    border: 1px solid #007bff;
}

.pagination-container .page-link {
    display: block;
    padding: 8px 12px;
    color: #007bff;
    text-decoration: none;
    border: 1px solid #ddd;
    border-radius: 5px;
    transition: all 0.3s ease-in-out;
}

.pagination-container .page-link:hover {
    background: #0056b3;
    color: #fff;
    border: 1px solid #0056b3;
}
</style>
