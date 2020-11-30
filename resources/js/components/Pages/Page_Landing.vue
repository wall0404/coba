<template>
    <div class="coba-page">
        <div class="coba-container coba-flex coba-header">
            <span class="coba-page-headline">Landing Page</span>
        </div>
        <div class="coba-container">
            Nothing here yet
        </div>
        <div class="coba-container" v-if="$store.getters.data.user !== null && $store.getters.data.user !== ''">
            Hello {{$store.getters.data.user.firstName}}
        </div>
        <div class="coba-container" v-else>
            <router-link to="/login">Anmelden</router-link>
        </div>
    </div>
</template>

<script>
export default {
name: "Page_Landing"
}
</script>

<style scoped>

</style>
