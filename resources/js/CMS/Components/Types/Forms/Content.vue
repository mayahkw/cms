<template>
    <v-row>
        <v-col cols="12">
            <v-switch
                :label="block.value.editable ? 'Dinamico' : 'Estatico'"
                v-model="block.value.editable"
            ></v-switch>
        </v-col>
        <v-col cols="12">
            <ckeditor
                :editor="myCms.$state.editor"
                v-model="block.value.value"
                :config="myCms.$state.editorConfig"
            ></ckeditor>
        </v-col>
    </v-row>
</template>

<script>
import { useMyAdminStore } from "@/Pages/My/Admin/Store.js";
import { useMyCmsStore } from "@/Pages/My/Cms/Store.js";

export default {
    name: "Title",
    components: {},
    setup() {
        const myAdmin = useMyAdminStore();
        const myCms = useMyCmsStore();
        return { myAdmin, myCms };
    },
    props: {
        block: {
            type: Object,
            default() {
                return { id: -1, value: null };
            },
        },
    },
    data() {
        return {};
    },
    created() {
        if (this.block.value === null) {
            this.block.value = { value: null, editable: null };
        }
    },
    watch: {
        "myAdmin.$state.config.langs": {
            deep: true,
            handler() {
                // this.langDefault();
            },
        },
    },
    computed: {},
    methods: {},
};
</script>
