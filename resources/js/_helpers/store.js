import Vuex from "vuex";
import Vue from "vue";


Vue.use(Vuex)

export const store = new Vuex.Store({
    state: {
        data: null,
    },
    mutations: {
        refreshUser (state) {
            fetch('/api/details', {
                method: 'GET',
                headers: {
                    'content-type': 'application/json',
                    'Authorization' : 'Bearer '+localStorage.token
                }
            })
                .then(res => res.json())
                .then(res => {
                    state.data = res.success;
                    console.log(state.data.user);
                })
                .catch(error => {
                    console.log(error);
                    state.data = null;
                    localStorage.removeItem('token')
                })

        },
        clearData (state) {
            state.data = null;
            localStorage.removeItem('token')
        },
        clearUser (state) {
            state.data.user = null;
            state.data.sidebar = null;
            localStorage.removeItem('token')
        }
    },
    getters: {
        data: state => state.data,
        check: state => state.data!=null
    }
});
