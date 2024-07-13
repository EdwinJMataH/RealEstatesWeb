import { defineStore } from "pinia";
import { ref } from "vue";
import { fetchAPI } from "@/helpers.js";

export const useStoreProfileInformation = defineStore('useStoreProfileInformation', () => {

    const init_model = () => {
        return {
            email: null,
            name: null
        };
    };

    const is_invalid = () => {
        return {
            email: false,
            name: false
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

    const update = async (functionCallback = ()=>{}) => {

        await fetchAPI({ method: 'post', to: 'profile.information', send: {...model.value } }, (response) => {
            functionCallback(response);
        })
    }


    return {
        invalid,
        clearInvalid,
        setValueInvalid,
        model,
        clearModel,
        setValueModel,
        update
    };
});
