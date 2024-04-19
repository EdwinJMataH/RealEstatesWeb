import { ref } from "vue";
export default function useUser() {
    const permissions = ref([
        { label: "Administrador", value: "Administrador" },
        { label: "Colaborador", value: "Colaborador" },
    ]);
    const profiles = ref([
        { label: 'Creador', value: 'Creador'},
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

    return {
        permissions, 
        profiles,
        types_permits,
        show_profiles,
        show_icon,
        model, 
        clearModel, 
        setValueModel
    };
}
