<template>
    <div class="coba-page">
        <div class="coba-container coba-flex coba-header">
            <span class="coba-page-headline">Arbeitsplatzauswahl</span>
        </div>
        <div class="coba-container">
            <div class="coba-flex coba-flex-wrap coba-flex-space-evenly">
                <div v-for="workstation in workstations" :key="workstation.id" class="seat-container">
                    <div class="coba-text-strong coba-text">{{workstation.name}}</div>
                    <router-link class="coba-button coba-button-accent coba-button-very-big coba-button-round coba-button-no-border" :to="'/booking/new/booking/'+workstation.id"></router-link>
                    <div :class="'coba-utilization-indicator '+(load?'coba-utilization-indicator-gray':workstation.indicator)" @click="openModal(workstation)"></div>
                </div>
                <modal :show-modal="modal.open" @modal-close-event="closeModal">
                    <template v-slot:header>
                        <div class="coba-modal-header">{{modal.header}}</div>
                    </template>
                    <template v-slot:body>
                        <div class="coba-modal-body">
                            <table class="coba-table">
                                <tr v-for="day in modal.body">
                                    <th>{{day.date}}</th>
                                    <th><div :class="'coba-utilization-indicator coba-utilization-indicator-small coba-utilization-indicator-'+day.color"></div></th>
                                    <th v-if="day.end" class="coba-table-align-right">{{day.start.substring(0, 5)}} - {{day.end.substring(0, 5)}}</th>
                                    <th v-else class="coba-table-align-right">{{day.start}}</th>
                                </tr>
                            </table>
                        </div>
                    </template>
                </modal>
            </div>
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
                body: {}
            }
        }
    },
    mounted() {
        this.workstations = this.$store.getters.data.locations[this.location_id-1].workstations;
    },
    created() {
        let date = new Date();
        this.today_date = date.toISOString().slice(0, 10);
        date.setDate(new Date().getDate() + 7);
        this.date_in_7_days = date.toISOString().slice(0, 10);

        console.log(this.today_date);
        this.fetchData();
    },
    methods: {
        fetchData() {
            this.load = true;
            fetch('/api/booking?filter[date][min]='+this.today_date+'&filter[date][max]='+this.date_in_7_days+'&filter[location_id]='+this.location_id, {
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
                this.workstations[i].workstation_bookings = [];

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
                    let bookedHours = this.calcHours(this.workstations[i].workstation_bookings[date])
                    if(bookedHours > 6) {
                        full_days++;
                    }
                }

                if(full_days >= 5)
                    this.workstations[i].indicator = 'coba-utilization-indicator-red'; //mark red
                else if(full_days === 0)
                    this.workstations[i].indicator = "coba-utilization-indicator-green"; //mark green
                else
                    this.workstations[i].indicator = "coba-utilization-indicator-orange"; //mark orange

            }
        },
        //calculate and sum all hours in the given array of bookings
        calcHours(bookings) {
            let hours = 0;
            for(let i = 0; i < bookings.length; i++) {
                hours += Number(bookings[i].to.substring(0,2)) - Number(bookings[i].from.substring(0,2))
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
            if(hours >= 4)
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
            this.modal.header = workstation.name + " - Übersicht";

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
        }
    }
}
</script>

<style scoped>
.seat-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 30px;
}
.coba-table th {
    height: 40px;
}
</style>
