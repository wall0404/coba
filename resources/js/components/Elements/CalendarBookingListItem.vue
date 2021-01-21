<template>
    <div class="booking py-3" :class="{'strong':user_id === $store.getters.data.user.user_id}">
        <div v-if="workstation.name===null" class="table-item seat">H</div>
        <div v-else class="table-item seat">{{workstation.name}}</div>
        <div class="table-item time">{{ time }}</div>
        <router-link class="table-item name" :to="'/team/'+user_id">{{ name }}</router-link>
        <div class="table-item icon"><b-icon v-if="false" icon="star-fill" font-scale="0.75"></b-icon></div>
        <router-link class="table-item icon coba-utilization-indicator" v-if="user_id !== $store.getters.data.user.user_id"
                     :class="{'coba-utilization-indicator-red':color==='red',
                                'coba-utilization-indicator-green':color==='green',
                                'coba-utilization-indicator-orange':color==='orange',
                                'coba-utilization-indicator-disabled':this.today.setHours(0,0,0,0) > new Date(date).setHours(0,0,0,0)
                                }"
                     :to="{ name: 'DateTimeSelection', params: { workstation_id:workstation.id, preSelectedDays: [dayObj] }}">
            <b-icon icon="plus"></b-icon>
        </router-link>
        <router-link class="table-item icon" v-else
                     v-bind:to="'/booking/'+booking.id">
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
            booking: null,
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
            let user = this.users.find(x => x.user_id === bookings[0].user_id);
            this.booking = bookings[0];
            this.user_id = user.user_id;
            this.name = user.firstName + " " + user.lastName;
            this.time = (startBooking.from.substr(0,5) +" - " + endBooking.to.substr(0,5));
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
