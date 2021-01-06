<template>
    <div class="coba-page">
        <div class="coba-container coba-flex coba-header">
            <span class="coba-page-headline">Buchung</span>
        </div>
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
            this.bookings = JSON.parse(localStorage.getItem("bookings_"+this.$route.params.workstation_id))
            if(this.bookings == null){
                console.error("Keine Buchungen wurden übergeben.")
                this.$router.push("/home")
            }
        }
        else
            localStorage.setItem("bookings_" + this.$route.params.workstation_id, JSON.stringify(this.bookings));

        this.fetchWorkstation();
        this.fetchData();
    },
    methods: {
        fetchData() {
            /*this.load = true;
            fetch('/api/workstation?filter[location_id]='+this.location_id, {
                method: 'GET',
                headers: {
                    'content-type': 'application/json',
                    'Authorization' : 'Bearer '+localStorage.token
                }
            })
                .then(res => res.json())
                .then(res => {
                    if(res.success) {
                        this.workstations = res.success;
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
                })*/
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
