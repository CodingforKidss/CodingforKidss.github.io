<template>
    <div class = "sidebar" data-active-color = "danger" data-color = "white">
        <!--Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"-->
        <div class = "logo">
            <router-link :to = "{ name: 'dashboard' }" class = "simple-text logo-mini">
                <!--<div class = "logo-image-small">
                    <img onerror = "src='/img/avatar.png'" src = "/img/logo.png">
                </div>-->
            </router-link>
            <router-link :to = "{ name: 'dashboard' }" class = "simple-text logo-normal">
                {{user && user['name'] ? ('Welcome ' + user['name']) : 'Dashboard'}}
                <!-- <div class="logo-image-big">
                  <img src="../assets/img/logo-big.png">
                </div> -->
            </router-link>
        </div>
        <div class = "sidebar-wrapper">
            <ul class = "nav">
                <li :class = "{ 'active': $route.name == 'dashboard' }"
                        v-if = "user && user['role'] && user['role']['name'] && (user['role']['name'] === 'Admin' || user['role']['name'] === 'Parent')">
                    <router-link :to = "{ name: 'dashboard' }" class = "">
                        <i class = "nc-icon nc-layout-11"></i>
                        <p>Dashboard</p>
                    </router-link>
                </li>
                <li :class = "{ 'active': $route.name == 'dashboard.courses' }" v-if = "user && user['role'] && user['role']['name'] && (user['role']['name'] === 'Admin')">
                    <router-link :to = "{ name: 'dashboard.courses' }" class = "">
                        <i class = "nc-icon nc-single-copy-04"></i>
                        <p>Courses</p>
                    </router-link>
                </li>
                <li :class = "{ 'active': $route.name == 'dashboard.enrolments' }" v-if = "user && user['role'] && user['role']['name'] && user['role']['name'] === 'Admin'">
                    <router-link :to = "{ name: 'dashboard.enrolments' }" class = "">
                        <i class = "nc-icon nc-single-copy-04"></i>
                        <p>Enrolments</p>
                    </router-link>
                </li>
                <li :class = "{ 'active': $route.name == 'dashboard.students' || $route.name == 'dashboard.student.id' }"
                        v-if = "user && user['role'] && user['role']['name'] && (user['role']['name'] === 'Admin')">
                    <router-link :to = "{ name: 'dashboard.students' }" class = "">
                        <i class = "nc-icon nc-badge"></i>
                        <p>Students</p>
                    </router-link>
                </li>
                <li :class = "{ 'active': $route.name == 'dashboard.parents' || $route.name == 'dashboard.parent.id' }"
                        v-if = "user && user['role'] && user['role']['name'] && (user['role']['name'] === 'Admin')">
                    <router-link :to = "{ name: 'dashboard.parents' }" class = "">
                        <i class = "nc-icon nc-badge"></i>
                        <p>Parents</p>
                    </router-link>
                </li>
                <li :class = "{ 'active': $route.name == 'dashboard.users' }"
                        v-if = "user && user['role'] && user['role']['name'] && (user['role']['name'] === 'Admin' || user['role']['name'] === 'HR')">
                    <router-link :to = "{ name: 'dashboard.users' }" class = "">
                        <i class = "nc-icon nc-circle-10"></i>
                        <p>User Management</p>
                    </router-link>
                </li>
                <li :class = "{ 'active': $route.name == 'dashboard.settings' }"
                        v-if = "user && user['role'] && user['role']['name'] && (user['role']['name'] === 'Admin' || user['role']['name'] === 'Parent')">
                    <router-link :to = "{ name: 'dashboard.settings' }" class = "">
                        <i class = "nc-icon nc-settings-gear-65"></i>
                        <p>Settings</p>
                    </router-link>
                </li>
            </ul>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {}
        },
        created() {
        },
        mounted() {
            console.log('Sidebar Component mounted.');
        },
        computed: {
            user() {
                let data = this.$store.getters.user;
                console.log('computed: user: ', data);
                return data;
            }
        },
    }
</script>
