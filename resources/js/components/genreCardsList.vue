<template>
    <div class="columns is-multiline">
        <div class="column is-2" v-for="genre in genres">
            <a
                class="button genre-card-button is-outlined height-100 width-100"
                type="button"
                :tabindex="tabable ? 0 : -1"
                @keyup.enter="handleClick(genre)"
                @click="handleClick(genre)"
            >
                <div class="width-100">
                    <span>{{ genre.name }}</span>
                    <a class="button is-danger is-outlined is-pulled-right deletion-button"
                       @click.stop="handleDeleteClick(genre)">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </a>
        </div>
    </div>
</template>

<script>
    export default {
        name: "genreCardsList",
        props: {
            genres: {
                type: Array,
                required: true
            },
            tabable: {
                type: Boolean,
                required: true,
                default: true,
            }
        },
        mounted() {
            this.$nextTick(function () {
                this.$emit('mounted');
            });
        },
        methods: {
            handleClick: function(genre) {
                this.$emit('genre-clicked', genre);
            },
            handleDeleteClick: function(genre) {
                this.$emit('genre-deletion-clicked', genre);
            }
        }
    }
</script>
