<template>

    <div v-if="show_sidebar" class="coba-calendar-wrapper" @click.self="$emit('modal-close-event')">

        <div class="coba-calendar-container">

            <div class="coba-calendar-sidebar-content">
                <div class="coba-calendar-sidebar-header"> Standorte </div>

                <ul class="coba-list-nobul-nobor">
                    <div v-for="location in locations" :key="location.id">
                        <li><label :class="{'checked': filter.location[location.id]}"><input type="checkbox" name="cb" @change="change()" v-model="filter.location[location.id]" class="coba-check">{{location.name}}
                            <b-icon class="calendar-check" v-if="filter.location[location.id]" icon="check2" font-scale="1.5" ></b-icon></label></li>
                    </div>
                    <li><label :class="{'checked': filter.location['homeoffice']}"><input type="checkbox" name="cb" @change="change()" class="coba-check" v-model="filter.location['homeoffice']"> Remote Work
                        <b-icon class="calendar-check" v-if="filter.location['homeoffice']" icon="check2" font-scale="1.5" ></b-icon></label></li>
                </ul>
                <div class="coba-calendar-sidebar-small-header"> Filter nach </div>
                <ul class="coba-list-nobul-nobor">
                    <li><label :class="{'checked': filter.mybook}"><input type="checkbox" class="coba-check" name="cb" @change="change()" v-model="filter.mybook"> Meine Buchungen
                        <b-icon class="calendar-check" v-if="filter.mybook" icon="check2" font-scale="1.5" ></b-icon></label></li>
                    <li><label :class="{'checked': filter.available}"><input type="checkbox" class="coba-check" name="cb"@change="change()" v-model="filter.available"> Verfügbare Plätze
                        <b-icon class="calendar-check" v-if="filter.available" icon="check2" font-scale="1.5" ></b-icon></label></li>
                    <li><label :class="{'checked': filter.bestbud}"><input type="checkbox" class="coba-check" name="cb" @change="change()" v-model="filter.bestbud"> Best Buddies
                        <b-icon class="calendar-check" v-if="filter.bestbud" icon="check2" font-scale="1.5" ></b-icon></label></li>
                    <li><label :class="{'checked': filter.fav}"><input type="checkbox" class="coba-check" name="cb" @change="change()" v-model="filter.fav"> Favoriten
                        <b-icon class="calendar-check" v-if="filter.fav" icon="check2" font-scale="1.5" ></b-icon></label></li>
                </ul>

                <button class="calendar-button" @click="reset()"> Filter zurücksetzen</button>
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
                },
                mybook:false,
                available:false,
                bestbud: false,
                fav: false,
            }
        }
    },

    created() {
        this.change()
    },

    methods: {
        change() {
            this.$emit('change-event', this.filter);
        },

        reset(){
            this.filter.mybook = false;
            this.filter.available = false;
            this.filter.bestbud = false;
            this.filter.fav = false;
        }

    }
}
</script>

<style scoped>


</style>
