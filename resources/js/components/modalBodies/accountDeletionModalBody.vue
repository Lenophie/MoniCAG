<template>
    <div id="delete-modal-body">
        <p><span v-html="message"></span></p>
        <hr>
        <form id="delete-form" autocomplete="off">
            <div class="field">
                <label class="label" for="password">{{confirmPasswordLabel}}</label>
                <div class="control has-icons-left">
                    <input class="input" type="password" id="password" name="password" required>
                    <span class="icon is-small is-left">
                        <i class="fas fa-key"></i>
                    </span>
                </div>
            </div>
            <div id="errors-field-password"></div>
        </form>
    </div>
</template>

<script>
    export default {
        props: ['message', 'confirmPasswordLabel']
    }
</script>
