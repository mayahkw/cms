<template>
    <v-card>
        <v-toolbar color="black" theme="dark">
            <v-card-title color="indigo darken-2">
                Construir {{ theme.name }}
            </v-card-title>
        </v-toolbar>

        <v-row class="pa-4" justify="space-between">
            <v-col cols="3">
                <v-row>
                    <v-col cols="12">
                        <v-switch
                            label="Preview"
                            v-model="showPreview"
                        ></v-switch>
                    </v-col>

                    <v-col v-if="edit.id !== null" cols="12">
                        {{ edit.block.name }}
                    </v-col>

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
                                    <th class="text-left">Add</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="block in blocks.data"
                                    :key="block.id"
                                    @click="editBlock(block, 'new')"
                                >
                                    <td>{{ block.name }}</td>
                                    <td>{{ block.lang }}</td>
                                </tr>
                            </tbody>
                        </v-table>

                        <v-pagination
                            v-if="blocks.last_page > 1"
                            v-model="view.page"
                            :length="blocks.last_page"
                            prev-icon="mdi-menu-left"
                            next-icon="mdi-menu-right"
                        ></v-pagination>
                    </v-col>
                </v-row>
            </v-col>

            <v-divider vertical></v-divider>

            <v-col class="d-flex">
                <v-row v-if="theme.blocks">
                    <v-col cols="12" v-if="theme.blocks.length > 0">
                        <Constructor 
                            v-for="(child, i) in theme.blocks" :key="i" 
                            @update="editBlock" 
                            draggable="true"
                            @dragover.prevent
                            @block:drag="blockDragDrop"
                            @block:drop="blockDragDrop"
                            @dragstart="blockDragDrop({ tipo: 'drag', id: child})"
                            @drop.prevent="blockDragDrop({ tipo: 'drop', id: child})"
                            :nivel="1" 
                            :showPreview="showPreview"
                            :block="child" 
                            v-bind:Constructor="Constructor"
                            >                          
                        </Constructor>
                        <!-- ->        
                            
                   <!- -->
                    </v-col>
                    <v-col v-else>
                        No se tiene ningun bloque agregado al theme
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
    </v-card>
</template>

<script>
import { useMyAdminStore } from "@/Pages/My/Admin/Store.js";
import { useMyCmsStore } from "@/Pages/My/Cms/Store.js";
import Constructor from "@/Pages/My/Cms/Components/Constructor.vue";

export default {
    name: "Index Themes",
    components: { Constructor },
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
            theme: { id: -1, name: "" },
            showPreview: true,
            order: {
                prevent: 0,
                count: 0,
                drag: [],
                drop: [],
            },
        };
    },
    created() {
        this.loadBlocks();
        this.loadTheme();
    },
    watch: {
        "myCms.$state.editBlock.id"() {
            this.edit = this.myCms.$state.editBlock;
            //   this.loadEdit();
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
        checkOrdern(){

        },
        async blockDragDrop(t) {
            let newOrder = {
                action: null,
                id: null,
                parent_id: null,
                order: null
            }

            if (t.tipo === "drag") {
                this.order.drag.push(t.id);
                console.log(this.order);
            }
            if (t.tipo === "drop") {
                this.myAdmin.$state.loading.show = true;
                this.myAdmin.$state.loading.text = "Organizando blocks";
                // console.log(t.id);
                this.order.drop.push(t.id);
                this.order.count++;
                await setTimeout(() => {
                    this.myAdmin.$state.loading.show = false;
                    this.order.prevent++;
                    console.log("count " + this.order.prevent);
                    console.log("counto " + this.order.count);
                    if (this.order.prevent === this.order.count) {
                        console.log("drop out");
                        
                        console.log('El ' +this.order.drag[0].id);
                        newOrder.id = this.order.drag[0].id;
                        // console.log(this.order.drop[0].options.father.value);
                        if(this.order.drop[0].options.father.value === false){
                            console.log('Se queda en '+this.order.drop[0].parent.id);
                            newOrder.parent_id = this.order.drop[0].parent.id
                            console.log(' Despues de '+this.order.drop[0].id);
                            newOrder.order = this.order.drop[0].order+1

                        }else{
                            console.log('Se queda en '+this.order.drop[0].id);
                            newOrder.parent_id = this.order.drop[0].id
                        }
                        // Ejecutar el grabado de la nueva disposicion de blocks y recargar
                        console.log(this.edit);
                        this.myAdmin.$state.loading.show = true;
                        this.myAdmin.$state.loading.text = "Actualizando block's";
                        
                        newOrder.action = 'order';
                        axios
                            .post(
                                route("api_my_admin.cms.themes.blocks.store"),
                                newOrder,
                                this.myAdmin.$state.headers
                            )
                            .then((response) => {
                                this.myAdmin.$state.loading.show = false;
                                this.loadTheme();
                            })
                            .catch((error) => {
                                this.myAdmin.$state.loading.show = false;
                            });
                        
                        //  Restablecer contador
                        this.order = {
                            prevent: 0,
                            count: 0,
                            drag: [],
                            drop: [],
                        };
                    }
                }, 500);
            }
        },
        addNew() {
            console.log("test");
        },
        /*
        checkBlock(id) {
            axios
                .get(
                    route("api_my_admin.cms.themes.blocks.show", {
                        block: id,
                    }),
                    this.myAdmin.$state.headers
                )
                .then((result) => {
                    this.myAdmin.$state.headers.params = {};
                    console.log(result.data);
                    return result.data;
                })
                .catch((err) => {
                    console.log("error My Admin cms themes");
                    console.log(err.message);
                });
        },*/
        editBlock(b, action = "edit") {
            console.log(b);
            let block = {};
            if (action === "new") {
                block = {
                    id: -1,
                    theme_id: this.theme.id,
                    block_id: b.id,
                    parent_id: this.edit.id,
                    options: b.options,
                    operators: b.operators,
                    value: b.value,
                };
            } else {
                block = b;
            }
            this.myAdmin.$state.loading.show = true;
            this.myAdmin.$state.loading.text = "Contruyendo theme";

            axios
                .post(
                    route("api_my_admin.cms.themes.blocks.store"),
                    block,
                    this.myAdmin.$state.headers
                )
                .then((response) => {
                    this.myAdmin.$state.loading.show = false;
                    this.loadTheme();
                })
                .catch((error) => {
                    this.myAdmin.$state.loading.show = false;
                });
        },
        loadBlocks() {
            // this.myAdmin.$state.headers.params = {theme: this.$route.params.theme,};
            this.myAdmin.$state.headers.params = this.view;

            axios
                .get(
                    route("api_my_admin.cms.blocks.index"),
                    this.myAdmin.$state.headers
                )
                .then((result) => {
                    this.blocks = result.data;
                    this.myAdmin.$state.headers.params = {};
                    this.myAdmin.$state.varModulo.blocks = result.data;
                })
                .catch((err) => {
                    console.log("error My Admin cms themes");
                    console.log(err.message);
                });
        },
        loadTheme() {
            // this.myAdmin.$state.headers.params = {theme: this.$route.params.theme,};
            axios
                .get(
                    route("api_my_admin.cms.themes.show", {
                        theme: this.$route.params.theme,
                    }),
                    this.myAdmin.$state.headers
                )
                .then((result) => {
                    this.theme = result.data;
                    this.myAdmin.$state.headers.params = {};
                    this.myAdmin.$state.varModulo.theme = result.data;
                })
                .catch((err) => {
                    console.log("error My Admin cms themes");
                    console.log(err.message);
                });
        },
    },
};
</script>
