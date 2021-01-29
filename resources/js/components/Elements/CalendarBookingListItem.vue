<template>
    <div class="booking py-3" > <!-- :class="{'strong':user_id === $store.getters.data.user.user_id}" -->
        <div class="table-item seat">{{workstation.name}}</div>
        <!-- Anzeige der Buchungszeiten -->
        <div class="table-item time">
            <div v-if="bookings_workstation.length==0"> <!-- Keine Buchung für die Workstation -->
                {{time}}
            </div>
            <div v-else v-for="booking in bookings_workstation">
               {{booking.from.substring(0,5)}} - {{booking.to.substring(0,5)}}<br>
             </div>
        </div>

        <!-- Anzeige der Person, die den Platz gebucht hat -->
        <div class="table-item name">
            <div v-if="user_booking_list==0"></div>
            <div v-else v-for="user in user_booking_list">
                <router-link v-if="user.user_id==$store.getters.data.user.user_id" :to="'/profile'">meins</router-link> <!-- Weiterleitung zum eigenen Profil -->
                <router-link v-else :to="'/team/'+user.user_id">{{user.firstName}} {{user.lastName.substring(0,1)}}.</router-link> <!-- Weiterleitung zum Profil des Teammitglieds -->
            </div>
        </div>

        <div class="table-item icon"><b-icon v-if="false" icon="star-fill" font-scale="0.75"></b-icon></div>

        <!-- Anzeige der Buchungsbutton wenn Buchung von einem anderem User ist-->
        <!--<div class="table-item icon">
            <div v-for="booking in bookings_workstation">

                <router-link class="coba-utilization-indicator" v-if="bookings_workstation.length==0"
                             :class="{'coba-utilization-indicator-green':color==='green', 'coba-utilization-indicator-disabled':this.today.setHours(0,0,0,0) > new Date(date).setHours(0,0,0,0)
                                }"
                             :to="{ name: 'DateTimeSelection', params: { workstation_id:workstation.id, preSelectedDays: [dayObj], calenderBool: true }}">
                    <b-icon icon="plus"></b-icon>
                </router-link>

                <router-link class="coba-utilization-indicator" v-else-if="booking.user_id !== $store.getters.data.user.user_id"
                             :class="{'coba-utilization-indicator-red':color==='red',
                                'coba-utilization-indicator-green':color==='green',
                                'coba-utilization-indicator-orange':color==='orange',
                                'coba-utilization-indicator-disabled':this.today.setHours(0,0,0,0) > new Date(date).setHours(0,0,0,0)
                                }"
                             :to="{ name: 'DateTimeSelection', params: { workstation_id:workstation.id, preSelectedDays: [dayObj], calenderBool: true }}">
                    <b-icon icon="plus"></b-icon>
                </router-link>

                <router-link v-else
                             v-bind:to="'/booking/'+booking.id">
                    <b-icon icon="pencil"></b-icon>
                </router-link>
            </div>
        </div>-->



        <router-link class="table-item icon coba-utilization-indicator" v-if="user_id !== $store.getters.data.user.user_id"
                     :class="{'coba-utilization-indicator-red':color==='red',
                                'coba-utilization-indicator-green':color==='green',
                                'coba-utilization-indicator-orange':color==='orange',
                                'coba-utilization-indicator-disabled':this.today.setHours(0,0,0,0) > new Date(date).setHours(0,0,0,0)
                                }"
                     :to="{ name: 'DateTimeSelection', params: { workstation_id:workstation.id, preSelectedDays: [dayObj], calenderBool: true }}">
            <b-icon icon="plus"></b-icon>
        </router-link>

        <router-link class="table-item icon" v-else
                     v-bind:to="'/booking/'+bookings_workstation.id">
            <b-icon icon="pencil"></b-icon>
        </router-link>
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
            user_booking_list: null, //Enthält die User, die eine Buchung für die Workingstation getätigt haben
            bookings_workstation: null, //Enthält die Buchungen für die Workingstation
            color: "green",
            today: new Date(),
            dayObj: {
                date: new Date(this.date)
            }
        }
    },
    created() {
        //Alle Buchungen für diese Workstation abspeichern
        let bookings_for_this_workstation = [];
        for(let i = 0; i < this.bookings.length; i++) {
            if(this.bookings[i].workstation_id === this.workstation.id) {
                bookings_for_this_workstation.push(this.bookings[i]);
            }
        }
        //Buchungen nach aufsteigend nach der Uhrzeit sortieren
        this.bookings_workstation = bookings_for_this_workstation.sort((a,b) => (a.from > b.from) ? 1 : -1);

        //Users abspeichern, die die Buchungen getätigt haben
        let user_booking_workstation_list = [];
        for(let i = 0; i < this.bookings_workstation.length; i++) {
            for(let j = 0; j < this.users.length; j++){
                if(this.users[j].user_id === this.bookings_workstation[i].user_id) {
                    user_booking_workstation_list.push(this.users[j]);
                }
            }
        }
        this.user_booking_list = user_booking_workstation_list;

        this.calcInfo(bookings_for_this_workstation);
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
            let user = this.users.find(x => x.user_id === bookings[0].user_id);
            //this.bookings_workstation = bookings[0];
            this.user_id = user.user_id;
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
    width: 13%;
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
