<template>
    <div class="booking-list-container mt-1">
        <div class="coba-full-width">
            <div class="section-headline p-2 px-3">Campus</div>
            <div class="booking-list px-3">
                <div class="booking py-3" v-for="n in 2">
                    <div class="table-item seat">C{{n}}</div>
                    <div class="table-item time">16.00 - 18.00</div>
                    <div class="table-item name">Oliver K</div>
                    <div class="table-item icon"><b-icon v-if="n===2" icon="star-fill" font-scale="0.75"></b-icon></div>
                    <div class="table-item icon coba-utilization-indicator coba-utilization-indicator-orange"><b-icon icon="plus"></b-icon></div>
                </div>
                <div class="booking py-3">
                    <div class="table-item seat">C4</div>
                    <div class="table-item time">-</div>
                    <div class="table-item name"></div>
                    <div class="table-item icon"></div>
                    <div class="table-item icon coba-utilization-indicator coba-utilization-indicator-green"><b-icon icon="plus"></b-icon></div>
                </div>
                <div class="booking py-3 strong">
                    <div class="table-item seat">C5</div>
                    <div class="table-item time">9.00 - 17.00</div>
                    <div class="table-item name">Sebastian S.</div>
                    <div class="table-item icon"></div>
                    <div class="table-item icon coba-utilization-indicator coba-utilization-indicator-red"><b-icon icon="plus"></b-icon></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "CalendarBookingList"
}
</script>

<style scoped>
    .booking-list-container {
        border-top: 2px solid darkgray;
        width: 100%;
        overflow-x: scroll;
    }
    .section-headline {
        background-color: orange;
        font-weight: bold;
    }
    .booking-list {

    }
    .booking {
        display: flex;
    }
    .booking.strong {
        font-weight: bold;
    }
    .table-item {
        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;
    }
    .seat {
        width: 20%;
    }
    .time {
        width: 35%;
    }
    .name {
        width: 25%;
    }
    .icon {
        width: 10%;
    }
</style>
