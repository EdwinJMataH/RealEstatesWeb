import { defineStore } from "pinia";
import { ref } from "vue";
import { fetchAPI } from "@/helpers.js";

export const useStoreProfile = defineStore('useStoreProfile', () => {


    const init_model = () => {
        return {
            email: null,
            name: null,
            current_password: null,
            new_password: null,
            repeat_password: null,
        };
    };

    const is_invalid = () => {
        return {
            email: false,
            name: false,
            current_password: false,
            new_password: false,
            repeat_password: false,
        };
    };

    let model   = ref(init_model());
    let invalid = ref(is_invalid());

    const clearModel = () => {
        model.value = init_model();
    };

    const setValueModel = (value) => {
        model.value = { ...value };
    };

    const clearInvalid = () => {
        invalid.value = is_invalid();
    };

    const setValueInvalid = (value) => {
        invalid.value = { ...value };
    };


    return {
        invalid,
        clearInvalid,
        setValueInvalid,
        model,
        clearModel,
        setValueModel,
    };
});
