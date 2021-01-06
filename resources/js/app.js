window.Vue = require('vue');



import {router} from './_helpers/router';
import {store} from './_helpers/store';
import NavBar from './components/Navbar'
import Spinner from './components/Global/Spinner'
import VueRangeSlider from 'vue-range-component'
import { BootstrapVueIcons } from 'bootstrap-vue'

Vue.use(BootstrapVueIcons);
Vue.use(VueRangeSlider);

Vue.prototype.$date_options_long = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
Vue.prototype.$date_options_short = { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric' };
Vue.prototype.$only_month_and_year = { year: 'numeric', month: 'long' };


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
