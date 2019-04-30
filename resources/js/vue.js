window.Vue = require('vue');
Vue.component('modal', require('./components/modal.vue').default);

new Vue({
    el: '#app'
});
