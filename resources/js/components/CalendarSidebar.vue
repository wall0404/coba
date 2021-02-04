<template>


    <div v-if="show_sidebar" class="coba-calendar-wrapper" @click.self="$emit('modal-close-event')">

        <div class="coba-calendar-container">

        <div class="coba-calendar-sidebar-content">
            <div class="coba-calendar-sidebar-header"> Standorte </div>

            <ul class="coba-list-nobul-nobor">
                <!--  <div v-for="location in locations" :key="location.id">
                    <li><label :class="{'checked': changeLocation()}"><input type="checkbox" name="cb" @change="change()" v-model="changeLocation()" class="coba-check">{{location.name}}</label></li> </div> -->
                    <li><label :class="{'checked': filter.remwork}"><input type="checkbox" name="cb" @change="change()" class="coba-check" v-model="filter.remwork"> Remote Work
                        <b-icon class="check" v-if="filter.remwork" icon="check2" font-scale="1.5" ></b-icon></label></li>
            </ul>
            <div class="coba-calendar-sidebar-small-header"> Filter nach </div>
            <ul class="coba-list-nobul-nobor">
                <li><label :class="{'checked': filter.mybook}"><input type="checkbox" class="coba-check" name="cb" @change="change()" v-model="filter.mybook"> Meine Buchungen
                    <b-icon class="check" v-if="filter.mybook" icon="check2" font-scale="1.5" ></b-icon></label></li>
                <li><label :class="{'checked': filter.available}"><input type="checkbox" class="coba-check" name="cb"@change="change()" v-model="filter.available"> Verfügbare Plätze
                    <b-icon class="check" v-if="filter.available" icon="check2" font-scale="1.5" ></b-icon></label></li>
                <li><label :class="{'checked': filter.bestbud}"><input type="checkbox" class="coba-check" name="cb" @change="change()" v-model="filter.bestbud"> Best Buddies
                    <b-icon class="check" v-if="filter.bestbud" icon="check2" font-scale="1.5" ></b-icon></label></li>
                <li><label :class="{'checked': filter.fav}"><input type="checkbox" class="coba-check" name="cb" @change="change()" v-model="filter.fav"> Favoriten
                    <b-icon class="check" v-if="filter.fav" icon="check2" font-scale="1.5" ></b-icon></label></li>
            </ul>

            <button class="calender-button" @click="reset()"> Filter zurücksetzen</button>


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
                locations: this.$store.getters.locations,

                filter:{
                    location:{
                        tower: false,
                        digcam: false,
                    },
                    remwork: false,
                    mybook:false,
                    available:false,
                    bestbud: false,
                    fav: false,
                }
                }
            },

    methods: {
        change() {
            this.$emit('change-event', this.filter)
        },

        reset(){
            this.filter.mybook = false,
            this.filter.available = false,
            this.filter.bestbud = false,
            this.filter.fav = false
        }

        //changeLocation(){
            //if(this.location.name === "Tower"){
           //     return this.filter.location.tower;
            //}
            //if(this.location.name === "Digital Campus"){
            //    return this.filter.location.digcam;
          //  }
        //}
    }
}
</script>

<style scoped>

.check{
    color: #FFC931;
    position: fixed;
    right: 8%;
}

</style>
