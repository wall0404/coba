<template>
    <div class="coba-page">
        <div class="coba-container coba-flex coba-header">
            <span class="coba-page-headline">Buchung</span>
        </div>
        <div class="coba-container">
            <DayPicker :workstation="workstation" :bookings="null" @callback-picker-event="callbackPicker"></DayPicker>
        </div>
        <div class="coba-container">
            <TimePicker v-for="(day,index) in days" :key="index" :day="day"></TimePicker>
        </div>
        <div class="coba-container">
            <div :class="{'coba-button':true, 'coba-button-disabled':days.length===0}" @click="submit">Buchen</div>
        </div>
    </div>
</template>

<script>
import Spinner from "../../Global/Spinner";
import DayPicker from "../../Elements/DayPicker";
import TimePicker from "../../Elements/TimePicker";

export default {
    name: "Page_DateTimeSelection",
    components: {TimePicker, DayPicker, Spinner},
    data() {
        return {
            workstation: {},
            load: false,
            error: false,
            days: [],
        }
    },
    mounted() {
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
            console.log(this.days);
        }
    }
}
</script>

<style scoped>

</style>
