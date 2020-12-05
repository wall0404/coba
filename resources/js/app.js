window.Vue = require('vue');



import {router} from './_helpers/router';
import {store} from './_helpers/store';
import NavBar from './components/Navbar'
import Spinner from './components/Global/Spinner'
import VueRangeSlider from 'vue-range-component'

Vue.use(VueRangeSlider);

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
