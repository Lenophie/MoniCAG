<template>
    <div>
        <p class="has-text-danger">
            <span v-html="trans('messages.edit_users.user_deletion_warning')"></span>
        </p>
        <hr>
        <form :action="userDeletionRequest.route" autocomplete="off" v-on:submit.prevent="submit">
            <div class="field">
                <label class="label" for="user-deletion-confirm-password-input">{{ trans('Confirm password') }}</label>
                <div class="control has-icons-left">
                    <input
                        class="input"
                        type="password"
                        id="user-deletion-confirm-password-input"
                        name="password"
                        :placeholder="trans('Password')"
                        v-model="userDeletionRequest.params.password"
                        :disabled=userDeletionRequest.isProcessing
                        required>
                    <span class="icon is-small is-left">
                        <i class="fas fa-key"></i>
                    </span>
                </div>
            </div>
            <error-field
                :errors-list="userDeletionRequest.errors"
                :field-path="'password'">
            </error-field>
            <error-field
                :errors-list="userDeletionRequest.errors"
                :field-path="'user'">
            </error-field>
        </form>
    </div>
</template>

<script>
    import errorField from '../errorField.vue';

    export default {
        name: "userDeletionModalBody",
        props: {
            userDeletionRequest: {
                type: Object,
                required: true
            },
            submit: {
                type: Function,
                required: true
            }
        },
        components: {
            errorField
        }
    }
</script>
