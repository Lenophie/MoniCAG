<template>
    <div>
        <form :action="userRoleUpdateRequest.route" autocomplete="off" v-on:submit.prevent="submit">
            <div v-if="userRoleUpdateRequest.user != null">
                <p><span class="has-text-weight-bold">{{`${trans('Promotion')} : `}}</span>{{userRoleUpdateRequest.user.promotion}}</p>
            </div>
            <div class="field">
                <label class="label" for="role-select">{{ trans('Role') }}</label>
                <div class="control">
                    <div class="select is-fullwidth">
                        <select
                            v-if="userRoleUpdateRequest.params.role != null"
                            name="role"
                            id="role-select"
                            v-model="userRoleUpdateRequest.params.role">
                            <option
                                v-for="userRole in userRoles"
                                :value="userRole"
                                :selected="userRole === userRoleUpdateRequest.params.role">
                                {{ userRole.name }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <error-field
                :errors-list="userRoleUpdateRequest.errors"
                :field-path="'role'">
            </error-field>
            <div class="field">
                <label class="label" for="user-role-update-confirm-password-input">{{ trans('Confirm password') }}</label>
                <div class="control has-icons-left">
                    <input
                        class="input"
                        type="password"
                        id="user-role-update-confirm-password-input"
                        name="password"
                        :placeholder="trans('Password')"
                        v-model="userRoleUpdateRequest.params.password"
                        :disabled=userRoleUpdateRequest.isProcessing
                        required>
                    <span class="icon is-small is-left">
                        <i class="fas fa-key"></i>
                    </span>
                </div>
            </div>
            <error-field
                :errors-list="userRoleUpdateRequest.errors"
                :field-path="'password'">
            </error-field>
        </form>
    </div>
</template>

<script>
    import errorField from '../errorField.vue';

    export default {
        name: "userRoleUpdateModalBody",
        props: {
            userRoleUpdateRequest: {
                type: Object,
                required: true
            },
            userRoles: {
                type: Array,
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
