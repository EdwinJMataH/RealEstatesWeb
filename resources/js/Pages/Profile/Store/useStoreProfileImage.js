import { defineStore } from "pinia";
import { ref } from "vue";
import { fetchAPI } from "@/helpers.js";

export const useStoreProfileImage = defineStore('useStoreProfileImage', () => {

    // V A R I A B L E S
    const init_model = () => {
        return {
            image: "placeholder.jpg",
            image_send: "",
        };
    };

    let model   = ref(init_model());

    const clearModel = () => {
        model.value = init_model();
    };

    const setValueModel = (value) => {
        model.value = { ...value };
    };

    // F U N C T I O N S
    const update = async (functionCallback = ()=>{}) => {

        let file = new FormData();
        file.append('image',model.value.image_send)

        await fetchAPI({ method: 'post', to: 'profile.image', send: file }, (response) => {
            functionCallback(response);
        })
    }




    return {
        model,
        clearModel,
        setValueModel,
        update
    };
});
