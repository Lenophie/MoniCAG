<template>
    <a
        class="button user-card-button is-outlined height-100 width-100"
        type="button"
        :id="`user-card-button-${user.id}`"
        :disabled="isDisabled"
        :tabindex="isDisabled || !tabable ? -1 : 0"
        @keyup.enter="handleClick"
        @click="handleClick"
    >
        <user-card
            :user="user"
            :has-delete-button="true"
            :disabled="isDisabled"
            @user-deletion-clicked="handleDeleteClick"
        ></user-card>
    </a>
</template>

<script>
    import userCard from "../userCard.vue";

    export default {
        name: "userCardButton",
        props: {
            user: {
                type: Object,
                required: true
            },
            loggedUserId: {
                type: Number,
                required: true,
            },
            tabable: {
                type: Boolean,
                required: true,
                default: true,
            }
        },
        data: function() {
            return {
                isDisabled: this.user.role.id === 3 && this.loggedUserId !== this.user.id
            }
        },
        components: { userCard },
        methods: {
            /**
             * Handles a click on the button
             */
            handleClick: function() {
                if (!this.isDisabled) this.$emit('user-clicked', this.user);
            },

            /**
             * Handles a click on the inner delete button
             * @param user
             */
            handleDeleteClick: function(user) {
                this.$emit('user-deletion-clicked', user);
            }
        }
    }
</script>
