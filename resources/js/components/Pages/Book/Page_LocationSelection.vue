<template>
    <div class="coba-page">
        <div class="coba-container coba-flex coba-header">
            <span class="coba-page-headline">Standortauswahl</span>
        </div>
        <div class="coba-container">
            <div v-if="!load">
                <router-link v-for="location in locations" :key="location.id" class="coba-button coba-button-accent coba-button-bigger coba-button-no-border mt-3 p"
                    :to="'/booking/new/workstation/'+location.id" >
                    <div v-if="location.id === 1" class="picture-container" style="margin-top: -85px">
                        <img  src="https://m.faz.net/media0/ppmedia/aktuell/reise/2000692817/1.5295074/mmobject-still_full/ein-leuchtend-gelber.jpg" style="width: 85px ;height: 85px; object-fit: cover; position: absolute ; border-radius: 50% ; left: 8px ; border: 3px solid #FEEF00">
                    </div>
                    <div v-else-if="location.id === 2" class="picture-container" style="margin-top: -85px">
                        <img  src="https://pbs.twimg.com/media/DJgkybXXoAAU38X.jpg:large" style="width: 85px ;height: 85px; object-fit: cover; position: absolute ; border-radius: 50% ; left: 8px ; border: 3px solid #FEEF00">
                    </div>

                    {{location.name}}
                </router-link>
                <router-link class="coba-button coba-button-accent coba-button-bigger coba-button-no-border mt-3" :to="'/booking/new/homeoffice/'">
                   <div class="picture-container" style="margin-top: -85px">
                        <img  src="https://www.it-daily.net/images/Aufmacher-2019/Homeoffice-Laptop-639194614-700.jpg" style="width: 85px ;height: 85px; object-fit: cover; position: absolute ; border-radius: 50% ; left: 8px ; border: 3px solid #FEEF00 ">
                   </div>
                    Remote Work
                </router-link>
            </div>
            <spinner v-else></spinner>

            <div class="coba-flex-space-evenly mt-4">
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
            locations: this.$store.getters.locations
        }
    },
    created() {

    },
    methods: {

    }
}
</script>

<style scoped>
.picture-container{
    max-width: 40%;
    justify-content: center;
    border-radius: 50px;
}
</style>
