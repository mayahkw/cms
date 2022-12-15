<template>
    <div
        :class="
            (myCms.$state.editBlock.id === block.id
                ? 'consturct_select '
                : '') +
            (showPreview === true ? 'border consturct' : '') +
            checkClass(block.options.class)
        "
        :style="checkStyle(block.options.styles)"
    >
        <div v-if="showPreview" class="text-center h5 pt-3 pb-3">
            <small> {{ block.id }} {{ block.block.name }} </small><br />
            <v-btn
                v-if="block.options.father.value === true"
                size="x-small"
                @click="selectBlock(block)"
                color="success"
            >
                Select
            </v-btn>

            <v-btn
                size="x-small"
                class="ml-1"
                color="grey"
                @click="dialog = true"
            >
                Edit
                <v-dialog v-model="dialog" max-width="700">
                    <v-card>
                        <v-toolbar color="indigo" dark>
                            <v-toolbar-title>Editar</v-toolbar-title>
                            <v-spacer></v-spacer>
                        </v-toolbar>
                        <v-card-text>
                            <v-tabs
                                v-if="block.block.options.father.content"
                                v-model="tab"
                            >
                                <v-tab value="options">Options</v-tab>
                                <v-tab value="content">Content</v-tab>
                            </v-tabs>
                            <v-card
                                v-if="
                                    tab === 'options' &&
                                    block.options.class.length > 0
                                "
                            >
                                <v-card-title primary-title>
                                    Clases
                                </v-card-title>

                                <v-card-text>
                                    <v-row dense>
                                        <v-col
                                            cols="12"
                                            v-for="(clase, i) in block.options
                                                .class"
                                            :key="i"
                                        >
                                            <v-text-field
                                                v-if="clase.type === 'text'"
                                                v-model="clase.default"
                                                :label="clase.name"
                                            ></v-text-field>

                                            <v-select
                                                v-if="clase.type === 'select'"
                                                :items="clase.values"
                                                v-model="clase.default"
                                                :label="clase.name"
                                            ></v-select>
                                        </v-col>
                                    </v-row>
                                </v-card-text>
                            </v-card>
                            <v-card
                                v-if="
                                    tab === 'options' &&
                                    block.options.styles.length > 0
                                "
                            >
                                <v-card-title primary-title>
                                    Styles
                                </v-card-title>
                                <v-card-text>
                                    <v-row dense>
                                        <v-col
                                            cols="12"
                                            v-for="(style, i) in block.options
                                                .styles"
                                            :key="i"
                                        >
                                            <v-text-field
                                                v-if="style.type === 'text'"
                                                v-model="style.default"
                                                :label="style.name"
                                            ></v-text-field>

                                            <v-select
                                                v-if="style.type === 'select'"
                                                :items="style.values"
                                                v-model="style.default"
                                                :label="style.name"
                                            ></v-select>
                                        </v-col>
                                    </v-row>
                                </v-card-text>
                            </v-card>
                            <v-card v-if="tab === 'content'">
                                <v-card-title primary-title>
                                    Content
                                </v-card-title>
                                <v-card-text>
                                    <TitleForm
                                        v-if="block.block.type === 'title'"
                                        :block="block"
                                    ></TitleForm>

                                    <ImgForm
                                        v-if="block.block.type === 'img'"
                                        :block="block"
                                    ></ImgForm>

                                    <CarouselForm
                                        v-if="block.block.type === 'carousel'"
                                        :block="block"
                                    ></CarouselForm>
                                </v-card-text>
                            </v-card>
                        </v-card-text>
                        <v-card-actions>
                            <v-btn
                                color="primary"
                                block
                                @click="(dialog = false), update()"
                            >
                                Cerrar y guardar
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </v-btn>
            <br />
        </div>

        <Title
            v-if="block.block.type === 'title'"
            :block="block"
        ></Title>

        <Img
            v-if="block.block.type === 'img'"
            :block="block"
        ></Img>

        <Carousel
            v-if="block.block.type === 'carousel'"
            :block="block"
        ></Carousel>

        <!--
				-->
				<Constructor
            v-for="(child, e) in block.blocks"
            :key="e"
            draggable="true"
            @dragover.prevent
            @dragstart="blockDragDrop({ tipo: 'drag', id: child})"
            @drop.prevent="blockDragDrop({ tipo: 'drop', id: child})"
            @update="editBlock"
						@block:drag="blockDragDrop"
            @block:drop="blockDragDrop"
            :nivel="nivel + 1"
            :showPreview="showPreview"
            :block="child"
        ></Constructor>
				</div>
</template>

<script>
import { useMyAdminStore } from "@/Pages/My/Admin/Store.js";
import { useMyCmsStore } from "@/Pages/My/Cms/Store.js";
import Title from "@/Pages/My/Cms/Components/Types/Preview/Title.vue";
import TitleForm from "@/Pages/My/Cms/Components/Types/Forms/Title.vue";
import Img from "@/Pages/My/Cms/Components/Types/Preview/Img.vue";
import ImgForm from "@/Pages/My/Cms/Components/Types/Forms/Img.vue";
import Carousel from "@/Pages/My/Cms/Components/Types/Preview/Carousel.vue";
import CarouselForm from "@/Pages/My/Cms/Components/Types/Forms/Carousel.vue";

export default {
    name: "ConstructorNode",
    components: { Title, TitleForm, Img, ImgForm, Carousel, CarouselForm },
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
        nivel: {
            type: Number,
            default() {
                return 0;
            },
        },
        showPreview: {
            type: Boolean,
            default() {
                return false;
            },
        },
    },
    data() {
        return { dialog: false, tab: "options" };
    },
    created() {
        //console.log(this.block.block.options);
        if (this.block.options) {
					if (this.block.options.class) {
							for (let e = 0; e < this.block.block.options.class.length; e++) {
									let exist = 0;
									for (let i = 0; i < this.block.options.class.length; i++) {
											this.block.block.options.class[e].name ===
											this.block.options.class[i].name
													? exist++
													: "";
									}
									if (exist === 0) {
											this.block.options.class.push(
													this.block.block.options.class[e]
											);
									}
							}
					}
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
    methods: {
        blockDragDrop(t) {
            if (t.tipo === "drag") {
                this.$emit("block:drag", { tipo: "drag", id: t.id });
            }
            if (t.tipo === "drop") {
                this.$emit("block:drop", { tipo: "drop", id: t.id });
            }
        },
        update() {
            this.myAdmin.$state.loading.show = true;
            this.myAdmin.$state.loading.text = "Contruyendo theme";

            axios
                .post(
                    route("api_my_admin.cms.themes.blocks.store"),
                    this.block,
                    this.myAdmin.$state.headers
                )
                .then((response) => {
                    this.myAdmin.$state.loading.show = false;
                    this.$emit("update", this.block);
                })
                .catch((error) => {
                    this.myAdmin.$state.loading.show = false;
                });
        },
        selectBlock(v) {
            //console.log(v.id);
            this.myCms.$state.editBlock = v;
        },
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

<style scoped>
.consturct:hover {
    background: rgb(132 130 130 / 30%);
}
.consturct {
    background: #FFFFFF;
		color: black;
}
.consturct_select {
    background: #233e41bf !important;
    color: rgb(255 255 255);
}
</style>
