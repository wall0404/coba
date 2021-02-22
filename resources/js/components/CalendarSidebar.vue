<template>
    <!-- sidebar on page calendar, only shown when icon on the page is clicked -->
    <div v-if="show_sidebar" class="coba-calendar-wrapper" @click.self="$emit('modal-close-event')">

        <!-- sidebar is divided in a location-section and a filter section -->

        <div class="coba-calendar-container">

            <!-- location section-->
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

                <!-- filter section-->
                <div class="coba-calendar-sidebar-small-header"> Filter nach </div>
                <ul class="coba-list-nobul-nobor">
                    <li><label :class="{'checked': filter.onlyAvailableWorkstations}"><input type="checkbox" class="coba-check" name="cb"@change="change()" v-model="filter.onlyAvailableWorkstations"> Verfügbare Plätze
                        <b-icon class="calendar-check" v-if="filter.onlyAvailableWorkstations" icon="check2" font-scale="1.5" ></b-icon></label></li>
                    <li><label :class="{'checked': filter.onlyFavoriteWorkstations}"><input type="checkbox" class="coba-check" name="cb" @change="change()" v-model="filter.onlyFavoriteWorkstations"> Favoriten
                        <b-icon class="calendar-check" v-if="filter.onlyFavoriteWorkstations" icon="check2" font-scale="1.5" ></b-icon></label></li>
                    <li v-if="!filter.onlyAvailableWorkstations"><label :class="{'checked': filter.onlyMyBookings}"><input type="checkbox" class="coba-check" name="cb" @change="change()" v-model="filter.onlyMyBookings"> Meine Buchungen
                        <b-icon class="calendar-check" v-if="filter.onlyMyBookings" icon="check2" font-scale="1.5" ></b-icon></label></li>
                    <li v-if="!filter.onlyAvailableWorkstations"><label :class="{'checked': filter.onlyBestBuddyBookings}"><input type="checkbox" class="coba-check" name="cb" @change="change()" v-model="filter.onlyBestBuddyBookings"> Best Buddies
                        <b-icon class="calendar-check" v-if="filter.onlyBestBuddyBookings" icon="check2" font-scale="1.5" ></b-icon></label></li>
                </ul>
                <!-- button to reset selected filter options-->
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
                    1: true,
                    2: true,
                },
                onlyMyBookings:false,
                onlyAvailableWorkstations:false,
                onlyBestBuddyBookings: false,
                onlyFavoriteWorkstations: false,
            }
        }
    },

    created() {
        this.loadStorage();

        this.change();
    },

    methods: {

        //load from storage
        loadStorage() {
            let filter = localStorage.getItem("calendar_filter");
            console.log(filter);
            if (filter != null) {
                this.filter = JSON.parse(filter);
            }
        },

        //everytime a filter is selected this method sends the filter values to page calender and stores the changes in case the user switches between pages
        change(){
            //Wenn ausgewählt wird, dass nur freie Plätze angezeigt werden, dann sollen die Haken bei meine Buchungen und Buchungen von Best Buddys entfernt werden weil es offensichtlich kein Sinn macht, nach meinen Buchungen an freien Plätzen zu suchen
            if(this.filter.onlyAvailableWorkstations) {
                this.filter.onlyBestBuddyBookings = false;
                this.filter.onlyMyBookings = false;
            }

            this.$emit('change-event', this.filter);
            this.$store.commit('autoSaveFilter', {
                filter: this.filter
            });

            //save to storage
            localStorage.setItem("calendar_filter", JSON.stringify(this.filter));
        },

        //resets the selected filter options
        reset(){
            this.filter.onlyMyBookings = false;
            this.filter.onlyAvailableWorkstations = false;
            this.filter.onlyBestBuddy = false;
            this.filter.onlyFavoriteWorkstations = false;
        }
    }
}
</script>

<style scoped>


</style>
