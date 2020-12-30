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
import Page_Booking from "../components/Pages/Book/Page_Booking";
import Page_LocationSelection from "../components/Pages/Book/Page_LocationSelection";
import Page_WorkstationSelection from "../components/Pages/Book/Page_WorkstationSelection";
import Page_DateTimeSelection from "../components/Pages/Book/Page_DateTimeSelection";
import Page_BookingConfirmation from "../components/Pages/Book/Page_BookingConfirmation";
import Page_BookingCheckout from "../components/Pages/Book/Page_BookingCheckout";
import Page_SignUp from "../components/Pages/Auth/Page_SignUp";
import Page_TeamMember from "../components/Pages/Page_TeamMember";

const routes = [
    { path: '/login', component: Page_Login },
    { path: '/logout', component: Page_Logout },
    { path: '/signup', component: Page_SignUp },
    { path: '/', component: Page_Home, meta:{auth:true} },
    { path: '/', component: Page_Login, meta:{auth:false} },
    { path: '/home', component: Page_Home, meta:{auth:true} },
    { path: '/team', component: Page_Team, meta:{auth:true} },
    { path: '/team/:TeamMember_ID', component: Page_TeamMember, meta:{auth:true} },
    { path: '/calendar', component: Page_Calendar, meta:{auth:true} },
    { path: '/profile', component: Page_Profile, meta:{auth:true} },
    { path: '/booking/:id', component: Page_Booking, meta:{auth:true} },
    { path: '/booking/new/location', component: Page_LocationSelection, meta:{auth:true} },
    { path: '/booking/new/workstation/:location_id', component: Page_WorkstationSelection, meta:{auth:true} },
    { path: '/booking/new/date/:workstation_id', name: "DateTimeSelection", props: true, component: Page_DateTimeSelection, meta:{auth:true} },
    { path: '/booking/new/confirmation', name: "BookingConfirmation", props: true, component: Page_BookingConfirmation, meta:{auth:true} },
    { path: '/booking/new/checkout', name: "BookingCheckout", props: true, component: Page_BookingCheckout, meta:{auth:true} },
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
