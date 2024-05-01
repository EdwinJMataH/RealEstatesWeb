<script setup>
import { ref, watch, defineProps, defineEmits } from "vue";
import DialogModal from "@/Components/DialogModal.vue";
import Alert from "@/Components/Alert.vue";
import useUser from "@/Composables/useUser.js";
import { modalDimensions, validateEmail, isEmpty, messages } from "@/helpers.js";
const { permissions, profiles, types_permits, show_profiles, show_icon, disabled, model, store } = useUser();
const visible = ref(false);
const alerts  = ref([]);

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

const optionSelected = (val) => {
    show_profiles.value = val != 'Administrator';
    if(val == 'Administrator') model.value.profile = '';
};

const validateForm = () => {
    alerts.value = [];
    let modelTemp = { ...model.value };

    if (!show_profiles.value) delete modelTemp.profile;

    //empty
    let empty = Object.keys(modelTemp).some(element => isEmpty(model.value[element]));

    if (empty) {
        alerts.value.push({ severity: 'warn', detail: messages['form-empty']});
        return false;
    };

    //empty
    if(!validateEmail(model.value.email)) {
        alerts.value.push({ severity: 'error', detail: messages['error-email'] })
    };

    if (alerts.value.length) return false;
    alerts.value = [];
    return true;
};

const submit = async (val) => {
    if (!val) return;

    if (validateForm()) {
        await store((response => {
            const { severity, detail, status } = response;
            alerts.value = [];
            alerts.value.push({ severity: severity, detail: detail })

            if (status) closeDialog(true);
        }));
    }
};


watch( () => model.value.profile, (new_value, old_value) => {
    show_icon.value = Boolean(new_value);
});

</script>
<template>
    <Alert :alerts="alerts" />
    <DialogModal 
        :is_dialog_visible="props.is_dialog_visible" 
        :is_disabled="disabled" 
        @update:is_dialog_visible="closeDialog" 
        @submit="submit">

            <template #form>
                <div class="flex flex-col gap-2">
                    <label class="font-medium text-sm" for="email">Email</label>
                    <InputText id="email" v-model="model.email"/>
                </div>
                <div class="flex flex-col gap-2">
                    <label class="font-medium text-sm" for="account">Nivel de permiso</label>
                    <Dropdown 
                        v-model="model.permission" 
                        @update:modelValue="optionSelected" 
                        :options="permissions" 
                        optionLabel="label" 
                        optionValue="value" 
                        placeholder="Seleccionar..." 
                        class="w-full md:w-14rem" />
                </div>
                <div v-if="show_profiles" class="flex flex-col gap-2">
                    <label class="font-medium text-sm" for="account">Tipo de perfil</label>
                    <InputGroup class="flex items-center gap-2">
                        <Dropdown 
                            v-model="model.profile" 
                            :options="profiles" 
                            optionLabel="label" 
                            optionValue="value" 
                            placeholder="Seleccionar..." 
                            class="w-full md:w-14rem" />
                        <i v-if="show_icon"
                            class="text-xl cursor-pointer pi pi-eye border-blue-500 text-blue-500 hover:bg-blue-100" 
                            @click="visible = true">
                        </i>
                        <Dialog v-model:visible="visible" modal header="Permisos" :style="modalDimensions">
                            <div v-for="(type_permit, index) in types_permits[model.profile]" :key="type_permit">
                                <p>{{ index }}</p>
                                <ul class="pl-8 list-disc">
                                    <li v-for="permit in type_permit" :key="permit">{{ permit }}</li>
                                </ul>
                            </div>
                        </Dialog>
                    </InputGroup>

                </div>
            </template>
    </DialogModal>
</template>

