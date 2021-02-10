<template>
    <div class="booking-list-container mt-1">
        <spinner v-if="loadUsers || loadBookings"></spinner> <!-- Ladesymbol während Seite Daten aufruft -->
        <div v-else  class="coba-full-width">
            <div>
                <div class="section-headline p-2 px-3">Favoriten</div>
                <div class="booking-list px-3">
                    <span v-for="location in $store.getters.locations" v-if="selectedLocations.find(id => id === location.id)">
                        <calendar-booking-list-item v-if="workstation.isFavorite" v-for="(workstation, index) in location.workstations" :key="index" :users="users" :workstation="workstation" :bookings="bookings" :date="date" :user_id="$store.getters.data.user.user_id"></calendar-booking-list-item>
                    </span>
                </div>
            </div>
            <div v-for="location in $store.getters.locations" v-if="selectedLocations.find(id => id === location.id)">
                <div class="section-headline p-2 px-3">{{location.name}}</div>
                <div class="booking-list px-3">
                    <calendar-booking-list-item v-for="(workstation, index) in location.workstations" :key="index" :users="users" :workstation="workstation" :bookings="bookings" :date="date" :user_id="$store.getters.data.user.user_id"></calendar-booking-list-item>
                </div>
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
    props: ['selectedLocations'],
    data() {
        return {
            bookings: [],
            users: [],
            loadBookings: true,
            loadUsers: false,
            error: null,
            date: null,
        }
    },
    created() {
        this.date = new Date().toISOString().slice(0, 10)
        this.fetchBookingsForDate(this.date)
        this.fetchUsers();
    },
    methods: {
        fetchBookingsForDate(date) {
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

        }
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
        background-color: orange;
        font-weight: bold;
    }
    .booking-list {

    }

</style>
