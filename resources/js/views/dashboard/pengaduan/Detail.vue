<template>
    <div>
        <div class="d-flex flex-column flex-root">
            <div class="page d-flex flex-row flex-column-fluid">
                <app-sidebar></app-sidebar>
                <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                    <app-navbar></app-navbar>
                    <!-- isi contentnya ya -->

                    <div id="main-content">
                        <!--begin::Post-->
                        <div class="post d-flex flex-column-fluid" id="kt_post">
                            <!--begin::Container-->
                            <div id="kt_content_container" class="container-xxl">
                                <keep-alive>
                                    <component v-bind:is="componentDetailRole" />
                                </keep-alive>                               
                            </div>
                            <!--end::Container-->
                        </div>

                        <!--end::Post-->
                    </div>

                    <!-- end of content -->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Page-->
        </div>
        <app-scroll-top></app-scroll-top>
    </div>
</template>

<script>
    import AdminDetail from '@/views/dashboard/pengaduan/admin/Detail.vue'
    import HotlineDetail from '@/views/dashboard/pengaduan/hotline/Detail.vue'
    import SubkordDetail from '@/views/dashboard/pengaduan/subkord/Detail.vue'
    import KabidDetail from '@/views/dashboard/pengaduan/kabid/Detail.vue'
    import KonselorDetail from '@/views/dashboard/pengaduan/konselor/Detail.vue'
    import OpdDetail from '@/views/dashboard/pengaduan/opd/Detail.vue'
    import KadisDetail from '@/views/dashboard/pengaduan/kadis/Detail.vue'

    export default {
        components: {
            AdminDetail,
            HotlineDetail,
            SubkordDetail,
            KabidDetail,
            KonselorDetail,
            OpdDetail,
            KadisDetail
        },       
        computed: {
            componentDetailRole() {
                let role = this.$store.state.profile.role_id;

                let response = null;
                if (role == process.env.MIX_ROLE_ADMIN_ID) {
                    response = AdminDetail;
                } else if (role == process.env.MIX_ROLE_HOTLINE_ID) {
                    response = HotlineDetail
                } else if (role == process.env.MIX_ROLE_SUBKORD_ID) {
                    response = SubkordDetail
                } else if (role == process.env.MIX_ROLE_KABID_ID) {
                    response = KabidDetail
                }else if(role == process.env.MIX_ROLE_KONSELOR_ID){
                    response = KonselorDetail;
                }else if(role == process.env.MIX_ROLE_OPD_ID){
                    response = OpdDetail;
                }else if(role == process.env.MIX_ROLE_KADIS_ID){
                    response = KadisDetail;
                }

                return response;
            }
        },
        mounted() {
            reinitializeAllPlugin();
        },      
    }

</script>

<style scoped>

</style>
