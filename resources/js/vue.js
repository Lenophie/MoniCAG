window.Vue = require('vue');
Vue.component('modal', require('./components/modal.vue').default);
Vue.component('account-deletion-modal-body', require('./components/modalBodies/accountDeletionModalBody.vue').default);

new Vue({
    el: '#app'
});
