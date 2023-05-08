<template>
    <v-row>
        <v-col cols="6">
            <v-switch
                :label="block.value.editable ? 'Dinamico' : 'Estatico'"
                v-model="block.value.editable"
            ></v-switch>
        </v-col>

        <v-col cols="6">
            <v-btn
                block
                color="success"
                @click="
                    block.value.value.push({
                        img: [],
                        title: '',
                        description: '',
                    }),
                        filesUpload.push({ files: [] })
                "
            >
                Add Img
            </v-btn>
        </v-col>
    </v-row>

    <v-row v-for="(src, i) in filesUpload" :key="i">
        <v-col cols="8">
            <v-file-input
                chips
                counter
                v-model="src.files"
                show-size
                small-chips
                prepend-icon="mdi-camera"
                label="Imagen"
                truncate-length="26"
                accept="image/*"
                @update:modelValue="uploadFile(i)"
            ></v-file-input>
            <v-btn variant="flat" color="danger" block @click="deleteImage(i)">
                Quitar imagen
            </v-btn>
        </v-col>

        <v-col
            v-if="block.value.value[i] && block.value.value[i].img.length > 0"
            cols="4"
        >
            <v-img
                v-for="img in block.value.value[i].img"
                :key="img.id"
                :src="'/' + img.dir + '/' + img.name"
            ></v-img>
        </v-col>

        <v-col cols="12" v-if="block.value.value[i]">
            <v-text-field
                label="Titulo"
                v-model="block.value.value[i].title"
            ></v-text-field>
        </v-col>

        <v-col cols="12" v-if="block.value.value[i]">
            <v-textarea
                label="Descripcion"
                v-model="block.value.value[i].description"
            ></v-textarea>
        </v-col>
        <v-col cols="12">
            <v-divider />
        </v-col>
    </v-row>

    <v-row> </v-row>
</template>

<script>
import { useMyAdminStore } from "@/Pages/My/Admin/Store.js";
import { useMyCmsStore } from "@/Pages/My/Cms/Store.js";

export default {
    name: "Carousel",
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
                return { id: -1, value: [] };
            },
        },
    },
    data() {
        return {
            currentImage: undefined,
            previewImage: undefined,
            progress: 0,
            message: "",
            imageInfos: [],
            filesUpload: [],
        };
    },
    created() {
        console.log("this.block.value.value");
        console.log(this.block.value.value);
        for (let e = 0; e < this.block.value.value.length; e++) {
            this.filesUpload.push({ files: [] });
        }
        if (this.block.value === null) {
            this.block.value = { value: [], editable: null };
        }
    },
    watch: {
        "block.value": {
            deep: true,
            handler() {
                console.log("this.block.value.value");
                console.log(this.block.value.value);
                for (let e = 0; e < this.block.value.value.length; e++) {
                    //  this.filesUpload.push({ files: [] });
                    //       this.filesUpload.push({ files: "" });
                }
            },
        },
    },
    computed: {},
    methods: {
        deleteImage(i) {
            this.filesUpload.splice(i, 1);
            this.block.value.value.splice(i, 1);
        },

        async uploadFile(id) {
            //alert(id);
            console.log(this.filesUpload[id].files);

            let files = this.filesUpload[id].files;

            for (let i = 0; i < files.length; i++) {
                this.myAdmin.$state.loading.show = true;
                this.myAdmin.$state.loading.text =
                    "Guardando " + files.length + "  imagen(es)";

                let data = {
                    id: -1,
                    block: this.block.id,
                    file: files[i],
                };

                console.log(data);

                const onUploadProgress = (event) => {
                    const percentage = Math.round(
                        (100 * event.loaded) / event.total
                    );
                    console.log(percentage);
                };

                const response = await axios
                    .post(
                        route("api_my_admin.cms.files.store"),
                        data,
                        this.myAdmin.$state.headersFile
                    )
                    .then((response) => {
                        this.myAdmin.$state.loading.show = false;
                        this.block.value.value[id].img.push(response.data);
                    })
                    .catch((error) => {
                        console.log("error upload file");
                        console.log(error);
                    });
            }

            //this.block.value.value = resultUpload;
        },
    },
};
</script>
