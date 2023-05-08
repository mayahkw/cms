<template>
    <v-form>
        <v-row>
            <v-col cols="12">
                <h1
                    class="text-h6 text-center grey--text text--lighten-1 font-weight-light"
                >
                    <span v-if="edit.id !== -1"> Editar {{ item.name }} </span>
                    <span v-else>Crear nuevo</span>
                </h1>
            </v-col>

            <v-col cols="12">
                <v-text-field label="Nombre" v-model="item.name"></v-text-field>
            </v-col>

            <v-col cols="3">
                <v-text-field label="Tipo" v-model="item.type"></v-text-field>
            </v-col>

            <v-col cols="3">
                <v-select
                    v-model="item.use"
                    label="Uso"
                    :items="uses"
                    item-title="text"
                    item-value="id"
                ></v-select>
            </v-col>

            <v-col cols="3">
                <v-switch label="Padre" v-model="item.options.father.value">
                </v-switch>
            </v-col>

            <v-col cols="3">
                <v-text-field
                    v-if="item.options.father.value === true"
                    type="number"
                    label="Cantidad de hijos"
                    placeholder="0 para infinito"
                    v-model="item.options.father.limit"
                >
                </v-text-field>

                <v-switch
                    v-if="item.options.father.value === false"
                    label="Content"
                    v-model="item.options.father.content"
                >
                </v-switch>
            </v-col>

            <v-col cols="12">
                <v-textarea
                    label="Descripcion"
                    v-model="item.description"
                    rows="1"
                ></v-textarea>
            </v-col>
        </v-row>

        <v-row>
            <v-col v-if="item.options.father.content">
                <v-card class="mx-auto">
                    <v-toolbar color="indigo" dark>
                        <v-toolbar-title>Contenido</v-toolbar-title>
                        <v-spacer></v-spacer>
                    </v-toolbar>

                    <v-card-text>
                        <TitleForm v-if="item.type === 'title'" :block="item" />
                        <ImgForm
                            v-else-if="item.type === 'img'"
                            :block="item"
                        />
                        <CarouselForm
                            v-else-if="item.type === 'carousel'"
                            :block="item"
                        />
                        <ContentForm
                            v-else-if="item.type === 'content'"
                            :block="item"
                        />
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>

        <v-row>
            <!-- Clases -->
            <v-col cols="12">
                <v-card class="mx-auto">
                    <v-toolbar color="indigo" dark>
                        <v-toolbar-title>Class</v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-btn
                            icon
                            @click="
                                item.options.class.push({
                                    name: 'newClass',
                                    type: null,
                                    multiple: false,
                                    values: [],
                                    default: '',
                                })
                            "
                        >
                            <v-icon>mdi-view-grid-plus</v-icon>
                        </v-btn>
                    </v-toolbar>

                    <v-container fluid>
                        <v-row
                            v-for="(clase, i) in item.options.class"
                            :key="i"
                            dense
                        >
                            <v-col cols="6">
                                <v-row dense no-gutters>
                                    <v-col cols="6">
                                        <v-text-field
                                            label="Nombre de clase"
                                            v-model="clase.name"
                                        ></v-text-field>
                                    </v-col>

                                    <v-col cols="6">
                                        <v-select
                                            :items="types"
                                            v-model="clase.type"
                                            label="Tipo"
                                            item-value="name"
                                        >
                                        </v-select>
                                    </v-col>

                                    <v-col cols="12">
                                        <v-btn
                                            color="error"
                                            block
                                            @click="
                                                item.options.class.splice(i, 1)
                                            "
                                        >
                                            Eliminar clase
                                        </v-btn>
                                    </v-col>
                                </v-row>
                            </v-col>

                            <v-col cols="6">
                                <v-row
                                    dense
                                    no-gutters
                                    v-if="clase.type === 'select'"
                                >
                                    <v-col cols="8">
                                        <v-text-field
                                            v-model="newValue"
                                            label="Agregar"
                                            :append-inner-icon="
                                                newValue !== null
                                                    ? 'mdi-send'
                                                    : ''
                                            "
                                            @click:append-inner="
                                                clase.values.push(newValue)
                                            "
                                            @keypress.enter="
                                                clase.values.push(newValue)
                                            "
                                        ></v-text-field>
                                    </v-col>

                                    <v-col
                                        cols="4"
                                        v-if="checkSelect(clase.type)"
                                    >
                                        <v-switch
                                            label="Multiple"
                                            v-model="clase.multiple"
                                        ></v-switch>
                                    </v-col>

                                    <v-col cols="12">
                                        <v-select
                                            v-if="clase.values !== null"
                                            v-model="clase.default"
                                            :items="clase.values"
                                            :label="clase.name"
                                            :multiple="clase.multiple"
                                        >
                                            <template
                                                v-slot:item="{ props, item }"
                                            >
                                                <v-list-item
                                                    v-if="
                                                        typeof item.raw !==
                                                        'object'
                                                    "
                                                    v-bind="props"
                                                    :title="item.raw"
                                                >
                                                    <template v-slot:append>
                                                        <v-btn
                                                            @click="
                                                                deleteSelect(
                                                                    item.raw,
                                                                    clase
                                                                )
                                                            "
                                                            variant="text"
                                                            icon="mdi-delete"
                                                        >
                                                        </v-btn>
                                                    </template>
                                                </v-list-item>
                                            </template>
                                        </v-select>
                                    </v-col>
                                </v-row>
                            </v-col>
                            <v-col cols="12">
                                <v-divider></v-divider>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card>
            </v-col>

            <!-- Styles -->
            <v-col cols="12">
                <v-card class="mx-auto">
                    <v-toolbar color="indigo" dark>
                        <v-toolbar-title>Styles</v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-btn
                            icon
                            @click="
                                item.options.styles.push({
                                    name: 'newStyle',
                                    type: null,
                                    multiple: false,
                                    values: [],
                                    default: '',
                                })
                            "
                        >
                            <v-icon>mdi-view-grid-plus</v-icon>
                        </v-btn>
                    </v-toolbar>

                    <v-container fluid>
                        <v-row
                            v-for="(style, i) in item.options.styles"
                            :key="i"
                            dense
                        >
                            <v-col cols="6">
                                <v-row dense no-gutters>
                                    <v-col cols="6">
                                        <v-text-field
                                            label="Nombre de style"
                                            v-model="style.name"
                                        ></v-text-field>
                                    </v-col>

                                    <v-col cols="6">
                                        <v-select
                                            :items="types"
                                            v-model="style.type"
                                            label="Tipo"
                                            item-value="name"
                                        >
                                        </v-select>
                                    </v-col>

                                    <v-col cols="12">
                                        <v-btn
                                            color="error"
                                            block
                                            @click="
                                                item.options.styles.splice(i, 1)
                                            "
                                        >
                                            Eliminar style
                                        </v-btn>
                                    </v-col>
                                </v-row>
                            </v-col>

                            <v-col cols="6">
                                <v-row
                                    dense
                                    no-gutters
                                    v-if="style.type === 'select'"
                                >
                                    <v-col cols="8">
                                        <v-text-field
                                            v-model="newValue"
                                            label="Agregar"
                                            :append-inner-icon="
                                                newValue !== null
                                                    ? 'mdi-send'
                                                    : ''
                                            "
                                            @click:append-inner="
                                                style.values.push(newValue)
                                            "
                                            @keypress.enter="
                                                style.values.push(newValue),
                                                    (newValue = null)
                                            "
                                        ></v-text-field>
                                    </v-col>

                                    <v-col
                                        cols="4"
                                        v-if="checkSelect(style.type)"
                                    >
                                        <v-switch
                                            label="Multiple"
                                            v-model="style.multiple"
                                        ></v-switch>
                                    </v-col>

                                    <v-col cols="12">
                                        <v-select
                                            v-if="style.values !== null"
                                            v-model="style.default"
                                            :items="style.values"
                                            :label="style.name"
                                            :multiple="style.multiple"
                                        >
                                            <template
                                                v-slot:item="{ props, item }"
                                            >
                                                <v-list-item
                                                    v-if="
                                                        typeof item.raw !==
                                                        'object'
                                                    "
                                                    v-bind="props"
                                                    :title="item.raw"
                                                >
                                                    <template v-slot:append>
                                                        <v-btn
                                                            @click="
                                                                deleteSelect(
                                                                    item.raw,
                                                                    style
                                                                )
                                                            "
                                                            variant="text"
                                                            icon="mdi-delete"
                                                        >
                                                        </v-btn>
                                                    </template>
                                                </v-list-item>
                                            </template>
                                        </v-select>
                                    </v-col>
                                </v-row>
                                <v-row v-if="style.type === 'text'">
                                    <v-col cols="12">
                                        <v-text-field v-model="style.default">
                                        </v-text-field>
                                    </v-col>
                                </v-row>
                                <v-row v-if="style.type === 'number'">
                                    <v-col cols="12">
                                        <v-text-field
                                            type="number"
                                            v-model="style.default"
                                        >
                                        </v-text-field>
                                    </v-col>
                                </v-row>
                                <v-row v-if="style.type === 'color-picker'">
                                    <v-col cols="12">
                                        <v-color-picker v-model="style.default">
                                        </v-color-picker>
                                    </v-col>
                                </v-row>
                            </v-col>
                            <v-col cols="12">
                                <v-divider></v-divider>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card>
            </v-col>

            <!-- Options -->
            <v-col cols="12">
                <v-card class="mx-auto">
                    <v-toolbar color="indigo" dark>
                        <v-toolbar-title>Options</v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-btn
                            icon
                            @click="
                                item.options.options.push({
                                    name: 'newOption',
                                    type: null,
                                    multiple: false,
                                    values: [],
                                    default: '',
                                })
                            "
                        >
                            <v-icon>mdi-view-grid-plus</v-icon>
                        </v-btn>
                    </v-toolbar>

                    <v-container fluid>
                        <v-row
                            v-for="(option, i) in item.options.options"
                            :key="i"
                            dense
                        >
                            <v-col cols="6">
                                <v-row dense no-gutters>
                                    <v-col cols="6">
                                        <v-text-field
                                            label="Nombre de opcion"
                                            v-model="option.name"
                                        ></v-text-field>
                                    </v-col>

                                    <v-col cols="6">
                                        <v-select
                                            :items="types"
                                            v-model="option.type"
                                            label="Tipo"
                                            item-value="name"
                                        >
                                        </v-select>
                                    </v-col>

                                    <v-col cols="12">
                                        <v-btn
                                            color="error"
                                            block
                                            @click="
                                                item.options.options.splice(
                                                    i,
                                                    1
                                                )
                                            "
                                        >
                                            Eliminar option
                                        </v-btn>
                                    </v-col>
                                </v-row>
                            </v-col>

                            <v-col cols="6">
                                <v-row
                                    dense
                                    no-gutters
                                    v-if="option.type === 'select'"
                                >
                                    <v-col cols="8">
                                        <v-text-field
                                            v-model="newValue"
                                            label="Agregar"
                                            :append-inner-icon="
                                                newValue !== null
                                                    ? 'mdi-send'
                                                    : ''
                                            "
                                            @click:append-inner="
                                                option.values.push(newValue)
                                            "
                                            @keypress.enter="
                                                option.values.push(newValue),
                                                    (newValue = null)
                                            "
                                        ></v-text-field>
                                    </v-col>

                                    <v-col
                                        cols="4"
                                        v-if="checkSelect(option.type)"
                                    >
                                        <v-switch
                                            label="Multiple"
                                            v-model="option.multiple"
                                        ></v-switch>
                                    </v-col>

                                    <v-col cols="12">
                                        <v-select
                                            v-if="option.values !== null"
                                            v-model="option.default"
                                            :items="option.values"
                                            :label="option.name"
                                            :multiple="option.multiple"
                                        >
                                            <template
                                                v-slot:item="{ props, item }"
                                            >
                                                <v-list-item
                                                    v-if="
                                                        typeof item.raw !==
                                                        'object'
                                                    "
                                                    v-bind="props"
                                                    :title="item.raw"
                                                >
                                                    <template v-slot:append>
                                                        <v-btn
                                                            @click="
                                                                deleteSelect(
                                                                    item.raw,
                                                                    option
                                                                )
                                                            "
                                                            variant="text"
                                                            icon="mdi-delete"
                                                        >
                                                        </v-btn>
                                                    </template>
                                                </v-list-item>
                                            </template>
                                        </v-select>
                                    </v-col>
                                </v-row>

                                <v-row v-if="option.type === 'text'">
                                    <v-col cols="12">
                                        <v-text-field v-model="option.default">
                                        </v-text-field>
                                    </v-col>
                                </v-row>

                                <v-row v-if="option.type === 'number'">
                                    <v-col cols="12">
                                        <v-text-field
                                            type="number"
                                            v-model="option.default"
                                        >
                                        </v-text-field>
                                    </v-col>
                                </v-row>

                                <v-row v-if="option.type === 'switch'">
                                    <v-col cols="12">
                                        <v-switch
                                            :label="option.name"
                                            v-model="option.default"
                                        >
                                        </v-switch>
                                    </v-col>
                                </v-row>

                                <v-row v-if="option.type === 'color-picker'">
                                    <v-col cols="12">
                                        <v-color-picker
                                            v-model="option.default"
                                        >
                                        </v-color-picker>
                                    </v-col>
                                </v-row>
                            </v-col>
                            <v-col cols="12">
                                <v-divider></v-divider>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card>
            </v-col>
        </v-row>
    </v-form>
</template>

<script>
import { useMyAdminStore } from "@/Pages/My/Admin/Store.js";
import { useMyCmsStore } from "@/Pages/My/Cms/Store.js";
import TitleForm from "@/Pages/My/Cms/Components/Types/Forms/Title.vue";
import ImgForm from "@/Pages/My/Cms/Components/Types/Forms/Img.vue";
import CarouselForm from "@/Pages/My/Cms/Components/Types/Forms/Carousel.vue";
import ContentForm from "@/Pages/My/Cms/Components/Types/Forms/Content.vue";

export default {
    name: "Form Themes",
    components: { TitleForm, ImgForm, CarouselForm, ContentForm },
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
            uses: [
                { id: "all", text: "Todo" },
                { id: "block", text: "Bloque" },
            ],
            types: [
                { name: "select", title: "Select", multiple: true },
                { name: "text", title: "Texto", multiple: false },
                { name: "number", title: "Numero", multiple: false },
                { name: "image", title: "Imagen", multiple: true },
                { name: "switch", title: "Switch", multiple: false },
                { name: "color-picker", title: "Color", multiple: false },
            ],
            newValue: null,
        };
    },
    created() {
        this.checkOptions();
    },
    watch: {
        "myAdmin.$state.config.langs": {
            deep: true,
            handler() {
                // this.langDefault();
            },
        },
        item() {
            this.checkOptions();
        },
    },
    computed: {},
    methods: {
        checkOptions() {
            if (typeof this.item.options.options === "undefined") {
                this.item.options.options = [];
            }
        },
        deleteSelect(s, c) {
            for (let e = 0; e < c.values.length; e++) {
                if (s === c.values[e]) {
                    c.values.splice(e, 1);
                }
            }
        },
        checkSelect(v) {
            for (let e = 0; e < this.types.length; e++) {
                if (this.types[e].name === v) {
                    return this.types[e].multiple;
                }
            }
        },
    },
};
</script>
