<template>
    <v-row>
        <v-col cols="12">
            <v-switch
                :label="block.value.editable ? 'Dinamico' : 'Estatico'"
                v-model="block.value.editable"
            ></v-switch>
        </v-col>
        <v-col :cols="block.value.value === null ? 12 : 8">
            <v-file-input
                chips
                counter
                show-size
                small-chips
                prepend-icon="mdi-camera"
                label="Imagen"
                truncate-length="26"
                accept="image/*"
                @update:modelValue="uploadFile"
            ></v-file-input
        ></v-col>
        <v-col v-if="block.value.value !== null" cols="4">
            <v-img
                v-for="img in block.value.value"
                :key="img.id"
                :src="'/' + img.dir + '/' + img.name"
            ></v-img>
        </v-col>
    </v-row>
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
                return { id: -1, value: null };
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
        };
    },
    created() {
        if (this.block.value === null) {
            this.block.value = { value: null, editable: null };
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
        async uploadFile(files) {
            let resultUpload = [];
            for (let i = 0; i < files.length; i++) {
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
                        resultUpload.push(response.data);
                    })
                    .catch((error) => {
                        console.log("error upload file");
                        console.log(error);
                    });
            }

            this.block.value.value = resultUpload;
        },
    },
};
</script>
