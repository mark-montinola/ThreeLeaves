<template>
    <div>
        <slot name="slot-base-datacard"></slot>
    </div>
</template>

<script>
export default {
    name: 'BaseDatacard', 
    props: {
        presentationStyle: {
            type: String,
            required: true,
            validator: function (value) {
                return [
                    'free-form',
                    'tabular'
                ].indexOf(value) !== -1
            }
        }
    }
}
</script>