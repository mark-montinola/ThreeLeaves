<template>
    <div class="container">
        <div class="col-md-12 pt-2 pb-2">
            <b-card no-body v-if="formPresentationStyle=='Tab'">
                <slot name="slot-base-form"></slot>
            </b-card>
            <slot v-if="formPresentationStyle=='Card'" name="slot-base-form"></slot>
        </div>
    </div>
</template>

<script>
export default {
    name: 'BaseForm',
    props: {
        formPresentationStyle: null
    },
}
</script>

<style slot-scope>
    .container {
        max-width: 100%;
    }
</style>