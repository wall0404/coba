<template>
    <!-- the Navbar is only shown when the user is logged in -->
    <div class="coba-navbar coba-full-width"  v-if="$route.path.includes('/signup')!== true && $route.path.includes('/login')!== true && $route.path.includes('/logout')!== true">

        <div class="coba-navbar coba-full-width" v-if="exclude.find(name => name === this.$route.name)"  @click="openModal">
            <router-link v-for="nav_item in nav" v-bind:to="nav_item.mainURL" v-bind:key="nav_item.name">
                <div><b-icon :icon="nav_item.icon" font-scale="2"></b-icon> </div>
                <div  @click="returnWeg"></div>
            </router-link>
        </div>
        <b v-else class="coba-navbar coba-full-width">
            <router-link v-for="nav_item in nav" v-bind:to="nav_item.mainURL" v-bind:key="nav_item.name">
                <div><b-icon :icon="nav_item.icon" font-scale="2"></b-icon> </div>
            </router-link>
        </b>




        <modal :show-modal="showModal" @modal-close-event="closeModal" >
            <template v-slot:header>
                <div class="coba-modal-header">Springen</div>
            </template>

            <template v-slot:body>
                <div class="coba-modal-body coba-text">
                    Bist du dir sicher,zu dieser Seite in der Navigationsleiste zu springen?
                    <!-- Sind sie sich sicher, dass sie zurückkehren möchten? -->
                </div>
            </template>

            <template v-slot:footer>
                <div class="coba-modal-footer coba-button-container">
                    <button class="coba-button coba-button-big"  @click="returnClose">Nein</button>
                    <button class="coba-button coba-button-big coba-button-danger" @click="closeModal" > Ja</button>
                </div>
            </template>
        </modal>
    </div>
</template>

<script>
import Modal from "./Elements/Modal";
import Spinner from "./Global/Spinner";

export default {
    name: "Navbar",
    components: {Modal, Spinner},
    data() {
        return {
            load: false,
            error: false,
            showModal: false,
            nav: [

                {name: 'Home', mainURL: '/home', icon: 'house-fill'},
                {name: 'Team', mainURL: '/team', icon: 'people-fill'},
                {name: 'Cal', mainURL: '/calendar', icon: 'calendar2-week-fill'},
                {name: 'Profile', mainURL: '/profile', icon: 'person-fill'},
            ],
            exclude: [
               "DateTimeSelection"
            ],
        }
    },
    created() {
    },


    methods: {

        openModal() {
            this.showModal = true;
        },
        closeModal() {
            this.showModal = false;
        },
        returnClose(){
            this.$router.go(-1);
            this.showModal=false;
        },
        returnWeg(){
            this.$router.go(-1);
        }
    }
}
</script>


<style scoped>

</style>
