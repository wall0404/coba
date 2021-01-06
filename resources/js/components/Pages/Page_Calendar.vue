<template>
    <div class="coba-page page">
        <div class="coba-container coba-header coba-header-square mb-0">
            <span class="coba-page-headline">{{today.toLocaleDateString('de-DE', this.$only_month_and_year)}}</span>
        </div>
        <div class="coba-tab-navigation">
            <div v-for="(location, index) in $store.getters.locations" :class="{'selected':selectedLocations.find(id => id === location.id)}" class="coba-tab" :key="index" @click="selectLocation(location.id)">
                {{ location.name }}
            </div>
        </div>
        <div class="content">
            <calendar class="calendar" @dateSelected="callbackDateSelect"></calendar>
            <calendar-booking-list ref="list" class="booking-list" :selected-locations="selectedLocations"></calendar-booking-list>
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
            selectedLocations: [],
            selectedDate: null,
        }
    },
    created() {
        this.selectedLocations.push(this.$store.getters.locations[0].id)
    },
    methods: {
        selectLocation(location_id) {
            let index = this.selectedLocations.indexOf(location_id);
            if(index === -1) {
                //add to array
                this.selectedLocations.push(location_id)
            }
            else {
                //remove only if afterwards at least one location is left
                if(this.selectedLocations.length > 1) {
                    this.selectedLocations.splice(index, 1)
                }
            }
        },
        callbackDateSelect(date) {
            this.selectedDate = date;
            this.$refs.list.fetchBookingsForDate(date);
        }
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
