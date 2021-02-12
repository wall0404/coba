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
import Profile_Edit from "../components/Pages/Profile_Edit";
import Page_SignUp from "../components/Pages/Auth/Page_SignUp";
import Page_TeamMember from "../components/Pages/Page_TeamMember";
import Page_Inbox from "../components/Pages/Page_Inbox";
import Page_Settings from "../components/Pages/Book/Page_Settings";
import Page_FastBookingConfirmation from "../components/Pages/Book/Page_FastBookingConfirmation";
import Page_HomeofficeDateTimeSelection from "../components/Pages/Book/Page_HomeofficeDateTimeSelection";

const routes = [
    { path: '/login', name: "Login", component: Page_Login },
    { path: '/logout', name: "Logout", component: Page_Logout },
    { path: '/signup', name: "SignUp", component: Page_SignUp },
    { path: '/', name: "Home", component: Page_Home, meta:{auth:true} },
    { path: '/home', name: "Home", component: Page_Home, meta:{auth:true} },
    { path:'/settings', name: "Settings", component: Page_Settings, meta:{auth:true} },
    { path:'/inbox', name: "Inbox", component: Page_Inbox, meta:{auth:true} },
    { path: '/team', name: "Team", component: Page_Team, meta:{auth:true} },
    { path: '/team/:TeamMember_ID', name: "TeamMember", component: Page_TeamMember, meta:{auth:true} },
    { path: '/calendar', name: "Calendar", component: Page_Calendar, meta:{auth:true} },
    { path: '/profile', name: "Profile", component: Page_Profile, meta:{auth:true} },
    { path: '/booking/:id', component: Page_Booking, meta:{auth:true} },
    { path: '/booking/new/location', component: Page_LocationSelection, meta:{auth:true} },
    { path: '/booking/new/homeoffice', component: Page_HomeofficeDateTimeSelection, meta:{auth:true} },
    { path: '/booking/new/workstation/:location_id', component: Page_WorkstationSelection, meta:{auth:true} },
    { path: '/booking/new/date/:workstation_id', name: "DateTimeSelection", props: true, component: Page_DateTimeSelection, meta:{auth:true} },
    { path: '/booking/new/confirmation', name: "BookingConfirmation", props: true, component: Page_BookingConfirmation, meta:{auth:true} },
    { path: '/booking/new/fastbooking/:location_id', name: "FastBookingConfirmation", props: true, component: Page_FastBookingConfirmation, meta:{auth:true}},
    { path: '/booking/new/checkout', name: "BookingCheckout", props: true, component: Page_BookingCheckout, meta:{auth:true} },
    { path: '/profile/settings', component: Profile_Edit, meta:{auth:true} },
    { path: '*', component: error404},
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
