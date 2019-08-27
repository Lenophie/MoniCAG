<template>
    <div class="modal is-active">
        <div class="modal-background" @click="emitCloseEvent"></div>
        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">{{title}}</p>
                <a class="delete" aria-label="close" @click="emitCloseEvent"></a>
            </header>
            <div class="modal-card-body" tabindex="-1">
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
        name: "modal",
        props: {
            title: String
        },
        created() {
            document.addEventListener('keydown', this.onKey)
        },
        beforeDestroy() {
            document.removeEventListener('keydown', this.onKey)
        },
        methods: {
            emitCloseEvent() {
                this.$emit('close');
            },
            onKey(e) {
                if (e.key === 'Escape') this.emitCloseEvent();
            }
        }
    }
</script>
