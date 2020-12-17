<template>
    <div class="coba-page" >
        <div class="user-container">
            <button id="change-profile-button"  style="background-color: transparent "> <img class="round" src="https://icons-for-free.com/iconfiles/png/512/business+costume+male+man+office+user+icon-1320196264882354682.png" alt="user"/> </button>
        </div>
        <div style="text-align: center">
            <h3 style="margin-bottom: 0px">{{ $store.getters.data.user.firstName +" " + $store.getters.data.user.lastName }}</h3>
            <p style="margin-bottom: 5px">{{$store.getters.data.user.email}}</p>
            <div class="button-container">
                <button class="setting-button" >Kontoeinstellungen<img class="dots" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pg0KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDE2LjAuMCwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPg0KPCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIiAiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkIj4NCjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCINCgkgd2lkdGg9IjQwOHB4IiBoZWlnaHQ9IjQwOHB4IiB2aWV3Qm94PSIwIDAgNDA4IDQwOCIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNDA4IDQwODsiIHhtbDpzcGFjZT0icHJlc2VydmUiPg0KPGc+DQoJPGcgaWQ9Im1vcmUtdmVydCI+DQoJCTxwYXRoIGQ9Ik0yMDQsMTAyYzI4LjA1LDAsNTEtMjIuOTUsNTEtNTFTMjMyLjA1LDAsMjA0LDBzLTUxLDIyLjk1LTUxLDUxUzE3NS45NSwxMDIsMjA0LDEwMnogTTIwNCwxNTNjLTI4LjA1LDAtNTEsMjIuOTUtNTEsNTENCgkJCXMyMi45NSw1MSw1MSw1MXM1MS0yMi45NSw1MS01MVMyMzIuMDUsMTUzLDIwNCwxNTN6IE0yMDQsMzA2Yy0yOC4wNSwwLTUxLDIyLjk1LTUxLDUxczIyLjk1LDUxLDUxLDUxczUxLTIyLjk1LDUxLTUxDQoJCQlTMjMyLjA1LDMwNiwyMDQsMzA2eiIvPg0KCTwvZz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjwvc3ZnPg0K" />
                </button>
            </div>

            <!-- Musterdesignidee -->
            <div class="user-data-templ">
                <table  class="user-table">
                    <tr>
                        <td class="user-data-table-head">Favorisierte Plätze:</td>
                        <td class="user-data-table-input">Tower_1 <br> Tower_2 <br> DC_9</td>
                    </tr>
                    <tr>
                        <td class="user-data-table-head">Best-buddies:</td>
                        <td class="user-data-table-input">Max Mustermann  <br> Peter Pan  <br>Paul Panther</td>
                    </tr>
                </table>
            </div>
            <div class="coba-container">
                <button id="logout-button"  class="coba-button"> Logout</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Page_Profile"


}
</script>





<style scoped>

.user-container {
    border-radius: 5px;
    color: #b3b8cd;
    padding-top: 30px;
    position: relative;
    max-width: 100%;
    text-align: center;
    padding-bottom: 48px;
}
.user-container .round {
    border: 2px solid #FFC931;
    border-radius: 50%;
    padding: 7px;
    max-width: 50%;
    max-height: 50%;
    box-shadow: 10px 20px 30px 0px rgba(0, 0, 0, 0.75);
}
.setting-button{
    margin: 5px;
    border-radius: 10px;
    max-width: 70%;
    padding: 8px ;
    border: 2px solid #FFC931 ;
    height: 50px;
}
.setting-button .dots{
    max-height: 90%;
    max-width: 90%;
    opacity: 0.8;
}
.user-data-templ {
    max-width: 90%;
    margin-left: 5%;

    margin-top:30px;
    display: flex;
    border-radius: 8px;
    box-shadow: inset 100px 10px 100px -50px #FFC931;
    padding-bottom: 10px;
}
.user-table {
    border-collapse: collapse;
    margin: 25px 5px 5px 25px;
    font-size: 1.05em;
}
.user-table .user-data-table-head{
    text-align: left;
    font-weight: bold ;
    vertical-align: top;
}
.user-table .user-data-table-input{
    text-align: right;
}



</style>
