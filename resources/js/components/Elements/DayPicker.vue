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
    props: ['workstation','bookings'],
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
        this.initiateDates();
    },
    methods: {
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
                    let disabled = this.todayDate > date;
                    this.pages[this.page].push({day: this.dateToDayOfMonth(date), color: 'gray', selected: false, date: new Date(date.getTime()), time: [9,17], disabled: disabled});
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
        dateToDayOfMonth(date) {
            let days = ["Sonntag","Montag","Dienstag","Mittwoch","Donnerstag","Freitag","Samstag"];
            return days[date.getUTCDay()];
        },
        selectDate(day) {
            if(!day.disabled) {
                day.selected = !day.selected;
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
