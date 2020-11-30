import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const error404 = { template: '<div>Diese Seite ist noch nicht eingebaut</div>'}
const Dashboard = { template: '<div>Startseite. Diese Seite ist noch nicht eingebaut. Nachher findet man hier die wichtigsten Informationen auf den ersten Blick</div>'}


/*import Help from '.././components/Other/Help'
import LoginPage from '.././components/Auth/Login'
import LogoutPage from '.././components/Auth/Logout'*/
import Page_Home from "../components/Pages/Page_Home";
import Page_Calendar from "../components/Pages/Page_Calendar";
import Page_Profile from "../components/Pages/Page_Profile";
import Page_Team from "../components/Pages/Page_Team";
import Page_Login from "../components/Pages/Auth/Page_Login";
import Page_Logout from "../components/Pages/Auth/Page_Logout";
import Page_Landing from "../components/Pages/Page_Landing";

const routes = [
    { path: '/', component: Page_Landing },
    { path: '/login', component: Page_Login },
    { path: '/logout', component: Page_Logout },
    { path: '/home', component: Page_Home, meta:{auth:true} },
    { path: '/team', component: Page_Team, meta:{auth:true} },
    { path: '/calendar', component: Page_Calendar, meta:{auth:true} },
    { path: '/profile', component: Page_Profile, meta:{auth:true} },
    { path: '*', component: error404}
]


const router = new VueRouter({
    hash: false,
    mode: 'history',
    routes
})

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.auth)) {
        if (localStorage.token == null) {
            next({ path: '/login'})
        } else {
            next()
        }
    } else {
        next()
    }
})


export {router};
