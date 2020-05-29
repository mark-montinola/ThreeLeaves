<template>
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
            with font-awesome or any other icon font library -->

            <li class="nav-item">
                <router-link to="/dashboard" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </router-link>
            </li>

            <li class="nav-item">
                <router-link :to="{ name: 'module', params: { menu_name: 'Module', name: 'Module' }}" class="nav-link">
                    <i class="nav-icon fas fa-th"></i>
                    <p>Module</p>
                </router-link>
            </li>

            <li class="nav-item">
                <router-link to="/profile" class="nav-link">
                    <i class="nav-icon fas fa-user"></i>
                    <p>Profile</p>
                </router-link>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link" @click.prevent="logout">
                    <i class="nav-icon fas fa-sign-out-alt"></i>
                    <p>Logout</p>
                </a>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    name: 'SidebarMenu', 
    data() {
        return {
            display: 'block',
            is_mounted: false,
            is_expand: false,
            sidebar_menu: {}
        };
    },
    methods: {
        loadData() {
            if (this.$gate.isAdminOrAuthor()) {
                this.module_name = this.$route.params.module_name;
                // This will expand the menu list
                if (this.is_mounted == true && this.module_name != null) {
                    this.is_expand = true;
                    this.is_mounted = false;
                } else {
                    this.is_expand = false;
                    this.is_mounted = false;
                }
                axios.get('sidebar', {params: {module_name: this.module_name}})
                    .then(({ data }) => {
                        // console.log(data);
                        this.sidebar_menu = data;
                    }
                );
            }
        },
        logout() {
            axios.post('/logout').then(response => {
                document.location.href = "/";
            }).catch(error => {
                location.reload();
            });
        }
    },
    mounted() {
        this.is_mounted = true;
        this.loadData();
        Fire.$on("LoadData", () => {
            this.loadData();
        });
    },
    watch: {
        '$route' (to, from) {
            this.loadData();
        },
        immediate: true,
    },
};
</script>
