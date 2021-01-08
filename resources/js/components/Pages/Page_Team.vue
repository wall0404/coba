<template>

    <div class="coba-page">
        <div class="coba-header coba-header-accent position-relative">
            <h2 class="coba-page-headline">Team</h2>
            <div class="filter-container w-100 position-absolute coba-flex-space-evenly">
                <input id="contact"  class="coba-border-rounded coba-border-orange p-2" type="text"  placeholder="Kontakt suchen..">
                <button class="coba-button coba-button-round coba-button-small m-0"><b-icon icon="sort-up"></b-icon></button>
            </div>
        </div>

        <div class="coba-container">
            <div class="coba-shadow coba-border-rounded coba-flex-space-between p-2 mb-5" v-for="n in 5">
                <div class="profile-picture"  style="background-color: transparent "> <img class="coba-border-round coba-border-yellow p-1 w-100" src="https://icons-for-free.com/iconfiles/png/512/business+costume+male+man+office+user+icon-1320196264882354682.png" alt="user"/> </div>
                <div>
                    <table  class="user-table">
                        <tr>
                            <td class="user-data-name">Max Mustermann</td>
                        </tr>
                        <tr>
                            <td class="user-data-email">max.mustermann@coba.de</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
export default {
name: "Teampage",


}
</script>

<style scoped>
#contact{
    width: 65%;
}
.filter-container{
    bottom: 10px
}
.profile-picture {
    width: 25%;
}
.user-table {
    border-collapse: collapse;
    margin: 0 5px 5px 0;
    font-size: 1.05em;
    text-align: center;
}
.user-table .user-data-name {
    text-align: right;
    font-weight: bold;
}



</style>
