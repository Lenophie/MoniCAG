<template>
    <div class="columns no-mb">
        <div class="column is-12">
            <div class="field is-grouped is-grouped-multiline">
                <div v-for="altName in altNames" class="control">
                    <div class="tags has-addons">
                        <span class="tag is-link">{{altName}}</span>
                        <a
                            class="tag is-delete"
                            @click="removeAltName(altName)">
                        </a>
                    </div>
                </div>
            </div>
            <div class="field has-addons">
                <div class="control is-expanded">
                    <input
                        type="text"
                        class="input"
                        v-model="inputValue"
                        @keyup.enter="addAltName"
                    >
                </div>
                <div class="control">
                    <button
                        class="button is-outlined is-link height-100"
                        type="button"
                        @click="addAltName"
                    >
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "altNamesDefinitionList",
        props: {
            altNames: Array
        },
        data: function () {
            return {
                inputValue: '',
            }
        },
        methods: {
            /**
             * Adds an alt name to the local list of alt names
             */
            addAltName() {
                if (this.inputValue !== '') {
                    // Check for duplicates
                    let isDuplicate = false;
                    const lowerCaseInput = this.inputValue.toLowerCase();
                    for (const altName of this.altNames) {
                        if (altName.toLowerCase() === lowerCaseInput) {
                            isDuplicate = true;
                            break;
                        }
                    }

                    // Add the alt name
                    if (!isDuplicate) {
                        const newAltNamesList = Vue.util.extend([], this.altNames);
                        newAltNamesList.push(this.inputValue);
                        this.emitSelection(newAltNamesList);
                    }

                    // Clean input field
                    this.cleanInputField();
                }
            },
            /**
             * Adds an alt name from the local list of alt names
             * @param {string} altName The alt name to add to the list
             */
            removeAltName(altName) {
                // Find alt name index in the list
                const indexOfAltNameToRemove = this.altNames.indexOf(altName);

                // Remove alt name from the list
                if (indexOfAltNameToRemove > -1) {
                    const newAltNamesList = Vue.util.extend([], this.altNames);
                    newAltNamesList.splice(indexOfAltNameToRemove, 1);
                    this.emitSelection(newAltNamesList);
                }
            },
            /**
             * Cleans an alt name to the local list of alt names
             */
            cleanInputField() {
                this.inputValue = '';
            },
            /**
             * Emits an update of the selected genres
             */
            emitSelection(newAltNames) {
                this.$emit('update:alt-names', newAltNames);
            }
        }
    }
</script>
