import { defineStore } from "pinia";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

export const useMyCmsStore = defineStore("MyCms", {
    state: () => ({
        path: {},
        editBlock: { id: -1 },
        editor: ClassicEditor,
        editorConfig: {
            //plugins: [HorizontalLine],
        },
    }),
    getters: {
        isFontLarge: (state) => state.fontSize > 30,
    },
    actions: {
        increaseFontSize(amount) {
            this.fontSize += amount;
        },
        decreaseFontSize(amount) {
            this.fontSize -= amount;
        },
        resetFontSize() {
            this.fontSize = 16;
        },
    },
});
