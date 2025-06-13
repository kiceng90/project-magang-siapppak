<template>
    <div id="popup-search" class="page-popup page-search-popup">
        <div id="search-popup-close" class="popup-close-button">
            <div class="burger-icon">
                <span class="burger-icon-top"></span>
                <span class="burger-icon-bottom"></span>
            </div>
        </div>
        <div class="page-search-popup-content">
            <form role="search" method="get" class="search-form" action="/img/logo-with-text.png'">
                <label class="w-100">
                    <input type="search" class="search-field w-100" placeholder="Search…" name="q" title="Search for:">
                </label>
                <button type="submit" class="search-submit">
                    <span class="search-btn-icon fal fa-search"></span>
                    <span class="search-btn-text">
                        Search </span>
                </button>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    mounted() { }
};
</script>