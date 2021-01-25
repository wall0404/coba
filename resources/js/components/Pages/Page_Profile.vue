<template>
    <div class="coba-page">
        <div class="user-container mb-5 mt-4" >
            <router-link class="setting-button "  to="/profile/settings">
                <b-icon icon="pencil" font-scale="1.3"></b-icon>
            </router-link>
            <!-- Profile Pic -->
            <div>
              <img :src="'/api/profile_picture/' +$store.getters.data.user.user_id" alt="user_pic" class="coba-border-round coba-border-yellow user-avatar-shadow p-1 profile-img"  id="avatar"/>
            </div>

        </div>
        <div class="coba-container text-center pb-0">
            <h3 class="mb-0">{{ $store.getters.data.user.firstName +" " + $store.getters.data.user.lastName }}</h3>
            <p class="mb-1">{{$store.getters.data.user.email}}</p>
        </div>
        <div class="coba-input-container ">
            <div class="coba-border-rounded p-2 user-data-templ">
                     <ol>
                         <li class="listHead">Favorisierte Sitzplätze</li>
                         <template v-for="works in workstations.tower">
                             <li v-if="works.isFavorite " class="listInput">Tower {{ works.name }}</li>
                         </template>
                         <template v-for="works in workstations.dc">
                             <li v-if="works.isFavorite" class="listInput">Digital Campus {{ works.name }} </li>
                         </template>
                     </ol>
            </div>
            <div class="coba-border-rounded p-2 user-data-templ">
                <ol >
                    <li class="listHead">Best Buddies</li>
                    <li class="listInput">Max Mustermann</li>
                    <li class="listInput">Gundula Gause</li>
                    <li class="listInput">Paul Panther</li>
                </ol>
            </div>
            <router-link to="/logout" class="coba-button coba-button-half-width mt-5 mb-3 decent">Logout</router-link>
        </div>
    </div>
</template>

<script>
import Spinner from "../Global/Spinner";
import {store} from "../../_helpers/store";

export default {
    name: "Page_Profile",
    components: {Spinner} ,
    data(){
        return{
            load: false ,
            user: [],
            workstations:{
              tower:[] ,
              dc:[],
            }  ,
        }
    },
    created() {
        this.workstations.tower = store.getters.data.locations[0].workstations ;
        this.workstations.dc = store.getters.data.locations[1].workstations ;
    },
    methods:{
        getUser(){
            fetch('/api/user',{
                method: 'GET',
                    headers: {
                        'content-type': 'application/json',
                        'Authorization': 'Bearer ' + localStorage.token
                }.then(res => res.json() )
                .then( res => {
                    this.user = res.success ;
                })
            })
        },
    },

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
.setting-button{
    text-align:center;
    position: absolute;
    top: 0px;
    right: 30px;
    opacity: 0.8;
}
.user-data-templ {
    box-shadow: inset 5px 25px 70px -15px #FFC931;
    display: flex;
    margin-bottom: 20px;
    text-align: center;
    margin-top: 20px;
}

ol{
    display: table;
    margin: 0 auto ;
    clear: left ;
    list-style: none;
    padding: 0;
}
.listInput{
    list-style-type: circle;
    list-style-position: inside;
    text-align: center;
}
.listHead{
    font-weight: bold;
    list-style-type: none;
    padding-bottom: 5px;
}
.user-avatar-shadow{
    box-shadow: 10px 20px 30px 0 rgba(0, 0, 0, 0.5);
}


</style>
