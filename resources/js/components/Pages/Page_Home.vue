<template>
    <div class="coba-page">
        <div class="coba-container coba-header">
            <h1 class="coba-page-headline">Home</h1>
        </div>
        <div class="coba-container">
            Hello {{$store.getters.data.user.firstName}}
        </div>
        <div class="coba-container">
            <router-link to="/logout">Abmelden</router-link>
        </div>

    </div>
</template>

<script>
export default {
    name: "Page_Home",
}
</script>

<style scoped>

</style>
