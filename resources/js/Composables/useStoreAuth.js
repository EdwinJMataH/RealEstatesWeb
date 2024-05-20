import { ref } from "vue";
import { getResponse } from "@/helpers.js";
export default function useStoreAuth() {

    let severity = '';
    let detail   = '';
    let status   = '';

    const init_model = () => {
        return {
            email: null,
            password: null,
            remember: false,
            // processing: true,
        };
    };

    const is_invalid = () => {
        return {
            email: false,
            password: false,
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
        try {
            const response = await axios.post(route('login'), {...model.value});
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

    const logout = async (functionCallback = ()=>{}) => {
        try {
            const response = await axios.post(route('logout'));
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
        login,
        logout
    };
}
