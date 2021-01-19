<template>
    <div class="coba-page">
        <div class="coba-container coba-flex coba-header">
            <span class="coba-page-headline">Buchung</span>
        </div>
        <div v-if="!load">
            <div class="coba-container">
                <DayPicker :workstation="workstation" :bookings="bookings" @callback-picker-event="callbackPicker" :pre-selected-date-str="preSelectedDateStr"></DayPicker>
            </div>
            <div class="coba-container">
                <TimePicker v-for="(day,index) in days" :key="index" :day="day"></TimePicker>
            </div>
            <div class="coba-container">
                <button class="coba-button" @click="submit" :disabled="days.length===0">Buchen</button>
            </div>
        </div>
        <spinner v-else></spinner>
    </div>
</template>

<script>
import Spinner from "../../Global/Spinner";
import DayPicker from "../../Elements/DayPicker";
import TimePicker from "../../Elements/TimePicker";

export default {
    name: "Page_DateTimeSelection",
    props: ["bookings", 'preSelectedDateStr'],
    components: {TimePicker, DayPicker, Spinner},
    data() {
        return {
            workstation: {},
            load: false,
            error: false,
            days: [],
        }
    },
    created() {
        if(typeof this.bookings === 'undefined') {
            //fetch Data
            this.fetchData();
        }
        else
            localStorage.setItem("bookings_" + this.$route.params.workstation_id, JSON.stringify(this.bookings));

        this.fetchWorkstation();
    },
    methods: {
        fetchData() {
            this.load = true;
            let date = new Date();
            let today_date = date.toISOString().slice(0, 10); //cuts off the time: only date
            date.setDate(new Date().getDate() + 7);
            let date_in_7_days = date.toISOString().slice(0, 10);
            fetch('/api/booking?filter[date][min]='+today_date+'&filter[workstation_id]='+this.$route.params.workstation_id, {
                method: 'GET',
                headers: {
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
            this.bookings = {};

            //For every Booking
            for (let k = 0; k<data.length; k++) {
                try {
                    this.bookings[data[k].date].push(data[k])
                }
                catch (e) {
                    this.bookings[data[k].date] = []
                    this.bookings[data[k].date].push(data[k])
                }
            }
        },
        fetchWorkstation() {
            let locations = this.$store.getters.locations;
            for(let location in locations) {
                for (let workstation in locations[location].workstations) {
                    if(locations[location].workstations[workstation].id == this.$route.params.workstation_id) {
                        this.workstation = locations[location].workstations[workstation];
                        break;
                    }
                }
            }
        },
        callbackPicker(day) {
            if (day.selected)
                this.days.push(day);
            else {
                for (let day_index in this.days) {
                    if(this.days[day_index].date === day.date){
                        this.days.splice(day_index, 1);
                        break;
                    }
                }
            }
        },
        submit() {
            //go to confirmation
            let days = this.days;
            this.$router.push({
                name: 'BookingConfirmation',
                params: {
                    bookings: this.days
                }
            })
        }
    }
}
</script>

<style scoped>

</style>
