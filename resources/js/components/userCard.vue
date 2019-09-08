<template>
    <div class="user-card" :id="id">
        <div class="user-card-name">
            <span>{{ user.firstName }} {{user.lastName}}</span>
            <a
                v-if="hasDeleteButton"
                class="button is-danger is-small is-outlined is-pulled-right deletion-button"
                :id="`user-card-deletion-button-${user.id}`"
                :disabled="disabled"
                @click.stop="handleDeleteClick">
                <i class="fas fa-times"></i>
            </a>
            <hr class="user-card-hr">
        </div>
        <div class="user-card-footer" v-if="isRoleInfoShown">
            <span>
                {{user.role.name}}
                <span v-if="user.role.id === 1">
                     <i class="fas fa-chess-pawn"></i>
                </span>
                <span v-else-if="user.role.id === 2">
                     <i class="fas fa-chess-knight"></i>
                </span>
                <span v-else-if="user.role.id === 3">
                     <i class="fas fa-chess-queen"></i>
                </span>
            </span>
        </div>
    </div>
</template>

<script>
    // Icons
    import { library } from '@fortawesome/fontawesome-svg-core';
    import { faChessQueen, faChessKnight, faChessPawn } from '@fortawesome/free-solid-svg-icons';

    export default {
        name: "userCard",
        props: {
            user: {
                type: Object,
                required: true
            },
            showRole: {
                type: Boolean,
                required: false,
                default: true
            },
            hasDeleteButton: {
                type: Boolean,
                required: false,
                default: false
            },
            disabled: {
                type: Boolean,
                required: false,
                default: false,
            }
        },
        computed: {
            /**
             * Formats the id of the user card
             * @returns {string}
             */
            id: function() {
                return `user-card-${this.user.id}`;
            },

            /**
             * Determines if status info should be shown
             * @returns {boolean}
             */
            isRoleInfoShown: function() {
                return this.showRole && this.user.role != null;
            },
        },
        methods: {
            /**
             * Handles a click on the delete button
             */
            handleDeleteClick: function() {
                if (!this.disabled) this.$emit('user-deletion-clicked', this.user);
            }
        },
        beforeCreate() {
            library.add(faChessKnight, faChessQueen, faChessPawn);
        }
    }
</script>

<style scoped>
    .user-card {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .user-card-footer {
        font-style: italic;
        text-align: right;
        font-size: 10px;
    }

    .user-card-name {
        text-align: center;
    }

    .user-card-hr {
        margin-top: 0;
        margin-bottom: 3px;
        height: 1px;
    }
</style>
