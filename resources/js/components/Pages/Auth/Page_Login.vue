<template>
    <div>
        <div class="coba-container coba-flex coba-header">
            <span class="coba-page-headline">Anmelden</span>
        </div>
        <div class="coba-container">
            <form class="">

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

                <button class="coba-button coba-button-accent mt-4" type="button" @click="submit">Anmelden</button>

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
