<template>
    <div class="coba-page coba-homescreen">
        <div class="coba-container coba-header">
            <h1 class="coba-page-headline">Willkommen zurück,<br>{{$store.getters.data.user.firstName}}</h1>
        </div>
        <div class="coba-home-icons-container">
            <router-link to="/settings">
                <b-icon class="coba-home-icons" icon="gear" font-scale=1.7></b-icon>
            </router-link>
            <router-link to="/inbox">
                <b-icon class="coba-home-icons" icon="inbox-fill" font-scale="1.7"></b-icon>
            </router-link>
        </div>
        <div  v-if="!load" class="coba-container coba-text-strong">
            <div v-if="bookings.find( element => element.date === today_date)" class="coba-text-big">Heute bist du in</div>
            <div v-else  class="coba-text-big">Keine Buchungen für heute</div>
            <ul class="coba-list">
                <li v-for="today_booking in bookings" v-if="today_booking.date === today_date">{{ today_booking.workstation.location.name }}, {{today_booking.workstation.name}}, {{today_booking.from}} - {{today_booking.to}}</li>
            </ul>
        </div>
        <spinner v-else></spinner>
        <div class="coba-container coba-text-center">
            <router-link to="/booking/new/location" class="coba-text-very-big">Platz reservieren</router-link>
        </div>
        <div class="coba-container">
            <span class="coba-text-big">Kommende Buchungen:</span>
        </div>
        <div class="coba-container coba-full-width coba-footer-container">
            <ul class="coba-list" v-if="!load">
                <li v-for="booking in bookings" :key="booking.id">
                    <router-link v-bind:to="'/booking/'+booking.id">{{booking.date}}, <br>{{ booking.workstation.location.name }}, {{booking.workstation.name}}, {{booking.from}} - {{booking.to}}</router-link>
                </li>
            </ul>
            <spinner v-else></spinner>
        </div>

    </div>
</template>

<script>
import Spinner from "../Global/Spinner";
export default {
    name: "Page_Home",
    components: {Spinner},
    data() {
        return {
            load: false,
            error: false,
            bookings: [],
            today_date: new Date().toISOString().slice(0, 10)
        }
    },
    created() {
        this.fetchData();
    },
    methods: {
        fetchData() {
            this.load = true;
            fetch('/api/user/'+this.$store.getters.data.user.user_id+'/bookings?order_by=date&filter[date][min]='+this.today_date, {
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
