<template>
    <v-card>
        <v-toolbar color="black" theme="dark">
            <v-card-title color="indigo darken-2"> Paginas </v-card-title>
            <v-spacer></v-spacer>

            <v-btn variant="flat" color="secondary" @click="addNew()">
                Agregar
            </v-btn>
        </v-toolbar>

        <v-row class="pa-4" justify="space-between">
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
                                    v-for="item in pages.data"
                                    :key="item.name"
                                    @click="edit = item"
                                >
                                    <td>{{ item.alias }}</td>
                                    <td>{{ item.prority }}</td>
                                </tr>
                            </tbody>
                        </v-table>
                        <v-pagination
                            v-if="pages.last_page > 1"
                            v-model="view.page"
                            :length="pages.last_page"
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
                    <v-col class="12">
                        Selecciona una pagina para editar
                    </v-col>
                </v-row>
                <v-row v-else>
                    <v-col cols="12">
                        <h1
                            class="text-h6 text-center grey--text text--lighten-1 font-weight-light"
                        >
                            Editar {{ edit.alias }}
                        </h1>
                    </v-col>
                    <v-col cols="12">
                        {{ edit }}
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
    </v-card>
</template>

<script>
import { useMyAdminStore } from "@/Pages/My/Admin/Store.js";
import { useMyCmsStore } from "@/Pages/My/Cms/Store.js";

export default {
    name: "Admin Rutas",
    components: {},
    setup() {
        const myAdmin = useMyAdminStore();
        const myCms = useMyCmsStore();
        return { myAdmin, myCms };
    },
    props: {},
    data() {
        return {
            view: { search: "", page: 1 },
            pages: [],
            edit: { id: null },
        };
    },
    created() {
        this.loadPages();
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
                this.loadPages();
            },
        },
    },
    computed: {},
    methods: {
        addNew() {
            console.log("test");
        },
        loadPages() {
            this.myAdmin.$state.headers.params = this.view;
            axios
                .get(
                    route("api_my_admin.cms.paths.index"),
                    this.myAdmin.$state.headers
                )
                .then((result) => {
                    this.pages = result.data;
                    this.myAdmin.$state.headers.params = {};
                })
                .catch((err) => {
                    console.log("error My Admin cms paths");
                    console.log(err.message);
                });
        },
    },
};
</script>
