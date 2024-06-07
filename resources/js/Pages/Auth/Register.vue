<script setup>
import { watch, ref } from "vue";
import { Link, router } from "@inertiajs/vue3";
import AuthLayout from "@/Layouts/AuthLayout.vue";
import Form from "@/Components/Form.vue";
import Alert from "@/Components/Alert.vue";
import Input from "@/Components/Input.vue";
import useStoreAuthRegister from "@/Composables/useStoreAuthRegister.js";
import { validateEmail, validateFormIsEmpty, validateSamePasword } from "@/helpers.js";
const { model, invalid, register, clearInvalid, setValueInvalid } = useStoreAuthRegister();
const title = 'Registrarse';
const alerts  = ref([]);

const submit = async (val) => {
    alerts.value = [];
    clearInvalid();
    if (!val) return;

    let isEmpty = validateFormIsEmpty({ ...model.value });

    if (!isEmpty.status) {
        alerts.value.push(isEmpty.alert);
        setValueInvalid({ email:true, password:true, password_confirmation: true })
        return;
    }

    let isEmail = validateEmail(model.value.email);

    if (!isEmail.status) {
        alerts.value.push(isEmail.alert);
        setValueInvalid({ email:true })
        return;
    }

    let isSamePassword = validateSamePasword({ ...model.value });
    if (!isSamePassword.status) {
        alerts.value.push(isSamePassword.alert);
        setValueInvalid({ password:true, password_confirmation: true })
        return;
    }

    await register((response => {
        const { severity, detail, status } = response;
        alerts.value = [];
        alerts.value.push({ severity: severity, detail: detail })

        if (status) {
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        }
    }));
};

</script>

<template>
    <Alert :alerts="alerts" />
    <AuthLayout :title="title">
        <template #content>
            <Form
                :title="'Crear una cuenta'"
                :is_modal="true"
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
