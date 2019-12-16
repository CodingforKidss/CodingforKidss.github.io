<template>
    <div>
        <main>
            <router-view></router-view>
        </main>
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
    export default {
        created() {
            console.log('created: LayoutLogin: ');
        },
    };
</script>
