<template>
    <div>
        <div id="back_button" v-if="!exclude.find(name => name===$route.name)"
             :class="{'invert':whiteBackground.find(name => name===$route.name)}"
             @click="triggerBack(false)">
            <b-icon icon="arrow-left-short" font-scale="3"></b-icon>
        </div>
        <modal :show-modal="modal_open" @modal-close-event="closeModal">
            <template v-slot:header>
                <div class="coba-modal-header">Zurückkehren</div>
            </template>
            <template v-slot:body>
                <div class="coba-modal-body coba-text">
                    Bist du dir sicher, dass du zurückkehren möchtest?
                    <!-- Sind sie sich sicher, dass sie zurückkehren möchten? -->
                </div>
            </template>
            <template v-slot:footer>
                <div class="coba-modal-footer coba-button-container">
                    <button class="coba-button coba-button-danger" @click="triggerBack(true)">Ja</button>
                    <button class="coba-button" @click="closeModal">Nein</button>
                </div>
            </template>
        </modal>
    </div>
</template>

<script>
import Modal from "../Elements/Modal";
export default {
    name: "BackButton",
    components: {Modal},
    data() {
        return {
            exclude: [
                "Home", "Login", "SignUp", "Logout","Calendar","Team","Profile","TeamMember",
            ],
            whiteBackground: [
                "Profile", "TeamMember",
            ],
            checkTwice: [

            ],
            modal_open: false,
        }
    },
    methods: {
        triggerBack(force) {
            if (!force && (this.checkTwice.find(name => name === this.$route.name) || this.$store.getters.changes)) {
                this.modal_open = true;
                this.$store.commit('clearChanges');
            }
            else {
                this.$router.go(-1);
                this.closeModal();
            }
        },
        closeModal() {
            this.modal_open = false;
        }
    }
}
</script>

<style scoped>
    #back_button {
        position: absolute;
        top: 20px;
        left: 20px;
        color: white;
        z-index: 9;
    }
    .invert {
        color: gray !important;
    }
</style>
