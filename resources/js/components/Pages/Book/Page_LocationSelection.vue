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
                        <b-icon icon="clock-history" font-scale="2"></b-icon>
                    </router-link>
                </li>
                <router-link class="coba-button coba-button-accent coba-button-big coba-button-no-border mt-3" :to="'/booking/new/homeoffice/'"> Remote Work</router-link>
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
.button-on-top{
    position: absolute;
    width: 20%;
    right: 0px;
    bottom: -10px;
}
</style>
