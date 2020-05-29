<template>
    <BaseForm>
        <BaseDatacard v-bind:presentationStyle="free-form"/>
    </BaseForm>
</template>

<script>
import BaseForm from './BaseForm.vue';
import BaseDatacard from './BaseDatacard.vue';
export default {
    name: 'BaseForm', 
    components: [BaseForm, BaseDatacard]
}
</script>

<style slot-scope>
    .container {
        max-width: 100%;
    }
</style>