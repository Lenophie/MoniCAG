<template>
    <div v-if="Object.keys(errorsList).length > 0">
        <ul>
            <li v-for="error in nestedErrorList" class="error-text">{{error}}</li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: "errorField",
        props: {
            errorsList: {
                type: Object,
                required: true
            },
            fieldPath: {
                type: String,
                required: true
            }
        },
        computed: {
            /**
             * Builds the list of errors relevant to the provided field path
             * @returns {Array}
             */
            nestedErrorList: function () {
                const matchingKeys = [];
                for (const key of Object.keys(this.errorsList)) {
                    if (key.startsWith(this.fieldPath)) matchingKeys.push(key);
                }
                return Array.prototype.concat(...matchingKeys.map(key => this.errorsList[key]));
            }
        }
    }
</script>
