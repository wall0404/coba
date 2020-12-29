<template>
    <div class="coba-page page">
        <div class="coba-container coba-header coba-header-square mb-0">
            <span class="coba-page-headline">Calendar</span>
        </div>
        <div class="coba-tab-navigation">
            <div class="coba-tab selected">Campus</div>
            <div class="coba-tab">Tower</div>
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
    components: {CalendarBookingList, Calendar}
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
