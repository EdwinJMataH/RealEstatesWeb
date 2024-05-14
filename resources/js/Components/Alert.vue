<script setup>
import { watch, defineProps } from "vue";
import { useToast } from "primevue/usetoast";
const toast = useToast();
const props = defineProps({
    alerts: {
        type: Array,
        default: []
    }
});

watch(()=> props.alerts, (new_value, old_value) => {
    if ((new_value ?? '').length != 0) {
        new_value.forEach((item, index) => {
            toast.add({ severity: item.severity, summary: 'Mensaje', detail: item.detail, life: 4000 + index * 5 });
        });
    }
});
</script>
<template>
    <Toast />
</template>

