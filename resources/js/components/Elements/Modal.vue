<template>
    <div v-if="showModal" class="coba-modal-mask" @click.self="$emit('modal-close-event')">
        <div class="coba-modal">
            <slot name="header"></slot>
            <slot name="body"></slot>
            <slot name="footer"></slot>
        </div>
    </div>
</template>

<script>
export default {
    name: "Modal",
    props: ['showModal']
}
</script>

<style scoped>

</style>
