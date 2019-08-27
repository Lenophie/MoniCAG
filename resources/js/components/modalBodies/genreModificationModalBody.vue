<template>
    <div>
        <form :action="genreModificationRequest.route" autocomplete="off" v-on:submit.prevent="submit">
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
                           v-model="genreModificationRequest.params.nameFr"
                           :disabled=genreModificationRequest.isProcessing
                           required>
                </div>
            </div>
            <error-field
                :errors-list="genreModificationRequest.errors"
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
                           v-model="genreModificationRequest.params.nameEn"
                           :disabled=genreModificationRequest.isProcessing
                           required>
                </div>
            </div>
            <error-field
                :errors-list="genreModificationRequest.errors"
                :field-path="'nameEn'">
            </error-field>
        </form>
    </div>
</template>

<script>
    import ErrorField from "../errorField.vue";

    export default {
        name: "genreModificationModalBody",
        props: {
            genreModificationRequest: Object,
            submit: Function
        },
        components: { ErrorField },
    }
</script>
