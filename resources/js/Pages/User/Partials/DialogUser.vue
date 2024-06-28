<script setup>
import { ref, watch, defineProps, defineEmits } from "vue";
import { router } from "@inertiajs/vue3";
import DialogModal from "@/Components/DialogModal.vue";
import Alert from "@/Components/Alert.vue";
import Input from "@/Components/Input.vue";
import Dropdown from "@/Components/Dropdown.vue";
import { useStoreUser } from "../Store/useStoreUser.js";
import { modalDimensions, validateEmail, validateFormIsEmpty } from "@/helpers.js";
const storeUser = useStoreUser();
const { show_profiles, show_icon, disabled, model, invalid } = storeToRefs(storeUser);
const visible = ref(false);
const alerts  = ref([]);

const profiles = ref([
    { label: "Administrador", value: "Administrator" },
    { label: "Colaborador", value: "Collaborator" },
]);

const permissions = ref([
    { label: 'Creador', value: 'Creator'},
    { label: 'Editor', value: 'Editor'},
]);

const types_permits = ref({
        Creator: {
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

const emits = defineEmits(['close:dialog']);
const props = defineProps({
    is_dialog_visible: {
        type: Boolean,
        default: false,
    },
});

const closeDialog = (val) => {
    emits('close:dialog', val);
};

const clickIcon = (val) => visible.value = val;

const submit = async (val) => {
    alerts.value = [];
    storeUser.clearInvalid();
    if (!val) return;

    let modelTemp = { ...model.value };

    if (!show_profiles.value) delete modelTemp.type;

    let isEmpty = validateFormIsEmpty({ ...modelTemp });

    if (!isEmpty.status) {
        alerts.value.push(isEmpty.alert);
        let set = { email:true, profile:true, type: true };
        if (!show_profiles.value) delete set.type;
        storeUser.setValueInvalid({...set})
        return;
    }

    let isEmail = validateEmail(model.value.email);

    if (!isEmail.status) {
        alerts.value.push(isEmail.alert);
        storeUser.setValueInvalid({ email:true })
        return;
    }

    await storeUser.store((response => {
        const { severity, detail, status } = response;
        alerts.value = [];
        alerts.value.push({ severity: severity, detail: detail })

        if (status) {
            setTimeout(() => {
                closeDialog(true);
                storeUser.all();
            }, 1000);
        }
    }));
};

watch( () => model.value.type, (new_value, old_value) => {
    show_icon.value = Boolean(new_value);
});

watch( () => model.value.profile, (new_value, old_value) => {
    show_profiles.value = new_value != 'Administrator';
    if(new_value == 'Administrator') model.value.type = '';
});

const title = computed(() => {
    return (model.value.hasOwnProperty('uuid') ? 'Editar' : 'Registrar') + ' usuario';
});

</script>
<template>
    <Alert :alerts="alerts" />
    <DialogModal
        :is_dialog_visible="props.is_dialog_visible"
        :is_disabled="disabled"
        :title="title"
        @update:is_dialog_visible="closeDialog"
        @submit="submit">

        <template #form>

            <Input
                :label="'Correo electrónico'"
                :model="model"
                :name="'email'"
                :invalid="invalid"
            />

            <Dropdown
                :label="'Tipo de perfil'"
                :model="model"
                :name="'profile'"
                :invalid="invalid"
                :options="profiles"
            />

            <Dropdown
                v-if="show_profiles"
                :label="'Tipo de permiso'"
                :model="model"
                :name="'type'"
                :invalid="invalid"
                :options="permissions"
                :show_icon="show_icon"
                @click_icon="clickIcon"
            />

            <Dialog v-model:visible="visible" modal header="Permisos" :style="modalDimensions">
                <div v-for="(type_permit, index) in types_permits[model.type]" :key="type_permit">
                    <p>{{ index }}</p>
                    <ul class="pl-8 list-disc">
                        <li v-for="permit in type_permit" :key="permit">{{ permit }}</li>
                    </ul>
                </div>
            </Dialog>
        </template>
    </DialogModal>
</template>
