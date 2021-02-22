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
                <div style="position: relative;">
                    <router-link class="coba-button coba-button-accent coba-button-big coba-button-no-border mt-3" :to="'/booking/new/remotework/'"> Remote Work</router-link>
                    <router-link class="coba-button coba-button-big coba-button-no-border button-on-top mt-3" :to="'/booking/new/fastbooking/'+null">
                        <b-icon icon="skip-forward-fill" font-scale="1.5"></b-icon>
                    </router-link>
                </div>
            </div>
            <spinner v-else></spinner>
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
