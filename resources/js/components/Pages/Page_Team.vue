<template>

    <div class="coba-page">
        <div class="coba-header coba-header-accent">
            <h2 class="coba-page-headline">Team</h2>
        </div>
        <div class="filter-container">
            <input id="contact"  type="text"  placeholder="Kontakt suchen..">
            <button class="coba-button coba-button-round m-0"><b-icon icon="sort-up"></b-icon></button>
        </div>
        <br>
        <div class="user-data-templ" v-for="n in 5">
            <div class="profile-picture"  style="background-color: transparent "> <img class="round" src="https://icons-for-free.com/iconfiles/png/512/business+costume+male+man+office+user+icon-1320196264882354682.png" alt="user"/> </div>
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
</template>

<script>
export default {
name: "Teampage",


}
</script>

<style scoped>
#contact{
    border: 2px solid #ffad33 ;
    padding: 5px;
    width: 65%;
}
.filter-container{
    width: 100%;
    text-align: center;
    position: absolute;
    margin-top: -90px;
    margin-bottom: 10px;
    display: flex;
    justify-content: space-evenly;
}
.user-data-templ{
    max-width: 90%;
    box-shadow: 10px 20px 30px 0px rgba(0, 0, 0, 0.5);
    border-radius: 10px;
    margin: 20px auto;
    padding: 10px;
    display: flex;
    justify-content: space-between;
}
.profile-picture {
    width: 30%;
}
.user-table {
    border-collapse: collapse;
    margin: 0 5px 5px 0;
    font-size: 1.05em;
    text-align: center;
}
.user-table .user-data-name{
    text-align: right;
    font-weight: bold ;
}

.round {
    border: 1px solid #FFC931;
    border-radius: 50%;
    padding: 3px;
    max-width: 90%;
    max-height: 90%;
}



</style>
