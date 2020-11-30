<template>
    <div>
        <div class="coba-container coba-flex coba-header">
            <span class="coba-page-headline">Abmelden</span>
        </div>
        <div class="coba-container">
            {{text}}
        </div>
        <div class="coba-container">
            <router-link to="/">Zurück zur Startseite</router-link>
        </div>


    </div>
</template>

<script>
export default {
    name: "Page_Login",
    data() {
        return {
            text: ""
        }
    },
    mounted() {
        fetch('/api/logout', {
            method: 'GET',
            headers: {
                'content-type': 'application/json',
                'Authorization' : 'Bearer '+localStorage.token
            }
        }).then(res => res.json())
            .then(res => {
                this.$store.commit('clearUser')
                this.text = "Erfolgreich abgemeldet"
            })
    }
}
</script>

<style scoped>

</style>
