<template>
    <div class="time_picker">
        <vue-range-slider ref="slider" v-model="day.time" :min="min" :max="max" :formatter='formatter' :enable-cross="true" :step="0.5" @slide-end='slideEnd'
                          :tooltip-style="{backgroundColor: 'transparent', border: 'none', color: 'black'}">
        </vue-range-slider>
        <div class="coba-text">{{ day.date.toLocaleDateString('de-DE', this.$date_options_long) }}</div>
        <div v-for="booking in ownBookings">
            <span v-if="booking.date===day.date.toISOString().slice(0,10) && booking===doubleBooking[0]" class="coba-text coba-text-danger" >Du hast an diesem Tag schon eine Buchung von {{booking.from.substr(0,5)}} bis {{booking.to.substr(0,5)}}</span>
            <span v-else-if="booking.date===day.date.toISOString().slice(0,10)" class="coba-text coba-text-danger">und von {{booking.from.substr(0,5)}} bis {{booking.to.substr(0,5)}}</span>
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
            ownBookings: [],
            doubleBooking: [],
            formatter: (v) => `${Math.round(v-0.1)}.${v%1===0?'00':'30'}`,
        }
    },
    created() {
        this.fetchData();
        this.booked_start = (Number(this.day.booked_start.substr(0,2))+(this.day.booked_start.substr(3,2)==="00"?0:0.5));
        this.booked_end = (Number(this.day.booked_end.substr(0,2))+(this.day.booked_end.substr(3,2)==="00"?0:0.5));
    },
    methods: {
        setDoubleBooking(){
            let i = 0;
            for (let k = 0; k<this.ownBookings.length; k++){
                if(this.ownBookings[k].date===this.day.date.toISOString().slice(0,10)){
                    this.doubleBooking.push(this.ownBookings[k]);
                }
            }
        },
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
                        this.setDoubleBooking();
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
