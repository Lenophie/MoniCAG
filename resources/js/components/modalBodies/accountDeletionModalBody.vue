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
            <error-field
                :errors-list="accountDeletionRequest.errors"
                :field-key="'password'">
            </error-field>
        </form>
    </div>
</template>

<script>
    import errorField from '../errorField.vue';

    export default {
        props: {
            accountDeletionRoute: String,
            accountDeletionRequest: Object,
            submit: Function
        },
        mounted() {
            this.$emit('ready', this.accountDeletionRoute)
        },
        components: {
            errorField
        }
    }
</script>
