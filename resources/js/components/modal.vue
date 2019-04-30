<template>
    <div class="modal is-active">
        <div class="modal-background" @click="$emit('close')"></div>
        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">{{title}}</p>
                <a class="delete" aria-label="close" @click="$emit('close')"></a>
            </header>
            <div class="modal-card-body">
                <slot name="body"></slot>
            </div>
            <footer class="modal-card-foot">
                <slot name="footer"></slot>
            </footer>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['title'],
        created () {
            document.addEventListener('keydown', this.onkey)
        },
        beforeDestroy () {
            document.removeEventListener('keydown', this.onkey)
        },
        methods: {
            onkey(e) {
                if (e.key === 'Escape') this.$emit('close');
            }
        }
    }
</script>
