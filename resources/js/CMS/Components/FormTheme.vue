<template>
    <v-form>
        <v-row>
            <v-col cols="12">
                <h1
                    class="text-h6 text-center grey--text text--lighten-1 font-weight-light"
                >
                    Editar {{ item.name }}
                </h1>
            </v-col>

            <v-col cols="12">
                <v-text-field label="Nombre" v-model="item.name"></v-text-field>
            </v-col>

            <v-col cols="12">
                <v-textarea
                    label="Descripcion"
                    v-model="item.description"
                ></v-textarea>
            </v-col>

            <v-col cols="6">
                <v-btn
                    v-if="item.id !== -1"
                    block
                    color="success"
                    @click="
                        (myAdmin.$state.varModulo = {}),
                            $router.push({
                                name: 'my_admin.cms.themes.show',
                                params: { theme: item.id },
                            })
                    "
                >
                    Construir
                </v-btn>
            </v-col>

            <v-col cols="6">
                <v-btn
                    v-if="item.id !== -1"
                    block
                    color="danger"
                    @click="deleteTheme()"
                >
                    Eliminar
                </v-btn>
            </v-col>
        </v-row>
    </v-form>
</template>

<script>
import { useMyAdminStore } from "@/Pages/My/Admin/Store.js";
import { useMyCmsStore } from "@/Pages/My/Cms/Store.js";

export default {
    name: "Form Themes",
    components: {},
    setup() {
        const myAdmin = useMyAdminStore();
        const myCms = useMyCmsStore();
        return { myAdmin, myCms };
    },
    props: {
        item: {
            type: Object,
            default() {
                return { id: -1 };
            },
        },
    },
    data() {
        return {
            edit: { id: null },
        };
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
        deleteTheme() {
            console.log(this.item);
            this.myAdmin.$state.loading.show = true;
            this.myAdmin.$state.loading.text = "Eliminando theme";

            axios
                .delete(
                    route("api_my_admin.cms.themes.destroy", this.item.id),
                    this.myAdmin.$state.headers
                )
                .then((response) => {
                    this.$emit("update", response.data);
                    this.myAdmin.$state.loading.show = false;
                })
                .catch((error) => {
                    this.myAdmin.$state.loading.show = false;
                });
        },
    },
};
</script>
