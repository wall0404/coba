<template>
    <div class="time_picker">
        <vue-range-slider ref="slider" v-model="day.time" :min="min" :max="max" :formatter='formatter' :enable-cross="true" :step="0.5" @slide-end='slideEnd'
                          :tooltip-style="{backgroundColor: 'transparent', border: 'none', color: 'black'}">
        </vue-range-slider>
        <div class="coba-text">{{ day.date.toLocaleDateString('de-DE', this.$date_options_long) }}</div>
        <div v-for="(booking,index) in day.myBookings">
            <span v-if="index===0" class="coba-text coba-text-danger" >Du hast an diesem Tag schon eine Buchung von {{booking.from.substr(0,5)}} bis {{booking.to.substr(0,5)}}</span>
            <span v-else class="coba-text coba-text-danger">und von {{booking.from.substr(0,5)}} bis {{booking.to.substr(0,5)}}</span>
        </div>
    </div>
</template>

<script>
import 'vue-range-component/dist/vue-range-slider.css'

export default {
    name: "TimePicker",
    props: ['bookings', 'day'],
    data() {
        return {
            min: 6,
            max: 20,
            booked_start: 0,
            booked_end: 24,
            formatter: (v) => `${Math.round(v-0.1)}.${v%1===0?'00':'30'}`,
        }
    },
    created() {
        this.booked_start = (Number(this.day.booked_start.substr(0,2))+(this.day.booked_start.substr(3,2)==="00"?0:0.5));
        this.booked_end = (Number(this.day.booked_end.substr(0,2))+(this.day.booked_end.substr(3,2)==="00"?0:0.5));
    },
    methods: {
        slideEnd(value) {
            if(value[0] < this.booked_start && value[1] >= this.booked_start ) {
                //Buchung beginnt vor anderer Buchung und ragt rein
                //value[1] = this.booked_start;
                this.$refs.slider.setValue([value[0], this.booked_start]);
            }
            else if(value[0] <= this.booked_end && value[1] > this.booked_end ) {
                //Buchung beginnt während anderer Buchung
                //value[0] = this.booked_end;
                this.$refs.slider.setValue([this.booked_end, value[1]]);
            }
        }
    }
}
</script>

<style scoped>
    .time_picker {
        padding-top: 50px;
    }
</style>
