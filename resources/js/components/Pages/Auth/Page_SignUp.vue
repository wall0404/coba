<template>
    <div>
        <div class="coba-container coba-flex coba-header mb-4" style="flex-direction: column; padding-top:33px">
            <img src="/img/Coba_Logo-removebg-preview.png" style="text-align: center; margin-bottom: 10px" height="70px">
            <span class="coba-page-headline coba-text-center">TAS</span>
            <span class=" coba-text-center" style="font-size: 25px">Take A Seat</span>
        </div>
        <div class="coba-container" >
            <form class="coba-form">
                <span class="coba-text-medium"> Erstelle ein Konto</span>
                <div class="coba-input-container"> <!-- all inputfields are in this container -->
                    <element-input
                        v-bind:error="error"
                        classes="coba-margin-top"
                        type="text"
                        name="firstName"
                        v-bind:model="user"
                        placeholder="Vorname"></element-input>

                    <element-input
                        v-bind:error="error"
                        classes="coba-margin-top"
                        type="text"
                        name="lastName"
                        v-bind:model="user"
                        placeholder="Nachname"></element-input>

                    <element-input
                        v-bind:error="error"
                        classes="coba-margin-top"
                        type="email"
                        name="email"
                        v-bind:model="user"
                        placeholder="E-Mail"></element-input>
                    <element-input
                        v-bind:error="error"
                        classes="coba-margin-top"
                        type="password"
                        name="password"
                        v-bind:model="user"
                        placeholder="Passwort"></element-input>
                </div>

                <button class="coba-button coba-button-accent mt-4" type="button" @click="submit">Registrieren</button>

                <div class="coba-container">
                    <span class="coba-text-centered mt-2"> Du hast schon ein Konto?</span>
                    <router-link to="/login" class="coba-text-centered coba-text-centered-button mt-4">Hier Anmelden</router-link>
                </div>
            </form>
        </div>

    </div>
</template>

<script>
import ElementInput from "../../Elements/Input";
export default {
name: "Page_SignUp.vue",
    components: {ElementInput},
    data() {
        return {
            user: {
                firstName: "",
                lastName: "",
                email: "",
                password: ""
            },
            token: null,
            load: false,
            error: false
        }
    },
    mounted () {
    },
    methods: {
        submit() {
            this.load = true;
            fetch('/api/signup', {
                method: 'POST',
                body: JSON.stringify(this.user),
                headers: {
                    'content-type': 'application/json'
                }
            })
                .then(res => res.json())
                 .then(res => {
                    if(res.success) {
                        localStorage.token = res.success.token;
                        this.$store.commit('refreshUser');
                        this.$router.push('/home')
                    }
                    else {
                        this.error = res.error;
                        this.load = false;
                    }
                })
                .catch(error => {
                    console.log(error);
                    this.load = false;
                })
        },
        focusHandler() {
            this.error = false;
        }
    }
}
</script>

<style scoped>

</style>
