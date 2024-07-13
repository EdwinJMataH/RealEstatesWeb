import { defineStore } from "pinia";
import { ref } from "vue";
import { fetchAPI } from "@/helpers.js";

export const useStoreProfile = defineStore('useStoreProfile', () => {


    const init_model = () => {
        return {
            email: null,
            name: null,
            current_password: null,
            password: null,
            password_confirmation: null,
        };
    };

    const init_model_password = () => {
        return {
            current_password: null,
            password: null,
            password_confirmation: null,
        };
    };

    const is_invalid = () => {
        return {
            email: false,
            name: false,
            current_password: false,
            password: false,
            password_confirmation: false,
        };
    };

    let modelPassword   = ref(init_model_password());
    let model   = ref(init_model());
    let invalid = ref(is_invalid());

    const clearModelPassword = () => {
        modelPassword.value = init_model_password();
    };

    const setValueModelPassword = (value) => {
        modelPassword.value = { ...value };
    };

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

    const password = async (functionCallback = ()=>{}) => {

        await fetchAPI({ method: 'post', to: 'profile.password', send: {...modelPassword.value } }, (response) => {
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
        modelPassword,
        clearModelPassword,
        setValueModelPassword,
        password
    };
});
