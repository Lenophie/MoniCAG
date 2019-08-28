<template>
    <input
        ref="input"
        class="input"
        :class="{'is-danger': isInvalid}"
        type="number"
        :value="value"
        @input="handleInput"
    >
</template>

<script>
    export default {
        name: "numberInput",
        props: {
            value: {
                type: String|Number,
                required: true
            }
        },
        data: function () {
            return {
                isInvalid: false,
            }
        },
        methods: {
            handleInput: function ($event) {
                this.isInvalid = !this.$refs.input.checkValidity();
                this.$emit('input', $event.target.value);
            }
        }
    }
</script>
