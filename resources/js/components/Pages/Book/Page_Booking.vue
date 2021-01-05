<template>
    <div class="coba-page">
        <div class="coba-container coba-flex coba-header">
            <span class="coba-page-headline">Buchung {{$route.params.id}}</span>
        </div>
        <div class="coba-container">
            <!--
            <ul class="coba-list">
                <li v-for="this_booking in $store.getters.data.bookings" v-if="this_booking === booking">{{ this_booking.workstation.location.name }}, {{this_booking.workstation.name}}, {{this_booking.from}} - {{this_booking.to}}</li>
            </ul>-->
            <span class="coba-text"> {{booking}} </span>
             <!--  <span v-if=""> {{$store.getters.data.bookings.id}} </span>{{booking.date}}, {{ booking.workstation.location.name }}, {{booking.workstation.name}}, {{booking.from}} - {{booking.to}}-->
        </div>
        <div class="coba-container">
            <button v-if="!load" class="coba-button" @click='openModal'>Bearbeiten</button>
            <button v-if="!load" class="coba-button coba-button-danger" @click='openModal'>Löschen</button>
            <spinner v-else></spinner>
        </div>
        <modal :show-modal="showModal" @modal-close-event="closeModal" @modal-positive-event="deleteBooking">
            <template v-slot:header>
                <div class="coba-modal-header">Buchung entfernen</div>
            </template>
            <template v-slot:body>
                <div class="coba-modal-body">
                    Sind sie sich sicher, dass sie diese Buchung entfernen möchten?
                </div>
            </template>
            <template v-slot:footer>
                <div class="coba-modal-footer coba-button-container">
                    <button class="coba-button coba-button-danger" @click="deleteBooking">Ja</button>
                    <button class="coba-button" @click="closeModal">Nein</button>
                </div>
            </template>
        </modal>
    </div>
</template>

<script>
import Spinner from "../../Global/Spinner";
import Modal from "../../Elements/Modal";

export default {
    name: "Page_Booking",
    components: {Modal, Spinner},
    data() {
        return {
            load: false,
            error: false,
            showModal: false,
            booking: []
        }
    },
    methods: {
        openModal() {
            this.showModal = true;
        },
        closeModal() {
            this.showModal = false;
        },
        deleteBooking() {
            this.showModal = false;
            this.load = true;
            fetch('/api/booking/'+this.$route.params.id, {
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
                        this.$router.go(-1);
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
