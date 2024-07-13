<script setup>
import Form from '@/Components/Form.vue';
import Input from "@/Components/Input.vue";
import Alert from "@/Components/Alert.vue";
import { useStoreProfileInformation } from "../Store/useStoreProfileInformation.js";
import { validateEmail, validateFormIsEmpty } from "@/helpers.js";

const storeProfile = useStoreProfileInformation();
const { model, invalid } = storeToRefs(storeProfile);
const alerts  = ref([]);

const submit = async (val) => {
    alerts.value = [];
    storeProfile.clearInvalid();
    if (!val) return;

    let modelTemp = { ...model.value };

    let isEmpty = validateFormIsEmpty({ ...modelTemp });

    if (!isEmpty.status) {
        alerts.value.push(isEmpty.alert);
        storeProfile.setValueInvalid({...isEmpty.properties})
        return;
    }

    let isEmail = validateEmail(model.value.email);

    if (!isEmail.status) {
        alerts.value.push(isEmail.alert);
        storeProfile.setValueInvalid({ email:true })
        return;
    }

    await storeProfile.update((response => {
        const { severity, detail, status } = response;
        alerts.value = [];
        alerts.value.push({ severity: severity, detail: detail })

    }));
};
</script>


<template>
    <Alert :alerts="alerts" />
    <Form
        :title="'Datos Generales'"
        :has_columns="true"
        :description="'Actualice la información del perfil y la dirección de correo electrónico de su cuenta.'"
        @submit="submit">
        <template #form>
            <div class="lg:w-1/2">
                <Input
                    :label="'Nombre'"
                    :model="model"
                    :name="'name'"
                    :invalid="invalid"
                />
            </div>
            <div class="lg:w-1/2">
                <Input
                    :label="'Correo electrónico'"
                    :model="model"
                    :name="'email'"
                    :invalid="invalid"
                />
            </div>
        </template>
    </Form>
</template>
