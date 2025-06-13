<script setup>
    import _ from "lodash";

    import {
        ref,
        computed,
        onMounted
    } from 'vue'

    const props = defineProps({
        table_config: {
            type: Object,
            required: true,
        },
    })

    const emit = defineEmits(['change-page', 'update:current_page'
    ])

    const head = ref([])

    const maxVisibleButtons = ref(5);

    const data = computed(() => props.table_config.feeder.data)

    const total_pages = computed(() => {
        return Math.ceil(props.table_config.config.total_data / props.table_config.config.show_per_page);
    });

    const startPage = computed(() => {
        if (props.table_config.config.current_page == 1) {
            return 1;
        }

        if (props.table_config.config.current_page == total_pages.value) {
            return Number(total_pages.value) - (maxVisibleButtons.value - 1);
        }

        // When inbetween
        return props.table_config.config.current_page - 1;
    });

    const pages = computed(() => {
        const range = [];

        for (let x = Number(startPage.value); x <= Math.min(Number(startPage.value) + maxVisibleButtons
                .value - 1, Number(total_pages.value)); x++) {
            if (x > 0) {
                range.push({
                    name: x,
                    isDisabled: x === props.table_config.config.current_page
                });
            }

        }

        return range;
    })

    const isInFirstPage = computed(() => {
        return props.table_config.config.current_page === 1;
    })

    const isInLastPage = computed(() => {
        return props.table_config.config.current_page == total_pages.value;
    });


    onMounted(() => {
        head.value = props.table_config.feeder.column;
    });

    function changePage(page) {
        emit('update:current_page', page)
        emit('change-page')
    }

    function onClickFirstPage() {
        changePage(1);
    }

    function onClickPreviousPage() {
        changePage(props.table_config.config.current_page - 1);

    }

    function onClickPage(page) {
        changePage(page);
    }

    function onClickNextPage() {
        changePage(props.table_config.config.current_page + 1);
    }

    function onClickLastPage() {
        changePage(total_pages.value);
    }
</script>

<template>
    <div class="col-md-12 footer-bar">
        <div style="margin-bottom:15px;">
            Showing {{ props.table_config.feeder.data.length }} from {{ props.table_config.config.total_data }} total data
        </div>
        <ul class="custom-vue-datatable-pagination">
            <li>
                <button type="button" class="btn-prev-next-datatable" @click="onClickFirstPage" :disabled="isInFirstPage || props.table_config.config.loading || props.table_config.config.total_data == 0">
                        <i class="fa fa-arrow-left"></i>
                </button>
            </li>

            <li>
                <button type="button" class="btn-prev-next-datatable" @click="onClickPreviousPage"
                    :disabled="isInFirstPage || props.table_config.config.loading">
                    <i class="fa fa-chevron-left"></i>
                </button>
            </li>

            <li v-for="page in pages" :key="page.name">
                <button type="button"
                    :class="props.table_config.config.current_page == page.name ? 'active' : ''"
                    @click="onClickPage(page.name)" :disabled="page.isDisabled || props.table_config.config.loading || props.table_config.config.total_data == 0">
                    {{ page.name }}
                </button>
            </li>

            <li>
                <button type="button" class="btn-prev-next-datatable" @click="onClickNextPage"
                    :disabled="isInLastPage || props.table_config.config.loading || props.table_config.config.total_data == 0">
                    <i class="fa fa-chevron-right"></i>
                </button>
            </li>

            <li>
                <button type="button" class="btn-prev-next-datatable" @click="onClickLastPage" :disabled="isInLastPage || props.table_config.config.loading || props.table_config.config.total_data == 0">
                    <i class="fa fa-arrow-right"></i>
                </button>
            </li>
        </ul>
    </div>
</template>