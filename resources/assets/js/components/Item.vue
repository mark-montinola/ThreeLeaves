<template>
    <BaseForm>
        <form slot="slot-base-form" @submit.prevent="$route.params.method == 'edit' ? formUpdate() : formCreate()">
            <b-tabs card>
                <b-tab title="General" active>
                    <!-- Datacard -->
                    <BaseDatacardFreeForm :fields="fields" :items="items" :form="form"/>
                </b-tab>
            </b-tabs>
            <!-- Footer -->
            <div class="card-footer">
                <button v-if="($gate.isAdminOrAuthor() || users_access.permission.Edit === 'Y') && $route.params.method == 'edit'" type="submit" class="btn btn-success float-right">Update</button>
                <button v-if="($gate.isAdminOrAuthor() || users_access.permission.Add === 'Y') && $route.params.method == 'create'" type="submit" class="btn btn-primary float-right">Create</button>
            </div>
        </form>
    </BaseForm>
</template>

<script>
import BaseForm from './BaseForm.vue';
import BaseDatacardFreeForm from './BaseDatacardFreeForm.vue';
export default {
    name: 'FormMaintFreeForm',
    components: {BaseForm, BaseDatacardFreeForm},
    data() {
        return {
            mainProps: { blankColor: '#777', width: 200, height: 200, class: 'm1' },
            photoSource: null,
            form_name: '',
            editmode: false,
            fields: {},
            items: {},
            form: new Form({
            }),
            // Custom
            list: {},
            users_access: {},
        };
    },
    methods: {
        formUpdate() {
            this.$Progress.start();
            this.form
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
        loadData() {
            if (this.$gate.isAdminOrAuthor()) {
                // console.log(this.$route.fullPath);
                axios.get(this.$route.fullPath)
                    .then(({ data }) => {
                        console.log(data);
                        // this.fields = data.fields;
                        // this.items = data.items;
                        // this.$store.commit('setRoute', {route: data.breadcrumbs});
                        // // Custom
                        // this.list = data.list;
                        // this.users_access = data.users_access;
                        // if (data.items[0]) {
                        //     Object.keys(data.items[0]).forEach(element => {
                        //         Vue.set(this.form, element, '');
                        //         if (this.$route.params.method === 'edit') {
                        //             this.form.reset();
                        //             this.form.fill(data.items[0]);
                        //         }
                        //     });
                        // }
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
        '$route' (to, from) {
            this.loadData();
        },
        immediate: true,
    },
}
</script>

<style slot-scope>
    .container {
        max-width: 100%;
    }
</style>