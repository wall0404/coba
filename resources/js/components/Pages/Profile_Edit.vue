<template>
    <div class="coba-page">
        <div class="coba-container cobe-flex coba-header">
            <span class="coba-page-headline">Personenprofile</span>
        </div>

        <div class="coba-container">
            <span class="coba-page-text">Vorname: {{$store.getters.data.user.firstName}}</span>
            <input type="button" value="bearbeiten" style="float: right">
        </div>

        <div class="coba-container">
            <span class="coba-page-text">Nachname: {{$store.getters.data.user.lastName}}</span>
            <input type="button" value="bearbeiten" style="float: right">
        </div>

        <div class="coba-container">
            <span class="coba-page-text">Email: {{$store.getters.data.user.email}}</span>
            <input type="button" value="bearbeiten" style="float: right">
        </div>

        <div class="coba-container">
            <span class="coba-page-text">Passwort: </span>
            <input type="button" value="bearbeiten" style="float: right">
        </div>
        <div class="coba-container">
            <span class="coba-page-text">Lieblingssitzplätze: </span>
            <input type="button" value="bearbeiten" style="float: right">
        </div>

        <div class="coba-container">
            <span class="coba-page-text">Lieblingsbuddy: </span>
            <input type="button" value="bearbeiten" style="float: right">
        </div>
    </div>
</template>

<script>
export default {
    name: "Profile_Edit"
}
</script>

<style scoped>

</style>
