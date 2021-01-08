<template>
    <div class="coba-page">
        <div class="coba-container coba-flex coba-header">
            <span class="coba-page-headline">Bestätigung</span>
        </div>
        <div v-if="!error">
            <div class="coba-container">
                <div class="coba-headline">Buchungsübersicht</div>
            </div>
            <div class="coba-container">
                <booking v-for="(booking, index) in bookings" :booking="booking" :key="index"></booking>
            </div>
            <div class="coba-container">
                <button class="coba-button coba-button-accent" @click="submit">Bestätigen</button>
            </div>
        </div>
        <div v-else class="coba-container">
            <div class="coba-text-danger">{{error}}</div>
        </div>


        <div class="back-button">
            <a @click="$router.go(-1)">
                <div data-v-1febfe86="" class="coba-utilization-indicator coba-utilization-indicator-arrow-prev coba-utilization-indicator-big coba-utilization-indicator-disabled">➤</div>
            </a>
        </div>
    </div>
</template>

<script>
import Booking from "../../ListItems/Booking";
export default {
    components: {Booking},
    props: ['bookings'],
    name: "Page_BookingConfirmation",
    data() {
        return {
            error: null
        }
    },
    created() {
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
                    bookings: this.bookings
                }
            })
        }
    }
}
</script>

<style scoped>
.back-button{

    position: fixed;
    top: 20px;
    left: 40px;
    font-size: 35px;
}
</style>
