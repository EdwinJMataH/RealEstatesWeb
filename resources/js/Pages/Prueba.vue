<template>
    <h1 class="text-red-600 text-3XL font-bold ">¡Hola mundo!</h1>
    <div class="card flex justify-center">
        <AutoComplete v-model="value3" :suggestions="items" @complete="search" />
    </div>
    <div class="card flex justify-center">
        <AutoComplete v-model="value" dropdown :suggestions="items" @complete="search" />
    </div>
    <div class="card flex justify-center">
        <div class="flex flex-col items-center">
            <div class="font-bold text-xl mb-2">Authenticate Your Account</div>
            <p class="text-surface-700 block mb-5">Please enter the code sent to your phone.</p>
            <InputOtp v-model="value2" :length="6" style="gap: 0">
                <template #default="{ attrs, events, index }">
                    <input type="text" v-bind="attrs" v-on="events" class="custom-otp-input" />
                    <div v-if="index === 3" class="px-3">
                        <i class="pi pi-minus" />
                    </div>
                </template>
            </InputOtp>
            <div class="flex justify-between mt-5 self-stretch">
                <Button label="Resend Code" link class="p-0"></Button>
                <Button label="Submit Code"></Button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import AutoComplete from 'primevue/autocomplete';
import InputOtp from 'primevue/inputotp';
import Button from 'primevue/button';



const value = ref("");
const value3 = ref("");
const items = ref([]);
const value2 = ref(null);

const search = (event) => {
    let _items = [...Array(10).keys()];

    items.value = event.query ? [...Array(10).keys()].map((item) => event.query + '-' + item) : _items;
};
</script>

<style scoped>
.custom-otp-input {
    width: 48px;
    height: 48px;
    font-size: 24px;
    appearance: none;
    text-align: center;
    transition: all 0.2s;
    border-radius: 0;
    border: 1px solid rgb(var(--surface-400));
    background: transparent;
    outline-offset: -2px;
    outline-color: transparent;
    border-right: 0 none;
    transition: outline-color 0.3s;
    color: var(--text-color);
}

.custom-otp-input:focus {
    outline: 2px solid rgb(var(--primary-500));
}

.custom-otp-input:first-child,
.custom-otp-input:nth-child(5) {
    border-top-left-radius: 12px;
    border-bottom-left-radius: 12px;
}

.custom-otp-input:nth-child(3),
.custom-otp-input:last-child {
    border-top-right-radius: 12px;
    border-bottom-right-radius: 12px;
    border-right-width: 1px;
    border-right-style: solid;
    border-color: rgb(var(--surface-400));
}
</style>