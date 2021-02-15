<template>
    <div class="coba-page">
        <div class="coba-container coba-flex coba-header mb-0">
            <span class="coba-page-headline">Arbeitsplatzauswahl<br><p align="center"> {{location_name}} </p></span>
        </div>
        <div class="coba-container px-0">
            <!--<div class="coba-text-strong coba-text-big coba-flex-left pl-3">Favoriten</div>-->
            <div v-if="!load" class="coba-flex coba-flex-wrap coba-flex-space-evenly">
                <!-- :key  wurde entfernt-->
                <template v-for="workstation in workstations"  >
                    <div v-if="workstation.isFavorite" class="seat-container">
                    <router-link class="coba-button coba-button-big coba-button-round coba-button-no-border mb-0" :class="'coba-button-'+workstation.color" :to="{name:'DateTimeSelection', params: {workstation_id: workstation.id, bookings: workstation.workstation_bookings }}">
                       <b-icon style="position: absolute " icon="star-fill" font-scale="1.5" ></b-icon>
                    <!--    <b-icon class="icon-class" icon="star-fill" ></b-icon> -->
                    </router-link>
                    <div class="coba-flex-space-evenly m-0 p-2" @click="openModal(workstation)">
                        <div class="coba-text-strong coba-text-medium coba-text">{{workstation.name}}</div>
                        <button class="coba-button-very-small coba-button-round coba-button">i</button>
                    </div>
                    </div>
                </template>
            </div>

            <div v-if="!load" class="coba-container mt-0 pt-0 mb-2 "><hr class="m-0 p-0"></div>

            <div v-if="!load" class="coba-flex coba-flex-wrap coba-flex-space-evenly">
                <template v-for="workstation in workstations"  >
                    <div v-if="! workstation.isFavorite" class="seat-container">
                    <router-link class="coba-button coba-button-big coba-button-round coba-button-no-border mb-0" :class="'coba-button-'+workstation.color" :to="{name:'DateTimeSelection', params: {workstation_id: workstation.id, bookings: workstation.workstation_bookings }}">
                        <b-icon icon="plus" font-scale="2"></b-icon>
                    </router-link>
                    <div class="coba-flex-space-evenly m-0 p-2" @click="openModal(workstation)">
                        <div class="coba-text-strong coba-text-medium coba-text">{{workstation.name}}</div>
                        <button class="coba-button-very-small coba-button-round coba-button">i</button>
                    </div>
                    </div>
                </template>
            </div>
            <div v-if="!load" class="coba-flex coba-flex-wrap coba-flex-space-evenly">

                <modal :show-modal="modal.open" @modal-close-event="closeModal">
                    <template v-slot:header>
                        <div class="coba-modal-header">
                            <div class="coba-flex-space-evenly">{{modal.header}}
                                <b-icon @click="deleteFavoriteSeat()" v-if="modal.workstation.isFavorite" class="mb-1" style="color:#FEEF00" font-scale="1.5" icon="star-fill">
                                </b-icon> <b-icon @click="addFavoriteSeat()" v-else class="mb-1" style="color:#FEEF00" font-scale="1.5" icon="star"></b-icon> </div>
                        </div>
                    </template>
                    <template v-slot:body>
                        <div class="coba-modal-body">
                            <table class="coba-table">
                                <tr v-for="day in modal.body">
                                    <th>{{day.date}}</th> <!--gibt aktuellen Wochentag an-->
                                    <th><div :class="'coba-utilization-indicator coba-utilization-indicator-small coba-utilization-indicator-'+day.color"></div></th> <!--gibt aktuelle Farbe an-->
                                    <th v-if="day.end" class="coba-table-align-right">{{day.start.substring(0, 5)}} - {{day.end.substring(0, 5)}}</th>
                                    <th v-else class="coba-table-align-right">{{day.start}}</th> <!--day.start == verfügbar; also falls keine Buchung vorhanden ist, wird verfügbar angezeigt-->
                                </tr>
                            </table>
                        </div>
                    </template>
                </modal>
            </div>
            <spinner v-else></spinner>
        </div>
    </div>
</template>


<script>
import Spinner from "../../Global/Spinner";
import Modal from "../../Elements/Modal";

export default {
    name: "Page_WorkstationSelection",
    components: {Modal, Spinner},
    data() {
        return {
            load: false,
            error: false,
            location_id: this.$route.params.location_id,
            workstations: null,
            bookings: null,
            today_date: "",
            date_in_7_days: "",
            modal: {
                open: false,
                header: "",
                workstation:{},
                body: {}
            },
            location_name : "",
        }
    },
    mounted() {
        this.workstations = this.$store.getters.data.locations[this.location_id-1].workstations;
    },
    created() {
        let date = new Date();
        this.today_date = date.toISOString().slice(0, 10); //cuts off the time: only date
        date.setDate(new Date().getDate() + 7);
        this.date_in_7_days = date.toISOString().slice(0, 10);
        this.fetchData();
        for (var i = 0; i < this.$store.getters.locations.length; i++) {
            if(this.$store.getters.locations[i].id == this.location_id)
                this.location_name = this.$store.getters.locations[i].name
        }
    },
    methods: {
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
        colorIndicators() {
            //For every Workstation
            for (let i = 0; i<this.workstations.length; i++) {
                this.workstations[i].workstation_bookings = {};

                //For every Booking
                for (let k = 0; k<this.bookings.length; k++) {
                    if(this.bookings[k].workstation_id === this.workstations[i].id) {
                        try {
                            this.workstations[i].workstation_bookings[this.bookings[k].date].push(this.bookings[k])
                        }
                        catch (e) {
                            this.workstations[i].workstation_bookings[this.bookings[k].date] = []
                            this.workstations[i].workstation_bookings[this.bookings[k].date].push(this.bookings[k])
                        }
                    }
                }

                let full_days = 0;
                for(let date in this.workstations[i].workstation_bookings) {
                    if(new Date(date).getUTCDay() !== 0 && new Date(date).getUTCDay() !== 6){
                        let bookedHours = this.calcHours(this.workstations[i].workstation_bookings[date])
                        if(bookedHours >= 8) {
                            full_days++;
                        }
                    }

                }
                //calculate the color to show the availability of the workstation
                let today = new Date().getUTCDay();
                if(today===1){
                    if(full_days >= 15)
                        this.workstations[i].color = 'red'; //mark red
                    else if(full_days >= 11)
                        this.workstations[i].color = 'orange'; //mark orange
                    else this.workstations[i].color = 'green'; //mark green
                }
                if(today===2){
                    if(full_days >= 14)
                        this.workstations[i].color = 'red'; //mark red
                    else if(full_days >= 10)
                        this.workstations[i].color = 'orange'; //mark orange
                    else this.workstations[i].color = 'green'; //mark green
                }
                if(today===3){
                    if(full_days >= 13)
                        this.workstations[i].color = 'red'; //mark red
                    else if(full_days >= 9)
                        this.workstations[i].color = 'orange'; //mark orange
                    else this.workstations[i].color = 'green'; //mark green
                }
                if(today===4){
                    if(full_days >= 12)
                        this.workstations[i].color = 'red'; //mark red
                    else if(full_days >= 8)
                        this.workstations[i].color = 'orange'; //mark orange
                    else this.workstations[i].color = 'green'; //mark green
                }
                if(today===5){
                    if(full_days >= 11)
                        this.workstations[i].color = 'red'; //mark red
                    else if(full_days >= 7)
                        this.workstations[i].color = 'orange'; //mark orange
                    else this.workstations[i].color = 'green'; //mark green
                }
            }
        },
        //calculate and sum all hours in the given array of bookings
        calcHours(bookings) {
            let hours = 0;
            for(let i = 0; i < bookings.length; i++) {
                //Endzeit - Startzeit = berechnet gesamte Stundenanzahl pro Tag
                hours += Number(bookings[i].to.substring(0,2)) - Number(bookings[i].from.substring(0,2)) //Substring, to isolate the hours, 09:00 -> cuts off the last 3 chars
            }

            return hours;
        },
        calcModal(bookings) {
            let color = "";
            let hours = 0;
            let startHour = 24;
            let startBooking = null;
            let endHour = 0;
            let endBooking = null;
            for(let i = 0; i < bookings.length; i++) {
                hours += Number(bookings[i].to.substring(0,2)) - Number(bookings[i].from.substring(0,2));
                if(Number(bookings[i].to.substring(0,2))  > endHour) {
                    endHour = Number(bookings[i].to.substring(0, 2));
                    endBooking = bookings[i];
                }
                if(Number(bookings[i].from.substring(0,2))  < startHour) {
                    startHour = Number(bookings[i].from.substring(0, 2));
                    startBooking = bookings[i];
                }
            }
            if(hours >= 8)
                color = 'red'; //mark red
            else if(hours === 0)
                color = "green"; //mark green
            else
                color = "orange"; //mark orange
            return {color:color, start: startBooking.from, end: endBooking.to};
        },
        openModal(workstation) {
            //TODO
            this.modal.body = [];
            this.modal.header = workstation.name + " - Übersicht"; //richtet Name des Pop-ups ein
            this.modal.workstation = workstation;
            let date = new Date();
            let date_as_string = "";
            for(let i = 0; i < 8; i++) {
                date_as_string = date.toISOString().slice(0, 10);

                //pass on weekend
                if(date.getUTCDay() !== 0 && date.getUTCDay() !== 6) {
                    //Get info about this date
                    let dayInfo;
                    if (workstation.workstation_bookings[date_as_string]) {
                        dayInfo = this.calcModal(workstation.workstation_bookings[date_as_string])
                    } else {
                        dayInfo = {color: 'green', start: "Verfügbar", end: ""}
                    }
                    dayInfo.date = this.dateToDayOfMonth(date);
                    this.modal.body.push(dayInfo);
                    //Add one day to date
                }
                date.setDate(date.getDate() + 1);
            }
            this.modal.open = true;
        },
        closeModal() {
            this.modal.open = false;
        },
        dateToDayOfMonth(date) {
            let days = ["Sonntag","Montag","Dienstag","Mittwoch","Donnerstag","Freitag","Samstag"];
            return days[date.getUTCDay()];
        },
        deleteFavoriteSeat(){
            fetch('/api/workstation/favorite', {
                method: 'DELETE',
                body: JSON.stringify({
                    id: this.modal.workstation.id,
                }),
                headers: {
                    'content-type': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.token
                }
            })  .then( res => res.json())
                .then( res => {
                    if ( res.success){
                        this.modal.workstation.isFavorite = false
                    }
                }).catch(error =>{
                this.error = error;
                console.log(error) ;
            })
        },

        addFavoriteSeat(){
            fetch('/api/workstation/favorite', {
                method: 'POST',
                body: JSON.stringify({
                    id: this.modal.workstation.id,
                }),
                headers: {
                    'content-type': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.token
                }
            })  .then( res => res.json())
                .then( res => {
                    if ( res.success){
                        this.modal.workstation.isFavorite = true
                    }
                }).catch(error =>{
                this.error = error;
                console.log(error) ;
            })
        },
    }
}
</script>

<style scoped>
.seat-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 30px;
    margin-left: 15px;
    margin-right: 15px;
}
.coba-table th {
    height: 40px;
}
.icon-class{
    position: relative;
    top: 23px;
    left: 23px;
}
</style>
