import {
    createRouter,
    createWebHistory
} from 'vue-router'

import Index from "@/views/landing/Index.vue"

import Maintenance from "@/views/Maintenance.vue";

import TentangKami from "@/views/landing/tentang/tentangkami/Index.vue";
import UserGuide from "@/views/landing/tentang/userguide/Index.vue";
import PanduanVideo from "@/views/landing/tentang/panduanvideo/Index.vue";

import Kontak from "@/views/landing/kontak/Index.vue";

import Konsultasi from "@/views/landing/konsultasi/Index.vue";

import Pengaduan from "@/views/landing/layanan/pengaduan/Index.vue";
import CekPengaduan from "@/views/landing/layanan/cekpengaduan/Index.vue";
import PuspagaKota from "@/views/landing/layanan/puspagakota/Index.vue";
import PuspagaRW from "@/views/landing/layanan/puspagarw/Index.vue";
import UPTDPPA from "@/views/landing/layanan/uptdppa/Index.vue";
import KelasCatin from "@/views/landing/layanan/kelascatin/Index.vue";

import Mitra from "@/views/landing/mitra/Index.vue";

import Kie from "@/views/landing/kie/Index.vue";
import ArtikelPPA from "@/views/landing/artikel/Index.vue";
import BacaArtikel from "@/views/landing/artikel/ArtikelDetail.vue"

import Instagram from "@/views/landing/puspagatv/instagram/Index.vue";
import Youtube from "@/views/landing/puspagatv/youtube/Index.vue";

import MahasiswaMSIB from "@/views/landing/datapublik/mahasiswamsib/Index.vue";

import NotFound from "@/views/errors/404.vue";
import ForbiddenAccess from "@/views/errors/403.vue";

const routesWithPrefix = (prefix, routes) => {
    return routes.map(route => {
        route.path = `${prefix}${route.path}`

        return route
    })
}

var routes = [
    {
        path: '/',
        name: 'index',
        component: Index,
        meta: {
            guest: true,
        },
    },
    // {
    //     path: '/',
    //     name: 'index',
    //     component: Maintenance,
    //     meta: {
    //         guest: true,
    //     },
    // },
    // {
    //     path: "/maintenis",
    //     name: "maintenis",
    //     component: Maintenance,
    //     meta: {
    //         guest: true,
    //     },
    // },
    ...routesWithPrefix('/tentang', [
        {
            path: '/tentangkami',
            name: 'tentang-tentangkami',
            component: TentangKami,
            meta: {
                guest: true,
            },
        },
        {
            path: '/userguide',
            name: 'tentang-userguide',
            component: UserGuide,
            meta: {
                guest: true,
            },
        },
        {
            path: '/panduanvideo',
            name: 'tentang-panduanvideo',
            component: PanduanVideo,
            meta: {
                guest: true,
            },
        },
    ]),
    ...routesWithPrefix('/konsultasi', [
        {
            path: '/',
            name: 'konsultasi',
            component: Konsultasi,
            meta: {
                guest: true,
            },
        },
    ]),
    ...routesWithPrefix('/layanan', [
        {
            path: '/pengaduan',
            name: 'layanan-pengaduan',
            component: Pengaduan,
            meta: {
                guest: true,
            },
        },
        {
            path: '/cekpengaduan',
            name: 'layanan-cekpengaduan',
            component: CekPengaduan,
            meta: {
                guest: true,
            },
        },
        {
            path: '/puspagakota',
            name: 'layanan-puspagakota',
            component: PuspagaKota,
            meta: {
                guest: true,
            },
        },
        {
            path: '/puspagarw',
            name: 'layanan-puspagarw',
            component: PuspagaRW,
            meta: {
                guest: true,
            },
        },
        {
            path: '/uptdppa',
            name: 'layanan-uptdppa',
            component: UPTDPPA,
            meta: {
                guest: true,
            },
        },
        {
            path: '/kelascatin',
            name: 'layanan-kelascatin',
            component: KelasCatin,
            meta: {
                guest: true,
            },
        },
    ]),
    ...routesWithPrefix('/mitra', [
        {
            path: '/:slug',
            name: 'mitra',
            component: Mitra,
            meta: {
                guest: true,
            },
        },
    ]),
    ...routesWithPrefix('/puspagatv', [
        {
            path: '/instagram',
            name: 'puspagatv-instagram',
            component: Instagram,
            meta: {
                guest: true,
            },
        },
        {
            path: '/youtube',
            name: 'puspagatv-youtube',
            component: Youtube,
            meta: {
                guest: true,
            },
        },
    ]),
    {
        path: '/kontak-kami',
        name: 'kontak-kami',
        component: Kontak,
        meta: {
            guest: true,
        },
    },
    {
        path: '/kie',
        name: 'kie',
        component: Kie,
        meta: {
            guest: true,
        },
    },
    {
        path: '/artikel',
        name: 'artikel',
        component: ArtikelPPA,
        meta: {
            guest: true,
        },
    },
    {
        path: '/artikel/:id',
        name: 'artikel-detail',
        component: BacaArtikel,
        meta: {
            guest: true,
        },

    },
    ...routesWithPrefix('/datapublik', [
        {
            path: '/mahasiswamsib',
            name: 'datapublik-mahasiswamsib',
            component: MahasiswaMSIB,
            meta: {
                guest: true,
            },
        },
    ]),
    {
        path: "/404",
        component: NotFound
    },
    {
        path: "/403",
        component: ForbiddenAccess,
        meta: {
            auth: true,
        }
    },
    {
        path: '/:pathMatch(.*)*',
        redirect: "/404"
    }
    // {
    //     path: "/404",
    //     component: Maintenance
    // },
    // {
    //     path: "/403",
    //     component: Maintenance,
    //     meta: {
    //         auth: true,
    //     }
    // },
    // {
    //     path: '/:pathMatch(.*)*',
    //     redirect: "/404"
    // }

]

// routes = routesWithPrefix('/new', routes);

const router = createRouter({
    history: createWebHistory(process.env.MIX_SUBPATH_DOMAIN),
    routes,
    scrollBehavior(to, from, savedPosition) {
        return {
            top: 0
        }
    }
});

export default router
