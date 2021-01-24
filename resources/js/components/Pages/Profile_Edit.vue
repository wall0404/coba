<template xmlns="http://www.w3.org/1999/html">
    <div class="coba-page" >
        <div class="coba-container coba-flex coba-header">
            <span class="coba-page-headline">Profileinstellungen</span>
        </div>

        <!-- User profile pic -->
        <div class="coba-container">
            <hr>
            <p class="coba-text-big">Profilbild ändern:</p>
            <div class="coba-flex ">
                 <div class="picture-container">
                     <img :key="componentKey" :src="'/api/profile_picture/' +$store.getters.data.user.user_id" alt="user_pic"
                          class="coba-border-round coba-border-yellow user-avatar-shadow p-1 profile-img"  id="avatar"/>
                 </div>
                 <div class="ml-3">
                     <input class="inputFile" type="file" id="file" name="file" ref="upload" @change="uploadPic"  >
                     <label class="inputFileLabel flex mb-1" for="file"><b-icon class="mr-2 mt-1" icon="image"></b-icon> Wähle ein Profilbild</label>
                     <label class="inputFileLabel mt-1"  @click="deletePic"> Profilbild löschen </label>
                 </div>
            </div>

            <hr>
        </div>

        <div class="coba-container ">
            <span class="coba-text-big">Passwort ändern:
            </span>
            <b-icon @click.prevent="clickEvent" class="settings-button" :icon="showPasswordModal ? 'caret-up-square'  : 'caret-down-square' "></b-icon>
        </div>
        <!-- Password modal -->
        <div id="modal" v-if="showPasswordModal" >
                <div  class="modal-overlay" >
                <hr class="mb-0 mt-0">
                    <div class="coba-container">
                        <div class="row">
                            <div class="col-sm-4" >
                                    <p class="p-0 m-0 text-danger" v-if="this.wrongPassword" >falsches Passwort eingegeben</p>
                                <form id="changePasswordForm" name="form" @submit.prevent="changePassword">
                                <label>Aktuelles Passwort eingeben:</label>
                                <div class="form-group  coba-flex-space-evenly">
                                    <input id="1" ref="search1" v-bind:type="[showPassword1 ? 'text' : 'password']" class="form-control" placeholder="Aktuelles Passwort eingeben" style="width: 80%">
                                    <b-icon icon="eye" @click="showPassword1 = !showPassword1" ></b-icon>
                                </div>
                                    <p class="p-0 m-0 text-danger" v-if="wrongPasswordConfirmation" >Passwörter stimmen nicht überein</p>
                                    <p class="p-0 m-0 text-danger" v-if="passwordToShort">Passwort muss mindestens 8 Zeichen lang sein</p>
                                <label>Neues Passwort eingeben:</label>
                                <div class="form-group  coba-flex-space-evenly">
                                    <input id="2" ref="search2" v-bind:type="[showPassword2 ? 'text' : 'password']" class="form-control" placeholder="Neues Passwort eingeben" style="width: 80%">
                                    <b-icon icon="eye" @click="showPassword2 = !showPassword2" ></b-icon>
                                </div>
                                <label>Neues Passwort wiederholen:</label>
                                <div class="form-group  coba-flex-space-evenly">
                                    <input id="3" ref="search3" v-bind:type="[showPassword3 ? 'text' : 'password']" class="form-control" placeholder="Neues Passwort wiederholen" style="width: 80%">
                                    <b-icon icon="eye" @click="showPassword3 = !showPassword3" ></b-icon>
                                </div>
                                    <div class="mr-5 ml-5 mb-1 mt-2">
                                    <button type="submit" class="coba-button ">Bestätigen</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        </div>


        <!-- Fav Seat -->
        <div class="coba-container">
            <hr>
            <span class="coba-text-big">Favoritenplätze bearbeiten:</span>
        </div>
        <div class="coba-tab-navigation">
            <div v-for="(location, index) in $store.getters.locations" :class="{'selected':selectedLocations.find(id => id === location.id)}" class="coba-tab coba-tab-adjust" :key="index" @click="selectLocation(location.id)">
                {{ location.name }}
            </div>
        </div>
        <!-- Seats -->
        <div class="coba-container px-0">
            <!--ToDo -->
            <div v-if="!load" class="coba-flex coba-flex-wrap coba-flex-space-evenly">
                <template v-if="selectedLocations.length > 0">
                <div  ref="template" v-for="workstation in workLocations[selectedLocations[0]-1].workstations"  class="seat-container">

                    <div class="coba-button coba-button-big coba-button-round coba-button-no-border mb-0" @click="workstation.isFavorite?  deleteFavoriteSeat(workstation) : addFavoriteSeat(workstation )">
                        <b-icon  :icon="workstation.isFavorite? 'star-fill' : 'star'" font-scale="1.5" style="color:#FFC931" ></b-icon>
                    </div>
                    <div class="coba-flex-space-evenly m-0 p-2" >
                        <div class="coba-text-strong coba-text-medium coba-text">{{workstation.name}}</div>
                    </div>
                </div>
                </template>
            </div>
        </div>


        <!-- password confirmation modal -->
        <modal :show-modal="showConfirmationModal" @modal-close-event="closeConfModal">
            <template v-slot:header>
                <div class="coba-container coba-no-top-padding coba-flex-column">
                    <b-icon class="mt-3 mb-4" icon="hand-thumbs-up" font-scale="3" style="color:#FFC931"></b-icon>
                </div>
            </template>

            <template v-slot:body>
                <div class="coba-modal-body">
                    Dein Passwort wurde erfolgreich geändert!
                </div>
            </template>

            <template v-slot:footer>
                <div>
                    <button class="coba-button" @click="closeConfModal">Bestätigen</button>
                </div>
            </template>
        </modal>


    </div>

</template>


<script>
import {store} from "../../_helpers/store";
import Modal from "../Elements/Modal";
import Spinner from "../Global/Spinner";
import Vue from 'vue';

export default {
    name: "Profile_Edit",
    components: {Modal, Spinner},
    data(){
        return{
            showPasswordModal: false,
            location:[],
            load:false,

            showPassword1: false,
            showPassword2: false,
            showPassword3: false,
            wrongPassword: false ,
            wrongPasswordConfirmation: false ,
            passwordToShort: false ,

            componentKey: 0 ,
            render:false ,
            showConfirmationModal: false ,

            selectedLocations: [],
            workLocations: [] = this.$store.getters.data.locations ,
        }

    },

    methods:{
        selectLocation(location_id) {
            if ( this.selectedLocations.length === 0) {
                this.selectedLocations.push(location_id)
            }
            else {
                this.selectedLocations.pop() ;
                this.selectedLocations.push(location_id) ;
            }
        },

        uploadPic() {
            this.load = true;
            let input = this.$refs.upload;
            let file = input.files[0];
            let data = new FormData();
            data.append('profile_pic', file);
            // This will upload the file after having read it
            fetch('/api/profile_picture/'+ store.getters.data.user.user_id, {
                method: 'POST',
                body: data
            }).then(
                res => res.json() // if the response is a JSON object
            ).then(
                res => {
                    this.load = false;
                    if(res.success) {
                        // refresh
                        this.componentKey += 1;
                        // reset value of input-file => otherwise could not upload the same image twice
                        document.querySelector('#file').value = '' ;
                    }
                }
            ).catch(
                //Internet connection
            );
        },
        selectPic() {
            const elem = this.$refs.upload;
            elem.click();
        },
        deletePic() {
            this.load = true;
            fetch('/api/profile_picture/'+store.getters.data.user.user_id, {
                method: 'delete'
            })
                .then(res => res.json())
                .then(res => {
                    this.load = false;
                    if(res.success) {
                        this.componentKey += 1;
                    }
                })
                .catch(error => {
                    console.log(error);
                    this.load = false;
                })
        },
        clickEvent(){
            this.showPasswordModal = !this.showPasswordModal ;
            // autofocus on search-field 1
            if ( this.showPasswordModal) {
                this.$nextTick(function () {
                    this.$refs.search1.focus();
                        this.showPassword1= false;
                        this.showPassword2= false;
                        this.showPassword3= false;
                })
            }
        },
        changePassword(){
            this.wrongPasswordConfirmation = false ;
            this.passwordToShort = false ;
            this.wrongPassword = false ;
            document.getElementById("1").classList.remove('red') ;
            document.getElementById("2").classList.remove('red') ;
            document.getElementById("3").classList.remove('red') ;

            let t1 = document.getElementById("1").value ;
            let t2 = document.getElementById("2").value ;
            let t3 = document.getElementById("3").value ;
            // password doubleCheck failed
            if( t3 !== t2){
                this.wrongPasswordConfirmation = true ;
                document.getElementById("3").value = '';
                document.getElementById("2").classList.toggle('red') ;
                document.getElementById("3").classList.toggle('red') ;
                return ;
            }
            if( t3.length < 8){
                this.passwordToShort = true ;
                document.getElementById("2").value = '';
                document.getElementById("3").value = '';
                document.getElementById("2").classList.toggle('red') ;
                document.getElementById("3").classList.toggle('red') ;
                return;
            }

            fetch('/api/resetPassword', {
                method: 'POST',
                body: JSON.stringify({
                    password: t1 ,
                    new_password: t2 ,
                }),
                headers: {
                    'content-type': 'application/json',
                    'Authorization' : 'Bearer '+localStorage.token
                }
            })
                .then(res => res.json())
                .then(res => {
                    if( res.success) {
                        this.load = false;
                        this.showPasswordModal = false;
                        this.showConfirmationModal = true ;
                    }
                    else{
                        this.wrongPassword = true ;
                        document.getElementById("1").value = '';
                        document.getElementById("1").classList.toggle('red') ;
                        this.$nextTick(function () {
                            this.$refs.search1.focus();
                        })
                    }
                })
                .catch(error => {
                    console.log(error);
                    this.error = "Ein Fehler ist aufgetreten";
                    this.load = false;
                })


        },
        closeConfModal(){
            this.showConfirmationModal = false ;
        },

        deleteFavoriteSeat( workstation){
            fetch('/api/workstation/favorite', {
                method: 'DELETE',
                body: JSON.stringify({
                    id: workstation.id,
                }),
                headers: {
                    'content-type': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.token
                }
            })  .then( res => res.json())
                .then( res => {
                    if ( res.success){
                        console.log('delete_success') ;
                        this.render = false;
                        this.$nextTick(() => {
                            this.render = true;
                        });
                    }
                }).catch(error =>{
                this.error = error;
                console.log(error) ;
            })
        },

        addFavoriteSeat( workstation){
            fetch('/api/workstation/favorite', {
                method: 'POST',
                body: JSON.stringify({
                    id: workstation.id,
                }),
                headers: {
                    'content-type': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.token
                }
            })  .then( res => res.json())
                .then( res => {
                    if ( res.success){
                        console.log('add_success') ;
                        this.render = false;
                        this.$nextTick(() => {
                            this.render = true;
                        });
                    }
                }).catch(error =>{
                    this.error = error;
                    console.log(error) ;
            })
        },
    },
}
</script>

<style scoped>

/* is beeing used! */
.red {
    border: 1px solid red;
}
.picture-container{
    max-width: 40%;
    justify-content: center;
    margin-top: 3px;
}

/* funktioniert erstaunlich gut */
.profile-img {
    width: 6rem ;
    height: 6rem;
    object-fit: cover;
}
.inputFileLabel{
    padding: 10px;
    width: 100%;
    margin: 2px;
    background-color: #EBEBEB;
    border-radius: 5px;
}
.inputFile{
    width: 0.1px;
    height: 0.1px;
    opacity: 0;
    overflow: hidden;
    position: absolute;
    z-index: -1;
}
.inputFile:focus{
    outline: 1px dotted #000;
}
.settings-button{
    float:right;
    background-color: transparent;
    margin-right: 6%;
}

.coba-tab-navigation {
    flex-grow: 1;
}
.seat-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 15px;
    margin-left: 15px;
    margin-right: 15px;
}
.coba-tab-adjust{
    border-top: 1px solid #8C8C8C;;
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
