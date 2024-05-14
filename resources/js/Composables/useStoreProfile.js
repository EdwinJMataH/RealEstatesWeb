import { ref } from "vue";
import { getResponse } from "@/helpers.js";

export default function useStoreProfile() {
    const permissions = ref([
        { label: "Administrador", value: "Administrator" },
        { label: "Colaborador", value: "Collaborator" },
    ]);
    const profiles = ref([
        { label: 'Creador', value: 'Creator'},
        { label: 'Editor', value: 'Editor'},
    ]);
    const types_permits = ref({
        Creador: {
            'Permitido': [
                'Agregar nueva información'
            ],
            'Restringido': [
                'Modificar información existente',
                'Eliminar información existente',
                'Agregar usuarios'
            ]
        },
        Editor: {
            'Permitido': [
                'Agregar nueva información',
                'Modificar información existente',
            ],
            'Restringido': [
                'Eliminar información existente',
                'Agregar usuarios'
            ]
        }
    });
    const show_profiles = ref(false);
    const show_icon = ref(false);
    const disabled = ref(false);
    let users = ref([]);


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

    const all = async (functionCallback = ()=>{}) => {
        let severity = '';
        let detail   = '';
        let status   = '';
        let data     = [];
        try {
            const response = await axios.get(route('profile.all'));
            ({ severity, detail, status, data } = getResponse(response.data));

            if (data) {

                users.value = data.map(element => {
                    const { email, id, name, permission, profile} = element;
                    return {
                        email,
                        id,
                        name,
                        permission,
                        profile,
                        action: [0, 1]
                    }
                });
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

    const store = async (functionCallback = ()=>{}) => {
        let severity = '';
        let detail   = '';
        let status   = '';
        try {
            const response = await axios.post(route('users.store'), {...model.value});
            ({ severity, detail, status } = getResponse(response.data));

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
        permissions, 
        profiles,
        types_permits,
        show_profiles,
        show_icon,
        disabled,
        model, 
        clearModel, 
        setValueModel,
        all,
        users,
        store
    };
}
