<template>
    <div v-bind:class="classes">
        <textarea v-if="type === 'textarea'" class="coba-input coba-height-small" v-bind:placeholder="placeholder"
                  v-model="model[name]"
                  v-bind:class="((error&&error[name]!=null)?'coba-form-danger':'') + classes_input"
                  @focus="clearError">

        </textarea>
        <input v-else class="coba-input" v-bind:type="type" v-bind:placeholder="placeholder"
               v-model="model[name]"
               v-bind:class="((error&&error[name]!=null)?'coba-form-danger':'') + classes_input"
               @focus="clearError">


        <div v-if="error && error[name]">
            <span class="coba-text-danger" v-for="this_error in error[name]">{{this_error}}</span>
        </div>
    </div>
</template>

<script>
export default {
    props: ['error', 'name', 'type', 'classes', 'classes_input', 'model', 'placeholder'],
    name: "ElementInput",
    methods: {
        clearError() {
            try {
                this.error[this.name] = [];
                delete this.error[this.name];
            }
            catch (e) {

            }
        }
    }
}
</script>
