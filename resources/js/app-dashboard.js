require("./bootstrap");

import { createApp } from "vue/dist/vue.esm-bundler.js";

import VueDatePicker from "vue-datepicker-next";
import "vue-datepicker-next/index.css";

import { Money3Component } from "v-money3";

import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";

import { VueSignaturePad } from "vue-signature-pad";

import MainApp from "./components/Dashboard/App.vue";
import Navbar from "@/components/Dashboard/Navbar.vue";
import Sidebar from "@/components/Dashboard/Sidebar.vue";
import ScrollTop from "@/components/Dashboard/ScrollTop.vue";
import DashboardBaseLayout from "@/components/Dashboard/BaseLayout.vue";
import DashboardModal from "@/components/Dashboard/Modal.vue";

import DataTableServerSide from "@/components/Ui/DataTableServerSide.vue";
import SelectSingle from "@/components/Ui/SelectSingle.vue";
import SelectMultiple from "@/components/Ui/SelectMultiple.vue";
import Loader from "@/components/Ui/Loader.vue";

import routes from "@/router/dashboard/index.js";

import Toaster from "@meforma/vue-toaster";

import globalPlugin from "@/plugins/global-plugin.js";

import mainStore from "@/store/index.js";

//import Editor from '@tinymce/tinymce-vue'
import { QuillEditor } from "@vueup/vue-quill";

const app = createApp({});

// define your options
const globalOptions = {
    // debug: 'info',
    modules: {
        toolbar: [
            [{ header: [1, 2, 3, false] }],
            ["bold", "italic", "underline", "strike"],
            [{ list: "ordered" }, { list: "bullet" }],
            [
                { align: "" },
                { align: "center" },
                { align: "right" },
                { align: "justify" },
            ],
        ],
    },
};
// set default globalOptions prop
QuillEditor.props.globalOptions.default = () => globalOptions;

//app.component('app-editor', Editor)
app.component("app-editor", QuillEditor);

app.component("main-app", MainApp);
app.component("app-navbar", Navbar);
app.component("app-sidebar", Sidebar);
app.component("app-scroll-top", ScrollTop);
app.component("dashboard-base-layout", DashboardBaseLayout);
app.component("dashboard-modal", DashboardModal);

app.component("app-datepicker", VueDatePicker);

app.component("app-datatable-serverside", DataTableServerSide);
app.component("app-select-single", SelectSingle);
app.component("app-select-multiple", SelectMultiple);

app.component("app-loader", Loader);

app.component("app-money", Money3Component);
app.component("signature-pad", VueSignaturePad);

app.use(VueSweetalert2);

app.use(routes);

app.use(Toaster, {
    position: "top-right",
    dismissible: true,
    duration: 3000,
});

app.use(mainStore);

app.use(globalPlugin);

app.mount("#dashboard");
