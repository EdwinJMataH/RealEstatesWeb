<script setup>
import { watch, ref } from "vue";
import { Link, router } from "@inertiajs/vue3";
import AuthLayout from "@/Layouts/AuthLayout.vue";
import Form from "@/Components/Form.vue";
import Alert from "@/Components/Alert.vue";
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
                :description="'Complete el siguiente formulario para obtener acceso.'"
                :button_title="title"
                @submit="submit"
            >
                <template #form>
                    <div class="pt-4 w-full">
                        <div class="flex flex-col gap-2">
                            <label class="font-medium text-sm" for="email">Correo electrónico</label>
                            <InputText id="email" v-model="model.email" :invalid="invalid.email"  />
                        </div>
                    </div>
                    <div>
                        <div class="flex flex-col gap-2">
                            <label class="font-medium text-sm" for="password">Contraseña</label>
                            <Password  id="password" v-model="model.password" toggleMask :invalid="invalid.password"  :feedback="false" />
                        </div>
                    </div>
                    <div>
                        <div class="flex flex-col gap-2">
                            <label class="font-medium text-sm" for="password_confirmation">Confirmar contraseña</label>
                            <Password  id="password_confirmation" v-model="model.password_confirmation" toggleMask :invalid="invalid.password_confirmation"  :feedback="false" />
                        </div>
                    </div>
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
