<template>
    <div class="booking-list-container mt-1">
        <spinner v-if="loadUsers || loadBookings"></spinner> <!-- Ladesymbol während Seite Daten aufruft -->
        <div v-else  class="coba-full-width">
            <div>
                <!-- shows the favorite workstations, but only when at least one location is selected-->
                <div class="section-headline p-2 px-3" v-if="selectFilter.fav">Favoriten</div>
                <div class="booking-list px-3">
                    <div v-if="selectFilter.fav && selectFilter.location[location.id]" v-for="location in $store.getters.locations">
                        <calendar-booking-list-item v-if="workstation.isFavorite" v-for="(workstation, index) in location.workstations"
                                                    :key="index" :users="users" :workstation="workstation" :bookings="bookings" :date="date" :selected-filter="selectFilter"
                                                    v-on:refresh-list="fetchBookingsForDate"></calendar-booking-list-item>
                    </div>
                </div>
                <!-- shows a list of workstations for the selected location(s) -->
                <div v-for="location in $store.getters.locations" v-if="selectFilter.location[location.id]">
                    <div class="section-headline p-2 px-3">{{location.name}}</div>
                    <div class="booking-list px-3">
                        <calendar-booking-list-item v-for="(workstation, index) in location.workstations" :key="index" :users="users"
                                                    :workstation="workstation" :bookings="bookings" :date="date" :selected-filter="selectFilter"
                                                    v-on:refresh-list="fetchBookingsForDate"></calendar-booking-list-item>
                    </div>
                </div>
                <!--homeoffice -->
                <div v-if="selectFilter.location['homeoffice']">
                    <div class="section-headline p-2 px-3">Remote Work</div>
                    <div class="calendar-text calendar-text-remote-work">Remote Work buchen</div>
                    <button class="coba-remote-work-button">
                        <router-link to="/booking/new/homeoffice"><b-icon icon="arrow-90deg-right" font-scale="0.75"></b-icon></router-link>
                    </button>
                </div>
                <!-- warning message for the user if no loction is selected -->
                <div v-if="selectFilter.nolo" class="calendar-text" > Du hast noch keinen Standort ausgewählt</div>
          </div>
        </div>
    </div>
</template>

<script>
import Spinner from "../Global/Spinner";
import CalendarBookingListItem from "./CalendarBookingListItem";
export default {
    name: "CalendarBookingList",
    components: {CalendarBookingListItem, Spinner},
    props: ['selectFilter'],
    data() {
        return {
            bookings: [],
            users: [],
            loadBookings: true,
            loadUsers: false,
            error: null,
            date: null,
            dayObj: {
                date: new Date(this.date)
            }
        }
    },
    created() {
        this.date = new Date().toISOString().slice(0, 10)
        this.fetchBookingsForDate(this.date)
        this.fetchUsers();
    },
    methods: {
        fetchBookingsForDate(date) {
            if(typeof date !== 'undefined')
                this.date = date;
            this.loadBookings = true;
            fetch('/api/booking?order_by=date&filter[date][min]='+date+'&filter[date][max]='+date, {
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
                        this.loadBookings = false;
                    }
                    else {
                        this.error = true;
                        this.loadBookings = false;
                    }
                })
                .catch(error => {
                    console.log(error);
                    this.loadBookings = false;
                })

        },

        fetchUsers() {
            this.loadUsers = true;
            fetch('/api/user', {
                method: 'GET',
                headers: {
                    'content-type': 'application/json',
                    'Authorization' : 'Bearer '+localStorage.token
                }
            })
                .then(res => res.json())
                .then(res => {
                    if(res.success) {
                        this.users = res.success;
                        this.loadUsers = false;
                    }
                    else {
                        this.error = true;
                        this.loadUsers = false;
                    }
                })
                .catch(error => {
                    console.log(error);
                    this.loadUsers = false;
                })
        },

    }
}
</script>

<style scoped>
    .booking-list-container {
        border-top: 2px solid darkgray;
        width: 100%;
        overflow-x: scroll;
    }
    .section-headline {
        background-color: #FEEF00;
        font-weight: bold;
    }
    .booking-list {

    }

</style>
