<script setup>
import { watch, ref } from "vue";
import { Link, router } from "@inertiajs/vue3";
import AuthLayout from "@/Layouts/AuthLayout.vue";
import Form from "@/Components/Form.vue";
import Alert from "@/Components/Alert.vue";
import Input from "@/Components/Input.vue";
import useStoreAuth from "@/Composables/useStoreAuth.js";
import { validateEmail, validateFormIsEmpty } from "@/helpers.js";
const { model, invalid, login, clearInvalid, setValueInvalid } = useStoreAuth();
const title = 'Iniciar sesión';
const alerts  = ref([]);

defineProps({
    status: {
        type: String,
    },
});
const submit = async (val) => {
    alerts.value = [];
    clearInvalid();
    if (!val) return;

    let isEmpty = validateFormIsEmpty({ ...model.value });

    if (!isEmpty.status) {
        alerts.value.push(isEmpty.alert);
        setValueInvalid({ email:true, password:true })
        return;
    }

    let isEmail = validateEmail(model.value.email);

    if (!isEmail.status) {
        alerts.value.push(isEmail.alert);
        setValueInvalid({ email:true, password:false })
        return;
    }


    await login((response => {
        const { severity, detail, status } = response;
        alerts.value = [];
        alerts.value.push({ severity: severity, detail: detail })

        if (status) {
            // router.reload();
            setTimeout(() => {
                window.location.reload();
            }, 1000);
            // router.get(route('dashboard'));
        }
    }));
};

</script>

<template>
    <Alert :alerts="alerts" />
    <AuthLayout :title="title">
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
