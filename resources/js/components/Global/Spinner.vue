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
        box-shadow: 0em -2.6em 0em 0em #FEEF00, 1.8em -1.8em 0 0em #FEEF00, 2.5em 0em 0 0em #FEEF00, 1.75em 1.75em 0 0em #FEEF00, 0em 2.5em 0 0em #FEEF00, -1.8em 1.8em 0 0em #026877, -2.6em 0em 0 0em #014d58, -1.8em -1.8em 0 0em #00434D;
    }
    12.5% {
        box-shadow: 0em -2.6em 0em 0em #00434D, 1.8em -1.8em 0 0em #FEEF00, 2.5em 0em 0 0em #FEEF00, 1.75em 1.75em 0 0em #FEEF00, 0em 2.5em 0 0em #FEEF00, -1.8em 1.8em 0 0em #FEEF00, -2.6em 0em 0 0em #026877, -1.8em -1.8em 0 0em #014d58;
    }
    25% {
        box-shadow: 0em -2.6em 0em 0em #014d58, 1.8em -1.8em 0 0em #00434D, 2.5em 0em 0 0em #FEEF00, 1.75em 1.75em 0 0em #FEEF00, 0em 2.5em 0 0em #FEEF00, -1.8em 1.8em 0 0em #FEEF00, -2.6em 0em 0 0em #FEEF00, -1.8em -1.8em 0 0em #026877;
    }
    37.5% {
        box-shadow: 0em -2.6em 0em 0em #026877, 1.8em -1.8em 0 0em #014d58, 2.5em 0em 0 0em #00434D, 1.75em 1.75em 0 0em #FEEF00, 0em 2.5em 0 0em #FEEF00, -1.8em 1.8em 0 0em #FEEF00, -2.6em 0em 0 0em #FEEF00, -1.8em -1.8em 0 0em #FEEF00;
    }
    50% {
        box-shadow: 0em -2.6em 0em 0em #FEEF00, 1.8em -1.8em 0 0em #026877, 2.5em 0em 0 0em #014d58, 1.75em 1.75em 0 0em #00434D, 0em 2.5em 0 0em #FEEF00, -1.8em 1.8em 0 0em #FEEF00, -2.6em 0em 0 0em #FEEF00, -1.8em -1.8em 0 0em #FEEF00;
    }
    62.5% {
        box-shadow: 0em -2.6em 0em 0em #FEEF00, 1.8em -1.8em 0 0em #FEEF00, 2.5em 0em 0 0em #026877, 1.75em 1.75em 0 0em #014d58, 0em 2.5em 0 0em #00434D, -1.8em 1.8em 0 0em #FEEF00, -2.6em 0em 0 0em #FEEF00, -1.8em -1.8em 0 0em #FEEF00;
    }
    75% {
        box-shadow: 0em -2.6em 0em 0em #FEEF00, 1.8em -1.8em 0 0em #FEEF00, 2.5em 0em 0 0em #FEEF00, 1.75em 1.75em 0 0em #026877, 0em 2.5em 0 0em #014d58, -1.8em 1.8em 0 0em #00434D, -2.6em 0em 0 0em #FEEF00, -1.8em -1.8em 0 0em #FEEF00;
    }
    87.5% {
        box-shadow: 0em -2.6em 0em 0em #FEEF00, 1.8em -1.8em 0 0em #FEEF00, 2.5em 0em 0 0em #FEEF00, 1.75em 1.75em 0 0em #FEEF00, 0em 2.5em 0 0em #026877, -1.8em 1.8em 0 0em #014d58, -2.6em 0em 0 0em #00434D, -1.8em -1.8em 0 0em #FEEF00;
    }
}
@keyframes load5 {
    0%,
    100% {
        box-shadow: 0em -2.6em 0em 0em #FEEF00, 1.8em -1.8em 0 0em #FEEF00, 2.5em 0em 0 0em #FEEF00, 1.75em 1.75em 0 0em #FEEF00, 0em 2.5em 0 0em #FEEF00, -1.8em 1.8em 0 0em #026877, -2.6em 0em 0 0em #014d58, -1.8em -1.8em 0 0em #00434D;
    }
    12.5% {
        box-shadow: 0em -2.6em 0em 0em #00434D, 1.8em -1.8em 0 0em #FEEF00, 2.5em 0em 0 0em #FEEF00, 1.75em 1.75em 0 0em #FEEF00, 0em 2.5em 0 0em #FEEF00, -1.8em 1.8em 0 0em #FEEF00, -2.6em 0em 0 0em #026877, -1.8em -1.8em 0 0em #014d58;
    }
    25% {
        box-shadow: 0em -2.6em 0em 0em #014d58, 1.8em -1.8em 0 0em #00434D, 2.5em 0em 0 0em #FEEF00, 1.75em 1.75em 0 0em #FEEF00, 0em 2.5em 0 0em #FEEF00, -1.8em 1.8em 0 0em #FEEF00, -2.6em 0em 0 0em #FEEF00, -1.8em -1.8em 0 0em #026877;
    }
    37.5% {
        box-shadow: 0em -2.6em 0em 0em #026877, 1.8em -1.8em 0 0em #014d58, 2.5em 0em 0 0em #00434D, 1.75em 1.75em 0 0em #FEEF00, 0em 2.5em 0 0em #FEEF00, -1.8em 1.8em 0 0em #FEEF00, -2.6em 0em 0 0em #FEEF00, -1.8em -1.8em 0 0em #FEEF00;
    }
    50% {
        box-shadow: 0em -2.6em 0em 0em #FEEF00, 1.8em -1.8em 0 0em #026877, 2.5em 0em 0 0em #014d58, 1.75em 1.75em 0 0em #00434D, 0em 2.5em 0 0em #FEEF00, -1.8em 1.8em 0 0em #FEEF00, -2.6em 0em 0 0em #FEEF00, -1.8em -1.8em 0 0em #FEEF00;
    }
    62.5% {
        box-shadow: 0em -2.6em 0em 0em #FEEF00, 1.8em -1.8em 0 0em #FEEF00, 2.5em 0em 0 0em #026877, 1.75em 1.75em 0 0em #014d58, 0em 2.5em 0 0em #00434D, -1.8em 1.8em 0 0em #FEEF00, -2.6em 0em 0 0em #FEEF00, -1.8em -1.8em 0 0em #FEEF00;
    }
    75% {
        box-shadow: 0em -2.6em 0em 0em #FEEF00, 1.8em -1.8em 0 0em #FEEF00, 2.5em 0em 0 0em #FEEF00, 1.75em 1.75em 0 0em #026877, 0em 2.5em 0 0em #014d58, -1.8em 1.8em 0 0em #00434D, -2.6em 0em 0 0em #FEEF00, -1.8em -1.8em 0 0em #FEEF00;
    }
    87.5% {
        box-shadow: 0em -2.6em 0em 0em #FEEF00, 1.8em -1.8em 0 0em #FEEF00, 2.5em 0em 0 0em #FEEF00, 1.75em 1.75em 0 0em #FEEF00, 0em 2.5em 0 0em #026877, -1.8em 1.8em 0 0em #014d58, -2.6em 0em 0 0em #00434D, -1.8em -1.8em 0 0em #FEEF00;
    }
}

</style>
