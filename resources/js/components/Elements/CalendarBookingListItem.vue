<template>
    <div class="booking py-3" :class="{'strong':user_id === $store.getters.data.user.user_id}">
        <div class="table-item seat">{{workstation.name}}</div>
        <div class="table-item time">
            <div v-for="booking in booking">
                {{booking.from.substring(0, 5)}} - {{booking.to.substring(0,5)}}
            </div><br>
        </div>
        <div class="table-item name"> <!-- Anzeige der Person, die den Platz gebucht hat -->
            <div v-if="booking.length == 0"></div>
            <div v-else>
                <div v-for="booking_user in booking_user">
                    <router-link :to="'/team/'+booking_user.user_id">{{booking_user.firstName}} {{booking_user.lastName}}</router-link>
                </div><br>
            </div>
        </div>
        <div class="table-item icon"><b-icon v-if="false" icon="star-fill" font-scale="0.75"></b-icon></div>
        <div>
            <div v-for="booking in booking"> <!-- Anzeige der Buchungsbutton wenn Buchung von einem anderem User ist -->
                <router-link class="table-item icon coba-utilization-indicator" v-if="booking.user_id !== $store.getters.data.user.user_id"
                             :class="{'coba-utilization-indicator-red':color==='red',
                                        'coba-utilization-indicator-green':color==='green',
                                        'coba-utilization-indicator-orange':color==='orange',
                                        'coba-utilization-indicator-disabled':this.today.setHours(0,0,0,0) > new Date(date).setHours(0,0,0,0)
                                        }"
                             :to="{ name: 'DateTimeSelection', params: { workstation_id:workstation.id, preSelectedDays: [dayObj], calenderBool: true }}">
                    <b-icon icon="plus"></b-icon>
                </router-link>
                <!-- Anzeige des Buchungsbutton wenn Buchung vom angemeldeten User ist -->
                <router-link class="table-item icon" v-else
                             v-bind:to="'/booking/'+booking.id">
                    <b-icon icon="pencil"></b-icon>
                </router-link>
            </div><br>
        </div>
    </div>
</template>

<script>
export default {
    name: "CalendarBookingListItem",
    props: ['workstation', 'bookings', 'users', 'date'],
    data() {
        return {
            time: "-",
            name: "",
            user_id: null,
            booking: null,
            booking_user: null,
            color: "green",
            today: new Date(),
            dayObj: {
                date: new Date(this.date)
            }
        }
    },
    created() {
        let bookings_for_this_workstation = [];
        for(let i = 0; i < this.bookings.length; i++) {
            if(this.bookings[i].workstation_id === this.workstation.id) {
                bookings_for_this_workstation.push(this.bookings[i]);
            }
        }

        let users_for_this_workstation = [];
        for(let i = 0; i < bookings_for_this_workstation.length; i++) {
            for(let j = 0; j < this.users.length; j++){
                if(bookings_for_this_workstation[i].user_id === this.users[j].user_id){
                    users_for_this_workstation.push(this.users[j]);
                }
            }
        }

        this.booking_user = users_for_this_workstation;
        this.booking = bookings_for_this_workstation;
        this.calcInfo(bookings_for_this_workstation)
    },
    methods: {
        calcInfo(bookings) {
            if(bookings.length < 1)
                return;

            let color = "";
            let hours = 0;
            let startHour = 24;
            let startBooking = null;
            let endHour = 0;
            let endBooking = null;
            for(let i = 0; i < bookings.length; i++) {
                hours += Number(bookings[i].to.substring(0,2)) - Number(bookings[i].from.substring(0,2));
                if(Number(bookings[i].to.substring(0,2))  > endHour) {
                    endHour = Number(bookings[i].to.substring(0, 2));
                    endBooking = bookings[i];
                }
                if(Number(bookings[i].from.substring(0,2))  < startHour) {
                    startHour = Number(bookings[i].from.substring(0, 2));
                    startBooking = bookings[i];
                }
            }
            if(hours >= 8)
                color = 'red'; //mark red
            else if(hours === 0)
                color = "green"; //mark green
            else
                color = "orange"; //mark orange


            this.color = color;
            //let user = this.users.find(x => x.user_id === bookings[0].user_id);
            //this.booking = bookings[0];
            //this.user_id = user.user_id;
            //this.name = user.firstName + " " + user.lastName;
            //this.time = (startBooking.from.substr(0,5) +" - " + endBooking.to.substr(0,5));
        },
    }
}
</script>

<style scoped>
.booking {
    display: flex;
}
.booking.strong {
    font-weight: bold;
}
.table-item {
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
}
.seat {
    width: 20%;
}
.time {
    width: 35%;
}
.name {
    width: 25%;
}
.icon {
    width: 10%;
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>
