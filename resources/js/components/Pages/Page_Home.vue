<template>
    <div class="coba-page coba-homescreen">
        <div class="coba-container coba-header"> <!-- Überschrift -->
            <h1 class="coba-page-headline">Willkommen zurück,<br>{{$store.getters.data.user.firstName}}</h1>
        </div>
        <div  v-if="!load" class="coba-container coba-text-strong"> <!-- Anzeige der heutigen Buchungen -->
            <div v-if="bookings.find( element => element.date === today_date)" class="coba-text-big">Heute bist du in</div>
            <div v-else  class="coba-text-big">Keine Buchungen für heute</div>
            <ul class="coba-list"> <!-- Auflistung der heutigen Buchungen -->
                <li v-for="today_booking in bookings" v-if="today_booking.date === today_date">{{ today_booking.workstation.location.name }}, {{today_booking.workstation.name}}, {{today_booking.from}} - {{today_booking.to}}</li>
            </ul>
        </div>
        <spinner v-else></spinner>
        <div class="coba-container coba-flex-right"> <!-- Button zur Sitzplatzbuchung -->
            <span class="coba-text-very-big">Platz buchen</span>
            <button class="coba-button coba-button-round coba-button-normal coba-button-accent coba-button-distance-left-10"><router-link to="/booking/new/location"><b-icon icon="arrow-90deg-right" font-scale="1"></b-icon></router-link></button>
        </div>
        <div class="coba-container">
            <span class="coba-text-big">Kommende Buchungen:</span>
        </div>
        <div class="coba-container coba-full-width coba-footer-container"> <!-- Auflistung der kommenden Buchungen -->
            <ul class="coba-list" v-if="!load">
                <li class="coba-container coba-flex-space-evenly" v-for="booking in bookings" :key="booking.id">
                    {{booking.date}}, <br>{{ booking.workstation.location.name }}, {{booking.workstation.name}}, {{booking.from}} - {{booking.to}} <!-- the booking information -->
                    <!-- Drop Down list with pencil icon to toggle it -->
                    <div class="m-0 p-2" @click="openDropDown(booking)">    <!-- @click="openDropDown(booking)" - Triggerbox around the pencil icon, it opens a drop down List-->
                        <b-icon icon="pencil" font-scale="1"></b-icon> <!-- Pencil Icon inside the trigger box-->
                    </div>
                    <div v-if="dropDown.open && dropDown.id === booking.id" @click="closeDropDown(booking)">
                        <ul>
                            <li> Bearbeiten </li>
                            <li> <button v-if="!load" @click="openModal(booking)">Löschen</button> </li>
                        </ul>
                    </div>
                    <!-- drop down end -->
                </li>
            </ul>
            <spinner v-else></spinner>
        </div>
        <!-- modalDel -> A modal which asks if you really want to delete a booking -->
        <modal :show-modal="modalDel.open" @modal-close-event="closeModal" @modal-positive-event="deleteBooking">
            <template v-slot:header>
                <div class="coba-modal-header">Buchung {{modalDel.header}} entfernen</div> <!-- TODO individueller Buchungsname dahin? -->
            </template>
            <template v-slot:body>
                <div class="coba-modal-body">
                    Sind sie sich sicher, dass sie diese Buchung entfernen möchten?
                </div>
            </template>
            <template v-slot:footer>
                <div class="coba-modal-footer coba-button-container">
                    <button class="coba-button coba-button-danger" @click="deleteBooking(modalDel.header)">Ja</button>
                    <button class="coba-button" @click="closeModal">Nein</button>
                </div>
            </template>
        </modal>
    </div>

</template>

<script>
import Spinner from "../Global/Spinner";
import Modal from "../Elements/Modal";

export default {
    name: "Page_Home",
    components: {Modal, Spinner},
    data() {
        return {
            load: false,
            error: false,
            bookings: [],
            today_date: new Date().toISOString().slice(0, 10),
            dropDown: {
                id: "",
                open: false
            },
            modalDel: {
                header: "",
                open: false,
            },
        }
    },
    created() {
        this.fetchData();
    },
    methods: {
        fetchData() {
            this.load = true;
            fetch('/api/user/'+this.$store.getters.data.user.user_id+'/bookings?order_by=date&filter[date][min]='+this.today_date, {
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
        openDropDown(booking){
            this.dropDown.open = true;
            this.dropDown.id = booking.id;
        },
        closeDropDown(booking){
            this.dropDown.open = false;
            this.dropDown.id = "";
        },
        //all methods for the delete-modal
        openModal(booking) {
            this.modalDel.header = booking.id;
            this.modalDel.open = true;
        },
        closeModal() {
            this.modalDel.open = false;
        },
        deleteBooking(id) {
            this.showModal = false;
            this.load = true;
            fetch('/api/booking/'+id, {
                method: 'DELETE',
                headers: {
                    'content-type': 'application/json',
                    'Authorization' : 'Bearer '+localStorage.token
                }
            })
                .then(res => res.json())
                .then(res => {
                    if(res.success) {
                        this.load = false;
                        this.$router.go();
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
