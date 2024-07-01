<script setup>
import { ref } from "vue";
import { Link, router } from "@inertiajs/vue3";
import AuthLayout from "@/Layouts/AuthLayout.vue";
import Form from "@/Components/Form.vue";
import Input from "@/Components/Input.vue";
import { validateEmail, validateFormIsEmpty, validateSamePasword } from "@/helpers.js";
import { useStoreAuth } from "./Store/useStoreAuth.js";
const storeAuth = useStoreAuth();
const { invalid, model } = storeToRefs(storeAuth);
const title = 'Registrarse';
const alerts  = ref([]);

const submit = async (val) => {
    alerts.value = [];
    storeAuth.clearInvalid();
    if (!val) return;

    delete model.value.remember;

    let isEmpty = validateFormIsEmpty({ ...model.value });

    if (!isEmpty.status) {
        alerts.value.push(isEmpty.alert);
        storeAuth.setValueInvalid({ email:true, password:true, password_confirmation: true })
        return;
    }

    let isEmail = validateEmail(model.value.email);

    if (!isEmail.status) {
        alerts.value.push(isEmail.alert);
        storeAuth.setValueInvalid({ email:true })
        return;
    }

    let isSamePassword = validateSamePasword({ ...model.value });
    if (!isSamePassword.status) {
        alerts.value.push(isSamePassword.alert);
        storeAuth.setValueInvalid({ password:true, password_confirmation: true })
        return;
    }

    await storeAuth.store((response => {
        const { severity, detail, status } = response;
        alerts.value = [];
        alerts.value.push({ severity: severity, detail: detail })

        if (status) {
            setTimeout(() => {
                storeAuth.clearModel();
                router.visit(route('dashboard'));
            }, 1000);
        }
    }));
};

</script>

<template>
    <AuthLayout :title="title" :alerts="alerts">
        <template #content>
            <Form
                :title="'Crear una cuenta'"
                :is_modal="true"
                :divider="true"
                :description="'Complete el siguiente formulario para obtener acceso.'"
                :button_title="title"
                @submit="submit"
            >
                <template #form>
                    <Input
                        :label="'Correo electrónico'"
                        :model="model"
                        :name="'email'"
                        :invalid="invalid"
                    />
                    <Input
                        :label="'Contraseña'"
                        :model="model"
                        :name="'password'"
                        :invalid="invalid"
                        :is_password="true"
                    />
                    <Input
                        :label="'Confirmar contraseña'"
                        :model="model"
                        :name="'password_confirmation'"
                        :invalid="invalid"
                        :is_password="true"
                    />
                </template>
                <template #options>
                    <div class="flex flex-col gap-y-4 md:flex-row justify-center items-center">
                        <Link class="font-light text-sm" v-ripple :href="route('login')">¿Ya tienes una cuenta?</Link>
                    </div>
                </template>
            </Form>
        </template>
    </AuthLayout>
</template>
