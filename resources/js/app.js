window.Vue = require('vue');

Vue.component('example-component', require('./components/ExampleComponent.vue').default);


import NavBar from './components/Navbar'
import {router} from './_helpers/router';
import {store} from './_helpers/store';
import Spinner from './components/Global/Spinner'


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
