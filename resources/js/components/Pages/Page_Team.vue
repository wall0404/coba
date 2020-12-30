<template>

    <div class="coba-page">
        <div class="coba-header  position-relative">
            <h2 class="coba-page-headline">Team</h2>
        </div>
        <div class="filter-container w-100  coba-flex-space-evenly mb-5">
            <input v-model="searchQuery" @keyup="filterUsers" class="coba-border-rounded coba-border-orange p-2" type="text"  placeholder="Kontakt suchen..">
        </div>

        <div class="coba-container coba-smaller " v-for="user in users" >
            <router-link v-bind:to="'/team/' + user.user_id" >
            <div class="coba-shadow coba-border-rounded coba-flex-space-between p-3 pl-3 pr-1 mb-4"   >
                <div class="profile-picture"  style="background-color: transparent "> <img class="coba-border-round coba-border-yellow p-1 w-100" src="https://icons-for-free.com/iconfiles/png/512/business+costume+male+man+office+user+icon-1320196264882354682.png" alt="user"/> </div>
                <div class="user-data">
                    <table  class="user-table limit">
                        <tr>
                            <td class="user-data-name" >{{user.firstName + " " + user.lastName }}</td>
                        </tr>
                        <template v-for="booking in today_bookings">
                            <template v-for="works in workstations">
                                <tr>
                                    <td v-if="booking.date === today_date && booking.user_id === user.user_id && works.id === booking.workstation_id" class="user-data-name small text-info" > heute im {{works.location.name}}</td>
                                </tr>
                            </template>
                        </template>
                    </table>

                    <!-- need to handle:
                                        -what to display if more than one booking for today
                                        -still display "heute im ..." even when booking-time expired? -->
                </div>
            </div>
            </router-link>
        </div>
    </div>
</template>

<script>
import Spinner from "../Global/Spinner";
import {AxiosInstance as axios} from "axios";
import {router} from "../../_helpers/router";
export default {
    name: "Teampage",
    components: {Spinner} ,

        data () {
            return {
                load: false ,
                error: false ,
                users: [],
                filteredUsers:[],
                today_bookings: [],
                today_date: new Date().toISOString().slice(0, 10),
                searchQuery: '',
                workstations:[],
            }
        },
        methods: {
            /*
            loadUsers(){
                this.load = true ;
                fetch('/api/user/?order_by=firstName' ,{
                    method: 'GET' ,
                    headers: {
                        'content-type': 'application/json',
                        'Authorization' : 'Bearer '+localStorage.token
                    }
                } ) .then(res=> res.json())
                    .then(res => {
                        if(res.success) {
                            this.users = res.success;
                            this.filteredUsers = res.success ;
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
            */
            getTodayBookings(){
                this.load = true ;
                    fetch('/api/booking/?filter[date][min]=' +this.today_date , {
                        method: 'GET',
                        headers: {
                            'content-type': 'application/json',
                            'Authorization': 'Bearer ' + localStorage.token
                        }
                    }).then(response => response.json())
                        .then(response => {
                            if (response.success) {
                                this.today_bookings = response.success;
                                this.load = false;
                            } else {
                                this.error = true;
                                this.load = false;
                            }
                        })
                        .catch(error => {
                            console.log(error);
                            this.load = false;
                        })
            },
            filterUsers(){
                fetch('/api/user/?order_by=firstName' , {
                    method: 'GET',
                    headers: {
                        'content-type': 'application/json',
                        'Authorization': 'Bearer ' + localStorage.token
                    }
                })
                .then(res => res.json())
                .then(res => {
                    if( this.searchQuery){
                        this.users = res.success.filter(user =>
                            (user.firstName + user.lastName).toLowerCase().includes(this.searchQuery.toLowerCase())) ;
                    }else{
                        this.users = res.success ;
                    }
                })
            },
            getWorkstation(){
                fetch('/api/workstation',{
                    method: 'GET',
                    headers: {
                        'content-type': 'application/json',
                        'Authorization': 'Bearer ' + localStorage.token
                    }
                })
                .then( response => response.json())
                .then(response => {
                    if(response.success){
                        this.workstations = response.success ;
                    }
                }).catch(error => {
                    console.log(error) ;
                })
            }

        },
        created() {
            this.getTodayBookings() ;
            this.filterUsers() ;
            this.getWorkstation() ;
        },



}
</script>

<style scoped>
#contact{
    width: 65%;
}
.filter-container{
    bottom: 10px
}
.profile-picture {
    width: 25%;
}
.user-table {
    border-collapse: collapse;
    margin: 0 5px 5px 0;
    font-size: 1.05em;
    table-layout: fixed;
}
.user-table .user-data-name {
    font-weight: bold;
    text-align: left;
    table-layout: fixed;
}

/* dynamic text resizing to be continued  */
.user-data{
    word-break: break-word ;
    width: 75%;
    margin-left: 15%;

}
.coba-smaller{
    padding-top: 5px;
    padding-bottom: 5px;
}



</style>
