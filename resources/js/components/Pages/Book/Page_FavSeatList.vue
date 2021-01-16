<template>
    <div class="coba-page" >
        <div class="coba-header  position-relative">
            <h2 class="coba-page-headline">Favoritenplätze</h2>
        </div>
      <spinner v-if="load"></spinner>
        <div v-else class="coba-container "  >
            <router-link v-bind:to=" '/overTheRainbow'" >
                <div class="coba-shadow coba-border-rounded coba-flex-space-between  mb-2 box" >
                    <div class="coba-border-rounded coba-flex-space-between w-100 h-100 p-1 " >
                        <b-icon icon="star-fill" font-scale="2.5" style="color:#FFC931 ; margin-left: 5%"></b-icon>
                        <div class="user-data mt-2 ml-5">
                            <table class="user-table limit ">
                                <tr>
                                    <td class="user-data-name">Tower</td>
                                </tr>
                                <tr>
                                    <td class="user-data-name ">T2</td>
                                </tr>

                            </table>
                        </div>
                    </div>
                </div>
            </router-link>
        </div>

        <div  class="coba-container "  >
            <router-link v-bind:to=" '/overTheRainbow'" >
                <div class="coba-shadow coba-border-rounded coba-flex-space-between  mb-2 box " >
                    <div class="coba-border-rounded coba-flex-space-between w-100 h-100 p-1 " >
                        <b-icon icon="star-fill" font-scale="2.5" style="color:#FFC931 ; margin-left: 5%"></b-icon>
                        <div class="user-data mt-2 ml-5">
                            <table class="user-table limit ">
                                <tr>
                                    <td class="user-data-name">Digital Campus</td>
                                </tr>
                                <tr>
                                    <td class="user-data-name ">C4</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </router-link>
        </div>
    </div>
</template>

<script>
import Spinner from "../../Global/Spinner";
export default {
    name: "Page_FavSeatList",
    components: {Spinner} ,

    data () {
        return {
            load: false,
        }
    }
}
</script>

<style scoped>
.tower{
    background-image: url("https://media0.faz.net/ppmedia/aktuell/reise/2000692817/1.5295074/format_top1_breit/ein-leuchtend-gelber.jpg");
    background-repeat: no-repeat;
    background-position: right;
    background-size: 170px , cover;
    box-shadow: 220px 0px 22px 0px white  inset;
}
.digitalCampus{
    background-image: url("https://blog.commerzbank.com/digitalisierung/17q3/campus_aussen_1086x611.jpg");
    background-repeat: no-repeat;
    background-position: right;
    background-size: 135px , cover;
    box-shadow: 220px 0px 22px 0px white  inset;
}
.user-table {
    border-collapse: collapse;
    margin: 0 5px 5px 0;
    font-size: 1.03em;
    table-layout: fixed;
}
.user-table .user-data-name {
    font-weight: bold;
    text-align: left;
    table-layout: fixed;
}
.user-data{
    word-break: break-word ;
    width: 75%;
}
/*  otherwise inset boxshadow would not work*/
.box{
    max-width: 320px;
}
</style>
