<template>
    <img
        v-for="img in block.value.value"
        :key="img.id"
        :src="'/' + img.dir + '/' + img.name"
        :class="checkClass(block.options.class)"
        :style="checkStyle(block.options.styles)"
    />
</template>

<script>
import { useMyAdminStore } from "@/Pages/My/Admin/Store.js";
import { useMyCmsStore } from "@/Pages/My/Cms/Store.js";

export default {
    name: "Img",
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
                return { id: -1 };
            },
        },
    },
    data() {
        return {};
    },
    created() {},
    watch: {
        "myAdmin.$state.config.langs": {
            deep: true,
            handler() {
                // this.langDefault();
            },
        },
    },
    computed: {},
    methods: {
        checkClass(v) {
            //console.log("|_ Cargar clases");
            let rcl = "";

            for (let i = 0; i < v.length; i++) {
                if (typeof v[i].default === "string") {
                    rcl = rcl + " " + v[i].default;
                }
                if (typeof v[i].default === "object" && v[i].default !== null) {
                    console.log(v[i].default);
                }
            }
            return rcl;
        },
        checkStyle(v) {},
    },
};
</script>
