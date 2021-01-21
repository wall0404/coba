<template>
    <div class="coba-page">
        <div class="coba-container coba-flex coba-header">
            <span class="coba-page-headline">Buchung</span>
        </div>
        <div v-if="!load">
            <div class="coba-container">
                <DayPicker :workstation="workstation" :bookings="bookings" @callback-picker-event="callbackPicker" :pre-selected-days="preSelectedDays"></DayPicker>
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
import DayPicker from "../../Elements/DayPicker";
import TimePicker from "../../Elements/TimePicker";
import Spinner from "../../Global/Spinner";
export default {
    name: "Page_HomeofficeDateTimeSelection.vue",
    components: {TimePicker, DayPicker, Spinner},
    props: ['preSelectedDays'],
    data(){
        return {
            load: false,
            error: false,
            days: [],
            bookings: [],
            workstation: {
                name: "Homeoffice",
                id: null,
                location: {},
            },
        }
    },
    created() {
        if(typeof this.preSelectedDays === "undefined") //wenn ein Tag vorher schon irgendwo angegeben wurde, wurde es in dieser Variable zwischengespeichert
            try {
                this.preSelectedDays = this.$store.getters.data.autoSave[this.$route.params.workstation_id];
            }
            catch (e) {
                this.preSelectedDays = []
            }
        //this.fetchWorkstation();
        this.fetchData();
    },
    methods:{
        fetchData() {
            this.load = true;
            let date = new Date();
            let today_date = date.toISOString().slice(0, 10); //cuts off the time: only date
            date.setDate(new Date().getDate() + 7);
            let date_in_7_days = date.toISOString().slice(0, 10);
            fetch('/api/user/'+this.$store.getters.data.user.user_id+'/bookings?order_by=date&filter[date][min]='+today_date, {
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
            console.log(this.bookings);
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
