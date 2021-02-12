<template>
    <div class="coba-page">
        <div class="coba-container coba-flex coba-header">
            <span class="coba-page-headline" align="center">Was möchtes du ändern?</span>
        </div>

        <!-- Tag der Buchung -->
        <div class="coba-container">
            {{booking.date}}
        </div>
        <!-- Zeit der Buchung -->
        <div class="coba-container">
            <span>Zeitraum ändern</span>

        </div>
        <!-- Sitzplatz -->
        <div class="coba-container">
            <span>Sitzplatz ändern</span>
            {{booking.workstation_id}}
        </div>

    </div>
</template>

<script>
import TimePicker from "../../Elements/TimePicker";

export default {
    name: "Page_ChangeBooking",
    components: {TimePicker},
    props: ['booking'],
    data() {
        return {
            bookings: [],
            bookings_workstation_date: [],
            day: null
        }
    },
    created() {
        for(let i = 0; i < this.bookings.length; i++) {
            if(this.bookings[i].date === this.booking.date) {
                this.bookings_workstation_date.push(this.bookings[i]);
            }
        }
    },
    methods: {
        fetchData() {
            this.load = true;
            fetch('/api/booking/?filter[workstation_id]='+ this.booking.workstation_id, {
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
    }
}
</script>

<style scoped>

</style>
