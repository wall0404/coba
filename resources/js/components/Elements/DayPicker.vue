<template>
    <div>
        <div v-if="workstation && workstation.id !== null" class="coba-text coba-text-big coba-text-strong coba-text-center">{{workstation.location?workstation.location.name:''}} - {{workstation.name}}</div>
        <div v-else-if="workstation && workstation.id === null" class="coba-text coba-text-big coba-text-strong coba-text-center">{{workstation.name}}</div> <!-- extra exception for Homeoffice -->
        <div class="coba-text-strong coba-text coba-text-center">{{weekStartStr}} - {{weekEndStr}}</div>
        <div class="coba-utilization-indicator-container">
            <div :class="{'coba-utilization-indicator':true, 'coba-utilization-indicator-arrow-prev':true, 'coba-utilization-indicator-big':true, 'coba-utilization-indicator-disabled':page===0}" @click="prevPage">➤</div>
            <!-- the days as coloured circles -->
            <div v-for="day in days" :class="'coba-utilization-indicator coba-utilization-indicator-big coba-utilization-indicator-'+day.color+' '+(day.selected?'coba-utilization-indicator-selected-'+day.color:'')+(day.disabled?'coba-utilization-indicator-disabled':'')"
                @click="selectDate(day)">
                <!-- position of the weekday in reference to the check-sign -->
                <span v-if="amountOfBookings(day)>0" style="position: relative; left: 30%;">{{day.day.substring(0,1)}}</span>
                <span v-else>{{day.day.substring(0,1)}}</span>
                <!-- a check-sign if the user has already booked a seat for this date -->
                <b-iconstack v-if="amountOfBookings(day)>0" font-scale="1.5" shift-h="4" shift-v="-10">
                    <b-icon stacked icon="circle-fill" style="color:#EBEBEB"></b-icon>
                    <b-icon stacked icon="check" style="color:#2C2C2C"></b-icon>
                    <b-icon stacked icon="circle" style="color:#2C2C2C"></b-icon>
                </b-iconstack>

            </div>
            <div class="coba-utilization-indicator coba-utilization-indicator-arrow-next coba-utilization-indicator-big" :class="{'coba-utilization-indicator-disabled':page===2}" @click="nextPage">➤</div>
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
            pages: [],
            ownBookings: []
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

        this.fetchData();
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
                else if(this.preSelectedDays[i].date < page_weeks[1]) {
                    this.selectDate(this.pages[0][this.preSelectedDays[i].date.getUTCDay()-1], this.preSelectedDays[i].time)
                    this.page = 0;
                }
                else if(this.preSelectedDays[i].date < page_weeks[2]) {
                    this.selectDate(this.pages[1][this.preSelectedDays[i].date.getUTCDay()-1], this.preSelectedDays[i].time)
                    this.page = 1;
                }
                else if(this.preSelectedDays[i].date < page_weeks[3]) {
                    this.selectDate(this.pages[2][this.preSelectedDays[i].date.getUTCDay()-1], this.preSelectedDays[i].time)
                    this.page = 2;
                }
            }
            this.initiateDates();
        }
        else {
            this.initiateDates();
        }

    },
    methods: {
        fetchData() {
            this.load = true;
            let date = new Date();
            this.today_date = date.toISOString().slice(0, 10); //cuts off the time: only date
            fetch('/api/user/'+this.$store.getters.data.user.user_id+'/bookings?order_by=date&filter[date][min]='+this.today_date, {
                method: 'GET',
                headers: {
                    'content-type': 'application/json',
                    'Authorization' : 'Bearer '+localStorage.token
                }
            })
                .then(res => res.json())
                .then(res => {
                    if(res.success) {
                        this.ownBookings = res.success;
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
        },
        //tells how many bookings a user already has for a day
        amountOfBookings(dayNow){
            let i = 0;
            for (var k = 0;k<this.ownBookings.length;k++){
                if(this.ownBookings[k].date===dayNow.date.toISOString().slice(0,10)) {
                    i++;
                }
            } return i;
        },

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
            //Dont allow scrolling into future
            if(this.page > 2)
                this.page = 2;

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


            if(hours >= 8)
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
.coba-check-circle{
    ;
}
</style>
