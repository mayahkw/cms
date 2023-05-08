<template>
    <div
        :id="'carousel' + block.id"
        class="carousel slide"
        data-bs-ride="carousel"
        :class="checkClass(block.options.class)"
        :style="checkStyle(block.options.styles)"
    >
        <div
            v-if="block.options.options[2].default === true"
            class="carousel-indicators"
        >
            <button
                v-for="(src, i) in block.value.value"
                :key="i"
                type="button"
                :data-bs-target="'#carousel' + block.id"
                :data-bs-slide-to="i"
                :class="i === 0 ? 'active' : ''"
                :aria-current="i === 0 ? true : ''"
                :aria-label="'Slide ' + i"
            ></button>
        </div>

        <div class="carousel-inner">
            <div
                v-for="(src, i) in block.value.value"
                :key="i"
                :class="'carousel-item ' + (i == 0 ? 'active' : '')"
            >
                <img
                    v-if="src.img.length > 0"
                    :src="'/' + src.img[0].dir + '/' + src.img[0].name"
                    class="d-block w-100"
                    :alt="src.description"
                />
                <div
                    v-if="
                        block.options.options[0].default === true ||
                        block.options.options[1].default === true
                    "
                    class="carousel-caption d-none d-md-block"
                >
                    <h5 v-if="block.options.options[0].default === true">
                        {{ src.title }}
                    </h5>
                    <p v-if="block.options.options[1].default === true">
                        {{ src.description }}
                    </p>
                </div>
            </div>
        </div>

        <button
            class="carousel-control-prev"
            type="button"
            :data-bs-target="'#carousel' + block.id"
            data-bs-slide="prev"
        >
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>

        <button
            class="carousel-control-next"
            type="button"
            :data-bs-target="'#carousel' + block.id"
            data-bs-slide="next"
        >
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
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
                return { id: -1 };
            },
        },
    },
    data() {
        return {};
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
