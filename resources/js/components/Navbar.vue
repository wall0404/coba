<template>
    <div class="coba-navbar coba-full-width"  v-if="$store.getters.data.user !== null && $store.getters.data.user !== ''">
        <router-link v-for="nav_item in nav" v-bind:to="nav_item.mainURL" v-bind:key="nav_item.name">
            <div><b-icon :icon="nav_item.icon" font-scale="2"></b-icon></div>
        </router-link>
    </div>
    <div v-else class="coba-navbar coba-full-width">
        <router-link v-for="nav_item in nav_login" v-bind:to="nav_item.mainURL" v-bind:key="nav_item.name">
            <div>{{ nav_item.name }}</div>
        </router-link>
    </div>
</template>

<script>
export default {
    name: "Navbar",
    data() {
        return {
            nav: [
                {name: 'Home', mainURL: '/home', icon: 'house-fill'},
                {name: 'Team', mainURL: '/team', icon: 'people-fill'},
                {name: 'Cal', mainURL: '/calendar', icon: 'calendar2-week-fill'},
                {name: 'Profile', mainURL: '/profile', icon: 'person-fill'},
            ],
            nav_login: [
                {name: 'Sign In', mainURL: '/login'},
                {name: 'Sign Up', mainURL: '/signup'},
            ],
        }
    },
    created() {
    }
}
</script>
