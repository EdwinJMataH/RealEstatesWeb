<script setup>
import { ref, onMounted, watch } from "vue";
import Table from "@/Components/Table.vue";
import DialogUser from "./DialogUser.vue";
import Alert from "@/Components/Alert.vue";
import { router } from "@inertiajs/vue3";
import { useStoreUser } from "../Store/useStoreUser.js";
const storeUser = useStoreUser();
const { users, model, columns } = storeToRefs(storeUser);

let is_dialog_new_user = ref(false);
const alerts  = ref([]);

const edit = (val) => {
    const toDelete = ['name', 'action'];
    toDelete.forEach(property => delete val[property]);

    storeUser.setValueModel(val);
    is_dialog_new_user.value = true;

};

const destroy = async (val) => {
    storeUser.setValueModel(val);

    await storeUser.destroy((response => {
        const { severity, detail, status } = response;
        alerts.value = [];
        alerts.value.push({ severity: severity, detail: detail })

        if (status) {
            setTimeout(() => {
                storeUser.clearModel();
                router.visit(route('users.index'));
            }, 1000);
        }
    }));
};

const openDialog = () => {
    storeUser.clearInvalid();
    storeUser.clearModel();
    is_dialog_new_user.value = true;
}

const actions = [
    {
        icon: "pi pi-pencil",
        color: "green",
        callback: edit,
        action: "edit",
    },
    {
        icon: "pi pi-trash",
        color: "red",
        callback: destroy,
        action: "destroy",
    },
];

onMounted(async () => {
    await storeUser.all();
});

</script>

<template>
    <Alert :alerts="alerts" />

    <DialogUser
        :is_dialog_visible="is_dialog_new_user"
        @close:dialog="is_dialog_new_user = false"
    />
    <Table
        :data="users"
        :columns="columns"
        :actions="actions"
        @open:dialog-new="openDialog"
    />
</template>
