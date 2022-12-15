import { defineStore } from "pinia";

export const useMyCmsStore = defineStore("MyCms", {
    state: () => ({
        path: {},
        editBlock: { id: -1 },
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
