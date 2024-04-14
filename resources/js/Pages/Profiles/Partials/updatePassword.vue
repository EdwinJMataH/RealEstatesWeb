<script setup>
import Form from '@/Components/Form.vue';
</script>


<template>
    <Form 
        :title="'Actualizar Contraseña'" 
        :description="'Asegúrese de que su cuenta utilice una contraseña larga y aleatoria para mantenerse segura.'">
        <template #form>
            <div class="pt-4 flex flex-col gap-4 lg:w-1/2">
                <div class="flex flex-col gap-2">
                    <label class="font-medium text-sm" for="current-password">Contraseña Actual</label>
                    <Password id="current-password" v-model="value" :feedback="false" />
                </div>
                <div class="flex flex-col gap-2">
                    <label class="font-medium text-sm" for="new-password">Nueva Contraseña</label>
                    <Password v-model="value">
                        <template #footer>
                            <Divider />
                            <p class="mt-2">Suggestions</p>
                            <ul class="pl-2 ml-2 mt-0" style="line-height: 1.5">
                                <li>At least one lowercase</li>
                                <li>At least one uppercase</li>
                                <li>At least one numeric</li>
                                <li>Minimum 8 characters</li>
                            </ul>
                        </template>
                    </Password>
                </div>
            </div>
            <div class="pt-4 flex flex-col gap-4 lg:w-1/2 justify-end">
                <div class="flex flex-col gap-2">
                    <label class="font-medium text-sm" for="repeat-password">Repetir Contraseña</label>
                    <Password v-model="value">
                        <template #footer>
                            <Divider />
                            <p class="mt-2">Suggestions</p>
                            <ul class="pl-2 ml-2 mt-0" style="line-height: 1.5">
                                <li>At least one lowercase</li>
                                <li>At least one uppercase</li>
                                <li>At least one numeric</li>
                                <li>Minimum 8 characters</li>
                            </ul>
                        </template>
                    </Password>
                </div>
            </div>
        </template>
    </Form>
</template>