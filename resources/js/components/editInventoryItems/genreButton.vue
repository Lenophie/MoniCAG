<template>
    <a
        class="button genre-card-button is-outlined height-100 width-100"
        type="button"
        :id="`genre-card-button-${genre.id}`"
        :tabindex="tabable ? 0 : -1"
        @keyup.enter="handleClick(genre)"
        @click="handleClick(genre)"
    >
        <div class="width-100">
            <span>{{ genre.name }}</span>
            <a class="button is-danger is-outlined is-pulled-right deletion-button"
               :id="`genre-card-deletion-button-${genre.id}`"
               @click.stop="handleDeleteClick(genre)">
                <i class="fas fa-times"></i>
            </a>
        </div>
    </a>
</template>

<script>
    export default {
        name: "genreCardsList",
        props: {
            genre: {
                type: Object,
                required: true
            },
            tabable: {
                type: Boolean,
                required: true,
                default: true,
            }
        },
        methods: {
            /**
             * Handles a click on the genre card button
             * @param genre
             */
            handleClick: function(genre) {
                this.$emit('genre-clicked', genre);
            },

            /**
             * Handles a click on the genre card button's delete button
             * @param genre
             */
            handleDeleteClick: function(genre) {
                this.$emit('genre-deletion-clicked', genre);
            }
        }
    }
</script>
