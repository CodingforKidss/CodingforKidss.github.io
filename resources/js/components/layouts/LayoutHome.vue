<template>
    <div>
        <!--        <Sidebar></Sidebar>-->
        <!--        <div class = "main-panel">-->
        <!--            <nav class = "navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">-->
        <!--                <Headers></Headers>-->
        <!--            </nav>-->
        <!--            <div class = "content">-->
        <!--                <main>-->
        <router-view></router-view>
        <!--                </main>-->
        <!--            </div>-->
        <!--            <footer class = "footer">-->
        <!--                <Footer></Footer>-->
        <!--            </footer>-->
        <!--        </div>-->
        <modals-container/>
        <v-dialog/>
        <tooltip/>
        <notifications animation-type = "velocity" classes = "vue-notification-info" group = "info" position = "top center"/>
        <notifications animation-type = "velocity" group = "saved" position = "top right"/>
        <notifications animation-type = "velocity" group = "edited" position = "bottom right"/>
        <notifications animation-type = "velocity" group = "deleted" position = "bottom left"/>
    </div>
</template>
<script>
    import Headers from '../../components/partials/Headers'
    import Footer from '../../components/partials/Footer'

    export default {
        components: {
            Headers,
            Footer,
        },
        created() {
            console.log('created: LayoutHome: ');
        },
    };
</script>
