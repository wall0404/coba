<template>
    <div class="coba-container coba-settings-item">
        <div class="coba-full-width coba-flex space-between">
            <div>ICal</div>
            <div class="custom-control custom-switch">
                <b-form-checkbox v-model="checked" name="check-button" switch size="lg" @change="handleChange" :disabled="load">

                </b-form-checkbox>
            </div>
        </div>
        <div v-if="iCalAssignment" class="ical-url my-3 p-1 coba-flex space-between rounded-sm"
             v-clipboard:copy="iCalAssignment.url"
             v-clipboard:success="onCopy"
             v-clipboard:error="onError">
            <span>URL: </span> <span class="url ml-2">{{url}}</span><b-icon :icon="clipboard"></b-icon>
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
            clipboard: "clipboard"
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
                    'content-type': 'application/json'
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
                        'content-type': 'application/json'
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
                this.load = true;
                fetch('/api/ical', {
                    method: 'DELETE',
                    headers: {
                        'content-type': 'application/json'
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
        },
        onError() {
            this.clipboard = "clipboard-x";
        }
    }
}
</script>

<style scoped>
    .ical-url {
        position: relative;
        background-color: gray;
        color: white;
    }
    .url {
        white-space: nowrap;
        overflow: hidden;
        text-decoration: underline;
        text-overflow: ellipsis;
    }
</style>
