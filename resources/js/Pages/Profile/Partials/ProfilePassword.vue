<script setup>
import Form from '@/Components/Form.vue';
import Input from "@/Components/Input.vue";
import Alert from "@/Components/Alert.vue";
import { useStoreProfilePassword } from "@/Pages/Profile/Store/useStoreProfilePassword.js";
import { useStoreProfile } from "@/Pages/Profile/Store/useStoreProfile.JS";
import { validateFormIsEmpty, validateSamePasword } from "@/helpers.js";
const storeProfile  = useStoreProfile();
const storePassword = useStoreProfilePassword();
const { model, invalid } = storeToRefs(storePassword);
const alerts  = ref([]);

const submit = async (val) => {
    alerts.value = [];
    storePassword.clearInvalid();
    if (!val) return;

    let modelTemp = { ...model.value };

    let isEmpty = validateFormIsEmpty({ ...modelTemp });

    if (!isEmpty.status) {
        alerts.value.push(isEmpty.alert);
        storePassword.setValueInvalid({...isEmpty.properties})
        return;
    }

    let isSamePassword = validateSamePasword({ password: model.value.password, password_confirmation: model.value.password_confirmation });
    if (!isSamePassword.status) {
        alerts.value.push(isSamePassword.alert);
        storePassword.setValueInvalid({ password:true, password_confirmation: true })
        return;
    }

    await storePassword.update( async(response) => {
        const { severity, detail, status } = response;
        alerts.value = [];
        alerts.value.push({ severity: severity, detail: detail })

        if (status) {

            await storeProfile.show();
            setTimeout(() => {
                storeProfile.clearModel();
            }, 1000);
        }
    });
};

</script>


<template>
    <Alert :alerts="alerts" />
    <Form
        :title="'Actualizar contraseña'"
        :has_columns="true"
        :description="'Asegúrese de que su cuenta utilice una contraseña larga y aleatoria para mantenerse segura.'"
        @submit="submit">
        <template #form>
            <div class="lg:w-1/2 space-y-6">
                <Input
                    :label="'Contraseña actual'"
                    :model="model"
                    :name="'current_password'"
                    :invalid="invalid"
                    :is_password="true"
                />
                <Input
                    :label="'Nueva contraseña'"
                    :model="model"
                    :name="'password'"
                    :invalid="invalid"
                    :is_password="true"
                />
            </div>
            <div class="lg:w-1/2">
                <Input
                    :label="'Repetir contraseña'"
                    :model="model"
                    :name="'password_confirmation'"
                    :invalid="invalid"
                    :is_password="true"
                />
            </div>
        </template>
    </Form>
</template>
