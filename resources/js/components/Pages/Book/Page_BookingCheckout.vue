<template>
    <div class="coba-page coba-page-no-header">
        <div v-if="session_expired">
            <div class="coba-headline mb-4">Die Sitzung ist abgelaufen</div>
            <a @click="$router.go(-1)">Zurück</a>
        </div>
        <div v-else>
            <spinner v-if="load"></spinner>
            <div v-else>
                <div v-if="error.length === 0">
                    <span class="coba-text coba-text-very-big">Ihre Buchung wurde eingetragen</span>
                </div>
                <div v-else>
                    <booking v-for="(booking, index) in success"  :booking="booking" color="true" :key="index"></booking>
                    <booking v-for="(booking, index) in error"  :booking="booking" color="true" :key="index"></booking>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Spinner from "../../Global/Spinner";
import Booking from "../../ListItems/Booking";
export default {
    components: {Booking, Spinner},
    props: ['bookings'],
    name: "Page_BookingCheckout",
    data() {
        return {
            session_expired: false,
            load: false,
            error: [],
            success: [],
        }
    },
    created() {
        if(typeof this.bookings === 'undefined') {
            this.session_expired = true;
        }
        else {
            this.makeBooking();
        }
    },
    methods: {
        makeBooking() {
            this.load = true;
            let bookings = [];

            for(let booking_index in this.bookings) {
                bookings.push({
                    date: this.bookings[booking_index].date.toISOString().slice(0, 10),
                    from: this.bookings[booking_index].from,
                    to: this.bookings[booking_index].to,
                    workstation_id: this.bookings[booking_index].workstation.id,
                    user_id: this.$store.getters.data.user.user_id,
                });
            }

            //send request
            this.load = true;
            fetch('/api/booking', {
                method: 'POST',
                body: JSON.stringify(bookings),
                headers: {
                    'content-type': 'application/json',
                    'Authorization' : 'Bearer '+localStorage.token
                }
            })
                .then(res => res.json())
                .then(res => {
                    this.load = false;
                    this.error = res.error;
                    this.success = res.success;
                    console.log(this.error)
                    console.log(this.error.length);
                })
                .catch(error => {
                    console.log(error);
                    this.load = false;
                })
        }
    }
}
</script>

<style scoped>

</style>
