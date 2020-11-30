import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const error404 = { template: '<div>Diese Seite ist noch nicht eingebaut</div>'}
const LandingPage = { template: '<div>Landing page. nothing here yet</div>'}
const Dashboard = { template: '<div>Startseite. Diese Seite ist noch nicht eingebaut. Nachher findet man hier die wichtigsten Informationen auf den ersten Blick</div>'}


/*import Help from '.././components/Other/Help'
import LoginPage from '.././components/Auth/Login'
import LogoutPage from '.././components/Auth/Logout'*/
import Page_Home from "../components/Pages/Page_Home";
import Page_Calendar from "../components/Pages/Page_Calendar";
import Page_Profile from "../components/Pages/Page_Profile";
import Page_Team from "../components/Pages/Page_Team";

const routes = [
    { path: '/', component: LandingPage },
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
        //TODO import check auth
        next()
        /*if (localStorage.token == null) {
            next({ path: '/login'})
        } else {
            next()
        }*/
    } else {
        next()
    }
})


export {router};
