import { defineStore } from "pinia";
import { ref } from "vue";
import { fetchAPI } from "@/helpers.js";

export const useStoreAuth = defineStore('useStoreAuth', ()=> {

    const init_model = () => {
        return {
            email: null,
            password: null,
            password_confirmation: null,
            remember: false,
        };
    };

    const is_invalid = () => {
        return {
            email: false,
            password: false,
            password_confirmation: false,
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

    const login = async (functionCallback = ()=>{}) => {

        delete model.value.password_confirmation;
        await fetchAPI({ method: 'post', to: 'login', send: {...model.value } }, (response) => {
            functionCallback(response);
        })
    }

    const logout = async (functionCallback = ()=>{}) => {

        await fetchAPI({ method: 'post', to: 'logout' }, (response) => {
            functionCallback(response);
        })
    }

    const store = async (functionCallback = ()=>{}) => {

        delete model.value.remember;
        await fetchAPI({ method: 'post', to: 'register', send: {...model.value } }, (response) => {
            functionCallback(response);
        })
    }

    const forgotPassword = async (functionCallback = ()=>{}) => {

        delete model.value.remember;
        delete model.value.password;
        delete model.value.password_confirmation;
        await fetchAPI({ method: 'post', to: 'password.email', send: {...model.value } }, (response) => {
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
        login,
        logout,
        store,
        forgotPassword
    };
});
