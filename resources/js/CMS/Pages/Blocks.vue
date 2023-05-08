<template>
    <v-card>
        <v-toolbar color="black" theme="dark">
            <v-card-title color="indigo darken-2"> Bloques </v-card-title>
            <v-spacer></v-spacer>

            <v-btn variant="flat" color="secondary" @click="addNew()">
                Agregar
            </v-btn>
            <v-btn
                v-if="edit.id !== null"
                class="ml-2"
                variant="flat"
                color="secondary"
                @click="saveEdit()"
            >
                Guardar
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
                                    v-for="item in blocks.data"
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
                            v-if="blocks.last_page > 1"
                            v-model="view.page"
                            :length="blocks.last_page"
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
                    <v-col class="12"> Selecciona un bloque para editar </v-col>
                </v-row>
                <v-row v-else>
                    <v-col cols="12">
                        <FormBlock :item="edit"></FormBlock>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
    </v-card>
</template>

<script>
import { useMyAdminStore } from "@/Pages/My/Admin/Store.js";
import { useMyCmsStore } from "@/Pages/My/Cms/Store.js";
import FormBlock from "@/Pages/My/Cms/Components/FormBlock.vue";

export default {
    name: "Index blocks",
    components: { FormBlock },
    setup() {
        const myAdmin = useMyAdminStore();
        const myCms = useMyCmsStore();
        return { myAdmin, myCms };
    },
    props: {},
    data() {
        return {
            view: { search: "", page: 1 },
            blocks: [],
            edit: { id: null },
        };
    },
    created() {
        this.loadBlocks();
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
                this.loadBlocks();
            },
        },
    },
    computed: {},
    methods: {
        saveEdit() {
            console.log(this.edit);
            this.myAdmin.$state.loading.show = true;
            this.myAdmin.$state.loading.text = "Actualizando block";

            axios
                .post(
                    route("api_my_admin.cms.blocks.store"),
                    this.edit,
                    this.myAdmin.$state.headers
                )
                .then((response) => {
                    axios
                        .get(
                            route("api_my_admin.menus.index"),
                            this.myAdmin.$state.headers
                        )
                        .then((response) => {
                            this.myAdmin.$state.menu = response.data;
                            this.myAdmin.$state.loading.show = false;
                            this.loadBlocks();
                        });
                })
                .catch((error) => {
                    this.myAdmin.$state.loading.show = false;
                });
        },
        addNew() {
            this.edit = {
                id: -1,
                user_id: 1,
                order: 1,
                use: "all",
                type: "",
                name: "",
                description: "",
                options: {
                    class: [],
                    styles: [],
                    options: [],
                    father: { value: true, limit: null },
                },
                operators: null,
                value: { value: null },
                active: 1,
                deleted_at: null,
            };

            this.myAdmin.$state.varModulo = this.edit;
            //alert(this.edit.id);
        },
        loadBlocks() {
            this.myAdmin.$state.headers.params = this.view;
            axios
                .get(
                    route("api_my_admin.cms.blocks.index"),
                    this.myAdmin.$state.headers
                )
                .then((result) => {
                    this.blocks = result.data;
                    this.myAdmin.$state.headers.params = {};
                })
                .catch((err) => {
                    console.log("error My Admin cms blocks");
                    console.log(err.message);
                });
        },
    },
};
</script>
