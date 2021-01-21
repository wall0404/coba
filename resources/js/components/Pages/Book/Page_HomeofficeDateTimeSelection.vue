<template>
    <div class="coba-page">
        <div class="coba-container coba-flex coba-header">
            <span class="coba-page-headline">Buchung</span>
        </div>
        <div class="coba-container"> <!-- workdays are chooseable as buttons, and has a header which says Homeoffice and the dates for monday-friday -->
            <DayPicker :workstation="workstation" :bookings="[]" @callback-picker-event="callbackPicker" :pre-selected-date-str="preSelectedDateStr"></DayPicker>
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
import DayPicker from "../../Elements/DayPicker";
import TimePicker from "../../Elements/TimePicker";
import Spinner from "../../Global/Spinner";
export default {
    name: "Page_HomeofficeDateTimeSelection.vue",
    components: {TimePicker, DayPicker},
    props: ["bookings", 'preSelectedDateStr'],
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

        //this.fetchWorkstation();
        this.fetchData();
    },
    methods:{
        fetchData() {
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
