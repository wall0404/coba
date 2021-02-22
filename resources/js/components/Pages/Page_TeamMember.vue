<template>
    <div class="coba-page coba-homescreen">
        <div  v-if="!load">
            <div class="user-container mb-5 mt-4">
                <div v-if="teamMember.user_id !== this.$store.getters.data.user.user_id" @click="teamMember.isBuddy ?  removeBuddy(teamMember) : addBuddy(teamMember)" ><b-icon style="position: absolute ; right: 40px ; top:2% ; color: #FEEF00" :icon="teamMember.isBuddy ? 'star-fill' : 'star'" font-scale="2.5"></b-icon></div>
                <div><img class="coba-border-round coba-border-yellow user-avatar-shadow p-1 profile-img" :src="'/api/profile_picture/' +teamMember.user_id" alt="user"/> </div>
            </div>
            <div class="coba-container text-center pb-0 " >
                <h3  class="mb-0"> {{teamMember.firstName + " " + teamMember.lastName}}</h3>
                <p   class="mb-1">{{teamMember.email}}</p>
                <div v-for="booking in teamMember.upcomingBookings"> <!--todays bookings -->
                    <p v-if="booking.date === today_date && booking.workstation !== null" class="user-data-email text-info">heute im {{booking.workstation.location.name}}</p>
                    <p v-else-if="booking.date === today_date" class="user-data-email text-info">heute im Remote Work</p>
                </div>
                <br>
                <div class="coba-container text-left">
                    <span class="coba-text-big " >{{teamMember.firstName}}'s Buchungen:</span>
                </div>
            </div>
            <div class="coba-container coba-full-width coba-footer-container pb-5" style="min-height: 300px">
                <ul class="coba-list">
                    <li v-for="booking in teamMember.upcomingBookings" :key="booking.id">
                        <span v-if="typeof booking.workstation == 'object'&& booking.workstation !== null">{{makeDateToDateString(booking.date)}}, <br>{{ booking.workstation.location.name }}, {{booking.workstation.name}}, {{booking.from.substr(0,5)}} - {{booking.to.substr(0,5)}} <!-- the booking information --></span>
                        <span v-else>{{makeDateToDateString(booking.date)}}, <br>Remote Work, {{booking.from.substr(0,5)}} - {{booking.to.substr(0,5)}} <!-- the booking information when you have booked a homeoffice  --></span>
                    </li>
                </ul>
            </div>
        </div>
        <spinner v-else></spinner>

    </div>
</template>

<script>
import Spinner from "../Global/Spinner";

export default {
    name: "Page_TeamMember",
    components: {Spinner} ,
    data () {
        return {
            load: false ,
            error: false ,
            today_date: new Date().toISOString().slice(0, 10),
            teamMember: {},
        }
    },
    methods: {

        makeDateToDateString(dateStr){
            return  new Date(dateStr).toLocaleDateString('de-DE', this.$date_options_without_year);
        },

        getTeamMember(){
            this.load = true ;
            fetch('/api/user/' +this.$route.params.TeamMember_ID,{
                method: 'GET' ,
                headers: {
                    'content-type': 'application/json',
                    'Authorization' : 'Bearer '+localStorage.token
                }
            } ) .then(response => response.json())
                .then(response => {
                    if(response.success) {
                        this.teamMember = response.success;
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
        addBuddy( user ){
            user.isBuddy = true;

            fetch('/api/buddy/'+user.user_id,{
                method: 'POST',
                body: JSON.stringify({}),
                headers: {
                    'content-type': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.token
                }
            })  .then( res => res.json())
                .then( res => {
                    if ( res.success){

                    }
                }).catch(error =>{
                user.isBuddy = false;
                this.error = error;
                console.log(error) ;
            })
        },
        removeBuddy(user){
            user.isBuddy = false;
            fetch('/api/buddy/'+user.user_id, {
                method: 'DELETE',
                body: JSON.stringify({}),
                headers: {
                    'content-type': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.token
                }
            })  .then( res => res.json())
                .then( res => {
                    if ( res.success){

                    }
                }).catch(error =>{
                user.isBuddy = true;
                this.error = error;
                console.log(error) ;
            })
        }

    },
    created() {
        this.getTeamMember();
    }

}
</script>

<style scoped>

.user-container {
    position: relative;
    max-width: 100%;
    text-align: center;
}

/* funktioniert erstaunlich gut */
.profile-img {
    width: 12rem ;
    height: 12rem;
    object-fit: cover;
}
ol{
    display: table;
    margin: 0 auto ;
    clear: left ;
    list-style: none;
    padding: 0;
}
.user-avatar-shadow{
    box-shadow: 10px 20px 30px 0 rgba(0, 0, 0, 0.5);
}


</style>
