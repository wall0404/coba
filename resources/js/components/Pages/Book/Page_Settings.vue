<template>
    <div class="coba-page">
        <div class="coba-header">
            <h2 class="coba-page-headline">Einstellungen</h2>
        </div>
        <i-cal-settings></i-cal-settings>
        <div>
            <router-link to="/logout" class="coba-button coba-button-half-width mt-5 mb-3 decent">Logout</router-link>
        </div>
    </div>

</template>

<script>
import ICalSettings from "../../Elements/Settings/iCalSettings";
export default {
    name: "Page_Settings",
    components: {ICalSettings}
}
</script>

<style scoped>

</style>
