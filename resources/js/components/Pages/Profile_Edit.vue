<template>
    <div class="coba-page" >
        <div class="coba-container coba-flex coba-header">

            <span class="coba-page-headline">Personenprofile</span>
        </div>
        <div class="coba-container m-2">
            <button class="coba-button" >Profilbild ändern</button>
        </div>

        <div class="coba-container">
            <span class="coba-page-text">Vorname: {{$store.getters.data.user.firstName}}</span>

        </div>

        <div class="coba-container">
            <span class="coba-page-text">Nachname: {{$store.getters.data.user.lastName}}</span>

        </div>


        <div class="coba-container">
            <span class="coba-page-text">Email: {{$store.getters.data.user.email}}</span>
        </div>

        <div class="coba-container">
            <span class="coba-page-text">Passwort ändern:
            </span>
            <button @click="clickEvent" class="settings-button" ><b-icon icon="pencil-fill"></b-icon> </button>
        </div>
        <div id="modal" v-if="showModal" >
                <div  class="modal-overlay" >
                <hr>
                    <div class="coba-container">
                        <div class="row">
                            <div class="col-sm-4" >
                                <form id="changePasswordForm" @submit.prevent="changePassword">
                                <label>Aktuelles Passwort eingeben:</label>
                                <div class="form-group  coba-flex-space-evenly">
                                    <input ref="search1" v-bind:type="[showPassword1 ? 'text' : 'password']" class="form-control" placeholder="Aktuelles Password eingeben" style="width: 80%">
                                    <b-icon icon="eye" @click="showPassword1 = !showPassword1" ></b-icon>
                                </div>
                                <label>Neues Passwort eingeben:</label>
                                <div class="form-group  coba-flex-space-evenly">
                                    <input ref="search2" v-bind:type="[showPassword2 ? 'text' : 'password']" class="form-control" placeholder="Neues Passwort eingeben" style="width: 80%">
                                    <b-icon icon="eye" @click="showPassword2 = !showPassword2" ></b-icon>
                                </div>
                                <label>Neues Passwort wiederholen:</label>
                                <div class="form-group  coba-flex-space-evenly">
                                    <input ref="search3" v-bind:type="[showPassword3 ? 'text' : 'password']" class="form-control" placeholder="Neues Passwort wiederholen" style="width: 80%">
                                    <b-icon icon="eye" @click="showPassword3 = !showPassword3" ></b-icon>
                                </div>
                                    <div class="mr-5 ml-5 mb-1 mt-2">
                                    <button type="submit" class="coba-button ">Bestätigen</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>
        </div>

        <div class="coba-container">
            <span class="coba-page-text">Favoritenplätze:</span>
            <button class="settings-button"><b-icon icon="pencil-fill"></b-icon> </button>
            <div class="selection">
                <div id="nav" class="nav">
                    <ul class="list-container">
                        <li ><a href="#">Tower</a>
                            <ul v-for="works in location[0].workstations">
                                <li><router-link to="overTheRainbow">Platz: {{works.name}}</router-link></li>
                            </ul>
                        </li>
                        <li><a href="#">Campus</a>
                            <ul v-for="works in location[1].workstations">
                                <li><router-link to="overTheRainbow">Platz: {{works.name}}</router-link></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="coba-container">
            <span class="coba-page-text">Lieblingsbuddies:</span>
            <button class="settings-button"><b-icon icon="pencil-fill"></b-icon> </button>
        </div>
    </div>

</template>


<script>
import Modal from "../Elements/Modal";
import Spinner from "../Global/Spinner";
import {router} from "../../_helpers/router";

export default {
    name: "Profile_Edit",
    data(){
        return{
            showModal: false,
            location:[],
            load:false,
            showPassword1: false,
            showPassword2: false,
            showPassword3: false,
        }
    },
    methods:{
        clickEvent(){
            this.showModal = !this.showModal ;
            // autofocus on search-field 1
            if ( this.showModal) {
                this.$nextTick(function () {
                    this.$refs.search1.focus();
                })
            }
        },
        changePassword(){
            console.log('hello') ;
        },
        fetchData() {
            this.load = true;
            fetch('/api/location', {
                method: 'GET',
                headers: {
                    'content-type': 'application/json',
                    'Authorization' : 'Bearer '+localStorage.token
                }
            })
                .then(res => res.json())
                .then(res => {
                    if(res.success) {
                        this.location = res.success;
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
    },
    created() {
        this.fetchData();
    }
}
</script>

<style scoped>


.settings-button{
    float:right;
    background-color: transparent;
}
.list-container{
    display: flex;
}
ul{
    list-style:none;
}
ul li{
    outline:none;
    background:#eee;
    height:25px;
    line-height:25px;
    border: 1px solid #1b1e21;
}
a{
    text-decoration:none;
    color: #000000;
    display:block;
    width:100px;
    height:25px;
    outline: none;
}



ul li ul{
    outline:none;
    display:none;
    position:relative;
    left:75px;
    top:0px;
    width:100px;
    border:1px
    solid #CCC;
}

ul li ul li a:link,ul li ul li a:visited{
    background-color:#EEEEEE;
}
ul li ul li a:hover{
    background-color: #fae452;
}
a:hover{
    background-color: #666666;
    color:#FFFFFF;
}

ul li:hover ul{
    outline: none;
    display:block;
}

</style>
