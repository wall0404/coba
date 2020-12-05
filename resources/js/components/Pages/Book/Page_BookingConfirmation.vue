<template>
    <div class="coba-page">
        <div class="coba-container coba-flex coba-header">
            <span class="coba-page-headline">Bestätigung</span>
        </div>
        <div v-if="!error">
            <div class="coba-container">
                <div class="coba-headline">Buchungsübersicht</div>
            </div>
            <div class="coba-container">
                <div v-for="booking in bookings" class="coba-text-strong mb-4">
                    <div class="coba-flex coba-flex-space-between">
                        <div>{{booking.date.toLocaleDateString('de-DE', $date_options_short)}}</div>
                        <div>{{booking.from}} - {{booking.to}}</div>
                    </div>
                    <div>{{booking.workstation.location.name}} - {{booking.workstation.name}}</div>
                </div>
            </div>
            <div class="coba-container">
                <button class="coba-button coba-button-accent" @click="submit">Bestätigen</button>
            </div>
        </div>
        <div v-else class="coba-container">
            <div class="coba-text-danger">{{error}}</div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['bookings'],
    name: "Page_BookingConfirmation",
    data() {
        return {
            error: null
        }
    },
    created() {
        if(typeof this.bookings === 'undefined') {
            this.bookings = JSON.parse(localStorage.getItem("confirmation_bookings"))
            if(this.bookings == null)
                this.error = "Ein Fehler ist aufgetreten. Keine Buchungen zur Bestätigung gefunden.";
            else {
                for(let booking in this.bookings) {
                    this.bookings[booking].date = new Date(this.bookings[booking].date)
                }
            }
        }
        else
            localStorage.setItem("confirmation_bookings", JSON.stringify(this.bookings));

        for(let booking in this.bookings) {
            this.bookings[booking].from = Math.round(this.bookings[booking].time[0]-0.1)+":"+(this.bookings[booking].time[0]%1===0?'00':'30');
            this.bookings[booking].to = Math.round(this.bookings[booking].time[1]-0.1)+":"+(this.bookings[booking].time[1]%1===0?'00':'30');
        }
    },
    methods: {
        submit() {
            console.log(this.bookings);
        }
    }
}
</script>

<style scoped>

</style>
