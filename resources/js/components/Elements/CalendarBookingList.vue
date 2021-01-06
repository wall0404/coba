<template>
    <div class="booking-list-container mt-1">
        <spinner v-if="loadUsers || loadBookings"></spinner>
        <div v-else  class="coba-full-width">
            <div v-for="location in $store.getters.locations">
                <div class="section-headline p-2 px-3">{{location.name}}</div>
                <div class="booking-list px-3">
                    <calendar-booking-list-item v-for="(workstation, index) in location.workstations" :key="index" :users="users" :workstation="workstation" :bookings="bookings"></calendar-booking-list-item>
                    <!--<div class="booking py-3" v-for="n in 2">
                        <div class="table-item seat">C{{n}}</div>
                        <div class="table-item time">16.00 - 18.00</div>
                        <div class="table-item name">Oliver K</div>
                        <div class="table-item icon"><b-icon v-if="n===2" icon="star-fill" font-scale="0.75"></b-icon></div>
                        <div class="table-item icon coba-utilization-indicator coba-utilization-indicator-orange"><b-icon icon="plus"></b-icon></div>
                    </div>
                    <div class="booking py-3">
                        <div class="table-item seat">C4</div>
                        <div class="table-item time">-</div>
                        <div class="table-item name"></div>
                        <div class="table-item icon"></div>
                        <div class="table-item icon coba-utilization-indicator coba-utilization-indicator-green"><b-icon icon="plus"></b-icon></div>
                    </div>
                    <div class="booking py-3 strong">
                        <div class="table-item seat">C5</div>
                        <div class="table-item time">9.00 - 17.00</div>
                        <div class="table-item name">Sebastian S.</div>
                        <div class="table-item icon"></div>
                        <div class="table-item icon coba-utilization-indicator coba-utilization-indicator-red"><b-icon icon="plus"></b-icon></div>
                    </div>-->
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
    //props: ['selectedLocations'],
    data() {
        return {
            selectedLocations: [1],
            bookings: [],
            users: [],
            loadBookings: false,
            loadUsers: false,
            error: null,
        }
    },
    created() {
        this.fetchUsers();
        this.fetchBookingsForDate(new Date());
    },
    methods: {
        fetchBookingsForDate(date) {
            this.loadBookings = true;
            fetch('/api/booking?order_by=date&filter[date][min]='+date.toISOString().slice(0, 10)+'&filter[date][max]='+date.toISOString().slice(0, 10), {
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
