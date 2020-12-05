<template>
    <div  class="coba-text-strong mb-4" :class="{'coba-text-danger': color&&(typeof booking.error !== 'undefined'), 'coba-text-success': color&&(typeof booking.error === 'undefined')}">
        <div class="coba-flex coba-flex-space-between">
            <div>{{booking.date.toLocaleDateString('de-DE', $date_options_short)}}</div>
            <div>{{booking.from}} - {{booking.to}}</div>
        </div>
        <div v-if="booking.workstation">{{booking.workstation.location.name}} - {{booking.workstation.name}}</div>
        <div v-if="color">
            <div v-if="typeof booking.error === 'undefined'">
                Buchung war erfolgreich
            </div>
            <div v-else v-for="error in booking.error">
                {{error}}
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['booking', 'color'],
    name: "Booking",
    created() {
        if(typeof this.booking.date === "string")
            this.booking.date = new Date(this.booking.date);
    }
}
</script>

<style scoped>

</style>
