/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import Vue from 'vue'
import App from './App.vue'
import Vuex from 'vuex'

Vue.use(Vuex)

import store from './store.js'
import router from './router.js'

import moment from 'moment'
import VuePaginate from 'vue-paginate'
import Vuelidate from 'vuelidate'
import Notifications from 'vue-notification'
import Multiselect from 'vue-multiselect'
import VModal from 'vue-js-modal'
import VPopover from 'vue-js-popover'
import velocity from 'velocity-animate'
import {DatePicker, TimeSelect, TimePicker} from 'element-ui'
import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'


Vue.use(VuePaginate)
Vue.use(Vuelidate)
Vue.component('multiselect', Multiselect)
Vue.use(moment)
Vue.use(VModal, {
    dialog : true,
    dynamic: true,
    // injectModalsContainer: true
})
locale.use(lang)
Vue.use(VPopover, {tooltip: true})
Vue.use(Notifications, {velocity})
Vue.use(DatePicker)
Vue.use(TimeSelect)
Vue.use(TimePicker)


const app = new Vue({
    el        : '#app',
    router,
    store,
    components: {App},
    template  : '<App/>'
});
