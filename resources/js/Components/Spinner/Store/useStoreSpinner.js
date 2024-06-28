import { ref } from "vue";
import { defineStore } from 'pinia'

export const useStoreSpinner = defineStore('useStoreSpinner', () => {

    const visible = ref(true);

    const show = () => {
        visible.value = true;
    }

    const hidden = () => {
        visible.value = false;
    }


    return {
        visible,
        show,
        hidden
    };
})
