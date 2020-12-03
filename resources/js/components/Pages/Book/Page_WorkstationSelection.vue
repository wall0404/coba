<template>
    <div class="coba-page">
        <div class="coba-container coba-flex coba-header">
            <span class="coba-page-headline">Arbeitsplatzauswahl</span>
        </div>
        <div class="coba-container">
            <div v-if="!load" class="coba-flex coba-flex-wrap coba-flex-space-evenly">
                <div v-for="workstation in workstations" :key="workstation.id" class="seat-container">
                    <div class="coba-text-strong coba-text">{{workstation.name}}</div>
                    <router-link class="coba-button coba-button-accent coba-button-very-big coba-button-round coba-button-no-border" :to="'/booking/new/booking/'+workstation.id"></router-link>
                    <div class="round-indicator" :style="'background: '+workstation.indicator"></div>
                </div>
            </div>
            <spinner v-else></spinner>
        </div>
    </div>
</template>

<script>
import Spinner from "../../Global/Spinner";

export default {
    name: "Page_WorkstationSelection",
    components: {Spinner},
    data() {
        return {
            load: false,
            error: false,
            location_id: this.$route.params.location_id,
            workstations: null,
            bookings: null,
            today_date: "",
            date_in_7_days: "",
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
                let workstation_bookings = [];

                //For every Booking
                for (let k = 0; k<this.bookings.length; k++) {
                    if(this.bookings[k].workstation_id === this.workstations[i].id) {
                        try {
                            workstation_bookings[this.bookings[k].date].push(this.bookings[k])
                        }
                        catch (e) {
                            workstation_bookings[this.bookings[k].date] = []
                            workstation_bookings[this.bookings[k].date].push(this.bookings[k])
                        }
                    }
                }

                let full_days = 0;
                for(let date in workstation_bookings) {
                    console.log("test");
                    let bookedHours = this.calcHours(workstation_bookings[date])
                    if(bookedHours > 6) {
                        full_days++;
                    }
                }
                console.log(full_days)

                if(full_days >= 5)
                    this.workstations[i].indicator = '#FF6666'; //mark red
                else if(full_days === 0)
                    this.workstations[i].indicator = "#4ABE5D"; //mark green
                else
                    this.workstations[i].indicator = "#FFAD33"; //mark orange

            }
        },
        //calculate and sum all hours in the given array of bookings
        calcHours(bookings) {
            let hours = 0;
            for(let i = 0; i < bookings.length; i++) {
                hours += Number(bookings[i].to.substring(0,2)) - Number(bookings[i].from.substring(0,2))
            }
            return hours;
        }
    }
}
</script>

<style scoped>
.seat-container {
    display: flex;
    flex-direction: column;
    align-items: center;
}
.round-indicator {
    background-color: black;
    width: 30px;
    height: 30px;
    border-radius: 30px;
}
</style>
