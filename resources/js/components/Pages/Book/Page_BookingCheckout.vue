<template>
    <div class="coba-page coba-page-no-header coba-page-lower-padding">
        <div v-if="session_expired"> <!-- Anzeige wenn die Sitzung abgelaufen ist -->
            <div class="coba-headline mb-4 mx-4">Die Sitzung ist abgelaufen</div>
            <a @click="$router.push('/home')">Zurück zur Startseite</a> <!-- Button um eine Seite zurückzugehen -->
        </div>
        <div v-else>
            <spinner v-if="load"></spinner>
            <div v-else>
                <div v-if="error===false">
                    <div class="coba-container coba-no-top-padding" v-if="validation_error.length === 0"> <!-- Anzeige der erfolgreichen Buchung -->
                        <div class="coba-container coba-no-top-padding coba-flex-column"> <!-- Text -->
                            <span class="coba-text-strong coba-text-very-bigger coba-text-center">Deine Buchung war erfolgreich</span>
                            <b-icon class="mt-3 mb-4" icon="hand-thumbs-up" font-scale="3" style="color:#FEEF00"></b-icon>
                        </div>
                        <div class="coba-container"> <!-- Buttons -->
                            <router-link to="/home"><button class="coba-button coba-button-white coba-button-yellow-border">Zur Startseite</button></router-link>
                            <router-link v-if="calenderBool" to="/calendar"><button class="coba-button coba-button-no-border coba-button-accent mt-4">Weitere Buchung</button></router-link>
                            <router-link v-else to="/booking/new/location"><button class="coba-button coba-button-no-border coba-button-accent mt-4">Weitere Buchung</button></router-link>
                        </div>
                    </div>
                    <div v-else class="mx-4 booking-list"> <!-- Anzeige der fehlgeschlagenen Buchung -->
                        <booking v-for="(booking, index) in success"  :booking="booking" color="true" :key="'s'+index"></booking>
                        <booking v-for="(booking, index) in validation_error"  :booking="booking" color="true" :key="'e'+index"></booking>
                        <button class="coba-button"><a @click="$router.go(-2)">Zurück</a></button> <!-- Button um zwei Seiten zurückzugehen -> Seite zur Tagauswahl -->
                    </div>
                </div>
                <div v-else>
                    <span class="coba-text coba-text-very-big coba-text-danger">{{error}}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Spinner from "../../Global/Spinner";
import Booking from "../../ListItems/Booking";
import {router} from "../../../_helpers/router";
export default {
    components: {Booking, Spinner},
    props: ['bookings', 'calenderBool'],
    name: "Page_BookingCheckout",
    data() {
        return {
            session_expired: false,
            load: false,
            error: false,
            validation_error: [],
            success: [],
            /* Variablen für automatsiche Rückführung
            timeout: null ,
            countDown: null,*/
        }
    },
    created() {
        if(typeof this.bookings === 'undefined') {
            this.session_expired = true;
        }
        else {
            this.makeBooking();
        }

    },
    /* Automatische Rückführung
    mounted() {
        this.autoRedirect() ;
    },
    // stop if redirecting
    beforeRouteLeave(to, from, next) {
        clearTimeout(this.timeout);
        next();
    },*/

    methods: {
        /* Methode für automatische Rückführung
        autoRedirect(){
            // timeout variable could be used for display
            this.timeout = setTimeout(function (){
                 router.push('/home') ;
            },5000) ;
            this.countDown = this.timeout ;
        },*/

        makeBooking() {
            this.load = true;
            let bookings = [];

            for(let booking_index in this.bookings) {
                bookings.push({
                    date: this.bookings[booking_index].date.toISOString().slice(0, 10),
                    from: this.bookings[booking_index].from,
                    to: this.bookings[booking_index].to,
                    workstation_id: this.bookings[booking_index].workstation.id,
                    user_id: this.$store.getters.data.user.user_id,
                });
            }

            //send request
            this.load = true;
            fetch('/api/booking', {
                method: 'POST',
                body: JSON.stringify(bookings),
                headers: {
                    'content-type': 'application/json',
                    'Authorization' : 'Bearer '+localStorage.token
                }
            })
                .then(res => res.json())
                .then(res => {
                    this.load = false;
                    this.validation_error = res.error;
                    this.error = false;
                    this.success = res.success;

                    //clear changes
                    this.$store.commit('autoSaveInstance', {
                        workstation_id: this.bookings[0].workstation_id === null? "remotework":this.bookings[0].workstation.id,
                        days: []
                    })
                })
                .catch(error => {
                    console.log(error);
                    this.error = "Ein Fehler ist aufgetreten";
                    this.load = false;
                })
        }

    }

}
</script>

<style scoped>
.booking-list {
    padding-top: 50px;
}
</style>
