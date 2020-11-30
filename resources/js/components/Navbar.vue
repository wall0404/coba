<template>
    <div class="coba-navbar coba-full-width">
        <router-link v-for="nav_item in nav" v-bind:to="nav_item.mainURL" v-bind:key="nav_item.name">
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
                {name: 'Home', mainURL: '/home'},
                {name: 'Team', mainURL: '/team'},
                {name: 'Cal', mainURL: '/calendar'},
                {name: 'Profile', mainURL: '/profile'},
            ],
        }
    },
    created() {
    }
}
</script>
