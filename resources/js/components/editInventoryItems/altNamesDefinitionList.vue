<template>
    <div>
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
                    v-model:value="local.inputValue"
                    @keyup.enter="addAltName"
                >
            </div>
            <div class="control">
                <a
                    class="button is-outlined is-link height-100"
                    type="button"
                    @click="addAltName"
                >
                    <i class="fas fa-arrow-right"></i>
                </a>
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
                local : {
                    inputValue: '',
                    altNames: Vue.util.extend([], this.altNames) // prevent shallow copy
                }
            }
        },
        watch: {
            'local.altNames': function() {
                this.emitSelection();
            }
        },
        methods: {
            /**
             * Adds an alt name to the local list of alt names
             */
            addAltName() {
                // Check for duplicates
                let isDuplicate = false;
                for (const altName of this.local.altNames) {
                    if (altName === this.local.inputValue) {
                        isDuplicate = true;
                        break;
                    }
                }

                // Add the alt name
                if (!isDuplicate)
                    this.local.altNames.push(this.local.inputValue);

                // Clean input field
                this.cleanInputField();
            },
            /**
             * Adds an alt name from the local list of alt names
             * @param {string} altName The alt name to add to the list
             */
            removeAltName(altName) {
                // Find alt name index in the list
                const indexOfAltNameToRemove = this.local.altNames.indexOf(altName);

                // Remove alt name from the list
                if (indexOfAltNameToRemove > -1) this.local.altNames.splice(indexOfAltNameToRemove, 1);
            },
            /**
             * Cleans an alt name to the local list of alt names
             */
            cleanInputField() {
                this.local.inputValue = '';
            },
            /**
             * Emits an update of the selected genres
             */
            emitSelection() {
                this.$emit('update:alt-names', this.local.altNames);
            }
        }
    }
</script>
