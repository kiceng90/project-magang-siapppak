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
                                    <component v-bind:is="componentIndexRole" />
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
    import AdminIndex from '@/views/dashboard/pengaduan/admin/Index.vue'
    import HotlineIndex from '@/views/dashboard/pengaduan/hotline/Index.vue'
    import SubkordIndex from '@/views/dashboard/pengaduan/subkord/Index.vue'
    import KabidIndex from '@/views/dashboard/pengaduan/kabid/Index.vue'
    import KonselorIndex from '@/views/dashboard/pengaduan/konselor/Index.vue'
    import OpdIndex from '@/views/dashboard/pengaduan/opd/Index.vue'
    import KadisIndex from '@/views/dashboard/pengaduan/kadis/Index.vue'


    export default {
        components: {
            AdminIndex,
            HotlineIndex,
            SubkordIndex,
            KabidIndex,
            KonselorIndex,
            OpdIndex,
            KadisIndex
        },
        computed: {
            componentIndexRole() {
                let role = this.$store.state.profile.role_id;

                let response = null;
                if (role == process.env.MIX_ROLE_ADMIN_ID) {
                    response = AdminIndex;
                } else if (role == process.env.MIX_ROLE_HOTLINE_ID) {
                    response = HotlineIndex
                } else if (role == process.env.MIX_ROLE_SUBKORD_ID) {
                    response = SubkordIndex
                } else if (role == process.env.MIX_ROLE_KABID_ID) {
                    response = KabidIndex
                }else if(role == process.env.MIX_ROLE_KONSELOR_ID){
                    response = KonselorIndex;
                }else if(role == process.env.MIX_ROLE_OPD_ID){
                    response = OpdIndex;
                }else if(role == process.env.MIX_ROLE_KADIS_ID){
                    response = KadisIndex;
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
