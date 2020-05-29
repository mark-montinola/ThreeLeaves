<template>
    <b-container fluid>
    <!-- <b-container fluid> -->
        <b-card>
    
            <!-- User Interface controls -->
            <b-row>
                <b-col md="6" class="my-1">
                    <b-form inline>
                        <label class="mr-sm-2" for="show-etries">Show:</label>
                        <b-form-select 
                            class="mb-2 mr-sm-2 mb-sm-0"
                            v-model="perPage" 
                            :options="pageOptions"
                            id="show-etries"
                        ></b-form-select>
                        <label class="mr-sm-2" for="show-etries">Entries</label>
                    </b-form>
                </b-col>
                <b-col md="6" class="my-1">
                    <b-form inline class="float-md-right">
                        <label class="mr-sm-2" for="search">Search:</label>
                        <b-input-group class="mb-2 mb-sm-0">
                            <b-form-input id="search" v-model="filter"></b-form-input>
                            <b-input-group-append>
                                <b-button :disabled="!filter" @click="filter = ''">Clear</b-button>
                            </b-input-group-append>
                        </b-input-group>
                    </b-form>
                </b-col>
            </b-row>

            <b-row>
                <b-col md="12" class="my-1">
                    <!-- <router-link 
                        v-if="$gate.isAdminOrAuthor() || users_access.permission.Add === 'Y'"
                        :to="{ name: route_vue.add || 'form_add', params: { module_name: $route.params.module_name, category_name: $route.params.category_name, form_name: $route.params.form_name, method: 'create' }}" 
                        class="btn btn-primary float-right mb-2"
                    >
                        Create Record
                    </router-link> -->
                    <router-link 
                        v-if="$gate.isAdminOrAuthor() || users_access.permission.Add === 'Y'"
                        :to="{ name: 'form_add', params: { module_name: $route.params.module_name, category_name: $route.params.category_name, form_name: $route.params.form_name, method: 'create' }}" 
                        class="btn btn-primary float-right mb-2"
                    >
                        Create Record
                    </router-link>
                </b-col>
            </b-row>

            <!-- Main table element -->
            <div class="table-responsive">
                <b-table   
                    show-empty
                    stacked="md"
                    :items="items"
                    :fields="fields"
                    :bordered="bordered"
                    :borderless="borderless"
                    :fixed="fixed"
                    :striped="striped"
                    :hover="hover"
                    :foot-clone="footClone"
                    :current-page="currentPage"
                    :per-page="perPage"
                    :filter="filter"
                    :sort-by.sync="sortBy"
                    :sort-desc.sync="sortDesc"
                    :sort-direction="sortDirection"
                    :busy="isBusy"
                    @filtered="onFiltered"
                >
                    <template slot="photo" slot-scope="row">
                        <div class="row">
                            <b-img :src="'img/items/' + row.item.photo" style="display:block;" width="120px" max-width="120px" min-width="120px" height="auto" center alt=""></b-img>
                        </div>
                    </template>

                    <template slot="actions" slot-scope="row">
                        <div class="row">
                            <a class="btn col-12 col-xl-4" v-if="$gate.isAdminOrAuthor() || users_access.permission.Delete === 'Y'" @click="row.toggleDetails">
                                <i :class="row.detailsShowing ? 'fas fa-search-minus red' : 'fas fa-search-plus green'"></i>
                            </a>
                            <!-- <router-link 
                                :to="{ name: route_vue.edit || 'form_edit', params: { module_name: $route.params.module_name, category_name: $route.params.category_name, form_name: $route.params.form_name, method: 'edit', id: row.item.id, data: row.item }}" 
                                class="btn col-12 col-xl-4"
                            >
                                <i class="fa fa-edit blue"></i>
                            </router-link> -->
                            <router-link 
                                :to="{ name: 'form_edit', params: { module_name: $route.params.module_name, category_name: $route.params.category_name, form_name: $route.params.form_name, method: 'edit', id: row.item.id, data: row.item }}" 
                                class="btn col-12 col-xl-4"
                            >
                                <i class="fa fa-edit blue"></i>
                            </router-link>
                            <a class="btn col-12 col-xl-4" v-if="$gate.isAdminOrAuthor() || users_access.permission.Delete === 'Y'" @click="modalDelete(row.item.id)">
                                <i class="fa fa-trash red"></i>
                            </a>
                        </div>
                    </template>

                    <template slot="row-details" slot-scope="row">
                        <b-card>
                            <tr>
                                <th>Column Name</th>
                                <th>Column Value</th>
                            </tr>
                            <tr class="col-md-6 form-group" v-for="(value, key, ctr) in row.item" :key="key">
                                <th v-if="fields[ctr].label">{{ fields[ctr].label }}</th>
                                <th v-if="!fields[ctr].label">{{ fields[ctr].key.replace("_"," ") | titlecase }}</th>
                                <td>{{ value }}</td>
                            </tr>
                        </b-card>
                    </template>

                    <div slot="table-busy" class="text-center text-danger my-2">
                        <b-spinner class="align-middle"></b-spinner>
                        <strong>Loading...</strong>
                    </div>
                </b-table>
            </div>
            
            <b-row>
                <b-col md="6" class="my-1">
                    <b-pagination
                        v-model="currentPage"
                        :total-rows="totalRows"
                        :per-page="perPage"
                        class="my-0"
                    ></b-pagination>
                </b-col>
                <b-col md="6" class="my-1 text-right" v-if="sortBy">
                    Sorting By: <b>{{ getKeyValue(fields, sortBy, 'key').replace("_"," ") | titlecase }}</b>, Sort Direction: <b>{{ sortDesc ? 'Descending' : 'Ascending' }}</b>
                </b-col>
            </b-row>

            <!-- Info modal -->
            
        </b-card>
        <b-modal :id="infoModal.id" :title="infoModal.title" ok-only @hide="resetInfoModal">
            <pre>{{ infoModal.content }}</pre>
        </b-modal>
    </b-container>
</template>

<script>
    export default {
        name: 'FormManager',
        data() {
            return {
                form_name: '',
                route_vue: {},
                fields: {},
                items: [],
                bordered: true,
                borderless: false,
                fixed: false,
                striped: true,
                hover: true,
                footClone: false,
                currentPage: 1,
                perPage: 5,
                isBusy: false,
                totalRows: 1,
                pageOptions: [5, 10, 15],
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',
                filter: null,
                infoModal: {
                    id: 'info-modal',
                    title: '',
                    content: ''
                },
                form: new Form({
                }),
                // Custom
                list: {},
                users_access: {}
            }
        },
        computed: {
            sortOptions() {
                // Create an options list from our fields
                return this.fields
                .filter(f => f.sortable)
                .map(f => {
                    return { text: f.label, value: f.key }
                })
            }
        },
        methods: {
            // info(item, index, button) {
            //     this.infoModal.title = `Row index: ${index}`
            //     this.infoModal.content = JSON.stringify(item, null, 2)
            //     this.$root.$emit('bv::show::modal', this.infoModal.id, button)
            // },
            resetInfoModal() {
                this.infoModal.title = ''
                this.infoModal.content = ''
            },
            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length
                this.currentPage = 1
            },
            getKeyValue(obj, key, value) {
                for(let i = 0; i < obj.length; i++) {
                    if (obj[i]['key'] == key) {
                        return obj[i][value];
                    }
                }
                return null;
            },
            modalDelete(id) {
                swal({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then(result => {
                    // Send request to the server
                    if (result.value) {
                        this.form
                        .delete(this.$route.fullPath + "/delete/" + id)
                        .then((data) => {
                            // console.log(data);
                            swal("Deleted!", "Your file has been deleted.", "success");
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
                        });
                    }
                });
            },
            loadData() {
                if (this.$gate.isAdminOrAuthor()) {
                    this.form_name = this.$route.params.form_name;
                    this.isBusy = true;
                    axios.get(this.$route.fullPath)
                        .then(({ data }) => {
                            // console.log(data);
                            this.$store.commit('setRoute', {route: data.breadcrumbs});
                            this.route_vue = data.route_vue;
                            this.fields = data.fields;
                            this.fields.push({key: 'actions', class: 'text-center'});
                            this.items = data.items;
                            this.isBusy = false;
                            this.totalRows = data.items.length;
                            // Custom
                            this.list = data.list;
                            this.users_access = data.users_access;
                        }
                    );
                }
            },
        },
        mounted() {
            // Set the initial number of items
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

<style>
    /* Busy table styling */
    table.b-table[aria-busy='true'] {
        opacity: 0.6;
    }
    .box {
        background-color: white !important;
        padding: 50px !important;
    }
</style>
