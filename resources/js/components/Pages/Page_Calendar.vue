<template>
    <div class="coba-page page">
        <!-- opens the sidebar if the icon on the page is clicked and receives the filter values from CalendarSidebar -->
        <b-icon v-if="!open" icon="list" class="coba-calendar-sidebar-icon" font-scale="2" @click="toggleSidebar()">
        </b-icon>
        <CalendarSidebar :show_sidebar="open" @modal-close-event="toggleSidebar()" @change-event="callbackChange"></CalendarSidebar>

        <!--calendar-->
        <div class="coba-container coba-header coba-header-square mb-0">
            <div class="headline-button-container">
                <span @click="prevMonth"><b-icon icon="caret-left-fill" font-scale="1.25"></b-icon></span>
                <span class="coba-page-headline">{{ monthString[initialMonth] +" "+initialYear}}</span>
                <span @click="nextMonth"><b-icon icon="caret-right-fill" font-scale="1.25"></b-icon> </span>
            </div>
        </div>

        <!-- sends the received filter to calendar-booking-list, so a booking list according to the selected options can be generated-->
        <div class="content">
            <calendar ref="calendar" class="calendar" @dateSelected="callbackDateSelect"></calendar>
            <calendar-booking-list ref="list" class="booking-list" :selectFilter="passedFilter" ></calendar-booking-list>
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
            passedFilter: {},

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
        },

        callbackChange(filter){
            this.passedFilter = filter;
        }

    }
}
</script>

<style scoped>
    .page {
        min-height: 100%;
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

    .transparent-icon{
        color: transparent;
    }
</style>
