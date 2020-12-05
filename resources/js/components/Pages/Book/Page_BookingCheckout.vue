<template>
    <div class="coba-page coba-page-no-header">
        <div v-if="session_expired">
            Session expired
        </div>
    </div>
</template>

<script>
export default {
    props: ['bookings'],
    name: "Page_BookingCheckout",
    data() {
        return {
            session_expired: false,
        }
    },
    created() {
        if(typeof this.bookings === 'undefined') {
            this.session_expired = true;
        }
        else {
            this.makeBooking();
        }
    },
    methods: {
        makeBooking() {

        }
    }
}
</script>

<style scoped>

</style>
