<template>
    <div class="coba-utilization-indicator-container">
        <div v-for="day in days" :class="'coba-utilization-indicator coba-utilization-indicator-'+day.color+' '+(day.selected?'coba-utilization-indicator-selected':'')" >{{day.day.substring(0,1)}}</div>
    </div>
</template>

<script>
export default {
    name: "DayPicker",
    //props: ['days'],
    data() {
        return {
            days: [
                {day: "Montag", color:"green", selected: false},
                {day: "Dienstag", color:"orange", selected: true}
            ]
        }
    },
}
</script>

<style scoped>

</style>
