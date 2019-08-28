<template>
    <div class="inventory-item-card" :id="id">
        <div class="inventory-item-card-name">
            <span>{{ inventoryItem.name }}</span>
            <a
                v-if="hasDeleteButton"
                class="button is-danger is-small is-outlined is-pulled-right deletion-button"
                @click.stop="handleDeleteClick(inventoryItem)">
                <i class="fas fa-times"></i>
            </a>
            <hr class="inventory-item-card-hr">
        </div>
        <div class="inventory-item-card-precision" v-if="isPrecisionDivNecessary">
            <span class="inventory-item-card-info" v-if="isGenresInfoShown">
                <i class="fas fa-trophy"></i> {{genresString}}
            </span>
            <span class="inventory-item-card-info" v-if="isDurationInfoShown">
                <br v-if="isGenresInfoShown"/>
                <i class="far fa-clock"></i> {{durationInfo}}
            </span>
            <span class="inventory-item-card-info" v-if="isPlayersInfoShown">
                <br v-if="isDurationInfoShown || isGenresInfoShown"/>
                <i class="fas fa-users"></i> {{playersInfo}}
            </span>
        </div>
        <div class="inventory-item-card-footer" v-if="showStatus">
            {{inventoryItem.status.name}}
        </div>
    </div>
</template>

<script>
    // Tools
    import { buildMinMaxString } from "../tools.js";

    // Icons
    import { library } from '@fortawesome/fontawesome-svg-core';
    import { faTrophy, faUsers } from '@fortawesome/free-solid-svg-icons';
    import { faClock } from '@fortawesome/free-regular-svg-icons';

    export default {
        name: "inventoryItemCard",
        props: {
            inventoryItem: Object,
            showGenres: {
                type: Boolean,
                required: false,
                default: true,
            },
            showDuration: {
                type: Boolean,
                required: false,
                default: true,
            },
            showPlayers: {
                type: Boolean,
                required: false,
                default: true,
            },
            showStatus: {
                type: Boolean,
                required: false,
                default: true,
            },
            hasDeleteButton: {
                type: Boolean,
                required: false,
                default: false
            }
        },
        computed: {
            /**
             * Formats the id of the inventory item card
             * @returns {string}
             */
            id: function() {
                return `inventory-item-card-${this.inventoryItem.id}`;
            },

            /**
             * Determines if genres info should be shown
             * @returns {boolean}
             */
            isGenresInfoShown: function() {
                return this.showGenres && this.inventoryItem.genres != null && this.inventoryItem.genres.length > 0
            },

            /**
             * Determines if duration info should be shown
             * @returns {boolean}
             */
            isDurationInfoShown: function() {
                return this.showDuration && this.inventoryItem.duration != null &&
                    (this.inventoryItem.duration.min !== null || this.inventoryItem.duration.max !== null)
            },

            /**
             * Determines if players info should be shown
             * @returns {boolean}
             */
            isPlayersInfoShown: function() {
                return this.showPlayers && this.inventoryItem.players != null &&
                    (this.inventoryItem.players.min !== null || this.inventoryItem.players.max !== null)
            },

            /**
             * Determines if precision div should be shown
             * @returns {boolean}
             */
            isPrecisionDivNecessary: function() {
                return this.isGenresInfoShown || this.isDurationInfoShown || this.isPlayersInfoShown;
            },

            /**
             * Formats the genres string
             * @returns {string}
             */
            genresString: function() {
                const genresLength = this.inventoryItem.genres.length;
                let genresString = '';
                for (let genreIndex = 0; genreIndex < genresLength; genreIndex++) {
                    genresString += this.inventoryItem.genres[genreIndex].name;
                    if (genreIndex < genresLength - 1) genresString += ', ';
                }
                return genresString;
            },

            /**
             * Formats the duration info
             * @returns {string}
             */
            durationInfo: function() {
                const minutesString = this.trans('Minutes').toLowerCase();
                return buildMinMaxString(this.inventoryItem.duration.min, this.inventoryItem.duration.max,
                    minutesString, minutesString);
            },

            /**
             * Formats the players info
             * @returns {string}
             */
            playersInfo: function() {
                return buildMinMaxString(this.inventoryItem.players.min, this.inventoryItem.players.max,
                    this.trans('Player').toLowerCase(), this.trans('Players').toLowerCase());
            },
        },
        methods: {
            /**
             * Handles a click on the delete button
             * @param inventoryItem
             */
            handleDeleteClick: function(inventoryItem) {
                this.$emit('item-deletion-clicked', inventoryItem);
            }
        },
        beforeCreate() {
            library.add(faTrophy, faUsers, faClock);
        }
    }
</script>

<style scoped>
    .inventory-item-card {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .inventory-item-card-footer {
        font-style: italic;
        text-align: right;
        font-size: 10px;
    }

    .inventory-item-card-precision {
        font-size: 12px;
        text-align: left;
    }

    .inventory-item-card-info {
        white-space: normal;
    }

    .inventory-item-card-name {
        text-align: center;
    }

    .inventory-item-card-hr {
        margin-top: 0;
        margin-bottom: 3px;
        height: 1px;
    }
</style>
