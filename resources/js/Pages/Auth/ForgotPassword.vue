<script setup>
import { ref } from "vue";
import AuthLayout from "@/Layouts/AuthLayout.vue";
import Form from "@/Components/Form.vue";
import Input from "@/Components/Input.vue";
import { validateEmail, validateFormIsEmpty } from "@/helpers.js";
import { useStoreAuth } from "./Store/useStoreAuth.js";
const storeAuth = useStoreAuth();
const { invalid, model } = storeToRefs(storeAuth);
const title       = 'Recuperar contraseña';
const description = 'Compartenos la dirección de correo electrónico y enviaremos un enlace para restablecer su contraseña que le permitirá elegir una nueva.';
const alerts  = ref([]);

const submit = async (val) => {
    alerts.value = [];
    storeAuth.clearInvalid();
    if (!val) return;

    delete model.value.remember;
    delete model.value.password;
    delete model.value.password_confirmation;

    let isEmpty = validateFormIsEmpty({ ...model.value });

    if (!isEmpty.status) {
        alerts.value.push(isEmpty.alert);
        storeAuth.setValueInvalid({ email:true })
        return;
    }

    let isEmail = validateEmail(model.value.email);

    if (!isEmail.status) {
        alerts.value.push(isEmail.alert);
        storeAuth.setValueInvalid({ email:true })
        return;
    }

    await storeAuth.forgotPassword((response => {
        const { severity, detail, status } = response;
        alerts.value = [];
        alerts.value.push({ severity: severity, detail: detail })
    }));
};

</script>

<template>
    <AuthLayout :title="title" :alerts="alerts">
        <template #content>
            <Form
                :title="title"
                :is_modal="true"
                :description="description"
                :button_title="'Enviar'"
                @submit="submit"
            >
                <template #form>
                    <Input
                        :label="'Correo electrónico'"
                        :model="model"
                        :name="'email'"
                        :invalid="invalid"
                    />
                </template>
            </Form>
        </template>
    </AuthLayout>
</template>
