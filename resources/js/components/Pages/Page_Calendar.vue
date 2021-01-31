<template>
    <div class="coba-page page">

        <CalendarSidebar :show_sidebar="open"></CalendarSidebar>

        <div class="coba-container coba-header coba-header-square mb-0">

            <div class="headline-button-container">
                <span @click="prevMonth"><b-icon icon="caret-left-fill" font-scale="1.25"></b-icon></span>
                <span class="coba-page-headline">{{ monthString[initialMonth] +" "+initialYear}}</span>
                <span @click="nextMonth"><b-icon icon="caret-right-fill" font-scale="1.25"></b-icon> </span>
            </div>
        </div>

        <b-icon icon="list" class="coba-calendar-sidebar-icon" :class="{'transparent-icon': open}" font-scale="2" @click="toggleSidebar()">
        </b-icon>

        <div class="content">
            <calendar ref="calendar" class="calendar" @dateSelected="callbackDateSelect"></calendar>
            <calendar-booking-list ref="list" class="booking-list" :selected-locations="selectedLocations"></calendar-booking-list>
        </div>



    </div>
</template>

<script>
import Calendar from "../Elements/Calendar";
import CalendarBookingList from "../Elements/CalendarBookingList";
import CalendarSidebar from "../CalendarSidebar";
export default {
    name: "Page_Calendar",
    components: {CalendarSidebar, CalendarBookingList, Calendar},
    data() {
        return {
            today: new Date(),
            selectedLocations: [],
            selectedDate: null,
            initialMonth: 0,
            initialYear: 0,
            open:false,
            monthString: ["Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember"],

        }
    },
    created() {
        this.selectedLocations.push(this.$store.getters.locations[0].id)

        this.initialMonth = this.today.getMonth();
        this.initialYear = this.today.getFullYear();
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
        },
        nextMonth() {
            this.initialMonth++;
            if(this.initialMonth > 11) {
                this.initialMonth = 0;
                this.initialYear++;
            }
            this.$refs.calendar.initiateCalendar(this.initialYear, this.initialMonth);
        },
        prevMonth() {
            this.initialMonth--;
            if(this.initialMonth < 0) {
                this.initialMonth = 11;
                this.initialYear--;
            }
            this.$refs.calendar.initiateCalendar(this.initialYear, this.initialMonth);
        },

        toggleSidebar() {
            this.open = !this.open;
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

    .headline-button-container {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .coba-page-headline {
        padding-left: 20px;
        flex-grow: 1;
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

    .coba-calendar-sidebar-icon{
        width: 20px;
        height: 20px;
        position: fixed;
        top: 30px;
        right: 30px;
        color: white;
        z-index: 0;

    }

    .transparent-icon{
        color: transparent;
    }
</style>
