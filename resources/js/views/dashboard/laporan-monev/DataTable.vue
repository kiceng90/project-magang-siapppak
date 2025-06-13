<script setup>
import _ from "lodash";

import { computed } from "vue";
import { useStore } from "vuex";
import Pagination from "./Pagination.vue";

const store = useStore();

const props = defineProps({
    table_config: {
        type: Object,
        required: true,
    },
    table_class: {
        type: String,
        required: false,
        default: "",
    },
    table_style: {
        type: String,
        required: false,
        default: "",
    },
    search: {
        type: String,
    },
    show_per_page: {
        type: Number,
    },
    order: {
        type: String,
    },
    sort_by: {
        type: String,
    },
    current_page: {
        type: Number,
    },
    disable_search: {
        type: Boolean,
    },
});

const emit = defineEmits([
    "change-page",
    "update:search",
    "update:show_per_page",
    "update:order",
    "update:sort_by",
    "update:current_page",
    'viewLaporan', 'verifLaporan', 'exportLaporan'
]);

const head = computed(() => props.table_config.feeder.column ?? []);

const headParent = computed(() => props.table_config.feeder.column_parent ?? []);
const data = computed(() => props.table_config.feeder.data ?? []);

const isSubkord = computed(()=> store.state.profile.role_id == process.env.MIX_ROLE_SUBKORD_ID);
const isAdmin = computed(()=> store.state.profile.role_id == process.env.MIX_ROLE_ADMIN_ID);
const isKonselor = computed(()=> store.state.profile.role_id == process.env.MIX_ROLE_KONSELOR_ID);

function changeShowPerPage($event) {
    emit("update:current_page", 1);
    emit("update:show_per_page", $event.target.value);
    emit("change-page");
}

const changeSearch = _.debounce(($event) => {
    emit("update:current_page", 1);
    emit("update:search", $event.target.value);
    emit("change-page");
}, 1000);

function sort(sort_by, sort_column) {
    if (props.table_config.config.loading === true) {
        return false;
    }

    if (sort_column) {
        let order = "";
        if (sort_by == props.table_config.config.sort_by) {
            if (props.table_config.config.order == "asc") order = "desc";
            else if (props.table_config.config.order == "desc") order = "asc";
            else order = "asc";
        } else {
            order = "asc";
        }
        emit("update:current_page", 1);
        emit("update:sort_by", sort_by);
        emit("update:order", order);
        emit("change-page");
    }
}
</script>

<template>
    <div class="datatable-component">
        <div class="row" style="overflow-x: hidden !important">
            <div
                class="col-lg-12 d-flex justify-content-between align-items-center flex-wrap"
            >
                <div
                    class="d-flex align-items-center"
                    style="margin-bottom: 15px"
                >
                    <div
                        style="
                            color: #828389 !important;
                            font-size: 12px;
                            font-weight: 400;
                            margin-right: 5px;
                        "
                    >
                        Show per page
                    </div>
                    <select
                        :value="props.table_config.config.show_per_page"
                        class="select-show-per-page-datatable"
                        @change="changeShowPerPage($event)"
                    >
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div
                    class="d-flex align-items-center"
                    style="margin-bottom: 15px"
                    v-if="!disable_search"
                >
                    <div
                        class="w-100 d-flex align-items-center"
                        style="
                            max-width: 250px;
                            border: 1px #e4e6ef solid;
                            background: #fff;
                            border-radius: 5px;
                        "
                    >
                        <span
                            class="svg-icon svg-icon-3 svg-icon-gray-500"
                            style="margin-left: 15px"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                            >
                                <rect
                                    opacity="0.5"
                                    x="17.0365"
                                    y="15.1223"
                                    width="8.15546"
                                    height="2"
                                    rx="1"
                                    transform="rotate(45 17.0365 15.1223)"
                                    fill="currentColor"
                                ></rect>
                                <path
                                    d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                    fill="currentColor"
                                ></path>
                            </svg>
                        </span>
                        <input
                            type="text"
                            id="update-search"
                            class="form-control form-control-solid"
                            @input="changeSearch"
                            style="
                                background: #fff;
                                border: 0 !important;
                                outline: none !important;
                                box-shadow: unset !important;
                            "
                            :value="props.table_config.config.search"
                            placeholder="Search"
                        />
                    </div>
                </div>
            </div>
            <div
                class="col-md-12 table-bar"
                style="overflow-x: auto !important"
            >
                <table
                    class="custom-vue-datatable-monev"
                    :style="props.table_style"
                    :class="props.table_class"
                >
                    <thead>
                        <tr v-if="headParent.length > 0">
                            <th
                                v-for="col in headParent"
                                :colspan="col.colspan"
                                :rowspan="col.rowspan"
                                style="text-align: center; vertical-align: middle;"
                                :style="col.style"
                            >{{ col.text }}</th>
                        </tr>
                        <tr>
                            <th
                                v-for="(headx, idx) in head"
                                :key="idx"
                                :style="headx.style"
                                :class="{
                                    sortable: headx.sort_column === true,
                                }"
                                @click="sort(headx.sort_by, headx.sort_column)"
                            >
                                {{ headx.text ?? "" }}
                                <div
                                    v-if="headx.vhtm"
                                    v-html="headx.vhtm"
                                ></div>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        <template v-if="props.table_config.config.loading">
                            <tr>
                                <td
                                    :colspan="head.length"
                                    style="
                                        text-align: center;
                                        font-size: 9pt;
                                        color: #b5b5b5;
                                        padding-top: 50px;
                                        padding-bottom: 50px;
                                    "
                                >
                                    <div class="loader"></div>
                                </td>
                            </tr>
                        </template>

                        <template v-else-if="data.length">
                            <!-- <slot name="body"></slot> -->
                            <tr
                                v-for="(rowData, head_index) in data"
                                :key="head_index"
                            >
                                <!-- Row Number -->
                                <td style="text-align: center;">{{ ((current_page - 1) * show_per_page) + head_index + 1 }}</td>
                                <td
                                    v-for="(headx, row_index) in head"
                                    style="text-align: center;"
                                    :style="headx.rowStyle"
                                    :key="'row-'+row_index"
                                >
                                    <template v-if="headx.accessor">{{ rowData[headx.accessor] || '-' }}</template>
                                    <template v-else-if="headx.getData">{{ headx.getData(rowData) || '-' }}</template>
                                    <template v-else>-</template>
                                </td>
                                <!-- Status Verifikasi -->
                                <td style="text-align: center; white-space: nowrap;">{{ rowData.status_string || '-' }}</td>
                                <!-- Action -->
                                <td style="text-align: center;">
                                    <div class="dropdown" style="position:static !important;">
                                        <button class="btn btn-secondary btn-xs dropdown-toggle"
                                            type="button" data-bs-toggle="dropdown"
                                            style="padding:5px 10px !important;"
                                            aria-expanded="false">
                                            Aksi
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <!-- <a class="dropdown-item py-3" href="javascript:void(0);" @click="$emit('viewLaporan', rowData)">Lihat</a> -->
                                                <router-link class="dropdown-item py-3" :to="{name: 'kegiatan-monev-show', params: {id: rowData.id}}">Lihat</router-link>
                                            </li>
                                            <li v-if="isKonselor">
                                                <router-link class="dropdown-item py-3" :to="{name: 'kegiatan-monev-edit', params: {id: rowData.id}}">Edit</router-link>
                                            </li>
                                            <li v-if="isSubkord">
                                                <a class="dropdown-item py-3" href="javascript:void(0);" @click="$emit('verifLaporan', rowData)">Verifikasi</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item py-3" href="javascript:void(0);" @click="$emit('exportLaporan', rowData)">Export</a>
                                            </li>
                                            <li v-if="isAdmin">
                                                <a class="dropdown-item py-3" href="javascript:void(0);" @click="$emit('deleteLaporan', rowData)">Hapus</a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        </template>

                        <template v-else>
                            <tr>
                                <td
                                    :colspan="head.length"
                                    style="
                                        text-align: center;
                                        font-size: 9pt;
                                        color: #b5b5b5;
                                    "
                                >
                                    <div
                                        style="
                                            margin-top: 10px;
                                            margin-bottom: 10px;
                                        "
                                    >
                                        Tidak ditemukan data apapun disini.
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <Pagination
                :table_config="table_config"
                v-model:current_page="table_config.config.current_page"
                @change-page="emit('change-page')"
            />
        </div>
    </div>
</template>

<style>
.datatable-component .custom-vue-datatable-monev .loader {
    border: 5px solid #f3f3f3;
    /* Light grey */
    border-top: 5px solid #39a388;
    /* Blue */
    border-radius: 50%;
    width: 50px;
    height: 50px;
    margin: 0 auto;
    animation: spin 1s linear infinite;
    margin-bottom: 20px;
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}

.datatable-component .footer-bar {
    display: flex;
    margin-top: 15px;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
}

.datatable-component .custom-vue-datatable-monev-pagination {
    display: flex;
    flex-wrap: wrap;
    list-style-type: none;
    margin-bottom: 15px;
}

.datatable-component .custom-vue-datatable-monev-pagination button {
    padding: 5px;
    font-size: 12px;
    background-color: #fff !important;
    border: 0 !important;
    width: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 5px;
    height: 35px;
}

.datatable-component
    .custom-vue-datatable-monev-pagination
    button.btn-prev-next-datatable {
    background: #f7f9fb !important;
    border-radius: 8px !important;
}

.datatable-component .custom-vue-datatable-monev-pagination button.active {
    background: #ff8364 !important;
    border-radius: 8px;
    color: #fff !important;
}

.datatable-component .custom-vue-datatable-monev {
    width: 100%;
}

.datatable-component .custom-vue-datatable-monev thead tr th {
    border: 1px #eaebed solid !important;
    padding: 15px 10px;
    color: #404040;
}
.datatable-component .custom-vue-datatable-monev thead tr th.sortable {
    cursor: pointer;
}

.datatable-component .custom-vue-datatable-monev tbody tr td {
    border-bottom: 1px #eaebed solid !important;
    padding: 15px 10px;
}

.datatable-component .select-show-per-page-datatable {
    width: 60px;
    cursor: pointer;
    outline: none !important;
    box-shadow: unset !important;
    height: 40px;
    color: #828389 !important;
    background-color: #fff;
    border: 0 !important;
    border-radius: 5px;
}

.custom-vue-datatable-monev {
    min-width: 600px;
}
</style>
