<template>
    <div class="loader">Loading...</div>
</template>

<script>
export default {
name: "Spinner"
}
</script>

<style scoped>
.loader {
    margin: 100px auto;
    font-size: 6px;
    width: 1em;
    height: 1em;
    border-radius: 50%;
    position: relative;
    text-indent: -9999em;
    -webkit-animation: load5 1.1s infinite ease;
    animation: load5 1.1s infinite ease;
    -webkit-transform: translateZ(0);
    -ms-transform: translateZ(0);
    transform: translateZ(0);
}
@-webkit-keyframes load5 {
    0%,
    100% {
        box-shadow: 0em -2.6em 0em 0em #FEEF00, 1.8em -1.8em 0 0em #b7ac03, 2.5em 0em 0 0em #b7ac03, 1.75em 1.75em 0 0em #b7ac03, 0em 2.5em 0 0em #b7ac03, -1.8em 1.8em 0 0em #b7ac03, -2.6em 0em 0 0em #d0c401, -1.8em -1.8em 0 0em #eadd03;
    }
    12.5% {
        box-shadow: 0em -2.6em 0em 0em #eadd03, 1.8em -1.8em 0 0em #FEEF00, 2.5em 0em 0 0em #b7ac03, 1.75em 1.75em 0 0em #b7ac03, 0em 2.5em 0 0em #b7ac03, -1.8em 1.8em 0 0em #b7ac03, -2.6em 0em 0 0em #b7ac03, -1.8em -1.8em 0 0em #d0c401;
    }
    25% {
        box-shadow: 0em -2.6em 0em 0em #d0c401, 1.8em -1.8em 0 0em #eadd03, 2.5em 0em 0 0em #FEEF00, 1.75em 1.75em 0 0em #b7ac03, 0em 2.5em 0 0em #b7ac03, -1.8em 1.8em 0 0em #b7ac03, -2.6em 0em 0 0em #b7ac03, -1.8em -1.8em 0 0em #b7ac03;
    }
    37.5% {
        box-shadow: 0em -2.6em 0em 0em #b7ac03, 1.8em -1.8em 0 0em #d0c401, 2.5em 0em 0 0em #eadd03, 1.75em 1.75em 0 0em #FEEF00, 0em 2.5em 0 0em #b7ac03, -1.8em 1.8em 0 0em #b7ac03, -2.6em 0em 0 0em #b7ac03, -1.8em -1.8em 0 0em #b7ac03;
    }
    50% {
        box-shadow: 0em -2.6em 0em 0em #b7ac03, 1.8em -1.8em 0 0em #b7ac03, 2.5em 0em 0 0em #d0c401, 1.75em 1.75em 0 0em #eadd03, 0em 2.5em 0 0em #FEEF00, -1.8em 1.8em 0 0em #988f02, -2.6em 0em 0 0em #988f02, -1.8em -1.8em 0 0em #988f02;
    }
    62.5% {
        box-shadow: 0em -2.6em 0em 0em #b7ac03, 1.8em -1.8em 0 0em #b7ac03, 2.5em 0em 0 0em #b7ac03, 1.75em 1.75em 0 0em #d0c401, 0em 2.5em 0 0em #eadd03, -1.8em 1.8em 0 0em #FEEF00, -2.6em 0em 0 0em #988f02, -1.8em -1.8em 0 0em #988f02;
    }
    75% {
        box-shadow: 0em -2.6em 0em 0em #b7ac03, 1.8em -1.8em 0 0em #b7ac03, 2.5em 0em 0 0em #b7ac03, 1.75em 1.75em 0 0em #b7ac03, 0em 2.5em 0 0em #d0c401, -1.8em 1.8em 0 0em #eadd03, -2.6em 0em 0 0em #FEEF00, -1.8em -1.8em 0 0em #988f02;
    }
    87.5% {
        box-shadow: 0em -2.6em 0em 0em #b7ac03, 1.8em -1.8em 0 0em #b7ac03, 2.5em 0em 0 0em #b7ac03, 1.75em 1.75em 0 0em #b7ac03, 0em 2.5em 0 0em #b7ac03, -1.8em 1.8em 0 0em #d0c401, -2.6em 0em 0 0em #eadd03, -1.8em -1.8em 0 0em #FEEF00;
    }
}
@keyframes load5 {
    0%,
    100% {
        box-shadow: 0em -2.6em 0em 0em #FEEF00, 1.8em -1.8em 0 0em #b7ac03, 2.5em 0em 0 0em #b7ac03, 1.75em 1.75em 0 0em #b7ac03, 0em 2.5em 0 0em #b7ac03, -1.8em 1.8em 0 0em #b7ac03, -2.6em 0em 0 0em #d0c401, -1.8em -1.8em 0 0em #eadd03;
    }
    12.5% {
        box-shadow: 0em -2.6em 0em 0em #eadd03, 1.8em -1.8em 0 0em #FEEF00, 2.5em 0em 0 0em #b7ac03, 1.75em 1.75em 0 0em #b7ac03, 0em 2.5em 0 0em #b7ac03, -1.8em 1.8em 0 0em #b7ac03, -2.6em 0em 0 0em #b7ac03, -1.8em -1.8em 0 0em #d0c401;
    }
    25% {
        box-shadow: 0em -2.6em 0em 0em #d0c401, 1.8em -1.8em 0 0em #eadd03, 2.5em 0em 0 0em #FEEF00, 1.75em 1.75em 0 0em #b7ac03, 0em 2.5em 0 0em #b7ac03, -1.8em 1.8em 0 0em #b7ac03, -2.6em 0em 0 0em #b7ac03, -1.8em -1.8em 0 0em #b7ac03;
    }
    37.5% {
        box-shadow: 0em -2.6em 0em 0em #b7ac03, 1.8em -1.8em 0 0em #d0c401, 2.5em 0em 0 0em #eadd03, 1.75em 1.75em 0 0em #FEEF00, 0em 2.5em 0 0em #b7ac03, -1.8em 1.8em 0 0em #b7ac03, -2.6em 0em 0 0em #b7ac03, -1.8em -1.8em 0 0em #b7ac03;
    }
    50% {
        box-shadow: 0em -2.6em 0em 0em #b7ac03, 1.8em -1.8em 0 0em #b7ac03, 2.5em 0em 0 0em #d0c401, 1.75em 1.75em 0 0em #eadd03, 0em 2.5em 0 0em #FEEF00, -1.8em 1.8em 0 0em #988f02, -2.6em 0em 0 0em #988f02, -1.8em -1.8em 0 0em #988f02;
    }
    62.5% {
        box-shadow: 0em -2.6em 0em 0em #b7ac03, 1.8em -1.8em 0 0em #b7ac03, 2.5em 0em 0 0em #b7ac03, 1.75em 1.75em 0 0em #d0c401, 0em 2.5em 0 0em #eadd03, -1.8em 1.8em 0 0em #FEEF00, -2.6em 0em 0 0em #988f02, -1.8em -1.8em 0 0em #988f02;
    }
    75% {
        box-shadow: 0em -2.6em 0em 0em #b7ac03, 1.8em -1.8em 0 0em #b7ac03, 2.5em 0em 0 0em #b7ac03, 1.75em 1.75em 0 0em #b7ac03, 0em 2.5em 0 0em #d0c401, -1.8em 1.8em 0 0em #eadd03, -2.6em 0em 0 0em #FEEF00, -1.8em -1.8em 0 0em #988f02;
    }
    87.5% {
        box-shadow: 0em -2.6em 0em 0em #b7ac03, 1.8em -1.8em 0 0em #b7ac03, 2.5em 0em 0 0em #b7ac03, 1.75em 1.75em 0 0em #b7ac03, 0em 2.5em 0 0em #b7ac03, -1.8em 1.8em 0 0em #d0c401, -2.6em 0em 0 0em #eadd03, -1.8em -1.8em 0 0em #FEEF00;
    }
}

</style>
