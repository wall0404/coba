<template xmlns="http://www.w3.org/1999/html">
    <div class="coba-page" >
        <div class="coba-container coba-flex coba-header">

            <span class="coba-page-headline">Personenprofile</span>
        </div>

        <!-- User profile pic -->
        <div class="coba-container">
            <hr>
            <p class="coba-text-big">Profilbild ändern:</p>
            <div style="display: flex">
                 <div class="picture-container">
                     <img :key="componentKey" :src="'/api/profile_picture/' +$store.getters.data.user.user_id" alt="user_pic"
                          class="coba-border-round coba-border-yellow user-avatar-shadow p-1" style="max-width: 100% ; height: auto"  id="avatar"/>
                 </div>
                 <div class="ml-3">
                     <input class="inputFile" type="file" id="file" name="file" ref="upload" @change="uploadPic">
                     <label class="inputFileLabel flex mb-1" for="file"><b-icon class="mr-2 mt-1" icon="image"></b-icon> Wähle ein Profilbild</label>
                     <label class="inputFileLabel mt-1"  @click="deletePic"> Profilbild löschen </label>
                 </div>
            </div>

            <hr>
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
            <span class="coba-text-big">Passwort ändern:
            </span>
            <button @click.prevent="clickEvent" class="settings-button" ><b-icon icon="pencil-fill"></b-icon> </button>
            <p v-if="passwordChanged" class="text-success">Passwort wurde erfolgreich geändert</p>
        </div>
        <!-- Password modal -->
        <div id="modal" v-if="showModal" >
                <div  class="modal-overlay" >
                <hr>
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
                    <hr>
                </div>
        </div>
<!--
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
         alternative DropDown
        <div class="coba-container">
            <vue-dropdown :config="config"></vue-dropdown>
        </div>


        <div class="coba-container">
            <span class="coba-page-text">Lieblingsbuddies:</span>
            <button class="settings-button"><b-icon icon="pencil-fill"></b-icon> </button>
        </div>
        -->
    </div>

</template>


<script>
import {store} from "../../_helpers/store";

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
            wrongPassword: false ,
            wrongPasswordConfirmation: false ,
            passwordToShort: false ,
            passwordChanged: false,
            componentKey: 0 ,
        }
    },
    methods:{
        uploadPic() {
            this.load = true;
            const input = this.$refs.upload;
            const file = input.files[0];
            var data = new FormData();
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
            this.showModal = !this.showModal ;
            this.passwordChanged = false ;
            // autofocus on search-field 1
            if ( this.showModal) {
                this.$nextTick(function () {
                    this.$refs.search1.focus();
                })
            }
        },
        changePassword(){
            this.wrongPasswordConfirmation = false ;
            this.passwordToShort = false ;
            this.passwordChanged = false ;
            this.wrongPassword = false ;
            this.passwordChanged = false ;
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
                        this.passwordChanged = true;
                        this.showModal = false;
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
