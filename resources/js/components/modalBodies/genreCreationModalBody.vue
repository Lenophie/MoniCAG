<template>
    <div>
        <form :action="genreCreationRequest.route" autocomplete="off" v-on:submit.prevent="submit">
            <h5 class="title is-5">{{ trans('Names') }}</h5>
            <!-- French Name -->
            <div class="field has-addons has-addons-centered">
                <div class="control">
                    <a class="button is-static height-100">
                        <i class="field-flag flag-icon flag-icon-fr flag-icon-squared"></i>
                    </a>
                </div>
                <div class="control is-expanded">
                    <input class="input"
                           type="text"
                           id="genre-creation-name-fr"
                           name="nameFr"
                           v-model="genreCreationRequest.params.nameFr"
                           :disabled=genreCreationRequest.isProcessing
                           required>
                </div>
            </div>
            <error-field
                :errors-list="genreCreationRequest.errors"
                :field-path="'nameFr'">
            </error-field>
            <!-- English Name -->
            <div class="field has-addons has-addons-centered">
                <div class="control">
                    <a class="button is-static height-100">
                        <i class="field-flag flag-icon flag-icon-gb flag-icon-squared"></i>
                    </a>
                </div>
                <div class="control is-expanded">
                    <input class="input"
                           type="text"
                           id="genre-creation-name-en"
                           name="nameEn"
                           v-model="genreCreationRequest.params.nameEn"
                           :disabled=genreCreationRequest.isProcessing
                           required>
                </div>
            </div>
            <error-field
                :errors-list="genreCreationRequest.errors"
                :field-path="'nameEn'">
            </error-field>
        </form>
    </div>
</template>

<script>
    import ErrorField from "../errorField.vue";

    export default {
        name: "genreCreationModalBody",
        props: {
            genreCreationRequest: Object,
            submit: Function
        },
        components: { ErrorField },
    }
</script>
