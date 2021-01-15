<template>
<div>
    <div v-if="!load">
        Settings
    </div>
    <spinner v-else></spinner>
    <div class="back-button">
        <router-link class="back-button" to="/home">
            <div data-v-1febfe86="" class="coba-utilization-indicator coba-utilization-indicator-arrow-prev coba-utilization-indicator-big coba-utilization-indicator-disabled">➤</div>
        </router-link>
    </div>
</div>
</template>

<script>

import Spinner from "../../Global/Spinner";

export default {
name: "Page_Settings",
    components: {Spinner},
    data() {
        return {
            load: false,

        }
    },
}
</script>

<style scoped>

.back-button{

    position: fixed;
    top: 20px;
    left: 40px;
    font-size: 35px;
}

</style>
