<template>
    <div v-if="Object.keys(errorsList).length > 0">
        <ul>
            <li v-for="error in errorsList[fieldKey]" class="error-text">{{error}}</li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: "errorField",
        props: {
            errorsList: Object,
            fieldKey: String
        }
    }
</script>
