<template>
    <div>
        <div class="coba-container coba-flex coba-header">
            <span class="coba-page-headline">Registrieren</span>
        </div>
        <div class="coba-container">
            <form class="">

                <div class="coba-margin-top">
                    <div class="coba-width-1-1">
                        <input v-model="firstName" class="coba-input" type="text" id="firstName" placeholder="Vorname" v-bind:disabled="load"  v-bind:class="[error?'coba-form-danger':'']" v-on:focus="focusHandler" >
                    </div>
                </div>

                <div class="coba-margin-top">
                    <div class="coba-width-1-1">
                        <input v-model="lastName" class="coba-input" type="text" id="lastName" placeholder="Nachname" v-bind:disabled="load"  v-bind:class="[error?'coba-form-danger':'']" v-on:focus="focusHandler" >
                    </div>
                </div>

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
                    <span >E-Mail wurde einem anderen User schon zugewiesen</span>
                </div>

                <button class="coba-button coba-button-accent" type="button" @click="submit">Registrieren</button>

            </form>
        </div>

    </div>
</template>

<script>
export default {
name: "Page_SignUp.vue",
    data() {
        return {
            firstName: "",
            lastName: "",
            email: "",
            password: "",
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
                body: JSON.stringify({
                    firstName: this.firstName,
                    lastName: this.lastName,
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
