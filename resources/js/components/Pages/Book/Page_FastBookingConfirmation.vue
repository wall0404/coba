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
                <booking> booking></booking>
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
    props:['location_id', 'date'],
    name: "Page_FastBookingConfirmation.vue",
    components: {Booking},
    data() {
        return {
            load: false,
            error: false,
            location_id: this.$route.params.location_id,
            location_name: "",
            date: new Date(),
            booking:{
                date: this.today_date = date.toISOString().slice(0, 10),
                from: "09:00",
                to: "17:00",
                workstation: {
                    name: "",
                    location: {
                        name: "",
                    },

                },
                error: false,
            },
        }
    },
    created() {
        //sagt ob der heutige Tag oder der morgige betrachtet werden soll
        var hour = this.date.getHours(); //TODO UTCHours or Hours?
        if (hour >= 16){ //if its later than 16:00 the date will be tomorrows date
            this.date.setDate(new Date().getDate + 1);
        }
        for (var i = 0; i < this.$store.getters.locations.length; i++) {
            if(this.$store.getters.locations[i].id == this.location_id)
                this.location_name = this.$store.getters.locations[i].name
        }
        if(typeof this.bookings === 'undefined') {
            this.bookings = JSON.parse(localStorage.getItem("confirmation_bookings"))
            if(this.bookings == null)
                this.error = "Ein Fehler ist aufgetreten. Keine Buchungen zur Bestätigung gefunden.";
            else {
                for(let booking in this.bookings) {
                    this.bookings[booking].date = new Date(this.bookings[booking].date)
                }
            }
        }
        else
            localStorage.setItem("confirmation_bookings", JSON.stringify(this.bookings));

        for(let booking in this.bookings) {
            this.bookings[booking].from = (this.bookings[booking].time[0]<10?"0":"")+Math.round(this.bookings[booking].time[0]-0.1)+":"+(this.bookings[booking].time[0]%1===0?'00':'30');
            this.bookings[booking].to = (this.bookings[booking].time[1]<10?"0":"")+Math.round(this.bookings[booking].time[1]-0.1)+":"+(this.bookings[booking].time[1]%1===0?'00':'30');
        }
    },
    methods: {
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
