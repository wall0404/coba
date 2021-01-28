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
                <booking> v-for="(booking, index) in bookings" :booking="booking" :key="index"></booking>
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
    name: "Page_FastBookingConfirmation.vue",
    components: {Booking},
    data() {
        return {
            load: false,
            error: false,
            location_id: this.$route.params.location_id,
            today_date: "",
            tomorrow_date:"",
            booking: "",
            random: "",
        }
    },
    created() {
        let date = new Date();
        this.today_date = date.toISOString().slice(0, 10); //cuts off the time: only date
        date.setDate(new Date().getDate() + 1);
        this.tomorrow_date = date.toISOString().slice(0, 10);
        this.fetchData();
        for (var i = 0; i < this.$store.getters.locations.length; i++) {
            if(this.$store.getters.locations[i].id == this.location_id)
                this.location_name = this.$store.getters.locations[i].name
        }
    },
    methods:{
        fetchData() {
            this.load = true;
            fetch('/api/booking?filter[date][min]='+this.today_date+'&filter[location_id]='+this.location_id, {
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
                        this.colorIndicators();
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
