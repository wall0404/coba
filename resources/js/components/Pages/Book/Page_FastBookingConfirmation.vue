<template>
    <div class="coba-page">
        <div class="coba-container coba-flex coba-header">
            <span class="coba-page-headline">Bestätigung</span>
        </div>
        <div v-if="!error">
            <div class="coba-container">
                <div class="coba-headline">Buchungsübersicht</div>
                <div style="text-align: center"> Bist du einverstanden mit dieser Buchung?</div>
            </div>
            <div class="coba-container">
                <booking :booking="booking" ></booking>
            </div>
            <div class="coba-container">
                <button class="coba-button coba-button-accent" @click="submit">Bestätigen</button>
                <router-link class="coba-button" to="/"> Abbrechen</router-link>
            </div>
        </div>
        <div v-else class="coba-container">
            <div class="coba-text-danger">{{error}}</div>
        </div>
    </div>
</template>

<script>
import Booking from "../../ListItems/Booking";
export default {
    props:[],
    name: "Page_FastBookingConfirmation.vue",
    components: {Booking},
    data() {
        return {
            load: false,
            error: false,
            chosenDate: "",
            location_id: this.$route.params.location_id,
            location_name: "",
            booking: {
                date: "",
                from: "09:00",
                to: "17:00",
                user_id:"",
                workstation_id: "",
            },
        }
    },
    created() {
        //sagt ob der heutige Tag oder der morgige betrachtet werden soll
        let date = new Date();
        /* //entscheidet welcher Tag betrachtet werden soll (heute oder morgen)
        var hour = date.getHours(); //TODO UTCHours or Hours?
        if (hour >= 16){ //if its later than 16:00 the date will be tomorrows date
            date.setDate(new Date().getDate + 1);
        }
        */
        this.chosenDate= date.toISOString().slice(0,10);/*
        for (var i = 0; i < this.$store.getters.locations.length; i++) {
            if(this.$store.getters.locations[i].id == this.location_id)
                this.location_name = this.$store.getters.locations[i].name
        }*/
        if(typeof this.bookings === 'undefined') {
            //fetch Data
            this.fetchData();
        }
        else
            localStorage.setItem("confirmation_bookings", JSON.stringify(this.bookings));

        for(let booking in this.bookings) {
            this.bookings[booking].from = (this.bookings[booking].time[0]<10?"0":"")+Math.round(this.bookings[booking].time[0]-0.1)+":"+(this.bookings[booking].time[0]%1===0?'00':'30');
            this.bookings[booking].to = (this.bookings[booking].time[1]<10?"0":"")+Math.round(this.bookings[booking].time[1]-0.1)+":"+(this.bookings[booking].time[1]%1===0?'00':'30');
        }
    },
    methods: {
        fetchData(){
            fetch( '/api/booking/suggestion?date='+this.chosenDate+'&location_id='+this.location_id, {
            method: 'GET',
            headers: {
                //'Accept: application/json',
                'content-type': 'application/json',
                'Authorization' : 'Bearer '+localStorage.token
            }
        })
                .then(res => res.json())
                .then(res => {
                    if(res.success) {
                        this.formatBookings(res.success);
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
        formatBookings(data) {
            this.booking.user_id= data.user_id;
            this.booking.workstation_id =data.workstation_id;
            this.booking.date = data.date;
            this.booking.from = data.from;
            this.booking.to = data.from;
        },

        submit() {
            this.$router.push({
                name: 'BookingCheckout',
                params: {
                    bookings: this.bookings,
                    calenderBool: this.calenderBool
                }
            })
        }
    }
}
</script>

<style scoped>

</style>
