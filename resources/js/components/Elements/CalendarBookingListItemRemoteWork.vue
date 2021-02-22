<template>
    <div class="booking py-3">
        <!-- Anzeige der Buchungszeiten -->
        <div class="table-item time">
            {{booking.from.substring(0,5)}} - {{booking.to.substring(0,5)}}
        </div>

        <!-- Anzeige der Person, die den Platz gebucht hat -->
        <div class="table-item name">
            <router-link v-if="user.user_id===$store.getters.data.user.user_id" :to="'/profile'">{{user.firstName}}</router-link> <!-- Weiterleitung zum eigenen Profil -->
            <router-link v-else :to="'/team/'+user.user_id">{{user.firstName}} {{user.lastName.substring(0,1)}}.</router-link> <!-- Weiterleitung zum Profil des Teammitglieds -->
        </div>

        <div v-if="user.user_id===$store.getters.data.user.user_id">
            <edit-tool :openDD="dropDown.open" :booking="booking" :colorBack="this.colorBack" @modal-close-event="toggleDropDown(booking)" @modal-delete-event="delBookingfkn()"> </edit-tool>
        </div>
    </div>
</template>

<script>
import Modal from "./Modal";
import EditTool from "./EditTool";
export default {
    name: "CalendarBookingListItemRemoteWork",
    components: {EditTool},
    props: ['user', 'booking'],
    data() {
        return {
            colorBack: "gray",
            dropDown: {
                id: "",
                open: false
            },
        }
    },
    methods: {
        toggleDropDown(booking){
            this.dropDown.open = !this.dropDown.open;
            this.dropDown.id = booking.id;
        },
        delBookingfkn(id){
            this.$emit('refresh-list');
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
    width: 25%;
}
.time {
    width: 35%;
}
.name {
    width: 54%;
}
.icon {
    width: 10%;
    justify-content: center;
    align-items: center;
}
</style>
