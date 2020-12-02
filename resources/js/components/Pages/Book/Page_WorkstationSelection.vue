<template>
    <div class="coba-page">
        <div class="coba-container coba-flex coba-header">
            <span class="coba-page-headline">Arbeitsplatzauswahl</span>
        </div>
        <div class="coba-container">
            <div v-if="!load" class="coba-flex coba-flex-wrap coba-flex-space-evenly">
                <div v-for="workstation in workstations" class="coba-button coba-button-accent coba-button-very-big coba-button-round coba-button-no-border">{{workstation.name}}</div>
            </div>
            <spinner v-else></spinner>
        </div>
    </div>
</template>

<script>
import Spinner from "../../Global/Spinner";

export default {
    name: "Page_WorkstationSelection",
    props: ['location_id'],
    components: {Spinner},
    data() {
        return {
            load: false,
            error: false,
            workstations: []
        }
    },
    mounted() {
        this.fetchData();
    },
    methods: {
        fetchData() {
            this.load = true;
            fetch('/api/workstation?filter[location_id]='+this.location_id, {
                method: 'GET',
                headers: {
                    'content-type': 'application/json',
                    'Authorization' : 'Bearer '+localStorage.token
                }
            })
                .then(res => res.json())
                .then(res => {
                    if(res.success) {
                        this.workstations = res.success;
                        this.load = false;
                    }
                    else {
                        this.error = true;
                        this.load = false;
                    }
                })
                .catch(error => {
                    console.log(error);
                    this.load = false;
                })
        },
    }
}
</script>

<style scoped>

</style>
