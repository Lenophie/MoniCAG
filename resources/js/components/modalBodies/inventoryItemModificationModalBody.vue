<template>
    <div>
        <form :action="inventoryItemModificationRequest.route" autocomplete="off" v-on:submit.prevent="submit">
            <!-- Name -->
            <div class="field">
                <label class="label" for="inventory-item-creation-name">{{ trans('Name') }}</label>
                <div class="control">
                    <input class="input"
                         type="text"
                         id="inventory-item-creation-name"
                         name="name"
                         v-model="inventoryItemModificationRequest.params.name"
                         :disabled=inventoryItemModificationRequest.isProcessing
                         required>
                </div>
            </div>
            <error-field
                :errors-list="inventoryItemModificationRequest.errors"
                :field-path="'name'">
            </error-field>
            <!-- Duration -->
            <h5 class="title is-5 form-subtitle">{{ trans('Duration') }} ({{trans('Minutes').toLowerCase()}})</h5>
            <div class="columns no-mb">
                <!-- Duration Min -->
                <div class="column is-6">
                    <div class="field is-grouped">
                        <label class="label inline-label" for="inventory-item-creation-duration-min">{{ trans('Min') }}</label>
                        <div class="control is-expanded">
                            <number-input
                                id="inventory-item-creation-duration-min"
                                min="0"
                                step="1"
                                name="durationMin"
                                v-model.number="inventoryItemModificationRequest.params.duration.min"
                                :disabled=inventoryItemModificationRequest.isProcessing
                                required>
                            </number-input>
                        </div>
                    </div>
                </div>
                <!-- Duration Max -->
                <div class="column is-6">
                    <div class="field is-grouped">
                        <label class="label inline-label" for="inventory-item-creation-duration-max">{{ trans('Max') }}   </label>
                        <div class="control is-expanded">
                            <number-input
                                id="inventory-item-creation-duration-max"
                                min="0"
                                step="1"
                                name="durationMax"
                                v-model.number="inventoryItemModificationRequest.params.duration.max"
                                :disabled=inventoryItemModificationRequest.isProcessing
                                required>
                            </number-input>
                        </div>
                    </div>
                </div>
            </div>
            <error-field
                :errors-list="inventoryItemModificationRequest.errors"
                :field-path="'durationMin'">
            </error-field>
            <error-field
                :errors-list="inventoryItemModificationRequest.errors"
                :field-path="'durationMax'">
            </error-field>
            <!-- Player count -->
            <h5 class="title is-5 form-subtitle">{{ trans('Players') }}</h5>
            <div class="columns no-mb">
                <!-- Player Min -->
                <div class="column is-6">
                    <div class="field is-grouped">
                        <label class="label inline-label" for="inventory-item-creation-players-min">{{ trans('Min') }}</label>
                        <div class="control is-expanded">
                            <number-input
                                id="inventory-item-creation-players-min"
                                min="0"
                                step="1"
                                name="playersMin"
                                v-model.number="inventoryItemModificationRequest.params.players.min"
                                :disabled=inventoryItemModificationRequest.isProcessing
                                required>
                            </number-input>
                        </div>
                    </div>
                </div>
                <!-- Player Max -->
                <div class="column is-6">
                    <div class="field is-grouped">
                        <label class="label inline-label" for="inventory-item-creation-players-max">{{ trans('Max') }}</label>
                        <div class="control is-expanded">
                            <number-input
                                id="inventory-item-creation-players-max"
                                min="0"
                                step="1"
                                name="playersMax"
                                v-model.number="inventoryItemModificationRequest.params.players.max"
                                :disabled=inventoryItemModificationRequest.isProcessing
                                required>
                            </number-input>
                        </div>
                    </div>
                </div>
            </div>
            <error-field
                :errors-list="inventoryItemModificationRequest.errors"
                :field-path="'durationMin'">
            </error-field>
            <error-field
                :errors-list="inventoryItemModificationRequest.errors"
                :field-path="'durationMax'">
            </error-field>
            <!-- Genres -->
            <h5 class="title is-5 form-subtitle">{{ trans('Genres') }}</h5>
            <genres-selection-list
                :genres="genres"
                :selected-genres.sync="inventoryItemModificationRequest.params.genres">
            </genres-selection-list>
            <error-field
                :errors-list="inventoryItemModificationRequest.errors"
                :field-path="'genres'">
            </error-field>
            <!-- Alternative names -->
            <h5 class="title is-5 form-subtitle">{{ trans('Alternative names') }}</h5>
            <alt-names-definition-list
                :alt-names.sync="inventoryItemModificationRequest.params.altNames">
            </alt-names-definition-list>
            <error-field
                :errors-list="inventoryItemModificationRequest.errors"
                :field-path="'altNames'">
            </error-field>
        </form>
    </div>
</template>

<script>
    import errorField from '../errorField.vue';
    import genresSelectionList from '../editInventoryItems/genresSelectionList.vue';
    import altNamesDefinitionList from '../editInventoryItems/altNamesDefinitionList.vue';
    import numberInput from "../numberInput.vue";

    export default {
        name: "inventoryItemModificationModalBody",
        props: {
            inventoryItemModificationRequest: Object,
            genres: Array,
            submit: Function
        },
        components: {
            numberInput, errorField, genresSelectionList, altNamesDefinitionList
        },
    }
</script>
