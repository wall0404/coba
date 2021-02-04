<template>
    <div class="coba-dropdown-wrapper" @click.self="$emit('modal-close-event')">
        <div class="coba-dropdown-container" @click="toggleDropDown(booking)">
            <!-- Pencil Icon inside the trigger box -> will have a white background when drop down opens-->
            <div style="position: absolute; bottom: 10px; right: 10px" :class="{'white-background':dropDown.open&&dropDown.id === booking.id}">
                <b-icon icon="pencil" class="m-2" style="margin-bottom: 30px !important" font-scale="1"></b-icon>
            </div>
            <!-- Drop Down start -->
            <div v-if="dropDown.open && dropDown.id === booking.id" >
                <div class="coba-dropdown-content">
                    <ul class="coba-list-nobullets">
                        <li> <router-link :to="'/booking/edit/'+booking.id" style="background-color:rgba(255,255,255,0);">Bearbeiten</router-link> </li>
                        <li class="last"> <button v-if="!load" style="background-color:rgba(255,255,255,0);" @click="openModal(booking)">Löschen</button> </li>
                    </ul>
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
                        <button class="coba-button coba-button-danger" @click="deleteBooking(modalDel.header)">Ja</button>
                        <button class="coba-button" @click="closeModal">Nein</button>
                    </div>
                </template>
            </modal>
        </div>
    </div>
</template>

<script>
import Modal from "./Modal";
export default {
    name: "EditingTool",
    components: {Modal},
    props: ['openDD','booking'],
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
        }
    },
    methods: {
        toggleDropDown(booking){
            //this.dropDown.open = true;
            if (this.dropDown.open==true){
                this.dropDown.open = false;
            }
            else this.dropDown.open = true;
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
    .white-background{
        background-color: white;
        border-top-right-radius: 10px;
        border-top-left-radius: 10px;
    }
</style>
