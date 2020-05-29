<template>
    <div class="container">
        <div class="row justify-content-center">
            <section class="content">
                <div class="card-columns mt-5">
                    <div class="card small-box km-card" v-for="(i, key) in this.kram.data" :key="key">
                        <div class="inner">
                            <br>
                            <h4>{{ i.description }}</h4>
                            <br>
                            <br>
                        </div>
                        <div class="icon">
                            <i :class="i.icon"></i>
                        </div>
                        <router-link v-if="kram.breadcrumbs.length" :to="`${kram.breadcrumbs[kram.breadcrumbs.length - 1].path}/${i.description}`" class="small-box-footer">
                            More Information <i class="fa fa-arrow-circle-right"></i>
                        </router-link>
                    </div>
                </div>
            </section>
        </div>
    </div>
</template>

<script>
export default {
    name: 'MainMenu', 
    data() {
        return {
            kram: {},
        };
    },
    methods: {
        loadData() {
            if (this.$gate.isAdminOrAuthor()) {
                axios.get(this.$route.fullPath)
                    .then(({ data }) => {
                        this.kram = {};
                        this.kram = data;
                        this.$store.commit('setRoute', {route: this.kram.breadcrumbs});
                    }
                );
            }
        },
    },
    mounted() {
        this.loadData();
        Fire.$on("LoadData", () => {
            this.loadData();
        });
    },
    watch: {
        '$route' () {
            this.loadData();
        },
        immediate: true,
    },
}
</script>

<style>
    .km-card, .callout.callout-info, .alert-info, .label-info, .modal-info .modal-body {
        background-color: #7a9cb7 !important;
    }
</style>

