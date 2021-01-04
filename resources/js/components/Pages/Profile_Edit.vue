<template>
    <div class="coba-page">
        <div class="coba-container cobe-flex coba-header">
            
            <span class="coba-page-headline">Personenprofile</span>
        </div>

        <div class="coba-container">
            <span class="coba-page-text">Vorname: {{$store.getters.data.user.firstName}}</span>

        </div>

        <div class="coba-container">
            <span class="coba-page-text">Nachname: {{$store.getters.data.user.lastName}}</span>

        </div>


        <div class="coba-container">
            <span class="coba-page-text">Email: {{$store.getters.data.user.email}}</span>

        </div>

        <div class="coba-container">
            <span class="coba-page-text">Passwort:
            <input id="edit"  class="coba-border-rounded " type="text"  placeholder="edit..">
            </span>

            <button style="float:right"><b-icon icon="pencil-fill"></b-icon> </button>

        </div>
        <div class="coba-container">
            <span class="coba-page-text">Lieblingssitzplätze:</span>
            <button style="float:right"><b-icon icon="pencil-fill"></b-icon> </button>
            <div class="selection">
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




        </div>

        <div class="coba-container">
            <span class="coba-page-text">Lieblingsbuddy:</span>
            <button style="float:right"><b-icon icon="pencil-fill"></b-icon> </button>
        </div>
    </div>







</template>


<script>
import Modal from "../Elements/Modal";
import Spinner from "../Global/Spinner";
import {router} from "../../_helpers/router";

export default {
    name: "Profile_Edit",

}
</script>

<style scoped>
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

</style>
