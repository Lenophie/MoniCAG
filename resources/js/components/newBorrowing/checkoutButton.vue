<template>
    <a class="fa-layers fa-fw" id="checkout-link" @click="$emit('open')">
        <i class="fas fa-gift"></i>
        <span class="fa-layers-counter" id="checkout-counter">{{counter}}</span>
    </a>
</template>

<script>
    export default {
        props: {
            counter: Number
        },
    }
</script>
