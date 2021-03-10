<template>
    <div class="coba-page">
        <div class="coba-container coba-flex coba-header">
            <span class="coba-page-headline" align="center">Was möchtest du ändern?</span>
        </div>
        <spinner v-if="loadBookings || loadWorkstations"></spinner>
        <div v-else class="scroll">
            <!-- Tag der Buchung -->
            <div class="coba-container coba-text-center coba-text-big coba-text-strong">
                {{makeDateToDateString(booking.date)}}
            </div>
            <!-- Zeit der Buchung -->
            <div class="coba-container coba-text-center" >
                <span class="coba-text-strong coba-text-big">Zeitraum ändern: </span>
                <span class="coba-text-medium">{{this.booking.from.substring(0,5)}} - {{this.booking.to.substring(0,5)}}</span>
                <TimePicker :day="this.day"></TimePicker>
            </div>
            <!-- Sitzplatz -->
            <div class="coba-text-center">
                <span class="coba-text-strong coba-text-big">Sitzplatz ändern: </span>
                <span class="coba-text-medium">{{this.booking.workstation.name}}</span>
            </div>
            <div class="coba-container coba-flex-column">
                <div v-if="dropDownOpen" class="coba-dropdown-wrapper" @click.self="toggleDropDown()"></div>
                <div class="dropdown" @click="toggleDropDown">
                    <div>{{this.text}}<i class="dropdown-arrow"><b-icon icon="arrow-down-circle"></b-icon></i></div>
                    <div class="dropdown-align" v-if="dropDownOpen">
                        <ul class="list-text">
                            <li @click="reset">Keine Auswahl</li>
                            <li v-for="workstation in workstations" @click="changeWorkstation(workstation), calcHours(workstation.id)">{{workstation.name}}</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Buchung ändern -->
            <div class="coba-container">
                <button class="coba-button coba-button-no-border coba-button-accent mt-4" @click="openModal">Buchung ändern</button>
                <router-link to="/home"><button class="coba-button coba-button-no-border coba-button-accent mt-4">Abbrechen</button></router-link>
            </div>
        </div>
        <modal :show-modal="modalDel.open" @modal-close-event="closeModal" @modal-positive-event="changeBooking">
            <template v-slot:header>
                <div class="coba-modal-header">Buchung ändern</div>
            </template>
            <template v-slot:body>
                <div v-if="changeSuccessful && !changeFailure" class="cobal-modal-body mt-4 mb-4">
                    Die Änderung war erfolgreich!
                </div>
                <div v-if="changeFailure" class="cobal-modal-body mt-4 mb-4">
                    Änderung war fehlerhaft!
                </div>
                <div v-if="!changeSuccessful && !changeFailure" class="coba-modal-body">
                    Bist du dir sicher, dass du die Buchung ändern möchtest?
                </div>
            </template>
            <template v-slot:footer>
                <div v-if="changeSuccessful || changeFailure" class="coba-modal-footer coba-button-container">
                    <router-link to="/home" class="coba-button"><button @click.self="$emit('modal-delete-event')">Zur Startseite</button></router-link>
                </div>
                <div v-if="!changeSuccessful && !changeFailure" class="coba-modal-footer coba-button-container">
                    <button class="coba-button coba-button-danger" @click="changeBooking">Ja</button>
                    <button class="coba-button" @click="closeModal">Nein</button>
                </div>
            </template>
        </modal>
    </div>
</template>

<script>
import TimePicker from "../../Elements/TimePicker";
import Spinner from "../../Global/Spinner";
import Modal from "../../Elements/Modal";

export default {
    name: "Page_ChangeBooking",
    components: {TimePicker, Spinner, Modal},
    props: ['booking'],
    data() {
        return {
            loadBookings: false,
            loadWorkstations: false,
            loadChange: false,
            error: false,
            dropDownOpen: false,
            changeSuccessful: false,
            changeFailure: false,
            modalDel: {
                header: "",
                open: false,
            },
            text: "Auswählen",
            date: this.booking.date,
            bookings: [], //Buchungen für den gleichen Tag wie zu ändernden Buchung an gleicher Location
            workstations: [], //alle Workstations für die Location der zu ändernden Buchung
            workstationID: this.booking.workstation_id,
            day: {
                date: new Date(),
                booked_start: "00:00:00",
                booked_end: "24:00:00",
                time: [Number(this.booking.from.substr(0,2))+(this.booking.from.substr(3,2)==="00"?0:0.5),
                    Number(this.booking.to.substr(0,2))+(this.booking.to.substr(3,2)==="00"?0:0.5)],

            }
        }
    },
    created() {
        this.fetchWorkstations();
        this.fetchBookingsForDate(this.date);
    },
    methods: {
        fetchBookingsForDate(date) {
            this.loadBookings = true;
            fetch('/api/booking?filter[date][min]='+date+'&filter[date][max]='+date, {
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
                        this.loadBookings = false;
                    }
                    else {
                        this.error = true;
                        this.load = false;
                    }
                })
                .catch(error => {
                    console.log(error);
                    this.loadBookings = false;
                })
        },
        fetchWorkstations(){
            this.loadWorkstations = true;

            let locations = this.$store.getters.locations;

            for(let i = 0; i < locations.length; i++) {
                if(locations[i].id === this.booking.workstation.location_id){
                    this.workstations = this.$store.getters.locations[i].workstations;
                    this.loadWorkstations = false;
                }
            }
        },
        calcHours(workstationsID) {
            let workstationIDBookings = [];
            let hours = 0;
            let startHour = 24;
            let startBooking = null;
            let endHour = 0;
            let endBooking = null;
            let time = [9,17];

            //Booking nach workstationID filtern
            for(let i = 0; i < this.bookings.length; i++) {
                if(this.bookings[i].workstation_id === workstationsID && this.bookings[i].id !== this.booking.id) {
                    workstationIDBookings.push(this.bookings[i]);
                }
            }

            //wenn es keine weiteren Bookings gibt
            if(workstationIDBookings.length === 0) {
                this.day.time = time;
                return;
            }

            //Belegte Zeiten berechnen
            for(let i = 0; i < workstationIDBookings.length; i++) {
                hours += Number(workstationIDBookings[i].from.substring(0,2)) - Number(workstationIDBookings[i].to.substring(0,2));
                if(Number(workstationIDBookings[i].to.substring(0,2)) > endHour) {
                    endHour = Number(workstationIDBookings[i].to.substring(0,2));
                    endBooking = workstationIDBookings[i];
                }
                if(Number(workstationIDBookings[i].from.substring(0,2)) < startHour) {
                    startHour = Number(workstationIDBookings[i].from.substring(0,2));
                    startBooking = workstationIDBookings[i];
                }
            }

            if(Number(endBooking.to.substr(0,2)) < 14) {
                time = [
                    Number(endBooking.to.substr(0,2))+(endBooking.to.substr(3,2)==="00"?0:0.5),
                    17
                ]
            } else {
                time = [
                    9,
                    Number(startBooking.from.substr(0,2))+(startBooking.from.substr(3,2)==="00"?0:0.5)
                ]
            }

            this.day.booked_start = startBooking.from;
            this.day.booked_end = endBooking.to;
            this.day.time = time;

        },
        changeWorkstation(workstation){
            this.workstationID = workstation.id;
            this.text = workstation.name;
            //console.log(workstation);
        },
        reset() {
            this.workstationID = this.booking.workstation_id;
            this.text = "Auswählen";
            this.calcHours(this.workstationID);
        },
        changeBooking(){
            //this.modalDel.open = false;
            this.loadChange = true;
            //Neue Buchungsdaten setzen
            let changedBooking = {
                date: this.date,
                from: (this.day.time[0]<10?"0":"")+Math.round(this.day.time[0]-0.1)+":"+(this.day.time[0]%1===0?'00':'30'),
                to: (this.day.time[1]<10?"0":"")+Math.round(this.day.time[1]-0.1)+":"+(this.day.time[1]%1===0?'00':'30'),
                user_id: this.$store.getters.data.user.user_id,
                workstation_id: this.workstationID,
            }

            fetch('/api/booking/'+this.booking.id, {
                method: 'PUT',
                body: JSON.stringify(changedBooking),
                headers: {
                    'content-type': 'application/json',
                    'Authorization' : 'Bearer '+localStorage.token
                }
            })
                .then(res => res.json())
                .then(res => {
                    if(res.success) {
                        console.log("Buchung geändert");
                        this.changeSuccessful = true;
                        this.loadChange = false;
                    }
                    else {
                        this.error = true;
                        this.changeFailure = true;
                        this.loadChange = false;
                    }
                })
                .catch(error => {
                    console.log(error);
                    this.loadChange = false;
                })
        },
        makeDateToDateString(dateStr){
            let options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            return  new Date(dateStr).toLocaleDateString('de-DE', options);
        },
        toggleDropDown(){
            this.dropDownOpen = !this.dropDownOpen;
        },
        openModal() {
            this.modalDel.header = this.booking.id;
            this.modalDel.open = true;
        },
        closeModal() {
            this.modalDel.open = false;
        }
    }
}
</script>

<style scoped>
.no-scroll {
    overflow: hidden;
}
.scroll{
    overflow: scroll;
}
.dropdown {
    width: 10em;
    height: 1.8em;
    border: 2px solid #c0cdd1;
    border-radius: 5px;
    padding-left: 2px;
    padding-right: 5px;
    align-items: center;
}
.dropdown-align {
    position: relative;
    right: 4px;
}
.dropdown-arrow {
    float: right
}
.list-text{
    font-size: 1em;
}
ul {
   list-style: none;
   margin: 0;
   padding: 0;
}
li {
    width: 10em;
    height: 1.8em;
    border: solid #c0cdd1;
    border-width: 1.5px 2px 1.5px 2px;
    /*border-radius: 5px;*/
    padding-left: 2px;
    padding-right: 5px;
    background-color: #fff;
}
li:last-child {
    border-bottom-left-radius: 5px;
    border-bottom-right-radius: 5px;
    border-bottom-width: 2px;
}
</style>
