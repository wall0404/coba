<template>
    <div>
        <div v-if="workstation" class="coba-text coba-text-big coba-text-strong coba-text-center">{{workstation.location?workstation.location.name:''}} - {{workstation.name}}</div>
        <div class="coba-text-strong coba-text coba-text-center">{{weekStartStr}} - {{weekEndStr}}</div>
        <div class="coba-utilization-indicator-container">
            <div :class="{'coba-utilization-indicator':true, 'coba-utilization-indicator-arrow-prev':true, 'coba-utilization-indicator-big':true, 'coba-utilization-indicator-disabled':page===0}" @click="prevPage">➤</div>
            <div v-for="day in days" :class="'coba-utilization-indicator coba-utilization-indicator-big coba-utilization-indicator-'+day.color+' '+(day.selected?'coba-utilization-indicator-selected':'')+(day.disabled?'coba-utilization-indicator-disabled':'')"
                @click="selectDate(day)">{{day.day.substring(0,1)}}</div>
            <div class="coba-utilization-indicator coba-utilization-indicator-arrow-next coba-utilization-indicator-big" @click="nextPage">➤</div>
        </div>
    </div>

</template>

<script>
export default {
    name: "DayPicker",
    props: ['workstation','bookings', 'preSelectedDays'],
    data() {
        return {
            todayDate: new Date(),
            weekStart: null,
            weekEnd: null,
            page: 0,
            days: [],
            pages: []
        }
    },
    computed: {
        weekStartStr: function() {
            try {
                return this.weekStart.toLocaleDateString('de-DE', this.$date_options_short);
            }
            catch (e) {}
        },
        weekEndStr: function () {
            try {
                return this.weekEnd.toLocaleDateString('de-DE', this.$date_options_short);
            }
            catch (e) {}
        },
    },
    created() {

        if(typeof this.preSelectedDays !== 'undefined' && this.preSelectedDays.length > 0) {
            //es wurden Tage übergeben


            //Berechne das Datum der ersten Tage jeder Page
            let page_weeks = {};
            for(let page = 0; page<4; page++) {
                page_weeks[page] = new Date();
                page_weeks[page].setHours(0,0,0,0);
                page_weeks[page].setDate(page_weeks[page].getDate()+1);
                let dayOfWeek = page_weeks[page].getUTCDay();
                dayOfWeek = dayOfWeek===6?(-1):dayOfWeek;
                page_weeks[page].setDate(new Date().getDate() - dayOfWeek + 1 + (page * 7));

            }

            this.initiateAllDates();

            //check for each preselected day on which page it is
            for(let i = 0; i<this.preSelectedDays.length; i++) {

                if(this.preSelectedDays[i].date < page_weeks[0]) {}
                else if(this.preSelectedDays[i].date < page_weeks[1])
                    this.selectDate(this.pages[0][this.preSelectedDays[i].date.getUTCDay()-1], this.preSelectedDays[i].time)
                else if(this.preSelectedDays[i].date < page_weeks[2])
                    this.selectDate(this.pages[1][this.preSelectedDays[i].date.getUTCDay()-1], this.preSelectedDays[i].time)
                else if(this.preSelectedDays[i].date < page_weeks[3]) {
                    this.selectDate(this.pages[2][this.preSelectedDays[i].date.getUTCDay()-1], this.preSelectedDays[i].time)
                }
            }
        }
        else {
            this.initiateDates();
        }

    },
    methods: {
        initiateAllDates() {
            this.page = 2;
            this.initiateDates();
            this.page = 1;
            this.initiateDates();
            this.page = 0;
            this.initiateDates();
        },
        initiateDates() {
            //Dont allow scrolling into past
            if(this.page < 0)
                this.page = 0;

            this.weekStart = new Date();
            this.weekEnd = new Date();

            //set start of the week
            let dayOfWeek = this.weekStart.getUTCDay();
            dayOfWeek = dayOfWeek===6?(-1):dayOfWeek;
            this.weekStart.setDate(new Date().getDate() - dayOfWeek + 1 + (this.page * 7));


            let date = new Date(this.weekStart.getTime())
            if(typeof this.pages[this.page] == "undefined") {
                //This page wasn't rendered before
                this.pages[this.page] = [];
                //Crate badge for every day in this week
                for(let i = 0; i < 5; i++) {
                    let day_info = null;
                    let disabled = false; //Daypicker is disabled, if in the past
                    let color = "gray";
                    if(this.todayDate > date)   {
                        disabled = true;
                        day_info = {
                            free_start: "00:00:00",
                            free_end: "24:00:00",
                            time: [9,17]
                        };
                    }
                    else if(typeof this.bookings[date.toISOString().slice(0, 10)] == "undefined"){
                        color = "green";
                        day_info = {
                            free_start: "00:00:00",
                            free_end: "24:00:00",
                            time: [9,17]
                        };
                    }
                    else {
                        day_info = this.calcInfo(this.bookings[date.toISOString().slice(0, 10)])
                        color = day_info.color;
                    }

                    if(color === "red")
                        disabled = true;
                    this.pages[this.page].push({day: this.dateToDayOfMonth(date), color: color, selected: false, date: new Date(date.getTime()), time: day_info.time, disabled: disabled, booked_start: day_info.free_start, booked_end: day_info.free_end });


                    date.setDate(date.getDate() + 1);
                }
            }
            else {
                //If the dates were already calculated, only calculate the end of the week
                for(let i = 0; i < 5; i++)
                    date.setDate(date.getDate() + 1);
            }
            this.weekEnd.setDate(date.getDate()-1);
            this.days = this.pages[this.page];
        },

        calcInfo(bookings) {
            let color = "";
            let hours = 0;
            let startHour = 24;
            let startBooking = null;
            let endHour = 0;
            let endBooking = null;
            let time = [9,17];

            for(let i = 0; i < bookings.length; i++) {
                hours += Number(bookings[i].to.substring(0,2)) - Number(bookings[i].from.substring(0,2));
                if(Number(bookings[i].to.substring(0,2))  > endHour) {
                    endHour = Number(bookings[i].to.substring(0, 2));
                    endBooking = bookings[i];
                }
                if(Number(bookings[i].from.substring(0,2))  < startHour) {
                    startHour = Number(bookings[i].from.substring(0, 2));
                    startBooking = bookings[i];
                }
            }

            if(Number(endBooking.to.substr(0,2))<14) {
                time = [
                    Number(endBooking.to.substr(0,2))+(endBooking.to.substr(3,2)==="00"?0:0.5),
                    17
                ]
            }
            else {
                time = [
                    9,
                    Number(startBooking.from.substr(0,2))+(startBooking.from.substr(3,2)==="00"?0:0.5)
                ]
            }


            if(hours >= 5)
                color = "red";//mark red
            else
                color = "orange"; //mark orange

            return {color:color, free_start: startBooking.from, free_end: endBooking.to, time};
        },

        dateToDayOfMonth(date) {
            let days = ["Sonntag","Montag","Dienstag","Mittwoch","Donnerstag","Freitag","Samstag"];
            return days[date.getUTCDay()];
        },
        selectDate(day, time) {
            if(!day.disabled) {
                if(typeof time !== 'undefined')
                    day.time = time

                day.selected = !day.selected;
                day.workstation = this.workstation;
                this.$emit('callback-picker-event', day);
            }
        },
        nextPage() {
            this.page++;
            this.initiateDates();
        },
        prevPage() {
            this.page--;
            this.initiateDates();
        }
    }
}
</script>

<style scoped>

</style>
