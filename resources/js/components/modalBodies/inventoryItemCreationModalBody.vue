<template>
    <div>
        <form :action="inventoryItemCreationRequest.route" autocomplete="off" v-on:submit.prevent="submit">
            <!-- Name -->
            <div class="field">
                <label class="label" for="inventory-item-creation-name">{{ trans('Name') }}</label>
                <div class="control">
                    <input class="input"
                         type="text"
                         id="inventory-item-creation-name"
                         name="name"
                         v-model="inventoryItemCreationRequest.params.name"
                         :disabled=inventoryItemCreationRequest.isProcessing
                         required>
                </div>
            </div>
            <error-field
                :errors-list="inventoryItemCreationRequest.errors"
                :field-path="'name'">
            </error-field>
            <!-- Duration -->
            <h5 class="title is-5">{{ trans('Duration') }} ({{trans('Minutes').toLowerCase()}})</h5>
            <div class="columns">
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
                                v-model="inventoryItemCreationRequest.params.duration.min"
                                :disabled=inventoryItemCreationRequest.isProcessing
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
                                v-model="inventoryItemCreationRequest.params.duration.max"
                                :disabled=inventoryItemCreationRequest.isProcessing
                                required>
                            </number-input>
                        </div>
                    </div>
                </div>
            </div>
            <error-field
                :errors-list="inventoryItemCreationRequest.errors"
                :field-path="'durationMin'">
            </error-field>
            <error-field
                :errors-list="inventoryItemCreationRequest.errors"
                :field-path="'durationMax'">
            </error-field>
            <!-- Player count -->
            <h5 class="title is-5">{{ trans('Players') }}</h5>
            <div class="columns">
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
                                v-model="inventoryItemCreationRequest.params.players.min"
                                :disabled=inventoryItemCreationRequest.isProcessing
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
                                v-model="inventoryItemCreationRequest.params.players.max"
                                :disabled=inventoryItemCreationRequest.isProcessing
                                required>
                            </number-input>
                        </div>
                    </div>
                </div>
            </div>
            <error-field
                :errors-list="inventoryItemCreationRequest.errors"
                :field-path="'durationMin'">
            </error-field>
            <error-field
                :errors-list="inventoryItemCreationRequest.errors"
                :field-path="'durationMax'">
            </error-field>
            <!-- Genres -->
            <h5 class="title is-5">{{ trans('Genres') }}</h5>
            <genres-selection-list
                :genres="genres"
                :selected-genres.sync="inventoryItemCreationRequest.params.genres">
            </genres-selection-list>
            <error-field
                :errors-list="inventoryItemCreationRequest.errors"
                :field-path="'genres'">
            </error-field>
            <!-- Alternative names -->
            <h5 class="title is-5">{{ trans('Alternative names') }}</h5>
            <alt-names-definition-list
                :alt-names.sync="inventoryItemCreationRequest.params.altNames">
            </alt-names-definition-list>
            <error-field
                :errors-list="inventoryItemCreationRequest.errors"
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
        name: "inventoryItemCreationModalBody",
        props: {
            inventoryItemCreationRequest: Object,
            genres: Array,
            submit: Function
        },
        components: {
            numberInput, errorField, genresSelectionList, altNamesDefinitionList
        },
    }
</script>
