<template>


    <div v-if="show_sidebar" class="coba-calendar-wrapper" @click.self="$emit('modal-close-event')">

        <div class="coba-calendar-container">

        <div class="coba-calendar-sidebar-content">
            <div class="coba-calendar-sidebar-header"> Standorte </div>
            <ul class="coba-list-nobul-nobor">

                <li><label><input type="checkbox" class="coba-check" v-for="location in locations" :key="location.id"> {{location.name}} </label></li>

                <!-- <li><label :class="{'checked': filter.location.digcam}"><input type="checkbox" name="cb" @change="change" v-model="filter.location.digcam" class="coba-check"> Digitaler Campus </label></li>
                <li><label><input type="checkbox" class="coba-check"> Tower </label></li>
                <li><label><input type="checkbox" class="coba-check"> Remote Work </label></li> -->

            </ul>
            <div class="coba-calendar-sidebar-small-header"> Filter nach </div>
            <ul class="coba-list-nobul-nobor">
                <li><label><input type="checkbox" class="coba-check"> Meine Buchungen </label></li>
                <li><label><input type="checkbox" class="coba-check"> Verfügbare Plätze </label></li>
                <li><label><input type="checkbox" class="coba-check"> Best Buddies </label></li>
                <li><label><input type="checkbox" class="coba-check"> Favoriten </label></li>
            </ul>


        </div>
    </div>
</div>


</template>

<script>
export default {
    name: "CalendarSidebar",
    props: ['show_sidebar'],

    data(){
        return{
                locations: this.$store.getters.locations
                }
            },

    methods: {
        change() {
            this.$emit('change-event', this.filter)
        }
    }
}
</script>

<style scoped>


</style>
