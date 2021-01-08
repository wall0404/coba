<template>
    <div class="coba-page">
<<<<<<< Updated upstream
        <div class="coba-container cobe-flex coba-header">
            <span class="coba-page-headline">Personenprofile</span>
        </div>

        <div class="coba-container">
            <span class="coba-page-text">Vorname: {{$store.getters.data.user.firstName}}</span>
            <div class="edit-button">
                <button class="small button">bearbeiten
                </button>
            </div>
        </div>

        <div class="coba-container">
            <span class="coba-page-text">Nachname: {{$store.getters.data.user.lastName}}</span>
            <div class="edit-button">
                <button class="small button">bearbeiten
                </button>
            </div>
        </div>


        <div class="coba-container">
            <span class="coba-page-text">Email: {{$store.getters.data.user.email}}</span>
            <div class="edit-button">
                <button class="small button">bearbeiten
                </button>
            </div>
        </div>

        <div class="coba-container">
            <span class="coba-page-text">Passwort: </span>
            <div class="edit-button">
                <button class="small button">bearbeiten
                </button>
            </div>
        </div>
        <div class="coba-container">
            <span class="coba-page-text">Lieblingssitzplätze:</span>
            <div class="coba-container">
                <div id="nav" class="nav">
                    <ul>
                        <li><a href="#">Tower</a>
                            <ul>
                                <li><a href="#">Tower 1</a></li>
                                <li><a href="#">Tower 2</a></li>
                                <li><a href="#">Tower 3</a></li>
                                <li><a href="#">Tower 4</a></li>
                                <li><a href="#">Tower 5</a></li>
                                <li><a href="#">Tower 6</a></li>
                                <li><a href="#">Tower 7</a></li>
                                <li><a href="#">Tower 8</a></li>
                                <li><a href="#">Tower 9</a></li>
                                <li><a href="#">Tower 10</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Campus</a>
                            <ul>
                                <li><a href="#">Campus 1</a></li>
                                <li><a href="#">Campus 2</a></li>
                                <li><a href="#">Campus 3</a></li>
                                <li><a href="#">Campus 4</a></li>
                                <li><a href="#">Campus 5</a></li>
                                <li><a href="#">Campus 6</a></li>
                                <li><a href="#">Campus 7</a></li>
                                <li><a href="#">Campus 8</a></li>
                                <li><a href="#">Campus 9</a></li>
                                <li><a href="#">Campus 10</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="edit-button">
                <button class="small button">bearbeiten
                </button>
            </div>
        </div>

        <div class="coba-container">
            <span class="coba-page-text">Lieblingsbuddy:</span>
            <div class="edit-button">
                <button class="small button">bearbeiten
                </button>
            </div>
        </div>
    </div>

</template>

<script>
export default {
    name: "Profile_Edit"
=======
        <div class="coba-container coba-flex coba-header">
            <span class="coba-page-headline">Bestätigung</span>
        </div>
        <div v-if="!error">
            <div class="coba-container">
                <div class="coba-headline">Buchungsübersicht</div>
            </div>
            <div class="coba-container">
                <booking v-for="(booking, index) in bookings" :booking="booking" :key="index"></booking>
            </div>
            <div class="coba-container">
                <button class="coba-button coba-button-accent" @click="submit">Bestätigen</button>
            </div>
        </div>
        <div v-else class="coba-container">
            <div class="coba-text-danger">{{error}}</div>
        </div>


        <div class="back-button">
            <a @click="$router.go(-1)">
                <div data-v-1febfe86="" class="coba-utilization-indicator coba-utilization-indicator-arrow-prev coba-utilization-indicator-big coba-utilization-indicator-disabled">➤</div>
            </ a>
        </div>
    </div>
</template>

<script>
import Booking from "../../ListItems/Booking";
export default {
    components: {Booking},
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
            this.bookings[booking].from = (this.bookings[booking].time[0]<10?"0":"")+Math.round(this.bookings[booking].time[0]-0.1)+":"+(this.bookings[booking].time[0]%1===0?'00':'30');
            this.bookings[booking].to = (this.bookings[booking].time[1]<10?"0":"")+Math.round(this.bookings[booking].time[1]-0.1)+":"+(this.bookings[booking].time[1]%1===0?'00':'30');
        }
    },
    methods: {
        submit() {
            this.$router.push({
                name: 'BookingCheckout',
                params: {
                    bookings: this.bookings
                }
            })
        }
    }
>>>>>>> Stashed changes
}
</script>

<style scoped>
<<<<<<< Updated upstream
.edit-button {
    float: right;
}

ul{
    list-style:none;
}
ul li{
    outline:none;
    background:#eee;

    height:25px;
    line-height:25px;
    border-bottom:1px
    solid #CCC;
    position:relative;
}
a{
    text-decoration:none;
    color: #000000;
    display:block;
    width:100px;
    height:25px;
    outline: none;
}



ul li ul{
    outline:none;
    display:none;
    position:relative;
    left:75px;
    top:0px;
    width:100px;
    border:1px
    solid #CCC;
}

ul li ul li a:link,ul li ul li a:visited{
    background-color:#EEEEEE;
}
ul li ul li a:hover{
    background-color: #fae452;
}
a:hover{
    background-color: #666666;
    color:#FFFFFF;
}

ul li:hover ul{
    outline: none;
    display:block;
}


=======
.back-button{

    position: fixed;
    top: 20px;
    left: 40px;
    font-size: 35px;
}
>>>>>>> Stashed changes
</style>
