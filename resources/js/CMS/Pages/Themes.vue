<template>
    <v-card>
        <v-toolbar color="black" theme="dark">
            <v-card-title color="indigo darken-2"> Temas </v-card-title>
            <v-spacer></v-spacer>

            <v-btn
                variant="flat"
                color="secondary"
                @click="
                    addNew(),
                        (myAdmin.$state.varModulo = {
                            id: -1,
                            lang: null,
                            name: '',
                            description: null,
                        })
                "
            >
                Agregar
            </v-btn>

            <v-btn
                v-if="edit.id !== null"
                class="ml-2"
                variant="flat"
                color="secondary"
                @click="save()"
            >
                Guardar
            </v-btn>
        </v-toolbar>

        <v-row class="pa-4">
            <v-col cols="3">
                <v-row>
                    <v-col cols="12">
                        <v-text-field
                            label="Buscar pagina"
                            v-model="view.search"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12">
                        <v-table>
                            <thead>
                                <tr>
                                    <th class="text-left">Name</th>
                                    <th class="text-left">Views</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="item in themes.data"
                                    :key="item.name"
                                    @click="
                                        (edit = item),
                                            (myAdmin.$state.varModulo = item)
                                    "
                                >
                                    <td>{{ item.name }}</td>
                                    <td>{{ item.lang }}</td>
                                </tr>
                            </tbody>
                        </v-table>
                        <v-pagination
                            v-if="themes.last_page > 1"
                            v-model="view.page"
                            :length="themes.last_page"
                            rounded="circle"
                        ></v-pagination>
                    </v-col>
                </v-row>
            </v-col>

            <v-divider vertical></v-divider>

            <v-col class="d-flex">
                <v-row
                    v-if="edit.id === null"
                    class="text-h6 text-center grey--text text--lighten-1 font-weight-light"
                    style="align-self: center"
                >
                    <v-col class="12"> Selecciona un tema para editar </v-col>
                </v-row>
                <v-row v-else dense no-gutters>
                    <v-col cols="12">
                        <FormTheme
                            :item="edit"
                            @update="loadThemes(true)"
                        ></FormTheme>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
    </v-card>
</template>

<script>
import { useMyAdminStore } from "@/Pages/My/Admin/Store.js";
import { useMyCmsStore } from "@/Pages/My/Cms/Store.js";
import FormTheme from "@/Pages/My/Cms/Components/FormTheme.vue";

export default {
    name: "Index Themes",
    components: { FormTheme },
    setup() {
        const myAdmin = useMyAdminStore();
        const myCms = useMyCmsStore();
        return { myAdmin, myCms };
    },
    props: {},
    data() {
        return {
            view: { search: "", page: 1 },
            themes: [],
            edit: { id: null },
        };
    },
    created() {
        this.loadThemes();
    },
    watch: {
        "myAdmin.$state.config.langs": {
            deep: true,
            handler() {
                // this.langDefault();
            },
        },
        view: {
            deep: true,
            handler() {
                this.loadThemes();
            },
        },
    },
    computed: {},
    methods: {
        save() {
            console.log(this.item);
            this.myAdmin.$state.loading.show = true;
            this.myAdmin.$state.loading.text = "Guardando theme";

            axios
                .post(
                    route("api_my_admin.cms.themes.store"),
                    this.edit,
                    this.myAdmin.$state.headers
                )
                .then((response) => {
                    this.myAdmin.$state.loading.show = false;
                    this.edit = response.data;
                    this.loadThemes();
                })
                .catch((error) => {
                    this.myAdmin.$state.loading.show = false;
                });
        },
        addNew() {
            this.edit = { id: -1 };
        },
        loadThemes(v = false) {
            v === false ? "" : (this.edit = { id: null });
            this.myAdmin.$state.headers.params = this.view;
            axios
                .get(
                    route("api_my_admin.cms.themes.index"),
                    this.myAdmin.$state.headers
                )
                .then((result) => {
                    this.themes = result.data;
                    this.myAdmin.$state.headers.params = {};
                })
                .catch((err) => {
                    console.log("error My Admin cms themes");
                    console.log(err.message);
                });
        },
    },
};
</script>
