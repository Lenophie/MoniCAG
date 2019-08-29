<template>
    <div class="field is-grouped is-grouped-multiline">
        <div v-for="genre in genres" class="control">
            <label class="checkbox">
                <input type="checkbox" :name="`genre-${genre.id}`" :value="genre.id" v-model="localSelectedGenres">
                {{genre.name}}
            </label>
        </div>
    </div>
</template>

<script>
    export default {
        name: "genresSelectionList",
        props: {
            genres: {
                type: Array,
                required: true,
            },
            selectedGenres: {
                type: Array,
                required: true,
            }
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
