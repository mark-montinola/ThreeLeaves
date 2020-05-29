<template>
    <section class="content-header mb-4" v-if="$store.state.breadcrumbs">
        <h1 v-if="$store.state.breadcrumbs.length">
            {{ $store.state.breadcrumbs[$store.state.breadcrumbs.length - 1].display }}
        </h1>
        <nav class="breadcrumb" v-if="$store.state.breadcrumbs">
            <router-link class="breadcrumb-item" v-for="(crumb, key) in $store.state.breadcrumbs" :to="crumb.path" :key="key">
                {{ crumb.name }}
            </router-link>
        </nav>
    </section>
</template>

<script>
export default {
    name: 'ContentHeader',
}
</script>

<style>
    .content-header {
        position: relative;
        padding: 15px 15px 0 15px;
    }
    
    .content-header>.breadcrumb>li+li:before {
        content: '/\00a0';
    }

    .breadcrumb>li+li:before {
        padding: 0 5px;
        color: #97a0b3;
        content: "/\00a0";
    }

    :after, :before {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }

    .content-header>.breadcrumb>li>a {
        color: #444;
        text-decoration: none;
        display: inline-block;
    }

    .breadcrumb-item {
        color: #777;
    }

    .content-header>.breadcrumb {
        position: relative;
        margin-top: 5px;
        top: 0;
        right: 0;
        float: none;
        background: #d2d6de;
        padding-left: 10px;
    }
    
</style>
