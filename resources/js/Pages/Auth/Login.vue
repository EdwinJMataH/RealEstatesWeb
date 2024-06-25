<script setup>
import { ref } from "vue";
import { Link, router } from "@inertiajs/vue3";
import AuthLayout from "@/Layouts/AuthLayout.vue";
import Form from "@/Components/Form.vue";
import Input from "@/Components/Input.vue";
import { validateEmail, validateFormIsEmpty } from "@/helpers.js";
import { useStoreAuth } from "./Store/useStoreAuth.js";
const storeAuth = useStoreAuth();
const { invalid, model } = storeToRefs(storeAuth);
const title  = 'Iniciar sesión';
const alerts = ref([]);

const submit = async (val) => {
    alerts.value = [];
    storeAuth.clearInvalid();
    if (!val) return;

    delete model.value.password_confirmation;
    
    let isEmpty = validateFormIsEmpty({ ...model.value });

    if (!isEmpty.status) {
        alerts.value.push(isEmpty.alert);
        storeAuth.setValueInvalid({ email:true, password:true })
        return;
    }

    let isEmail = validateEmail(model.value.email);

    if (!isEmail.status) {
        alerts.value.push(isEmail.alert);
        storeAuth.setValueInvalid({ email:true, password:false })
        return;
    }

    await storeAuth.login((response => {
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
                :title="'Bienvenido a RealStatesWeb! 🚀'"
                :is_modal="true"
                :description="'Asegúrese de que sus datos ingresados sean los correctos.'"
                :button_title="title"
                :is_processing="model.processing"
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
                </template>
                <template #options>
                    <div class="flex flex-col gap-y-4 md:flex-row justify-between items-center">
                        <Link class="font-light text-sm" v-ripple :href="route('register')">¿No tienes una cuenta?</Link>
                        <Link class="font-light text-sm" v-ripple :href="route('password.request')">¿Olvidaste tu contraseña?</Link>
                    </div>
                </template>
                <template #remember>
                    <div>
                        <Checkbox name="remember" v-model="model.remember" :binary="true"/>
                        <label class="font-light text-sm" for="remember">Recordarme</label>
                    </div>
                </template>
            </Form>
        </template>
    </AuthLayout>
</template>
