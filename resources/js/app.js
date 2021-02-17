window.Vue = require('vue');



import {router} from './_helpers/router';
import {store} from './_helpers/store';
import NavBar from './components/Navbar'
import Spinner from './components/Global/Spinner'
import BackButton from "./components/Global/BackButton";
import VueRangeSlider from 'vue-range-component'
import { BootstrapVue, BootstrapVueIcons } from 'bootstrap-vue'
import VueClipboard from 'vue-clipboard2'
import { Doughnut } from 'vue-chartjs'

Vue.use(BootstrapVueIcons);
Vue.use(BootstrapVue);
Vue.use(VueRangeSlider);
Vue.use(VueClipboard);
Vue.use(Doughnut)

Vue.prototype.$date_options_long = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
Vue.prototype.$date_options_short = { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric' };
Vue.prototype.$only_month_and_year = { year: 'numeric', month: 'long' };
Vue.prototype.$date_options_without_year = { weekday: 'long', month: 'numeric', day: 'numeric' };


//Load user data
store.commit('refreshUser');
store.commit('getData');

Vue.prototype.$pushToLogin = () => {
    router.push("/login");
}

const app = new Vue({
    store,
    router,
    components: {
        'navbar': NavBar,
        'spinner' : Spinner,
        'backButton' : BackButton,
    },
    el: '#app',
});
