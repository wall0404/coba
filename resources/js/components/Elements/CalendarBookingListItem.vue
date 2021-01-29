<template>
    <div class="booking py-3" :class="{'strong':user_id === $store.getters.data.user.user_id}">
        <div class="table-item seat">{{workstation.name}}</div>
        <div class="table-item time">{{ time }}</div>
        <router-link v-if="user_id!==null" class="table-item name" :to="'/team/'+user_id">{{ name }}</router-link> <!-- Anzeige der Person, die den Platz gebucht hat -->
        <div v-else class="table-item name"></div> <!-- Platzhalter, wenn der Platz frei ist und der router-link zum Profil deaktiviert ist -->
        <div class="table-item icon"><b-icon v-if="false" icon="star-fill" font-scale="0.75"></b-icon></div>
        <!-- Anzeige der Buchungsbutton wenn Buchung von einem anderem User ist -->
        <router-link class="table-item icon coba-utilization-indicator" v-if="user_id !== $store.getters.data.user.user_id"
                     :class="{'coba-utilization-indicator-red':color==='red',
                                'coba-utilization-indicator-green':color==='green',
                                'coba-utilization-indicator-orange':color==='orange',
                                'coba-utilization-indicator-disabled':this.today.setHours(0,0,0,0) > new Date(date).setHours(0,0,0,0)
                                }"
                     :to="{ name: 'DateTimeSelection', params: { workstation_id:workstation.id, preSelectedDays: [dayObj], calenderBool: true }}">
            <b-icon icon="plus"></b-icon>
        </router-link>
        <!-- Drop Down list with pencil icon to toggle it -->
        <div class="table-item icon coba-dropdown-container" @click="toggleDropDown(booking)" v-else>    <!-- @click="openDropDown(booking)" - Triggerbox around the pencil icon, it opens a drop down List-->
            <!-- Pencil Icon inside the trigger box -> will have a white background when drop down opens-->
            <div :class="{'grey-background':dropDown.open&&dropDown.id === booking.id}">
                <b-icon icon="pencil"></b-icon>
            </div>
            <!-- Drop Down start -->
            <div v-if="dropDown.open && dropDown.id === booking.id" class="coba-dropdown-wrapper" style="bottom: -52px; z-index: 2; right: -11px">
                <div class="coba-dropdown-content" style="background-color: #EBEBEB">
                    <ul class="coba-list-nobullets" style="margin: 0px">
                        <li style="border-bottom: 1px solid #505050"> <button style="background-color:rgba(255,255,255,0);">Bearbeiten</button> </li>
                        <li class="last" > <button style="background-color:rgba(255,255,255,0);" @click="openModal(booking)">Löschen</button> </li>
                    </ul>
                </div>
            </div>
            <!-- drop down end -->
        </div>
        <!-- modalDel -> A modal which asks if you really want to delete a booking -->
        <modal :show-modal="modalDel.open" @modal-close-event="closeModal" @modal-positive-event="deleteBooking">
            <template v-slot:header>
                <div class="coba-modal-header">Buchung entfernen</div>
            </template>
            <template v-slot:body>
                <div class="coba-modal-body">
                    Bist du dir sicher, dass du die Buchung entfernen möchtest?
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
import Modal from "./Modal";
export default {
    name: "CalendarBookingListItem",
    components: {Modal},
    props: ['workstation', 'bookings', 'users', 'date'],
    data() {
        return {
            time: "-",
            name: "",
            user_id: null,
            booking: null,
            color: "green",
            today: new Date(),
            dayObj: {
                date: new Date(this.date)
            },
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
        let bookings_for_this_workstation = [];
        for(let i = 0; i < this.bookings.length; i++) {
            if(this.bookings[i].workstation_id === this.workstation.id) {
                bookings_for_this_workstation.push(this.bookings[i]);
            }
        }
        this.calcInfo(bookings_for_this_workstation)
    },
    methods: {
        calcInfo(bookings) {
            if(bookings.length < 1)
                return;

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


            this.color = color;
            let user = this.users.find(x => x.user_id === bookings[0].user_id);
            this.booking = bookings[0];
            this.user_id = user.user_id;
            this.name = user.firstName + " " + user.lastName;
            this.time = (startBooking.from.substr(0,5) +" - " + endBooking.to.substr(0,5));
        },
        toggleDropDown(booking){
            //this.dropDown.open = true;
            if (this.dropDown.open==true){
                this.dropDown.open = false;
            }
            else this.dropDown.open = true;
            this.dropDown.id = booking.id;
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
            //this.load = true;
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
                        //this.load = false;
                        this.$router.go();
                    }
                    else {
                        this.error = true;
                        //this.load = false;
                    }
                })
                .catch(error => {
                    console.log(error);
                    //this.load = false;
                })
        },
    }
}
</script>

<style scoped>
.booking {
    display: flex;
    position: relative;
}
.booking.strong {
    font-weight: bold;
}
.table-item {
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
}
.seat {
    width: 20%;
}
.time {
    width: 35%;
}
.name {
    width: 25%;
}
.icon {
    width: 10%;
    display: flex;
    justify-content: center;
    align-items: center;
}
.grey-background{
    background-color: #EBEBEB;
    border-top-right-radius: 10px;
    border-top-left-radius: 10px;
    position: absolute;
    padding: 10px;
    padding-top: 7px;
    z-index: 1;
}
</style>
