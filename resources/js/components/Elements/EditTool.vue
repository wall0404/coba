<template>
    <div >
        <div v-if="dropDown.open" class="coba-editing-wrapper" @click.self="toggleDropDown()"></div>
        <div class="coba-dropdown-container" @click="toggleDropDown()">
            <!-- Pencil Icon inside the trigger box -> will have a white background when drop down opens-->
            <div :class="{'white-background':dropDown.open&&colorBack==='white','gray-background':dropDown.open&&colorBack==='gray'}">
                <b-icon icon="pencil" class="m-2" :class="{'margin-bottom-30': colorBack==='white'}" font-scale="1"></b-icon>
            </div>
            <!-- Drop Down start -->
            <div v-if="dropDown.open" >
                <div class="coba-dropdown-content" :class="{'white-background':dropDown.open&&colorBack==='white','gray-background':dropDown.open&&colorBack==='gray'}">
                    <ul class="coba-list-nobullets" style="margin-bottom: 0px">
                        <li> <router-link :to="{name: 'ChangeBooking', params: { booking_id:booking.id, booking: booking }}" style="background-color:rgba(255,255,255,0);">Bearbeiten</router-link> </li>
                        <li class="last"> <button v-if="!load" style="background-color:rgba(255,255,255,0);" @click="openModal()">Löschen</button> </li>
                    </ul>
                </div>
            </div>
        </div>
        <modal :show-modal="modalDel.open" @modal-close-event="closeModal" @modal-positive-event="deleteBooking">
            <template v-slot:header>
                <div class="coba-modal-header">Buchung entfernen</div>
            </template>
            <template v-slot:body>
                <div class="coba-modal-body">
                    Bist du dir sicher, dass du die Buchung entfernen möchtest?
                    <!-- Sind sie sich sicher, dass sie diese Buchung entfernen möchten? -->
                </div>
            </template>
            <template v-slot:footer>
                <div class="coba-modal-footer coba-button-container">
                    <button class="coba-button coba-button-danger" @click="deleteBooking()" @click.self="$emit('modal-delete-event')">Ja</button>
                    <button class="coba-button" @click="closeModal">Nein</button>
                </div>
            </template>
        </modal>
    </div>
</template>

<script>
import Modal from "./Modal";
export default {
    name: "EditTool",
    components: {Modal},
    props: ['openDD','booking', 'colorBack'],
    data() {
        return {
            load: false,
            error: false,
            dropDown: {
                id: "",
                open: false
            },
            modalDel: {
                header: "",
                open: false,
            },
            delBooking: null,
        }
    },
    created() {
        if(typeof this.color === 'undefined')
            this.color = "white";
    },
    methods: {
        toggleDropDown(){
            this.dropDown.open = !this.dropDown.open;
        },
        //all methods for the delete-modal
        openModal() {
            console.log("test");
            this.modalDel.header = this.booking.id;
            this.modalDel.open = true;
        },
        closeModal() {
            this.modalDel.open = false;
        },
        deleteBooking() {
            this.modalDel.open = false;
            this.load = true;
            fetch('/api/booking/'+this.booking.id, {
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
                        //this.$router.go();
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
.coba-editing-wrapper{
    top:0;
    left:0;
    width: 100%;
    height: 100%;
    position: fixed;
    display: flex;
    z-index: 2;
}
.coba-dropdown-container {
    position: relative;
}
.coba-dropdown-content {
    position: absolute;
    bottom: -60px;
    right: 0px;
    width: fit-content;
    z-index: 3;
    padding: 7px 10px;
    text-align: left;
    border-radius: 10px;
}
.white-background{
    background-color: white;
    border-top-right-radius: 10px;
    border-top-left-radius: 10px;
}
.gray-background{
    background-color: gray;
    background-color: #EBEBEB;
    border-top-right-radius: 10px;
    border-top-left-radius: 10px;
}
</style>
