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
            <div class="calendar-week" v-for="week in calendar_dates">
                <div class="calendar-day-of-week" v-for="(day, dayOfWeek) in week" :class="{'booked':false, 'weekend':(dayOfWeek===5||dayOfWeek===6), 'today':day.date===today.toISOString().slice(0, 10), 'selected':selectedDate===day.date}" @click="selectDate(day.date)">
                     <span>{{day.day}}</span>
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
            today: new Date(),
            selectedDate: null,
            firstDayInMonth: new Date(),
            startDate: null,
            initialMonth: 11,
            initialYear: 2020,
            calendar_dates: []
        }
    },
    created() {
        //month
        // 0 => Januar, 1 => Februar
        //day in week
        // 0 => Sunday, 1 => Monday
        this.selectedDate = this.today.toISOString().slice(0, 10);
        //this.initiateCalendar()
    },
    methods: {
        initiateCalendar() {
            this.firstDayInMonth.setDate(1);
            this.firstDayInMonth.setMonth(this.initialMonth);
            //this.firstDayInMonth.setFullYear(this.initialYear);
            console.log(this.initialMonth)

            this.startDate = new Date(this.firstDayInMonth);

            //console.log(this.firstDayInMonth.toISOString().slice(0, 10));

            let dayOfWeek = this.firstDayInMonth.getUTCDay();
            dayOfWeek = dayOfWeek === 6 ? -1 : dayOfWeek;
            this.startDate.setDate(this.firstDayInMonth.getDate() - dayOfWeek + 1);

            console.log(this.startDate.toISOString().slice(0, 10));

            while (true) {
                if(this.startDate.getMonth() === (this.month+1) || (this.month===11 && this.startDate.getMonth() === 0))
                    break; //we reached the next month

                //Add a new week
                let week = [];
                for(let i = 0; i<7; i++) {
                    week.push({
                        day: this.startDate.getDate(),
                        date: this.startDate.toISOString().slice(0, 10),
                        bookings: null,
                    })
                    this.startDate.setDate(this.startDate.getDate() + 1);
                }

                this.calendar_dates.push(week);
            }
            console.log(this.calendar_dates)
        },
        selectDate(date) {
            let dateObj = new Date(date);
            let k = dateObj.getUTCDay();
            if(k===6 || k===0)
                return;
            this.selectedDate = date;
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
