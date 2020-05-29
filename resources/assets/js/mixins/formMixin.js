export const formMixin = {
    data() {
        return {
            fields: {},
            items: {},
            form: new Form({}),
            // Custom
            users_access: {},
        }
    },
    methods: {
        loadData() {
            if (this.$gate.isAdminOrAuthor()) {
                axios.get(this.$route.fullPath)
                    .then(({ data }) => {
                        // console.log(data);
                        console.log('load data');
                        this.fields = data.fields;
                        this.items = data.items;
                        this.$store.commit('setRoute', {route: data.breadcrumbs});
                        this.users_access = data.users_access;
                        if (data.items[0]) {
                            Object.keys(data.items[0]).forEach(element => {
                                Vue.set(this.form, element, '');
                                if (this.$route.params.method === 'edit') {
                                    this.form.reset();
                                    this.form.fill(data.items[0]);
                                }
                            });
                        }
                    }
                );
            }
        },
        formCreate() {
            this.$Progress.start();
            this.form
                .post(this.$route.fullPath)
                .then(data => {
                    // console.log(data);
                    Fire.$emit("LoadData");
                    $("#kram-rm-modal").modal("hide");
                    toast({
                        type: "success",
                        title: "Added Successfully"
                    });
                    this.$Progress.finish();
                    this.form.reset();
                }, (error) => {
                    if (error.response) {
                        /**
                         * The request was made and the server responded with a status code that falls out of the range of 2xx
                         * console.log(error.response.data);
                         * console.log(error.response.status);
                         * console.log(error.response.headers);
                         */
                        swal("Status: " + error.response.status, error.response.data.message, "error");
                    } else if (error.request) {
                        /**
                         * The request was made but no response was received
                         * `error.request` is an instance of XMLHttpRequest in the browser and an instance of
                         * http.ClientRequest in node.js
                         */
                        swal("Error!", error.request, "error");
                    } else {
                        // Something happened in setting up the request that triggered an Error
                        swal("Error!", error.message, "error");
                    }
                    this.$Progress.fail();
                }
            );
        }, 
        formEdit() {
            this.$Progress.start();
            // console.log(this.form);
            this.form
                // .put(`form/${this.$route.params.form_name}`)
                .put(this.$route.fullPath)
                .then((data) => {
                    console.log(data);
                    $("#kram-rm-modal").modal("hide");
                    swal("Updated!", "Information has been updated.", "success");
                    this.$Progress.finish();
                    Fire.$emit("LoadData");
                }, (error) => {
                    if (error.response) {
                        /**
                         * The request was made and the server responded with a status code that falls out of the range of 2xx
                         * console.log(error.response.data);
                         * console.log(error.response.status);
                         * console.log(error.response.headers);
                         */
                        swal("Status: " + error.response.status, error.response.data.message, "error");
                    } else if (error.request) {
                        /**
                         * The request was made but no response was received
                         * `error.request` is an instance of XMLHttpRequest in the browser and an instance of
                         * http.ClientRequest in node.js
                         */
                        swal("Error!", error.request, "error");
                    } else {
                        // Something happened in setting up the request that triggered an Error
                        swal("Error!", error.message, "error");
                    }
                    this.$Progress.fail();
                }
            );
        },
        resetErrors() {
            this.form.errors.errors = {};
        },
    },
    mounted() {
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
}