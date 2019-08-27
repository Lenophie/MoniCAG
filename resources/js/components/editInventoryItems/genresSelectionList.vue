<template>
    <div class="field is-grouped is-grouped-multiline">
        <div v-for="genre in genres" class="control">
            <label class="checkbox">
                <input type="checkbox" :value="genre.id" v-model="localSelectedGenres">
                {{genre.name}}
            </label>
        </div>
    </div>
</template>

<script>
    export default {
        name: "genresSelectionList",
        props: {
            genres: Array,
            selectedGenres: Array
        },
        model: {
            prop: "selectedGenres"
        },
        computed: {
            localSelectedGenres: {
                get() { return this.selectedGenres },
                set(v) { this.$emit('update:selected-genres', v) }
            }
        }
    }
</script>
