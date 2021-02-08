<template>
    <div class="booking py-3" > <!-- :class="{'strong':user_id === $store.getters.data.user.user_id}" -->
        <div class="table-item seat">{{workstation.name}}</div>
        <!-- Anzeige der Buchungszeiten -->
        <div class="table-item time">
            <div v-if="bookings_workstation.length==0"> <!-- Keine Buchung für die Workstation -->
                {{time}}
            </div>
            <div v-else v-for="booking in bookings_workstation" class="pb-2">
               {{booking.from.substring(0,5)}} - {{booking.to.substring(0,5)}}
             </div>
        </div>

        <!-- Anzeige der Person, die den Platz gebucht hat -->
        <div class="table-item name">
            <div v-if="user_booking_list.length==0"></div>
            <div v-else v-for="user in user_booking_list" class="pb-2">
                <router-link v-if="user.user_id==$store.getters.data.user.user_id" :to="'/profile'">meins</router-link> <!-- Weiterleitung zum eigenen Profil -->
                <router-link v-else :to="'/team/'+user.user_id">{{user.firstName}} {{user.lastName.substring(0,1)}}.</router-link> <!-- Weiterleitung zum Profil des Teammitglieds -->
            </div>
        </div>

        <div class="table-item icon"><b-icon v-if="false" icon="star-fill" font-scale="0.75"></b-icon></div>

        <!-- Anzeige der Buchungsbutton wenn Buchung von einem anderem User ist-->
        <div v-if="bookings_workstation.length==0" class="table-item icon">
            <router-link class="coba-utilization-indicator"
                         :class="{'coba-utilization-indicator-red':color==='red',
                                'coba-utilization-indicator-green':color==='green',
                                'coba-utilization-indicator-orange':color==='orange',
                                'coba-utilization-indicator-disabled':today.setHours(0,0,0,0) > new Date(date).setHours(0,0,0,0)
                                }"
                         :to="{ name: 'DateTimeSelection', params: { workstation_id:workstation.id, preSelectedDays: [dayObj], calenderBool: true }}">
                <b-icon icon="plus"></b-icon>
            </router-link>
        </div>
        <div v-else class="table-item icon">
            <div v-if="is_one_booking_from_user">
                <!-- Drop Down list with pencil icon to toggle it -->
                <div class="table-item icon coba-dropdown-container" @click="toggleDropDown(booking_from_user)">    <!-- @click="openDropDown(booking)" - Triggerbox around the pencil icon, it opens a drop down List -->
                    <!-- Pencil Icon inside the trigger box -> will have a white background when drop down opens -->
                    <div :class="{'grey-background':dropDown.open&&dropDown.id === booking_from_user.id}">
                        <b-icon icon="pencil"></b-icon>
                    </div>
                    <!-- Drop Down start -->
                    <div v-if="dropDown.open && dropDown.id === booking_from_user.id" class="coba-dropdown-wrapper" style="bottom: -52px; z-index: 2; right: -11px">
                        <div class="coba-dropdown-content" style="background-color: #EBEBEB">
                            <ul class="coba-list-nobullets" style="margin: 0px">
                                <li style="border-bottom: 1px solid #505050"> <button style="background-color:rgba(255,255,255,0);">Bearbeiten</button> </li>
                                <li class="last" > <button style="background-color:rgba(255,255,255,0);" @click="openModal(booking_from_user)">Löschen</button> </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- drop down end -->
            </div>
            <div v-else>
                <router-link class="coba-utilization-indicator"
                             :class="{'coba-utilization-indicator-red':color==='red',
                                'coba-utilization-indicator-green':color==='green',
                                'coba-utilization-indicator-orange':color==='orange',
                                'coba-utilization-indicator-disabled':today.setHours(0,0,0,0) > new Date(date).setHours(0,0,0,0)
                                }"
                             :to="{ name: 'DateTimeSelection', params: { workstation_id:workstation.id, preSelectedDays: [dayObj], calenderBool: true }}">
                    <b-icon icon="plus"></b-icon>
                </router-link>
            </div>
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
    props: ['workstation', 'bookings', 'users', 'date', 'user_id'],
    data() {
        return {
            time: "-",
            name: "",
            user_booking_list: [], //Enthält die User, die eine Buchung für die Workingstation getätigt haben
            bookings_workstation: [], //Enthält die Buchungen für die Workingstation
            is_one_booking_from_user: false, //getätigte Buchung vom user existiert oder nicht
            booking_from_user: null, //Buchung vom user
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
        //Alle Buchungen für diese Workstation abspeichern
        let bookings_for_this_workstation = [];
        for(let i = 0; i < this.bookings.length; i++) {
            if(this.bookings[i].workstation_id === this.workstation.id) {
                bookings_for_this_workstation.push(this.bookings[i]);
            }
        }

        //Buchungen nach aufsteigend nach der Uhrzeit sortieren
        this.bookings_workstation = bookings_for_this_workstation.sort((a,b) => (a.from > b.from) ? 1 : -1);

        //Prüfen, ob eine Buchung vom user existiert und diese abspeichern
        for(let i = 0; i < this.bookings_workstation.length; i++) {
            if(this.bookings_workstation[i].user_id === this.user_id) {
               this.is_one_booking_from_user = true;
               this.booking_from_user = this.bookings_workstation[i];
            }
        }

        //Users abspeichern, die die Buchungen getätigt haben
        let user_booking_workstation_list = [];
        for(let i = 0; i < this.bookings_workstation.length; i++) {
            for(let j = 0; j < this.users.length; j++){
                if(this.users[j].user_id === this.bookings_workstation[i].user_id) {
                    user_booking_workstation_list.push(this.users[j]);
                }
            }
        }
        this.user_booking_list = user_booking_workstation_list;

        this.calcInfo(bookings_for_this_workstation);
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
            //let user = this.users.find(x => x.user_id === bookings[0].user_id);
            //this.bookings_workstation = bookings[0];
            //this.user_id = user.user_id;
            //this.name = user.firstName + " " + user.lastName;
            //this.time = (startBooking.from.substr(0,5) +" - " + endBooking.to.substr(0,5));
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
    display: flex;
    flex-direction: column;
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
}
.seat {
    width: 13%;
}
.time {
    width: 35%;
}
.name {
    width: 25%;
}
.icon {
    width: 10%;
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
