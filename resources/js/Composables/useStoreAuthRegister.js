import { ref } from "vue";
import { getResponse } from "@/helpers.js";
export default function useStoreAuthRegister() {

    let severity = '';
    let detail   = '';
    let status   = '';

    const init_model = () => {
        return {
            email: null,
            password: null,
            password_confirmation: null,
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

    const register = async (functionCallback = ()=>{}) => {
        try {
            const response = await axios.post(route('register'), {...model.value});
            ({ severity, detail, status } = getResponse(response.data));

        } catch (error) {
            ({ severity, detail, status } = getResponse(error.response.data));

        } finally {
            functionCallback({
                severity: severity,
                detail: detail,
                status: status
            });
        }
    }



    return {
        invalid,
        clearInvalid,
        setValueInvalid,
        model,
        clearModel,
        setValueModel,
        register
    };
}
