<template>
    <div class="container">
        <div class="row justify-content-center">
            <not-found></not-found>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            // this.$route.meta.breadcrumbs = [
            //     {name: 'Dashboard', display: 'Dashboard', path: '/dashboard'}
            // ]
            this.$store.commit('setRoute', {route: [{name: 'Dashboard', display: 'Dashboard', path: '/dashboard'}]});
        }
    }
</script>
