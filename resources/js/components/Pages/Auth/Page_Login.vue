<template>
    <div>
        <div class="coba-container coba-flex coba-header mb-4" style="flex-direction: column">
            <img src="/img/Coba_Logo-removebg-preview.png" style="text-align: center; margin-bottom: 20px " height="70px">
            <span class="coba-page-headline coba-text-center">TAS <br> Take A Seat</span>
        </div>
        <div class="coba-container">
            <form class="coba-form">
                <div class="coba-input-container">
                    <div class="coba-margin-top">
                        <div class="coba-width-1-1">
                            <input v-model="email" class="coba-input" type="text" id="email" placeholder="E-Mail" v-bind:disabled="load" v-bind:class="[error?'coba-form-danger':'']"  v-on:focus="focusHandler">
                        </div>
                    </div>

                    <div class="coba-margin-top">
                        <div class="coba-width-1-1">
                            <input v-model="password" class="coba-input" type="password" id="password" placeholder="Passwort" v-bind:disabled="load"  v-bind:class="[error?'coba-form-danger':'']" v-on:focus="focusHandler" @keyup.enter="submit">
                        </div>
                    </div>

                    <div v-if="error" class="coba-text-danger coba-margin-small-top">
                        <span >E-Mail oder Passwort stimmt nicht</span>
                    </div>
                </div>

                <button class="coba-button coba-button-accent mt-4" type="button" @click="submit">Anmelden</button>
                <div class="coba-container">
                    <span class="coba-text-centered mt-4"> Du hast noch kein Konto?<br> </span>

                    <router-link to="/signup" class="coba-text-centered coba-text-centered-button mt-4">Hier Registrieren</router-link>
                </div>

            </form>
        </div>

    </div>
</template>

<script>
export default {
    name: "Page_Login",
    data() {
        return {
            email: "",
            password: "",
            token: null,
            load: false,
            error: false
        }
    },
    methods: {
        submit() {
            this.load = true;
            fetch('/api/login', {
                method: 'POST',
                body: JSON.stringify({
                    email: this.email,
                    password: this.password
                }),
                headers: {
                    'content-type': 'application/json'
                }
            })
                .then(res => res.json())
                .then(res => {
                    if(res.success) {
                        localStorage.token = res.success.token;
                        this.$store.commit('refreshUser');
                        this.$store.commit('getData'); //to get favorite seat info
                        this.$router.push('/home')
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
        focusHandler() {
            this.error = false;
        }
    }
}
</script>

<style scoped>

</style>
