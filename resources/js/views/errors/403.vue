<template>
    <div class="d-flex flex-column flex-root">
        <!--begin::Authentication - 404 Page-->
        <div class="d-flex flex-column flex-center mt-10 flex-column-fluid p-10">                    
            <!--begin::Message-->
            <h1 class="fw-bold mb-10" style="color: #A3A3C7">You Don't Have Access To The Page</h1>
            <!--end::Message-->
            <!--begin::Link-->           
            <router-link v-if="$store.state.profile.role_id == ROLE_ADMIN_ID" to="/" class="btn btn-primary">Return Home Page</router-link>
            <router-link v-if="$store.state.profile.role_id == ROLE_KABID_ID" to="/" class="btn btn-primary">Return Home Page</router-link>
            <router-link v-if="$store.state.profile.role_id == ROLE_KADIS_ID" to="/pengaduan" class="btn btn-primary">Return Pengaduan Page</router-link>
            <router-link v-if="$store.state.profile.role_id == ROLE_KONSELOR_ID" to="/" class="btn btn-primary">Return Home Page</router-link>
            <router-link v-if="$store.state.profile.role_id == ROLE_SUBKORD_ID" to="/" class="btn btn-primary">Return Home Page</router-link>
            <router-link v-if="$store.state.profile.role_id == ROLE_OPD_ID" to="/pengaduan" class="btn btn-primary">Return Pengaduan Page</router-link>
            <router-link v-if="$store.state.profile.role_id == ROLE_HOTLINE_ID" to="/cek-pengaduan" class="btn btn-primary">Return Cek Pengaduan Page</router-link>
            <router-link v-if="$store.state.profile.role_id == ROLE_KECAMATAN_ID" to="/puspaga" class="btn btn-primary">Return  Database Puspaga RW Page</router-link>
            <router-link v-if="$store.state.profile.role_id == ROLE_KELURAHAN_ID" to="/satgas-ppa" class="btn btn-primary">Return  Database Satgas PPA Page</router-link>            
            <router-link v-if="$store.state.profile.role_id == ROLE_ASISTEN_ID" to="/" class="btn btn-primary">Return  Home Page</router-link>            
            <!--end::Link-->
        </div>
        <!--end::Authentication - 404 Page-->
    </div>
</template>

<script>
    export default {
        data() {
            return {             
                ROLE_ADMIN_ID: process.env.MIX_ROLE_ADMIN_ID,
                ROLE_KABID_ID: process.env.MIX_ROLE_KABID_ID,
                ROLE_KADIS_ID: process.env.MIX_ROLE_KADIS_ID,
                ROLE_KONSELOR_ID: process.env.MIX_ROLE_KONSELOR_ID,
                ROLE_SUBKORD_ID: process.env.MIX_ROLE_SUBKORD_ID,
                ROLE_OPD_ID: process.env.MIX_ROLE_OPD_ID,
                ROLE_HOTLINE_ID: process.env.MIX_ROLE_HOTLINE_ID,
                ROLE_ASISTEN_ID: process.env.MIX_ROLE_ASISTEN_ID,
                ROLE_KECAMATAN_ID: process.env.MIX_ROLE_KECAMATAN_ID,
                ROLE_KELURAHAN_ID: process.env.MIX_ROLE_KELURAHAN_ID,
                ROLE_ASISTEN_ID: process.env.MIX_ROLE_ASISTEN_ID,
            }

        },
    }

</script>
