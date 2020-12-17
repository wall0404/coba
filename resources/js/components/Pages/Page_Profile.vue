<template>
    <div class="coba-page">
        <div class="user-container mb-5 mt-4">
            <div><img class="coba-border-round coba-border-yellow coba-shadow p-1" src="https://icons-for-free.com/iconfiles/png/512/business+costume+male+man+office+user+icon-1320196264882354682.png" alt="user"/> </div>
        </div>
        <div class="coba-container text-center pb-0">
            <h3 class="mb-0">{{ $store.getters.data.user.firstName +" " + $store.getters.data.user.lastName }}</h3>
            <p class="mb-1">{{$store.getters.data.user.email}}</p>
            <router-link class="setting-button coba-flex-space-evenly coba-border-yellow p-2 coba-border-rounded" to="/profile/settings">
                <span>Konto</span>
                <b-icon icon="sliders"></b-icon>
            </router-link>
        </div>
        <div class="coba-container">
            <!-- Musterdesignidee -->
            <div class="coba-border-rounded p-2 user-data-templ">
                <table  class="user-table w-100">
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
            <router-link to="/logout" class="coba-button mt-4">Logout</router-link>
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
    position: relative;
    max-width: 100%;
    text-align: center;
}
.user-container img {
    max-width: 50%;
    max-height: 50%;
}
.setting-button{
    margin: 10px auto;
}

.user-data-templ {
    display: flex;
    box-shadow: inset 100px 10px 100px -50px #FFC931;
}
.user-table {
    border-collapse: collapse;
    font-size: 1.05em;
}
.user-table .user-data-table-head{
    text-align: left;
    font-weight: bold;
    vertical-align: top;
}
.user-table .user-data-table-input{
    text-align: right;
}



</style>
