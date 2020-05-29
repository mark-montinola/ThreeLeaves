<template>
    <BaseForm v-if="Object.keys(tables).length > 0" v-bind:formPresentationStyle="properties['presentation_style']">
        <form slot="slot-base-form" @submit.prevent="$route.params.method == 'edit' ? formUpdate() : formCreate()">
            <template v-if="properties['presentation_style'] == 'Tab'">
                <b-tabs card>
                    <b-tab :title="i.description.replace(/_/g,' ') | titlecase" v-for="(i, table) in tables" :key="table">
                        <BaseDatacardFreeForm v-if="i.presentationStyle === 'Freeform'" 
                            v-bind:fields="fields[table]"
                            v-bind:form="form"
                            v-bind:table="table"
                            v-bind:currentRow="0"
                        />
                        <BaseDatacardTabular v-if="i.presentationStyle === 'Tabular'" 
                            v-bind:fields="fields[table]"
                            v-bind:form="form"
                            v-bind:table="table"
                            v-bind:title="i.description"
                            v-bind:parentId="id"
                        />
                    </b-tab>
                </b-tabs>
                <div class="card-footer">
                    <button v-if="($gate.isAdminOrAuthor() || users_access.permission.Edit === 'Y') && $route.params.method == 'edit'" type="submit" class="btn btn-success float-right">Update</button>
                    <button v-if="($gate.isAdminOrAuthor() || users_access.permission.Add === 'Y') && $route.params.method == 'create'" type="submit" class="btn btn-primary float-right">Create</button>
                </div>
            </template>

            <template v-if="properties['presentation_style'] == 'Card'">
                <div class="card" v-for="(i, table, ctr) in tables" :key="table">
                    <div class="card-header"> {{ i.description.replace(/_/g,' ') | titlecase }} </div>
                    <div class="card-body">
                        <BaseDatacardFreeForm v-if="i.presentationStyle === 'Freeform'" 
                            v-bind:fields="fields[table]"
                            v-bind:form="form"
                            v-bind:table="table"
                            v-bind:currentRow="0"
                        />
                        <BaseDatacardTabular v-if="i.presentationStyle === 'Tabular'" 
                            v-bind:fields="fields[table]"
                            v-bind:form="form"
                            v-bind:table="table"
                            v-bind:title="i.description"
                            v-bind:parentId="id"
                        />
                    </div>
                    <div class="card-footer" v-if="ctr == Object.keys(tables).length - 1">
                        <button v-if="($gate.isAdminOrAuthor() || users_access.permission.Edit === 'Y') && $route.params.method == 'edit'" type="submit" class="btn btn-success float-right">Update</button>
                        <button v-if="($gate.isAdminOrAuthor() || users_access.permission.Add === 'Y') && $route.params.method == 'create'" type="submit" class="btn btn-primary float-right">Create</button>
                    </div>
                </div>
            </template>
        </form>
    </BaseForm>
</template>

<script>
import BaseForm from './BaseForm.vue';
import BaseDatacardFreeForm from './BaseDatacardFreeForm.vue';
import BaseDatacardTabular from './BaseDatacardTabular.vue';
export default {
    name: 'Form',
    components: {BaseForm, BaseDatacardFreeForm, BaseDatacardTabular},
    data() {
        return {
            mainProps: { blankColor: '#777', width: 200, height: 200, class: 'm1' },
            photoSource: null,
            form_name: '',
            editmode: false,
            properties: {},
            tables: {},
            fields: {},
            items: {},
            id: null,
            form: new Form({
            }),
            // Custom
            list: {},
            users_access: {},
        };
    },
    methods: {
        formReset() {
            for (let i = 0; i < this.form.keys().length; i++) {
                this.form[this.form.keys()[i]] = JSON.parse(JSON.stringify(this.form.originalData[this.form.keys()[i]]));
            }
        },
        formUpdate() {
            this.$Progress.start();
            this.form
                .put(this.$route.fullPath)
                .then((data) => {
                    // console.log(data);
                    $("#kram-rm-modal").modal("hide");
                    swal("Updated!", "Information has been updated.", "success");
                    this.$Progress.finish();
                    Fire.$emit("LoadData");
                    this.formUpdateStatus();
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
            // console.log(0);
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
                    this.formReset();
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
                axios.get(this.$route.fullPath)
                    .then(({ data }) => {
                        // console.log(data);
                        this.properties = data.properties;
                        this.tables = data.tables;
                        this.fields = data.fields;
                        this.items = data.items;
                        this.id = data.id;
                        this.$store.commit('setRoute', {route: data.breadcrumbs});
                        // Custom
                        this.list = data.list;
                        this.users_access = data.users_access;
                        this.form.reset();
                        // console.log(this.items);
                        if (Object.keys(this.items).length > 0) {
                            Object.keys(this.items).forEach(element => {
                                Vue.set(this.form, element, this.items[element]);
                            });
                        }
                        //Copy to original data to be use in form reset
                        for (let i = 0; i < this.form.keys().length; i++) {
                            this.form.originalData[this.form.keys()[i]] = JSON.parse(JSON.stringify(this.form[this.form.keys()[i]]));
                        }
                    }
                );
            }
        },
        formUpdateStatus() {
            Object.keys(this.form).forEach(e => {
                for (let i = 0; i < this.form[e].length; i++) {
                    let status = this.form[e][i]['status'];
                    if (status == 'Deleted!') {
                        this.form[e].splice(i, 1);
                        i--;
                    } else if (status !== 'NotModified!') {
                        this.form[e][i]['status'] = 'NotModified!';
                    }
                }
            })
        }
    },
    mounted() {
        this.loadData();
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