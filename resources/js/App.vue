<template>
    <component v-bind:is = "layout"></component>
</template>

<script>
    import LayoutLogin from './components/layouts/LayoutLogin'
    import LayoutHome from './components/layouts/LayoutHome'
    import LayoutDashboard from './components/layouts/LayoutDashboard'

    export default {
        computed  : {
            layout() {
                let data = this.$store.getters.layout;
                console.log('computed: layout: ', data);
                return data;
            }
        },
        components: {
            'layout-login'    : LayoutLogin,
            'layout-home'     : LayoutHome,
            'layout-dashboard': LayoutDashboard
            // define as many layouts you want for the application
        }
    }
</script>
