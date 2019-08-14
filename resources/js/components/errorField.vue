<template>
    <div v-if="Object.keys(errorsList).length > 0">
        <ul>
            <li v-for="error in nestedErrorList" class="error-text">{{error}}</li>
        </ul>
    </div>
</template>

<script>
    import get from "lodash.get";

    export default {
        name: "errorField",
        props: {
            errorsList: Object,
            fieldPath: String
        },
        computed: {
            nestedErrorList: function () {
                return get(this.errorsList, this.fieldPath);
            }
        }
    }
</script>
