<template>
    <div class="coba-page">
        <div class="coba-container coba-flex coba-header">
            <span class="coba-page-headline">Standortauswahl</span>
        </div>
        <div class="coba-container">
            <div v-if="!load">
                <router-link v-for="location in locations" :key="location.id" class="coba-button coba-button-accent coba-button-big coba-button-no-border"
                    :to="'/booking/new/workstation/'+location.id">{{location.name}}</router-link>
            </div>
            <spinner v-else></spinner>

            <div class="coba-flex-space-evenly">
                <button class="coba-button-round coba-button">Old</button>
                <button class="coba-button-round coba-button">Fav</button>
            </div>
        </div>
        <div class="back-button">
            <router-link class="back-button" to="/home">
                <div data-v-1febfe86="" class="coba-utilization-indicator coba-utilization-indicator-arrow-prev coba-utilization-indicator-big coba-utilization-indicator-disabled">➤</div>
            </router-link>
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

.back-button{

    position: fixed;
    top: 20px;
    left: 40px;
    font-size: 35px;
}

</style>
