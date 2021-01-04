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
        <!--
        <v-container class="coba-container">
            <v-row align="center" justify="center">
                <v-col cols="12" md="4" sm="8">
                    <v-card>
                        <v-toolbar color="yellow">
                            <v-toolbar-title>Password ändern</v-toolbar-title>
                            <v-spacer/>
                        </v-toolbar>
                        <v-card-text>
                            <v-form ref="changePasswordForm">
                                <v-text-field label="Altes Passwort" name="oldPassword" type="password"/>

                                <v-text-field label="Neues Passwort" name="newPassword" type="password"/>

                                <v-text-field label="Neues Passwort bestätigen" name="newPasswordConfirmation" type="password"/>

                            </v-form>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>

        -->

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
                            <div class="col-sm-4">
                                <label>Aktuelles Password eingeben:</label>
                                <div class="form-group pass_show coba-flex-space-evenly">
                                    <input v-bind:type="[showPassword ? 'text' : 'password']" class="form-control" placeholder="Aktuelles Password eingeben" style="width: 80%">
                                    <b-icon icon="eye" @click="showPassword = !showPassword" ></b-icon>
                                </div>
                                <label>Neues Passwort eingeben:</label>
                                <div class="form-group pass_show coba-flex-space-evenly">
                                    <input v-bind:type="[showPassword ? 'text' : 'password']" class="form-control" placeholder="Neues Passwort eingeben" style="width: 80%">
                                    <b-icon icon="eye" @click="showPassword = !showPassword" ></b-icon>
                                </div>
                                <label>Neues Passwort wiederholen:</label>
                                <div class="form-group pass_show coba-flex-space-evenly">
                                    <input v-bind:type="[showPassword ? 'text' : 'password']" class="form-control" placeholder="Neues Passwort wiederholen" style="width: 80%">
                                    <b-icon icon="eye" @click="showPassword = !showPassword" ></b-icon>
                                </div>
                            </div>
                            <button class="coba-button small ml-5 mr-5 mt-2 mb-1">Bestätigen</button>
                        </div>
                    </div>
                    <hr>
                </div>
        </div>


        <div class="coba-container">
            <span class="coba-page-text">Lieblingssitzplätze:</span>
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
            <span class="coba-page-text">Lieblingsbuddy:</span>
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
            showPassword: false,
        }
    },
    methods:{
        clickEvent(){
            this.showModal = !this.showModal ;
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
.pass_show . {
    position: absolute;
    color: #f36c01;
    justify-content: center;
    display: flex;
}

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
