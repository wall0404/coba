<template>
    <div class="calendar-container">
        <div class="week-container">
            <div class="calendar-week header">
                <div class="calendar-day-of-week"><span>M</span></div>
                <div class="calendar-day-of-week"><span>D</span></div>
                <div class="calendar-day-of-week"><span>M</span></div>
                <div class="calendar-day-of-week"><span>D</span></div>
                <div class="calendar-day-of-week"><span>F</span></div>
                <div class="calendar-day-of-week weekend"><span>S</span></div>
                <div class="calendar-day-of-week weekend"><span>S</span></div>
            </div>
            <div class="calendar-week" v-for="n in 5">
                <div class="calendar-day-of-week" v-for="k in 7" :class="{'booked':(n+k)%2, 'weekend':(k===6||k===7), 'today':(n===2&&k===3), 'selected':(selected[0]===n&&selected[1]===k)}" @click="selectDate(n,k)">
                    <span>{{k}}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Calendar",
    data() {
        return {
            selected: [2,3]
        }
    },
    methods: {
        selectDate(n,k) {
            if(k===6 || k===7)
                return;
            this.selected = [n,k];
        }
    }
}
</script>

<style scoped>
    .calendar-container {
        width: 100%;
    }
    .week-container {
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .calendar-week.header {
        border-bottom: 1px solid #8C8C8C;
    }
    .calendar-week {
        flex-grow: 1;
        display: flex;
        justify-content: space-evenly;
    }
    .calendar-day-of-week {
        text-align: center;
        display: flex;
        flex-direction: column;
        height: calc(100vw / 9);
        width: calc(100vw / 9);
        border-radius: 50px;
        border: 2px solid transparent;
    }
    .calendar-day-of-week::after {
        content: ' ';
    }
    .calendar-day-of-week.booked::after {
        content: '\2022';
        margin-top: -10px;
    }
    .calendar-day-of-week.weekend {
        color: gray;
    }
    .calendar-day-of-week.selected {
        background-color: orange;
    }
    .calendar-day-of-week.today {
        border-color: orange;
    }

    .header .calendar-day-of-week {
        justify-content: center;
    }
</style>
