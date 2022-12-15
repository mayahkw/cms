<template>
    <div
        id="carouselExampleControls"
        class="carousel slide"
        data-bs-ride="carousel"
    >
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img
                    src="https://picsum.photos/500/300"
                    class="d-block w-100"
                    alt="..."
                />
            </div>
            <div class="carousel-item">
                <img
                    src="https://picsum.photos/500/300"
                    class="d-block w-100"
                    alt="..."
                />
            </div>
            <div class="carousel-item">
                <img
                    src="https://picsum.photos/500/300"
                    class="d-block w-100"
                    alt="..."
                />
            </div>
        </div>
        <button
            class="carousel-control-prev"
            type="button"
            data-bs-target="#carouselExampleControls"
            data-bs-slide="prev"
        >
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button
            class="carousel-control-next"
            type="button"
            data-bs-target="#carouselExampleControls"
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
