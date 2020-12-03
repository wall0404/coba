<template>
    <div class="coba-page">
        <div class="coba-container coba-flex coba-header">
            <span class="coba-page-headline">Buchung</span>
        </div>
        <div class="coba-container">
            <div class="coba-text coba-text-strong">{{ $route.params.workstation_id }}</div>
        </div>
        <div class="coba-container">
            <div class="coba-button">Buchen</div>
        </div>
    </div>
</template>

<script>
import Spinner from "../../Global/Spinner";

export default {
    name: "Page_DateTimeSelection",
    components: {Spinner},
    data() {
        return {
            load: false,
            error: false,
        }
    },
    mounted() {
        this.fetchData();
    },
    methods: {
        fetchData() {
            /*this.load = true;
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
                })*/
        },
    }
}
</script>

<style scoped>

</style>
