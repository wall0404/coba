<template>
    <div class="coba-page">
        <div class="coba-container coba-flex coba-header">
            <span class="coba-page-headline">Arbeitsplatzauswahl</span>
        </div>
        <div class="coba-container">
            <div v-if="!load" class="coba-flex coba-flex-wrap coba-flex-space-evenly">
                <router-link v-for="workstation in workstations" :key="workstation.id" class="coba-button coba-button-accent coba-button-very-big coba-button-round coba-button-no-border"
                             :to="'/booking/new/booking/'+workstation.id">{{workstation.name}}</router-link>
            </div>
            <spinner v-else></spinner>
        </div>
    </div>
</template>

<script>
import Spinner from "../../Global/Spinner";

export default {
    name: "Page_WorkstationSelection",
    components: {Spinner},
    data() {
        return {
            load: false,
            error: false,
            location_id: this.$route.params.location_id,
            workstations: null
        }
    },
    mounted() {
        this.workstations = this.$store.getters.data.locations[this.location_id-1].workstations;
    },
    methods: {
    }
}
</script>

<style scoped>

</style>
