<template>
    <div id="back_button">
        <b-icon icon="arrow-left-short" font-scale="3"></b-icon>
    </div>
</template>

<script>
export default {
    name: "BackButton",
    data() {
        return {
            exclude: [
                ""
            ]
        }
    }
}
</script>

<style scoped>
    #back_button {
        position: fixed;
        top: 20px;
        left: 20px;
    }
</style>
