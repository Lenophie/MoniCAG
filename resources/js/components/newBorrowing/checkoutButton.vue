<template>
    <button
        class="fa-layers fa-fw"
        id="checkout-link"
        @click="$emit('open')"
        :tabable="tabable ? 0 : -1"
    >
        <i class="fas fa-save"></i>
        <span class="fa-layers-counter" id="checkout-counter">{{counter}}</span>
    </button>
</template>

<script>
    export default {
        name: "checkoutButton",
        props: {
            counter: {
                type: Number,
                required: true,
                default: 0
            },
            tabable: {
                type: Boolean,
                required: true,
                default: true,
            }
        },
    }
</script>
