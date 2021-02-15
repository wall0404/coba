<template>
    <div class="coba-page coba-homescreen ">

        <div class="user-container mb-5 mt-4">
            <div><img class="coba-border-round coba-border-yellow coba-shadow p-1" src="https://icons-for-free.com/iconfiles/png/512/business+costume+male+man+office+user+icon-1320196264882354682.png" alt="user"/> </div>
        </div>
        <template v-for="user in users">
            <div v-if="user.user_id === id " class="coba-container text-center pb-0 ">
                <h3  class="mb-0"> {{user.firstName + " " + user.lastName}}</h3>
                <p   class="mb-1">{{user.email}}</p>
                <div v-for="booking in bookings">
                    <p v-if="booking.date === today_date && today_hours < booking.to  " class="user-data-email text-info">heute im {{booking.workstation.location.name}}</p>
                  <!--  <p v-if="booking.date === today_date && today_hours > booking.to" class="text-warning user-data-email" >war heute im {{booking.workstation.location.name}}</p> -->
                </div>
                <br>
                <div class="coba-container text-left">
                    <span class="coba-text-big " >{{user.firstName}}'s Buchungen:</span>
                </div>
            </div>
        </template>
        <div class="coba-container coba-full-width coba-footer-container pb-5" style="min-height: 300px">
            <ul class="coba-list" v-if="!load">
                <li v-for="booking in bookings" :key="booking.id">
                    {{booking.date}}, <br>{{ booking.workstation.location.name }}, {{booking.workstation.name}}, {{booking.from}} - {{booking.to}}
                </li>
            </ul>
            <spinner v-else></spinner>

    </div>
        <div class="back-button">
            <a @click="$router.go(-1)">
                <b-icon icon="arrow-left-short" font-scale="3"></b-icon>
            </a>
        </div>
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
            users: [],
            id: null ,
            bookings:[],
            today_date: new Date().toISOString().slice(0, 10),
            today_hours: new Date().toISOString().slice(11,19),  // ! standard: UMT+0
        }
    },
    methods: {
        loadID(){
            this.id = Number.parseInt(this.$route.params.TeamMember_ID )  ;
        },
        loadUsers(){
            this.load = true ;
            fetch('/api/user/'  ,{
                method: 'GET' ,
                headers: {
                    'content-type': 'application/json',
                    'Authorization' : 'Bearer '+localStorage.token
                }
            } ) .then(response => response.json())
                .then(response => {
                    if(response.success) {
                        this.users = response.success;
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

        getTeamMemberBookings(){
            this.load = true ;
            fetch('/api/user/' +this.id +'/bookings?order_by=date&filter[date][min]='+this.today_date ,{
                method: 'GET' ,
                headers: {
                    'content-type': 'application/json',
                    'Authorization' : 'Bearer '+localStorage.token
                }
            } ) .then(response => response.json())
                .then(response => {
                    if(response.success) {
                        this.bookings = response.success;
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
        }

    },
    created() {
        this.loadUsers();
        this.loadID() ;
        this.getTeamMemberBookings() ;
    }

}
</script>

<style scoped>

.user-container {
    position: relative;
    max-width: 100%;
    text-align: center;
}
.user-container img {
    max-width: 50%;
    max-height: 50%;
}
ol{
    display: table;
    margin: 0 auto ;
    clear: left ;
    list-style: none;
    padding: 0;
}
.back-button {
    position: absolute;
    top: 20px;
    left: 20px;
    color: gray;
}

</style>
