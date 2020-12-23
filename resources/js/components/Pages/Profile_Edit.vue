<template>
    <div class="coba-page">
        <div class="coba-container cobe-flex coba-header">
            <span class="coba-page-headline">Personenprofile</span>
        </div>

        <div class="coba-container">
            <span class="coba-page-text">Vorname: {{$store.getters.data.user.firstName}}</span>
            <div class="edit-button">
                <button class="small button">bearbeiten
                </button>
            </div>
        </div>

        <div class="coba-container">
            <span class="coba-page-text">Nachname: {{$store.getters.data.user.lastName}}</span>
            <div class="edit-button">
                <button class="small button">bearbeiten
                </button>
            </div>
        </div>


        <div class="coba-container">
            <span class="coba-page-text">Email: {{$store.getters.data.user.email}}</span>
            <div class="edit-button">
                <button class="small button">bearbeiten
                </button>
            </div>
        </div>

        <div class="coba-container">
            <span class="coba-page-text">Passwort: </span>
            <div class="edit-button">
                <button class="small button">bearbeiten
                </button>
            </div>
        </div>
        <div class="coba-container">
            <span class="coba-page-text">Lieblingssitzplätze:</span>
            <div class="edit-button">
                <button class="small button">bearbeiten
                </button>
            </div>
        </div>

        <div class="coba-container">
            <span class="coba-page-text">Lieblingsbuddy:</span>
            <div class="edit-button">
                <button class="small button">bearbeiten
                </button>
            </div>
        </div>
    </div>

</template>

<script>
export default {
    name: "Profile_Edit"
}
</script>

<style scoped>
.edit-button {
    float: right;
}
</style>
