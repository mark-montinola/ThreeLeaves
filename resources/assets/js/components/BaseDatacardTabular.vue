<template>
    <div>
        <div class="card-body p-0">
            <b-button variant="primary" class="float-right mr-2 row" @click="modalCreate()">Add Record</b-button>
        </div>
        <div class="card-body row">
            <div class="table-responsive">
                <b-table   
                    show-empty
                    stacked="md"
                    :fields="fieldsNew"
                    :items="formNew"
                >
                    <template slot="actions" slot-scope="row">
                        <div>
                            <!-- <label v-if="formErrorNew.includes(`${table}.${row.index}`)">Error</label> -->
                            <a class="btn col-12 col-xl-4" @click="modalEdit(row.index)">
                                <i class="fa fa-edit blue"></i>
                            </a>
                            <a class="btn col-12 col-xl-4" @click="modalDelete(row.index)">
                                <i class="fa fa-trash red"></i>
                            </a>
                        </div>
                    </template>
                    <div slot="table-busy" class="text-center text-danger my-2">
                        <b-spinner class="align-middle"></b-spinner>
                        <strong>Loading...</strong>
                    </div>
                </b-table>
            </div>
        </div>

        <!-- Modal -->
        <b-modal
            v-model="showModal"
            :title="title.replace(/_/g,' ') | titlecase"
            id="modal-tall modal-xl"
            size="xl" 
        >
            <b-container fluid>
                <b-row>
                    <div class="card-body row">
                        <div class="col-md-12 form-group">
                            <BaseDatacardFreeForm 
                                v-bind:fields="fields" 
                                v-bind:form="formModal" 
                                v-bind:sourceTabular="true"
                                v-bind:modalStatus="modalStatus"
                                v-bind:table="table"
                                v-bind:currentRow="currentRow"
                            />
                        </div>
                    </div>
                </b-row>
            </b-container>
            <div slot="modal-footer">
                <b-button
                    v-if="this.modalStatus == 'EDIT'"
                    variant="primary"
                    class="float-right"
                    @click="showModal=false; modalStatus = '';"
                >
                Close
                </b-button>
                <b-button
                    v-if="this.modalStatus == 'CREATE'"
                    variant="primary"
                    class="float-right"
                    @click="showModal=false; modalStatus = ''; modalAddClose()"
                >
                Add and Close
                </b-button>
                <b-button
                    v-if="this.modalStatus == 'CREATE'"
                    variant="primary"
                    class="float-right mr-2"
                    @click="modalAddReset()"
                >
                Add and Reset
                </b-button>
            </div>
        </b-modal>
    </div>
</template>

<script>
import { datacardMixin } from '../mixins/datacardMixin';
import BaseDatacardFreeForm from './BaseDatacardFreeForm.vue';
export default {
    name: 'BaseDatacardTabular',
    components: {BaseDatacardFreeForm},
    mixins: [datacardMixin],
    props: {
        fields: {},
        form: {},
        table: '',
        title: null,
        parentId: null
    },
    data() {
        return {
            items: {},
            currentRow: 0,
            showModal: false,
            modalStatus: '',
            fieldsModal: {},
            formModal: {}
        }
    },
    mounted() {
        this.items = this.form;
        this.fieldsModal = JSON.parse(JSON.stringify(this.fields));
        Vue.set(this.formModal, this.table, []);
    },
    computed: {
        fieldsNew() {
            let a = JSON.parse(JSON.stringify(this.fields));
            a['actions'] = {key: 'actions', class: 'text-center'};
            return a;
        },
        formNew() {
            let a = this.form[this.table];
            let b = [];
            if (!a) return b;
            for (let i = 0; i < a.length; i++) {
                if (a[i]['status'] !== 'Deleted!') {
                    b[i] = a[i]['data'];
                    // Error
                    if (this.formErrorNew.includes(`${this.table}.${i}`)) {
                        b[i]['_rowVariant'] = 'danger';
                    } else {
                        b[i]['_rowVariant'] = ''; 
                    }
                }
            }
            return b;
        },
        formErrorNew() {
            let a = [];
            let b = null;
            Object.keys(this.form.errors.errors).forEach(e => {
                b = e.substring(0, e.indexOf(".data."));
                if (a.indexOf(b)) a.push(b);
            })
            return a;
        }
    },
    methods: {
        modalEdit(e) {
            this.formModal[this.table] = [this.form[this.table][e]];
            this.formModal['errors'] = this.form.errors;
            this.currentRow = e;
            this.showModal = true;
            this.modalStatus = 'EDIT';
        },
        modalCreate() {
            this.modalReset();
            this.showModal = true;
            this.modalStatus = 'CREATE';
        },
        modalReset() {
            const e = {};
            Vue.set(this.formModal[this.table], 0, {});
            Vue.set(this.formModal[this.table][0], 'data', {});
            Object.keys(this.fieldsModal).forEach(a => {
                Vue.set(this.formModal[this.table][0]['data'], a, e[a] = a == 'id' ? this.parentId : null);
            });
            Vue.set(this.formModal[this.table][0], 'status', 'New!');
            this.formModal['errors'] = this.form.errors;
        },
        modalAddReset() {
            this.form[this.table].push(this.formModal[this.table][0]);
            this.modalReset();
        },
        modalAddClose() {
            this.form[this.table].push(this.formModal[this.table][0]);
        },
        modalDelete(e) {
            let status = this.form[this.table][e]['status'];
            if (status == 'NotModified!' || status == 'DataModified!') {
                this.form[this.table][e]['status'] = 'Deleted!';
            } else {
                this.form[this.table].splice(e, 1);
                // Error
                Object.keys(this.form['errors']['errors']).forEach(a => {
                    if (a.substring(0, a.indexOf(".data.")) == `${this.table}.${e}`) {
                        this.$delete(this.form['errors']['errors'], a);
                    }
                });
            }
        },
    },
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style scoped>
    .invalid-feedback {
        display: unset;
    }
</style>
