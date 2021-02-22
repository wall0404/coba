<template>
    <div class="coba-page">
        <div class="coba-container coba-flex coba-header">
            <span class="coba-page-headline">Bestätigung</span>
        </div>
        <div v-if="!load">
            <div class="coba-container">
                <div class="coba-headline">Buchungsübersicht</div>
                <div style="text-align: center"> Bist du einverstanden mit dieser Buchung?</div>
            </div>
            <div class="coba-container">
                <booking :booking="booking" :color="booking.error"></booking>
            </div>
            <div class="coba-container">
                <button class="coba-button coba-button-accent" @click="submit">Bestätigen</button>
                <router-link class="coba-button" to="/"> Abbrechen</router-link>
            </div>
        </div>
        <spinner v-else></spinner>
    </div>
</template>

<script>
import Booking from "../../ListItems/Booking";
import Spinner from "../../Global/Spinner";
export default {
    props:[],
    name: "Page_FastBookingConfirmation.vue",
    components: {Spinner, Booking},
    data() {
        return {
            load: false,
            error: false,
            chosenDate: "",
            location_id: this.$route.params.location_id,
            booking: {
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
            console.log(new Date());
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
            this.load = true;
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
                    if(res != null) {
                        //this.formatBookings(res);
                        this.booking=res;
                        /*this.day=res;
                        this.booking.date.toISOString();
                        this.booking.date = new Date(this.booking.date);
                        this.booking.workstation.id = this.booking.workstation_id;
                        console.log(this.booking.date);
                        console.log(this.day);*/
                        if(this.booking.workstation_id==null){
                            this.booking.workstation = {
                                name: "Remote Work",
                                location:{
                                }
                            }
                            this.booking.error=true;
                        }
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
        submit() {
            this.$router.push({
                name: 'BookingCheckout',
                params: {
                    bookings: [this.booking],
                    calenderBool: this.calenderBool
                }
            })
        }
    }
}
</script>

<style scoped>
</style>
