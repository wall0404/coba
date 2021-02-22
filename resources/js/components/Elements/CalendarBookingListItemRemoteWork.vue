<template>
    <div class="booking py-3" :class="{'strong':user.user_id === $store.getters.data.user.user_id}"> <!-- :class="{'strong':user_id === $store.getters.data.user.user_id}" -->
        <!-- Anzeige der Buchungszeiten -->
        <div class="table-item time">
            {{booking.from.substring(0,5)}} - {{booking.to.substring(0,5)}}
        </div>

        <!-- Anzeige der Person, die den Platz gebucht hat -->
        <div class="table-item name">
            <router-link :to="'/team/'+user.user_id">{{user.firstName}} {{user.lastName}}</router-link>
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
    methods: {
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
    width: 25%;
}
.icon {
    width: 10%;
    justify-content: center;
    align-items: center;
}
</style>
