<template>
    <div>
        <div class="card-body row" v-for="(i, index) in form[table]" :key="index">
            <div class="col-md-6 form-group" v-for="(ii, key, cc) in fields" :key="key">
                <label :for=key[cc] v-if="ii.label" class="col-form-label">{{ ii.label }}:</label>
                <label :for=key[cc] v-if="!ii.label" class="col-form-label">{{ key.replace(/_/g," ") | titlecase }}:</label>
                <div class="input-group input-group" v-if="ii.element == 'input' || ii.element == 'multiselect'">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="addon-wrapping">
                            <i :class="ii.icon"></i>
                        </span>
                    </div>
                    <input
                        v-if="ii.inputType == 'text' && ii.element == 'input'"
                        v-model="form[table][index]['data'][key]"
                        class="form-control"
                        :id="`${table}.${index}.data.${key}`"
                        :name="`${table}.${index}.data.${key}`"
                        :disabled="(sourceTabular && key === 'id') || (modalStatus == 'CREATE' ? false : (ii.guarded || ii.disabled))"
                        :maxlength="ii.maxlength"
                        :type="ii.inputType"
                        :class="{ 'is-invalid': form.errors.has(`${table}.${currentRow}.data.${key}`) }"
                    >
                    <input
                        v-if="ii.inputType == 'number' && ii.element == 'input'"
                        v-model="form[table][index]['data'][key]"
                        class="form-control"
                        :id="`${table}.${index}.data.${key}`"
                        :name="`${table}.${index}.data.${key}`"
                        :disabled="(sourceTabular && key === 'id') || (modalStatus == 'CREATE' ? false : (ii.guarded || ii.disabled))"
                        :maxlength="ii.maxlength"
                        :type="ii.inputType"
                        :class="{ 'is-invalid': form.errors.has(`${table}.${currentRow}.data.${key}`) }"
                    >
                    <!-- JSON -->
                    <input
                        v-if="ii.inputType == 'json' && ii.element == 'input'"
                        v-model="form[table][index]['data'][key]"
                        class="form-control"
                        disabled="disabled"
                        :id="`${table}.${index}.data.${key}`"
                        :name="`${table}.${index}.data.${key}`"
                        :maxlength="ii.maxlength"
                        :type="ii.inputType"
                        :class="{ 'is-invalid': form.errors.has(`${table}.${currentRow}.data.${key}`) }"
                    >

                    <div 
                        v-if="ii.inputType == 'json' && ii.element == 'input'"
                        class="input-group-append" id="button-addon4">
                        <button class="btn btn-outline-secondary" type="button" @click="jsonEditor(key)">JSON Editor</button>
                    </div>

                    <datepicker 
                        v-if="ii.inputType == 'date' && ii.element == 'input'"
                        v-model="form[table][index]['data'][key]"
                        :wrapper-class="'datepicker-class form-control'"
                        :input-class="'form-control datepicker-class-input'"
                        :id="`${table}.${index}.data.${key}`"
                        :name="`${table}.${index}.data.${key}`"
                    >
                    </datepicker>

                    <multiselect 
                        v-if="ii.element == 'multiselect' && ii.customLabel == false" 
                        v-model="form[table][index]['data'][key]" 
                        :id="`${table}.${index}.data.${key}`"
                        :name="`${table}.${index}.data.${key}`"
                        :options="ii.options" 
                        :disabled="(sourceTabular && key === 'id') || (modalStatus == 'CREATE' ? false : (ii.guarded || ii.disabled))"
                        :class="{'is-invalid': form.errors.has(`${table}.${currentRow}.data.${key}`), 'multiselect-class': true, 'form-control': true}"
                        label="value" track-by="key" placeholder="Select one"
                    >
                    </multiselect>
                    <multiselect 
                        v-if="ii.element == 'multiselect' && ii.customLabel == true" 
                        v-model="form[table][index]['data'][key]" 
                        :id="`${table}.${index}.data.${key}`"
                        :name="`${table}.${index}.data.${key}`"
                        :options="ii.options" 
                        :disabled="(sourceTabular && key === 'id') || (modalStatus == 'CREATE' ? false : (ii.guarded || ii.disabled))"
                        :class="{'is-invalid': form.errors.has(`${table}.${currentRow}.data.${key}`), 'multiselect-class': true, 'form-control': true}"
                        :custom-label="customLabel" 
                        label="value" track-by="key" placeholder="Select one"
                    >
                    </multiselect>
                </div>

                <div class="help-block invalid-feedback" v-if="form.errors.errors[`${table}.${currentRow}.data.${key}`]">
                    {{ form.errors.errors[`${table}.${currentRow}.data.${key}`][0].replace(`${table}.${currentRow}.data.${key}`, key.replace(/_/g," ")) }}
                </div>
            </div>
        </div>

        <!-- Modal Test -->
        <b-modal
            v-model="showModal"
            title="JSON Editor"
            id="modal-tall modal-lg"
            size="lg" 
        >
            <b-container fluid>
                <b-row>
                    <div class="card-body row">
                        <JsonEditor :objData="jsonData" v-model="jsonData" ></JsonEditor>
                    </div>
                </b-row>
            </b-container>
            <div slot="modal-footer">
                <b-button
                    variant="secondary"
                    class="float-right"
                    @click="jsonEditorCancel"
                >
                Cancel
                </b-button>
                <b-button
                    variant="primary"
                    class="float-right mr-1"
                    @click="jsonEditorSet"
                >
                Set Changes
                </b-button>
            </div>
        </b-modal>
    </div>
</template>

<script>
import { datacardMixin } from '../mixins/datacardMixin';
export default {
    name: 'BaseDatacardFreeForm', 
    mixins: [datacardMixin],
    props: {
        fields: {},
        form: {},
        table: '',
        currentRow: 0,
        sourceTabular: false,
        modalStatus: '',
    },
    watch: {
        form: {
            handler(val){
                let status = val[this.table][0]['status'];
                if (status == 'New!') {
                    val[this.table][0]['status'] = 'NewModified!'
                }
                if (status == 'NotModified!') {
                    val[this.table][0]['status'] = 'DataModified!'
                }
            },
            deep: true
        }
    },
    data() {
        return {
            showModal: false,
            jsonData: {},
            jsonColumn: '',
        }
    },
    methods: {
        jsonEditor(e) {
            this.jsonColumn = e;
            console.log(e);
            this.showModal = true;
            this.jsonData = JSON.parse(event.target.parentNode.previousElementSibling.value);
        },
        jsonEditorSet() {
            Vue.set(this.form.kram_form_fields[0].data, this.jsonColumn, JSON.stringify(this.jsonData));
            this.showModal = false;
        },
        jsonEditorCancel() {
            this.showModal = false;
        }
        // jsonEditor: function (event) {
        //     // `this` inside methods points to the Vue instance
        //     alert('Hello ' + this.name + '!')
        //     // `event` is the native DOM event
        //     if (event) {
        //         alert(event.target.tagName)
        //     }
        // }
    }
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style scoped>
    .invalid-feedback {
        display: unset;
    }
</style>

<style>
    .datepicker-class {
        padding: unset;
        border: unset;
    }

    .datepicker-class-input {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }

    .datepicker-class-input:read-only {
        background-color: unset;
    }

    .multiselect-class {
        padding: unset;
        box-sizing: border-box !important;
        min-height: 38px !important;
    }

    .multiselect-class .multiselect__tags {
        border: unset;
        min-height: calc(100% - 5px) !important;
        max-height: calc(100% - 5px) !important;
    }

    .multiselect--disabled, 
    .multiselect--disabled .multiselect__tags, 
    .multiselect--disabled .multiselect__tags .multiselect__single {
        background-color: #e9ecef !important;
        opacity: 1 !important;
    }
    
    .multiselect--disabled .multiselect__select {
        height: 35px !important;
    }
</style>
