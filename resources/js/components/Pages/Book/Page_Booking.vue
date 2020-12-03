<template>
    <div class="coba-page">
        <div class="coba-container coba-flex coba-header">
            <span class="coba-page-headline">Booking {{$route.params.id}}</span>
        </div>
        <div class="coba-container">
            <button v-if="!load" class="coba-button coba-button-danger" @click='deleteBooking'>Löschen</button>
            <spinner v-else></spinner>
        </div>
    </div>
</template>

<script>
import Spinner from "../../Global/Spinner";

export default {
    name: "Page_Booking",
    components: {Spinner},
    data() {
        return {
            load: false,
            error: false,
            booking: []
        }
    },
    methods: {
        deleteBooking() {
            this.load = true;
            fetch('/api/booking/'+this.$route.params.id, {
                method: 'DELETE',
                headers: {
                    'content-type': 'application/json',
                    'Authorization' : 'Bearer '+localStorage.token
                }
            })
                .then(res => res.json())
                .then(res => {
                    if(res.success) {
                        this.load = false;
                        this.$router.go(-1);
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
