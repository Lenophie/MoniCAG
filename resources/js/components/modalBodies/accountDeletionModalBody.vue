<template>
    <div>
        <p><span v-html="trans('messages.account.deletion_warning')"></span></p>
        <hr>
        <form :action="accountDeletionRoute" autocomplete="off" v-on:submit.prevent="submit">
            <div class="field">
                <label class="label" for="account-deletion-confirm-password-input">{{ trans('Confirm password') }}</label>
                <div class="control has-icons-left">
                    <input
                        class="input"
                        type="password"
                        id="account-deletion-confirm-password-input"
                        name="password"
                        :placeholder="trans('Password')"
                        v-model="accountDeletionRequest.params.password"
                        :disabled=accountDeletionRequest.isProcessing
                        required>
                    <span class="icon is-small is-left">
                        <i class="fas fa-key"></i>
                    </span>
                </div>
            </div>
            <div v-if="Object.keys(accountDeletionRequest.errors).length > 0">
                <ul>
                    <li v-for="error in accountDeletionRequest.errors.password" class="error-text">{{error}}</li>
                </ul>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        props: ['accountDeletionRoute', 'accountDeletionRequest', 'submit'],
        mounted() {
            this.$emit('ready', this.accountDeletionRoute)
        }
    }
</script>
