<template>
    <div class="coba-page">
        <div class="coba-container coba-flex coba-header">
            <span class="coba-page-headline">Standortauswahl</span>
        </div>
        <div class="coba-container">
            <div v-if="!load">
                <li class="position-relative coba-list-nobullets" v-for="location in locations" :key="location.id">
                    <router-link class="coba-button coba-button-accent coba-button-big coba-button-no-border"
                                 :to="'/booking/new/workstation/'+location.id"> {{location.name}}</router-link>
                    <router-link class="coba-button coba-button-big coba-button-no-border button-on-top" :to="'/booking/new/fastbooking/'+location.id">
                        <b-icon icon="skip-forward-fill" font-scale="1.5"></b-icon>
                    </router-link>
                </li>
            </div>
            <spinner v-else></spinner>

            <div class="coba-flex-space-evenly">
                <button class="coba-button-round coba-button">
                    <b-icon icon="clock-history" font-scale="2"></b-icon>
                </button>
                <button class="coba-button-round coba-button">
                    <b-icon icon="star-fill" font-scale="2"></b-icon>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import Spinner from "../../Global/Spinner";

export default {
    name: "Page_LocationSelection",
    components: {Spinner},
    data() {
        return {
            load: false,
            error: false,
            locations: this.$store.getters.locations,
            date: new Date()
        }
    },
    created() {

    },
    methods: {
        /*
        setDate(){
            var hour = this.date.getHours(); //TODO UTCHours or Hours?
            if (hour >= 16){
                this.date.setDate(new Date().getDate + 1);
            }
        },

        submit(location_id){
            this.$router.push({
                to: '/booking/new/fastbooking/'+location.id,
                //name: 'FastBookingConfirmation',
                params:{
                    location_id: location_id,
                    date: this.date,
                }
            })
        }*/
    }
}
</script>

<style scoped>
.button-on-top{
    position: absolute;
    width: 20%;
    right: 0px;
    bottom: -10px;
}
</style>
