require('./bootstrap')

import {
    createApp
} from 'vue/dist/vue.esm-bundler.js'


import 'vue-datepicker-next/index.css';

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

import MainApp from './components/Landing/App.vue';
import DataTableServerSide from "@/components/Ui/DataTableServerSide.vue";
import SelectSingle from "@/components/Ui/SelectSingle.vue";
import SelectMultiple from "@/components/Ui/SelectMultiple.vue";
import Navbar from "@/components/Landing/Navbar.vue";
import Header from "@/components/Landing/Header.vue";
import Footer from "@/components/Landing/Footer.vue";
import PopupSearch from "@/components/Landing/PopupSearch.vue";
import MobileMenu from "@/components/Landing/MobileMenu.vue";

import routes from '@/router/landing/index.js'

import Toaster from "@meforma/vue-toaster";

import globalPlugin from "@/plugins/global-plugin.js";

import mainStore from "@/store/index.js";

import Editor from '@tinymce/tinymce-vue'

const app = createApp({})

app.component('app-editor', Editor)

app.component('main-app', MainApp);
app.component('app-navbar', Navbar);
app.component('app-header', Header);
app.component('app-footer', Footer);
app.component('app-popupsearch', PopupSearch);
app.component('app-mobilemenu', MobileMenu);

app.component('app-datatable-serverside', DataTableServerSide);
app.component('app-select-single', SelectSingle);
app.component('app-select-multiple', SelectMultiple);

app.use(VueSweetalert2);

app.use(routes)

app.use(Toaster, {
    position: 'top-right',
    dismissible: true,
    duration: 3000,
});

app.use(mainStore);

app.use(globalPlugin);

app.mount('#landing')
