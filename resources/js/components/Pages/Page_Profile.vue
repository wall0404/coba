<template>
    <div class="coba-page">
        <div class="user-container mb-5 mt-4" >
            <router-link class="setting-button mr-4 " style="size: auto" to="/profile/settings">
                <b-icon icon="pencil" ></b-icon>
            </router-link>

            <div class="picture-container"><img :src="'/api/profile_picture/' +$store.getters.data.user.user_id" alt="user_pic"
                      class="coba-border-round coba-border-yellow user-avatar-shadow p-1" style="width: 180px ; height: 180px"  id="avatar"/>
            </div>

        </div>
        <div class="coba-container text-center pb-0">
            <h3 class="mb-0">{{ $store.getters.data.user.firstName +" " + $store.getters.data.user.lastName }}</h3>
            <p class="mb-1">{{$store.getters.data.user.email}}</p>

            <div>
                <input type="file" ref="upload" @change="uploadPic">
                <br>
                <button  @click="deletePic">Bild Löschen</button>
            </div>



        </div>
        <div class="coba-input-container ">
            <!-- Musterdesignidee -->
            <div class="coba-border-rounded p-2 user-data-templ">
                     <ol>
                         <li class="listHead">Favorisierte Standorte</li>
                         <li class="listInput">Tower_1 </li>
                         <li class="listInput">Tower_2 </li>
                         <li class="listInput">DC_9    </li>
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
            selectedFile: '',
        }
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
                        this.$router.go()  ;
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
                        this.$router.go();
                    }
                })
                .catch(error => {
                    console.log(error);
                    this.load = false;
                })
        }
    },

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
.setting-button{
    text-align:center;
    position: absolute;
    top: 0px;
    right: 0px;
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
