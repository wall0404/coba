window.Vue = require('vue');

Vue.component('example-component', require('./components/ExampleComponent.vue').default);


import NavBar from './components/Navbar'
import {router} from './_helpers/router';
import {store} from './_helpers/store';
import Spinner from './components/Global/Spinner'
import VueRangeSlider from 'vue-range-component'
import { BootstrapVueIcons } from 'bootstrap-vue'

Vue.use(VueRangeSlider);
Vue.use(BootstrapVueIcons);

Vue.prototype.$date_options_long = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
Vue.prototype.$date_options_short = { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric' };


//Load user data
store.commit('refreshUser');
store.commit('getData');

const app = new Vue({
    store,
    router,
    components: {
        'navbar': NavBar,
        'spinner' : Spinner,
    },
    el: '#app',
});
