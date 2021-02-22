<template>
    <div class="coba-container coba-settings-item">
        <div class="coba-full-width coba-flex space-between">
            <div>ICal</div>
            <div class="custom-control custom-switch">
                <b-form-checkbox v-model="checked" name="check-button" switch size="lg" @change="handleChange" :disabled="load">

                </b-form-checkbox>
            </div>
        </div>
        <div v-if="iCalAssignment" class="ical-url my-3 p-1 coba-flex space-between rounded-sm" :class="{'green':copied}"
             v-clipboard:copy="iCalAssignment.url"
             v-clipboard:success="onCopy"
             v-clipboard:error="onError">
            <span class="url ml-2">{{this.iCalAssignment.url}}</span><b-icon :icon="clipboard" font-scale="1.5"></b-icon>
        </div>
        <spinner v-else-if="load&&checked"></spinner>
    </div>
</template>

<script>
import Spinner from "../../Global/Spinner";
export default {
    name: "iCalSettings",
    components: {Spinner},
    data() {
        return {
            iCalAssignment: null,
            checked: false,
            load: false,
            clipboard: "clipboard",
            copied: false
        }
    },
    computed: {
        url: function() {
            return "..."+this.iCalAssignment.url.substring(this.iCalAssignment.url.length-26)
        }
    },
    created() {
        this.fetchData();
    },
    methods: {
        fetchData() {
            this.load = true;
            fetch('/api/ical', {
                method: 'GET',
                headers: {
                    'content-type': 'application/json',
                    'Authorization' : 'Bearer '+localStorage.token
                }
            })
                .then(res => res.json())
                .then(res => {
                    if(res.success) {
                        this.iCalAssignment = res.success;
                        this.checked = this.iCalAssignment !== null;
                        this.load = false;
                    }
                    else {
                        this.error = true;
                        this.load = false;
                    }
                })
                .catch(error => {
                    console.log(error);
                    this.load = false;
                })
        },
        handleChange() {
            if(this.checked) {
                this.load = true;
                fetch('/api/ical', {
                    method: 'POST',
                    headers: {
                        'content-type': 'application/json',
                        'Authorization' : 'Bearer '+localStorage.token
                    }
                })
                    .then(res => res.json())
                    .then(res => {
                        if(res.success) {
                            this.iCalAssignment = res.success;
                            this.checked = this.iCalAssignment !== null;
                            this.load = false;
                        }
                        else {
                            this.error = true;
                            this.load = false;
                        }
                    })
                    .catch(error => {
                        console.log(error);
                        this.load = false;
                    })
            }
            else {
                this.copied = false;
                this.load = true;
                fetch('/api/ical', {
                    method: 'DELETE',
                    headers: {
                        'content-type': 'application/json',
                        'Authorization' : 'Bearer '+localStorage.token
                    }
                })
                    .then(res => res.json())
                    .then(res => {
                        if(res.success) {
                            this.iCalAssignment = null;
                            this.checked = false;
                            this.clipboard = "clipboard";
                            this.load = false;
                        }
                        else {
                            this.error = true;
                            this.load = false;
                        }
                    })
                    .catch(error => {
                        console.log(error);
                        this.load = false;
                    })
            }
        },
        onCopy() {
            this.clipboard = "clipboard-check";
            this.copied = true;
        },
        onError() {
            this.clipboard = "clipboard-x";
        }
    }
}
</script>

<style scoped>
    .custom-switch {
        left: 5px;
    }
    .ical-url {
        position: relative;
        background-color: lightgray;
        border: 1px dashed gray;
    }
    .green {
        background-color: lightgreen;
        border: 1px solid gray;
    }
    .url {
        overflow-wrap: break-word;
        word-wrap: break-word;
        hyphens: none;
        -ms-word-break: break-all;
        /* This is the dangerous one in WebKit, as it breaks things wherever */
        word-break: break-all;
        /* Instead use this non-standard one: */
        word-break: break-word;
        text-decoration: underline;
    }
</style>
