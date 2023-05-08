<template>
    <v-card>
        <v-toolbar color="black" theme="dark">
            <v-card-title color="indigo darken-2"> Paginas </v-card-title>
            <v-spacer></v-spacer>

            <v-btn
                variant="flat"
                color="secondary"
                v-if="edit.id !== -1"
                @click="addNew()"
            >
                Agregar
            </v-btn>

            <v-btn
                variant="flat"
                color="secondary"
                v-if="edit.id !== null"
                @click="save()"
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
                                    v-for="item in pages.data"
                                    :key="item.name"
                                    @click="select(item)"
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
                <v-form>
                    <v-row
                        v-if="edit.id === null"
                        class="text-h6 text-center grey--text text--lighten-1 font-weight-light"
                        style="align-self: center"
                    >
                        <v-col class="12">
                            Selecciona una pagina para editar
                        </v-col>
                    </v-row>

                    <v-row v-if="edit.id !== null">
                        <v-col cols="12">
                            <h1
                                class="text-h4 text-center grey--text text--lighten-1 font-weight-light"
                            >
                                {{ edit.id }}
                                <span v-if="edit.id !== -1">Editar</span>
                                <span v-else>Crear</span>
                                {{ edit.alias }}
                            </h1>
                        </v-col>

                        <v-col cols="12">
                            <v-text-field
                                label="Alias de la pagina"
                                v-model="edit.alias"
                                :rules="[myAdmin.$state.rules.required]"
                                @keyup="autoPath()"
                            ></v-text-field>
                        </v-col>

                        <v-col cols="12">
                            <v-row v-for="(lang, i) in edit.langs" :key="i">
                                <v-col cols="2">
                                    <v-autocomplete
                                        :label="'Theme para ' + lang.lang"
                                        :items="themes"
                                        item-value="id"
                                        :rules="[myAdmin.$state.rules.required]"
                                        item-title="name"
                                        v-model="lang.theme_id"
                                        @update:modelValue="autoPath()"
                                    >
                                    </v-autocomplete>
                                </v-col>
                                <v-col cols="3">
                                    <v-text-field
                                        :label="'Titulo ' + lang.lang"
                                        v-model="lang.title"
                                        :hint="lang.full_path"
                                        :rules="[myAdmin.$state.rules.required]"
                                        @keyup="autoPath()"
                                    >
                                    </v-text-field>
                                </v-col>
                                <v-col
                                    cols="6"
                                    @click="editPath[i].edit = true"
                                >
                                    <v-text-field
                                        v-if="editPath[i].edit === true"
                                        :label="'URL ' + lang.lang"
                                        v-model="lang.path"
                                        :hint="lang.full_path"
                                        :rules="[myAdmin.$state.rules.required]"
                                        @keyup="
                                            (editPath[i].auto = false),
                                                autoPath()
                                        "
                                    >
                                    </v-text-field>
                                    <v-text-field
                                        v-else
                                        disabled
                                        :label="'URL ' + lang.lang"
                                        v-model="lang.full_path"
                                    >
                                    </v-text-field>
                                </v-col>
                                <v-col cols="1">
                                    <v-btn
                                        :disabled="edit.id === -1"
                                        color="primary"
                                        block
                                        @click="
                                            $router.push(
                                                '/' +
                                                    lang.full_path +
                                                    '?edit=true'
                                            )
                                        "
                                    >
                                        <v-icon icon="mdi-file-edit"> </v-icon>
                                    </v-btn>
                                </v-col>
                            </v-row>
                        </v-col>

                        <v-col cols="12">
                            <v-row>
                                <v-col cols>
                                    <v-select
                                        :items="['daily', 'yearly', 'never']"
                                        v-model="edit.refresh"
                                        label="Tiempo de revision"
                                    ></v-select>
                                </v-col>
                                <v-col cols>
                                    <v-select
                                        :items="[
                                            0, 0.1, 0.2, 0.3, 0.4, 0.5, 0.6,
                                            0.7, 0.8, 0.9, 1,
                                        ]"
                                        label="Prioridad"
                                        v-model="edit.priority"
                                    ></v-select>
                                </v-col>
                                <v-col cols>
                                    <v-switch
                                        label="Indexada"
                                        v-model="edit.index"
                                    ></v-switch>
                                </v-col>
                                <v-col cols>
                                    <v-switch
                                        label="Pagina de inicio"
                                        v-model="edit.home"
                                    ></v-switch>
                                </v-col>
                            </v-row>
                        </v-col>

                        <v-col cols="12">
                            <v-row>
                                <v-col cols="4">
                                    <v-switch
                                        label="Programar publicación"
                                        v-model="edit.program_public"
                                    ></v-switch>
                                </v-col>
                                <v-col cols>
                                    <v-text-field
                                        v-if="edit.program_public"
                                        label="Fecha"
                                        v-model="edit.public_at"
                                        placeholder="dd-mm-yyyy HH:mm"
                                        :rules="[myAdmin.$state.rules.dateTime]"
                                    >
                                    </v-text-field>
                                </v-col>
                            </v-row>
                        </v-col>

                        <v-col cols="12">
                            <v-row>
                                <v-col cols="4">
                                    <v-switch
                                        label="Programar baja"
                                        v-model="edit.program_disabled"
                                    ></v-switch>
                                </v-col>
                                <v-col cols v-if="edit.program_disabled">
                                    <v-text-field
                                        label="Fecha"
                                        type="datetime"
                                        v-model="edit.disabled_at"
                                        placeholder="dd-mm-yyyy HH:mm"
                                        :rules="[myAdmin.$state.rules.dateTime]"
                                    >
                                    </v-text-field>
                                </v-col>
                            </v-row>
                        </v-col>
                    </v-row>
                </v-form>
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
            themes: [],
            editPath: [],
            pages: [],
            edit: {
                id: null,
                domain: "all",
                lang: null,
                langs: [],
                alias: "",
                refresh: "",
                priority: 1,
                index: 1,
                home: 0,
                active: 1,
            },
        };
    },
    created() {
        this.loadPages();
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
                this.loadPages();
            },
        },
    },
    computed: {},
    methods: {
        checkUrl(url) {
            console.log("checar url" + url);
        },
        autoPath() {
            let defLangs = this.myAdmin.$state.config.langs.values;

            for (let l = 0; l < defLangs.length; l++) {
                console.log(this.edit.langs[l].title);
                if (this.editPath[l].auto === true) {
                    this.edit.langs[l].path = this.edit.langs[l].title
                        .replaceAll(" ", "-")
                        .replaceAll("/", "-")
                        .toLowerCase();
                }
                let base = "/";

                if (this.edit.langs[l].theme_id !== null) {
                    for (let t = 0; t < this.themes.length; t++) {
                        if (this.themes[t].id === this.edit.langs[l].theme_id) {
                            base = this.themes[t].path;
                        }
                    }
                }

                this.edit.langs[l].full_path =
                    defLangs[l] + base + this.edit.langs[l].path;
                this.checkUrl(this.edit.langs[l].full_path);
            }
        },
        addNew() {
            let langs = [];
            let defLangs = this.myAdmin.$state.config.langs.values;
            for (let l = 0; l < defLangs.length; l++) {
                this.editPath.push({ auto: true, edit: false });
                langs.push({
                    path_id: -1,
                    theme_id: null,
                    lang: defLangs[l],
                    title: "",
                    path: "",
                    full_path: "",
                });
            }

            this.edit = {
                id: -1,
                domain: "all",
                lang: "es_mx",
                langs: langs,
                alias: "Pagina nueva",
                refresh: "yearly",
                priority: 1,
                index: 1,
                home: 0,
                program_public: 0,
                public_at: null,
                program_disabled: 0,
                disabled_at: null,
                active: 1,
            };

            this.myAdmin.$state.varModulo.path = this.edit;
            this.autoPath();
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
        loadThemes() {
            this.myAdmin.$state.headers.params = this.view;
            axios
                .get(
                    route("api_my_admin.cms.themes.index"),
                    this.myAdmin.$state.headers
                )
                .then((result) => {
                    this.themes = result.data.data;
                    this.myAdmin.$state.varModulo.themes = this.themes;
                    this.myAdmin.$state.headers.params = {};
                })
                .catch((err) => {
                    console.log("error My Admin cms themes");
                    console.log(err.message);
                });
        },
        select(item) {
            this.editPath = [];
            for (let l = 0; l < item.langs.length; l++) {
                this.editPath.push({ auto: false, edit: false });
            }
            this.edit = item;
        },
        save() {
            console.log(this.item);
            this.myAdmin.$state.loading.show = true;
            this.myAdmin.$state.loading.text = "Guardando pagina";

            axios
                .post(
                    route("api_my_admin.cms.paths.store"),
                    this.edit,
                    this.myAdmin.$state.headers
                )
                .then((response) => {
                    this.myAdmin.$state.loading.show = false;
                    this.edit = response.data;
                    this.auto = true;
                    this.loadPages();
                })
                .catch((error) => {
                    this.myAdmin.$state.loading.show = false;
                });
        },
    },
};
</script>
