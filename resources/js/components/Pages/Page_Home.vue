<template>
    <div class="coba-page">
        <div class="coba-container coba-header">
            <h1 class="coba-page-headline">Home</h1>
        </div>
        <div class="coba-container">
            Hello {{$store.getters.data.user.firstName}}
        </div>
        <div class="coba-container">
            <router-link to="/logout">Abmelden</router-link>
        </div>
        <div class="coba-container">
            <div v-for="booking in bookings">Benutzer: {{booking.user_id}} Datum: {{booking.date}} Arbeitsplatz: {{booking.workstation_id}}</div>
        </div>

    </div>
</template>

<script>
export default {
    name: "Page_Home",
    data() {
        return {
            bookings: [
                {name: "Buchung 1"},
                {name: "Buchung 2"}
            ],
        }
    },
    mounted() {
      this.fetchData();
    },
    methods: {
        fetchData() {
            this.load = true;
            fetch('/api/user/'+this.$store.getters.data.user.user_id+'/bookings', {
                method: 'GET',
                headers: {
                    'content-type': 'application/json',
                    'Authorization' : 'Bearer '+localStorage.token
                }
            })
                .then(res => res.json())
                .then(res => {
                    if(res.success) {
                        this.bookings = res.success;
                        console.log(this.bookings)
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
