<template>
    <div class = "container-fluid">
        <div class = "row">
            <nav class = "footer-nav">
                <ul>
                    <li>
                        <router-link :to = "{ name: 'dashboard' }" class = "">Dashboard</router-link>
                    </li>
                </ul>
            </nav>
            <div class = "credits ml-auto">
                <span class = "copyright">©2019 CodingforKids, made with&nbsp;&nbsp;<i class = "fa fa-heart heart"></i></span>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['title'],
        mounted() {
            console.log('Footer Component mounted.')
        }
    }
</script>
