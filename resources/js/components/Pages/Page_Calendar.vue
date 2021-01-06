<template>
    <div class="coba-page page">
        <div class="coba-container coba-header coba-header-square mb-0">
            <span class="coba-page-headline">{{today.toLocaleDateString('de-DE', this.$only_month_and_year)}}</span>
        </div>
        <div class="coba-tab-navigation">
            <div v-for="(location, index) in locations" class="coba-tab" :class="location.selected?'selected':''" :key="index" @click="selectLocation(index)">
                {{ location.name }}
            </div>
        </div>
        <div class="content">
            <calendar class="calendar"></calendar>
            <calendar-booking-list class="booking-list"></calendar-booking-list>
        </div>

    </div>
</template>

<script>
import Calendar from "../Elements/Calendar";
import CalendarBookingList from "../Elements/CalendarBookingList";
export default {
    name: "Page_Calendar",
    components: {CalendarBookingList, Calendar},
    data() {
        return {
            today: new Date(),
            locations: this.$store.getters.locations,
            selectedDate: null,
        }
    },
    created() {
        this.locations[0].selected = true;
        for(let i = 1; i < this.locations.length; i++) {
            this.locations[i].selected = false;
        }
    },
    methods: {
        selectLocation(index) {
            this.locations[index].selected = !this.locations[index].selected;
            console.log(this.locations[index].selected)
        },
    }
}
</script>

<style scoped>
    .page {
        height: 100vh;
        display: flex;
        flex-direction: column;
    }
    .coba-header {
        flex-grow: 2;
    }
    .coba-tab-navigation {
        flex-grow: 1;
    }
    .content {
        display: flex;
        flex-direction: column;
        height: 400px;
        flex-grow: 60;
    }
    .calendar {
        flex-grow: 3;
    }
    .booking-list {
        flex-grow: 50;
    }
</style>
