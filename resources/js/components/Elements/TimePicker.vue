<template>
    <div class="time_picker">
        <vue-range-slider v-model="day.time" :min="min" :max="max" :formatter='formatter' :enable-cross="true" :step="0.5"
                          :tooltip-style="{backgroundColor: 'transparent', border: 'none', color: 'black'}">
        </vue-range-slider>
        <div class="coba-text">{{ day.date.toLocaleDateString('de-DE', this.$date_options_long) }}</div>
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
            formatter: (v) => `${Math.round(v-0.1)}.${v%1===0?'00':'30'}`,
        }
    },
    created() {
    }
}
</script>

<style scoped>
    .time_picker {
        padding-top: 50px;
    }
</style>
