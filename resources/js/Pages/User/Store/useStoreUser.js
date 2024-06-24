import { ref } from "vue";
import { getResponse, fetchAPI } from "@/helpers.js";
import { defineStore } from 'pinia'

export const useStoreUser = defineStore('useStoreUser', () => {

    let users = ref([]);
    const show_profiles = ref(false);
    const show_icon = ref(false);
    const disabled = ref(false);
    const columns = ref([
        {
            field: "email",
            header: "Correo electrónico",
        },
        {
            field: "name",
            header: "Nombre",
        },
        {
            field: "profile",
            header: "Tipo de perfil",
        },
        {
            field: "type",
            header: "Tipo de permiso",
        },
        // {
        //     field: "status",
        //     header: "Estatus",
        // },
    ]);

    const init_model = () => {
        return {
            email: "",
            profile: "",
            type: "",
        };
    };

    const is_invalid = () => {
        return {
            email: false,
            profile: false,
            type: false,
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

    const all = async (functionCallback = ()=>{}) => {

        await fetchAPI({ method: 'get', to: 'users.all' }, (response) => {
            const { data } = response;
            users.value = [];
            if (data) {
                users.value = data.map(element => {
                    return { ...element, action: [0, 1] }
                });
            }
        })
    }

    const store = async (functionCallback = ()=>{}) => {

        let parameter = {};
        let to = 'users.store';
        if (model.value.hasOwnProperty('uuid')) {
            parameter.uuid = model.value.uuid;
            to = 'users.update';
        }
        await fetchAPI({ method: 'post', to: to, send: {...model.value }, parameter }, (response) => {
            functionCallback(response);
        })
    }

    const destroy = async (functionCallback = ()=>{}) => {
        
        await fetchAPI({ method: 'post', to: 'users.destroy', parameter: { uuid: model.value.uuid } }, (response) => {
            functionCallback(response);
        })
    }


    return {
        invalid,
        clearInvalid,
        setValueInvalid,
        show_profiles,
        show_icon,
        disabled,
        model,
        clearModel,
        setValueModel,
        all,
        columns,
        users,
        store,
        destroy
    };
})
