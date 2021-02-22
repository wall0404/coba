
<template>

    <div class="coba-page">

       <div style="position: fixed ; width: 100% ;z-index:2 " >
          <div class="coba-header adjust-header"  >
              <div ><h2 class="coba-page-headline">Team</h2></div>
              <div class="filter-container coba-flex-space-evenly mt-3">
                  <input  v-model="searchQuery" @keyup="fetchUsers" class="coba-border-rounded coba-border-yellow p-2" type="text"  placeholder="Kontakt suchen..">
              </div>
          </div>
       </div>
        <div style="height: 250px">

        </div>

        <spinner v-if="load"></spinner>
        <div v-else v-for="user in users" class="coba-container coba-smaller"  >
            <b-icon v-if="user.isBuddy" icon="star-fill" style="position: relative ; top: 95px; left:70px; z-index: 1 ; margin-top: -20px ; color:#FEEF00" font-scale="1.5"  ></b-icon>
            <router-link v-bind:to="'/team/' + user.user_id" >
                <div class="coba-shadow coba-border-rounded coba-flex-space-between p-3 pl-3 pr-1 mb-4"   >
                    <div class="profile-picture"  style="background-color: transparent ">
                        <img class="coba-border-round coba-border-yellow p-1 profile-img" :src="'/api/profile_picture/' +user.user_id" alt="user"/>
                    </div>
                    <div class="user-data" >
                        <table  class="user-table limit">
                            <tr>
                                <td  class="user-data-name" >{{user.firstName + " " + user.lastName }}</td>
                            </tr>
                                <tr>
                                    <td v-if="user.todayBookings.length != 0" class="user-data-name small text-info">
                                        <template v-for="booking in user.todayBookings">
                                            <span v-if="booking.workstation_id === null" class="user-data-name small text-info"> heute im Remote Work</span>
                                            <span v-else class="user-data-name small text-info" > heute im {{getWorkstation(booking.workstation_id)}}</span>
                                            <br>
                                        </template>
                                    </td>
                                </tr>
                        </table>
                    </div>
                </div>
            </router-link>
        </div>
    </div>
</template>

<script>
import Spinner from "../Global/Spinner";
import {pad} from "lodash";
export default {
    name: "Teampage",
    components: {Spinner} ,
        data () {
            return {
                load: false ,
                users: [],
                searchQuery: '',
                workstations:[],
                timeout:null ,
            }
        },
        methods: {

            fetchUsers(){
                this.load = true;
                if (this.timeout){
                    clearTimeout( this.timeout) ;
                    this.timeout = null ;
                }
                // timeout for reducing query-requests => avoiding crash
                this.timeout = setTimeout ( () => {
                    fetch('/api/user_bookings' , {
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
                                    (user.firstName + user.lastName).toLowerCase().includes(this.searchQuery.toLowerCase())).sort(this.compare) ;
                                    window.scrollTo(0,0);

                                this.load = false;
                            }else{
                                 this.users = res.success.sort( this.compare) ;
                                window.scrollTo(0,0);

                                this.load = false;
                            }
                        })
                },300) ;
            },
            compare(a,b){
                if( a.isBuddy === true && b.isBuddy === false ){
                    return -1 ;
                }
                if ( a.isBuddy === false && b.isBuddy === false ){
                    return 0 ;
                }
                else return 1 ;
            },
            getWorkstation(id){
                let locations = this.$store.getters.locations;
                for(let i = 0; i<locations.length; i++) {
                    for (let k = 0; k < locations[i].workstations.length; k++) {
                        if(locations[i].workstations[k].id === id) {
                            return locations[i].name;
                        }
                    }
                }
            }
        },
        created(){
            this.fetchUsers() ;
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
.adjust-header{
    display: block;
    text-align: center;
    padding-top: 50px;
}
.profile-picture {
    width: 25%;
}
.profile-img {
    width: 4.5rem ;
    height: 4.5rem;
    object-fit: cover;
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
