<template>
    <div class="calendar-container">
        <!--<div @click="nextMonth()">Add</div>-->
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
                <div class="calendar-day-of-week" v-for="(day, dayOfWeek) in week" :class="{'booked':my_bookings.find(x => x.date === day.date), 'weekend':(dayOfWeek===5||dayOfWeek===6), 'today':day.date===today.toISOString().slice(0, 10), 'selected':selectedDate===day.date}" @click="selectDate(day.date)">
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
            initialMonth: 0,
            initialYear: 0,
            calendar_dates: [],
            my_bookings: [],
            load: false,
            error: null,
        }
    },
    created() {
        //month
        // 0 => Januar, 1 => Februar
        //day in week
        // 0 => Sunday, 1 => Monday
        this.initialMonth = this.today.getMonth();
        this.initialYear = this.today.getFullYear();
        this.selectedDate = this.today.toISOString().slice(0, 10);


        this.initiateCalendar(this.initialYear, this.initialMonth)
    },
    methods: {
        initiateCalendar(year, month) {
            this.initialYear = year;
            this.initialMonth = month;
            this.calendar_dates = [];

            this.firstDayInMonth.setDate(1);
            this.firstDayInMonth.setMonth(this.initialMonth);
            this.firstDayInMonth.setFullYear(this.initialYear);

            this.fetchMyBookings()

            this.startDate = new Date(this.firstDayInMonth);


            let dayOfWeek = this.firstDayInMonth.getUTCDay();
            dayOfWeek = dayOfWeek === 6 ? -1 : dayOfWeek;
            this.startDate.setDate(this.firstDayInMonth.getDate() - dayOfWeek + 1);


            while (true) {
                if(this.startDate.getMonth() === (this.initialMonth+1) || (this.initialMonth===11 && this.startDate.getMonth() === 0))
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
        },
        selectDate(date) {
            let dateObj = new Date(date);
            let k = dateObj.getUTCDay();
            if(k===6 || k===0)
                return;
            this.selectedDate = date;
            this.$emit('dateSelected', this.selectedDate);
        },
        fetchMyBookings() {
            this.load = true;
            fetch('/api/user/'+this.$store.getters.data.user.user_id+'/bookings?order_by=date&filter[date][min]='+this.firstDayInMonth.toISOString().slice(0, 10), {
                method: 'GET',
                headers: {
                    'content-type': 'application/json',
                    'Authorization' : 'Bearer '+localStorage.token
                }
            })
                .then(res => res.json())
                .then(res => {
                    if(res.success) {
                        this.my_bookings = res.success;
                        this.load = false;
                    }
                    else {
                        this.error = true;
                        this.load = false;
                    }
                })
                .catch(error => {
                    console.log(error);
                    this.load = false;
                })
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
