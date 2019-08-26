<template>
    <div class="field is-grouped is-grouped-multiline">
        <div v-for="genre in genres" class="control">
            <label class="checkbox">
                <input type="checkbox" :value="genre.id" v-model="local.selectedGenres">
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
        data: function () {
            return {
                local : {
                    selectedGenres: []
                }
            }
        },
        watch: {
            'local.selectedGenres': function() {
                this.emitSelection();
            }
        },
        methods: {
            /**
             * Emits an update of the selected genres
             */
            emitSelection() {
                this.$emit('update:selected-genres', this.local.selectedGenres);
            }
        }
    }
</script>
