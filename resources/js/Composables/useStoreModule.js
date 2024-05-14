import { ref } from "vue";
import { getResponse } from "@/helpers.js";
import { getModulesMenu } from "@/helpers.js";
export default function useStoreModule() {
    
    let modules = ref([]);
    let itemsMenu = ref([]);
    const init_model = () => {
        return {
            email: "",
            profile: "",
            permission: "",
        };
    };

    let model = ref(init_model());

    const clearModel = () => {
        model.value = init_model();
    };

    const setValueModel = (value) => {
        model.value = { ...value };
    };

    const index = async (functionCallback = ()=>{}) => {
        let severity = '';
        let detail   = '';
        let status   = '';
        let data     = [];
        try {
            const response = await axios.get(route('module.index'));
            ({ severity, detail, status, data } = getResponse(response.data));

            if (data) {
                console.log("data: " + data);


                data.map(element => {

                    let moduleMenu = getModulesMenu(element.module_id);
                    if (moduleMenu) itemsMenu.value.push(moduleMenu);
                });

                itemsMenu.value.sort((a, b) => a.orderBy - b.orderBy);

            }


        } catch (error) {
            ({ severity, detail, status } = getResponse({ status: false }));

        } finally {
            functionCallback({
                severity: severity,
                detail: detail,
                status: status
            });
        }
    }


    return {
        model, 
        clearModel, 
        setValueModel,
        index,
        modules,
        itemsMenu
    };
}
