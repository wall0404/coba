<template>
    <div class="coba-page coba-homescreen">
        <div class="coba-container coba-header">
            <h1 v-if="this.prevRoute.path.includes('/signup')" class="coba-page-headline">Willkommen bei TAS,<br>{{$store.getters.data.user.firstName}}</h1>
            <h1 v-else class="coba-page-headline">Willkommen zurück,<br>{{$store.getters.data.user.firstName}}</h1>
        </div>
        <div class="coba-home-icons-container">
            <!-- this section is the part in home that contains the two icons settings and inbox!-->
            <router-link to="/settings">
                <b-icon class="coba-home-icons" icon="gear" font-scale=1.7></b-icon>
            </router-link>
            <router-link to="/inbox">
                <b-icon class="coba-home-icons" icon="inbox-fill" font-scale="1.7"></b-icon>
            </router-link>
        </div>
        <!-- Todays bookings -->
        <div  v-if="!load" class="coba-container coba-text-strong">
            <div v-if="bookings.find( element => element.date === today_date)" class="coba-text-big">Heute bist du in</div>
            <div v-else  class="coba-text-big">Keine Buchungen für heute</div>
            <ul class="coba-list">
                <li v-for="today_booking in bookings" v-if="today_booking.date === today_date">
                    <span v-if="typeof today_booking.workstation == 'object'&& today_booking.workstation !== null">
                        {{ today_booking.workstation.location.name }} {{today_booking.workstation.name}}, {{today_booking.from.substr(0,5)}} - {{today_booking.to.substr(0,5)}}
                    </span>
                    <span v-else>
                        Remote Work, {{today_booking.from.substr(0,5)}} - {{today_booking.to.substr(0,5)}}
                    </span>
                </li>
            </ul>
        </div>
        <spinner v-else></spinner>
        <div class="coba-container coba-flex-right coba-book-button"> <!-- Button zur Sitzplatzbuchung -->
            <span class="coba-text-very-big">Platz buchen</span>
            <button class="coba-button coba-button-round coba-button-normal coba-button-accent coba-button-distance-left-10 coba-button-no-border"><router-link to="/booking/new/location"><b-icon icon="arrow-return-right" flip-v font-scale="1"></b-icon></router-link></button>
        </div>
        <!-- all other bookings -->
        <div class="coba-container">
            <span class="coba-text-big">Kommende Buchungen:</span>
        </div>
        <div class="coba-container coba-full-width coba-footer-container"> <!-- Auflistung der kommenden Buchungen -->
            <ul class="coba-list" v-if="!load">
                <li class="coba-container position-relative" style="display: flex;" v-for="booking in bookings" :key="booking.id">
                    <span v-if="typeof booking.workstation == 'object'&& booking.workstation !== null" style="width: 83%">{{makeDateToDateString(booking.date)}}, <br>{{ booking.workstation.location.name }}, {{booking.workstation.name}}, {{booking.from.substr(0,5)}} - {{booking.to.substr(0,5)}} <!-- the booking information --></span>
                    <span v-else style="width: 83%">{{makeDateToDateString(booking.date)}}, <br>Homeoffice, {{booking.from.substr(0,5)}} - {{booking.to.substr(0,5)}} <!-- the booking information when you have booked a homeoffice  --></span>
                    <edit-tool class="table-item" :openDD="dropDown.open" :booking="booking" :colorBack="colorBack" @modal-close-event="toggleDropDown(booking)" @modal-delete-event="delBookingfkn(booking.id)"> </edit-tool>
                </li>
            </ul>
            <spinner v-else></spinner>
        </div>
    </div>
</template>

<script>
import Spinner from "../Global/Spinner";
import Modal from "../Elements/Modal";
import EditTool from "../Elements/EditTool";

export default {
    name: "Page_Home",
    components: {EditTool, Modal, Spinner},
    data() {
        return {
            load: false,
            error: false,
            bookings: [],
            today_date: new Date().toISOString().slice(0, 10),
            dropDown: {
                id: "",
                open: false
            },
            colorBack: "white",
            prevRoute: {path: ""},
        }
    },
    created() {
        this.fetchData();
    },
    methods: {
        fetchData() {
            this.load = true;
            fetch('/api/user/'+this.$store.getters.data.user.user_id+'/bookings?order_by=date&filter[date][min]='+this.today_date, {
                method: 'GET',
                headers: {
                    'content-type': 'application/json',
                    'Authorization' : 'Bearer '+localStorage.token
                }
            })
                .then(res => res.json())
                .then(res => {
                    if(res.success) {
                        this.bookings = res.success;
                        this.load = false;
                    }
                    else {
                        this.error = true;
                        this.load = false;
                    }
                })
                .catch(error => {
                    console.log(error);
                    this.load = false;
                })
        },
        makeDateToDateString(dateStr){
            return  new Date(dateStr).toLocaleDateString('de-DE', this.$date_options_without_year);
        },
        toggleDropDown(booking){
            this.dropDown.open = !this.dropDown.open;
            this.dropDown.id = booking.id;
        },
        delBookingfkn(bookingID){
            var i =0;
            while (this.bookings[i].id !== bookingID){
                i++;
            }
            this.bookings.splice(i,1);
        },
    }
}
</script>

<style scoped>
.coba-book-button {
    padding: 0 20px;
}
.table-item{
    display: flex;
    flex-direction: column;
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
    justify-content: center;
    align-items: center;
    width: 13%;
    overflow: inherit;
}
</style>
