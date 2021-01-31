<template>

<div class="coba-calander-container">
    <div v-if="show_sidebar" class="coba-calendar-wrapper" @click="toggleSidebar">
        <div class="coba-calendar-sidebar-content">
            <div class="coba-calendar-sidebar-header"> Standorte </div>
            <ul class="coba-list-nobul-nobor">
                <li>Digitaler Campus</li>
                <li> Tower </li>
                <li> Homeoffice </li>
            </ul>
            <div class="coba-calendar-sidebar-header"> Filter nach </div>
            <div class="coba-calendar-sidebar-small-header"> Personen </div>
            <ul class="coba-list-nobul-nobor">
                <li>Meine Buchungen</li>
                <li> Best Buddies</li>
                <li> Gesamtes Team</li>
            </ul>
            <div class="coba-calendar-sidebar-small-header"> Sitzplätze </div>
            <ul class="coba-list-nobul-nobor">
                <li>Favoriten </li>
                <li> Verfügbare Plätze </li>
                <li> Alle Plätze </li>
            </ul>
        </div>
    </div>
</div>


</template>

<script>
export default {
    name: "CalendarSidebar",
    props: ['show_sidebar'],



    methods:{
        toggleSidebar() {
            this.show_sidebar = !this.show_sidebar;
        }
    }


}
</script>

<style scoped>


</style>
