import { defineStore } from "pinia";
import { ref } from "vue";
import { fetchAPI } from "@/helpers.js";
import { useStoreProfileInformation } from "@/Pages/Profile/Store/useStoreProfileInformation.js";
import { useStoreProfileImage } from "@/Pages/Profile/Store/useStoreProfileImage.js";
const storeProfileInformation = useStoreProfileInformation();
const storeProfileImage       = useStoreProfileImage();

export const useStoreProfile = defineStore('useStoreProfile', () => {

    // V A R I A B L E S
    const init_model = () => {
        return {
            profile: "",
            email: "",
            name: "",
            image: "",
        };
    };

    let model = ref(init_model());

    const clearModel = () => {
        model.value = init_model();
    };

    const setValueModel = (value) => {
        model.value = { ...value };
    };

    // F U N C T I O N S
    const show = async (functionCallback = ()=>{}) => {

        await fetchAPI({ method: 'get', to: 'profile.show' }, (response) => {
            clearModel();
            storeProfileInformation.clearModel();
            storeProfileImage.clearModel();

            const { status, data } = response;

            if (status) {

                setValueModel(data);
                storeProfileInformation.setValueModel({ email: data.email, name: data.name });
                storeProfileImage.setValueModel({ image: data.image });
            }
        })
    }

    return {
        model,
        clearModel,
        show
    };
});
