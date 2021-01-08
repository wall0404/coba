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

        <div class="back-button">
            <a v-if="!load"   @click='openModal'>
                <div data-v-1febfe86="" class="coba-utilization-indicator coba-utilization-indicator-arrow-prev coba-utilization-indicator-big coba-utilization-indicator-disabled">➤</div>
            </a>
            <spinner v-else></spinner>
        </div>


        <modal :show-modal="showModal" @modal-close-event="closeModal" >
            <template v-slot:header>
                <div class="coba-modal-header">
                    <b-icon class="theicon" icon="exclamation-triangle-fill" color=#861F08 font-size="50px"></b-icon>
                </div>
            </template>
            <template v-slot:body>
                <div class="coba-modal-middle">
                    Bist du dir sicher?
                </div>
                <div class="coba-modal-body">
                    Wenn du jetzt die Seite verlässt, werden deine Buchungen gelöscht.
                </div>
            </template>
            <template v-slot:footer>
                <div class="coba-modal-footer coba-button-container">
                    <button class="coba-button coba-button-big" @click="closeModal">Hier Bleiben</button>
                    <button class="coba-button coba-button-big coba-button-danger" @click="$router.go(-1)">Verlassen</button>
                </div>
            </template>
        </modal>




    </div>
</template>

<script>
import Spinner from "../../Global/Spinner";
import DayPicker from "../../Elements/DayPicker";
import TimePicker from "../../Elements/TimePicker";
import Modal from "../../Elements/Modal";
export default {
    name: "Page_DateTimeSelection",
    props: ["bookings", 'preSelectedDateStr'],
    components: {TimePicker, DayPicker, Modal,Spinner},
    data() {
        return {
            workstation: {},
            load: false,
            error: false,
            days: [],
            showModal: false,
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
        },
        openModal() {
            this.showModal = true;
        },
        closeModal() {
            this.showModal = false;
        },
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
.theicon{

    display:inline-block;
    vertical-align: middle;
}
.coba-modal-middle{
    font-size:30px;
}
</style>
