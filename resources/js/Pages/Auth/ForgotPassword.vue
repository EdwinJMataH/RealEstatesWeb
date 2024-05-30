<script setup>
import { watch, ref } from "vue";
import { Link, router } from "@inertiajs/vue3";
import AuthLayout from "@/Layouts/AuthLayout.vue";
import Form from "@/Components/Form.vue";
import Alert from "@/Components/Alert.vue";
import useStoreAuthForgotPassword from "@/Composables/useStoreAuthForgotPassword.js";
import { validateEmail, validateFormIsEmpty } from "@/helpers.js";
const { model, invalid, forgotPassword, clearInvalid, setValueInvalid, clearModel } = useStoreAuthForgotPassword();
const title       = 'Recuperar contraseña';
const description = 'Compartenos la dirección de correo electrónico y enviaremos un enlace para restablecer su contraseña que le permitirá elegir una nueva.';
const alerts  = ref([]);

const submit = async (val) => {
    alerts.value = [];
    clearInvalid();
    if (!val) return;

    let isEmpty = validateFormIsEmpty({ ...model.value });

    if (!isEmpty.status) {
        alerts.value.push(isEmpty.alert);
        setValueInvalid({ email:true })
        return;
    }

    let isEmail = validateEmail(model.value.email);

    if (!isEmail.status) {
        alerts.value.push(isEmail.alert);
        setValueInvalid({ email:true })
        return;
    }

    await forgotPassword((response => {
        const { severity, detail, status } = response;
        alerts.value = [];
        alerts.value.push({ severity: severity, detail: detail })
        clearModel();

    }));
};

</script>

<template>
    <Alert :alerts="alerts" />
    <AuthLayout :title="title">
        <template #content>
            <Form
                :title="title"
                :is_modal="true"
                :description="description"
                :button_title="'Enviar'"
                @submit="submit"
            >
                <template #form>
                    <div class="pt-4 w-full">
                        <div class="flex flex-col gap-2">
                            <label class="font-medium text-sm" for="email">Correo electrónico</label>
                            <InputText id="email" v-model="model.email" :invalid="invalid.email"  />
                        </div>
                    </div>
                </template>
            </Form>
        </template>
    </AuthLayout>
</template>
