<template>

    <div class="coba-calendar-sidebar" @click="toggleSidebar()">
        <b-icon icon="list" font-scale="2"></b-icon>
    </div>

    <div v-if="open" class="coba-calendar-wrapper" @click="toggleSidebar">
        <div class="coba-calendar-content">
            <div class="coba-calendar-header"> Standorte </div>
            <ul>
                <li>Digitaler Campus</li>
                <li> Tower </li>
                <li> Homeoffice </li>
            </ul>
            <div class="coba-calendar-header"> Filter nach </div>
            <div class="coba-calendar-small-header"> Personen </div>
            <ul>
                <li>Meine Buchungen</li>
                <li> Best Buddies</li>
                <li> Gesamtes Team</li>
            </ul>
            <div class="coba-calendar-small-header"> Sitzplätze </div>
            <ul>
                <li>Favoriten </li>
                <li> Verfügbare Plätze </li>
                <li> Alle Plätze </li>
            </ul>
        </div>
    </div>


</template>

<script>
export default {
name: "CalendarSidebar",

    data:{
        open: false
    },

    methods:{
        toggleSidebar() {
            this.open = !this.open;
        }
    }


}
</script>

<style scoped>

.coba-calendar-sidebar{
    width: 20px;
    height: 20px;
    position: fixed;
    top: 30px;
    right: 30px;

}

</style>
