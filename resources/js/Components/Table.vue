<script setup>
import { ref, onMounted } from "vue";
import { FilterMatchMode } from "primevue/api";
import ConfirmDialog from 'primevue/confirmdialog';
import ConfirmPopup from 'primevue/confirmpopup';
import { useConfirm } from "primevue/useconfirm";
const confirm = useConfirm();
// import { useToast } from 'primevue/usetoast';
import { ProductService } from "@/Service/ProductService";
const emits = defineEmits(['open:dialog-new']);
const props = defineProps({
    columns: {
        type: Array,
        default: [],
    },
    actions: {
        type: Array,
        default: [],
    },
    multiple: {
        type: Boolean,
        default: false,
    },
    index: {
        type: Boolean,
        default: true,
    },
    data:{
        type: Array,
        default: []
    }
});

onMounted(() => {
    ProductService.getProducts().then((data) => (products.value = data));
});

// const toast = useToast();
const dt = ref();
const products = ref();
const productDialog = ref(false);
const deleteProductDialog = ref(false);
const deleteProductsDialog = ref(false);
const product = ref({});
const selectedProducts = ref();
const filters = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
});
const submitted = ref(false);
const statuses = ref([
    { label: "INSTOCK", value: "instock" },
    { label: "LOWSTOCK", value: "lowstock" },
    { label: "OUTOFSTOCK", value: "outofstock" },
]);

const formatCurrency = (value) => {
    if (value)
        return value.toLocaleString("en-US", {
            style: "currency",
            currency: "USD",
        });
    return;
};
const openNew = () => {
    emits('open:dialog-new', true)
    product.value = {};
    submitted.value = false;
    productDialog.value = true;
};
const hideDialog = () => {
    productDialog.value = false;
    submitted.value = false;
};
const saveProduct = () => {
    submitted.value = true;

    if (product?.value.name?.trim()) {
        if (product.value.id) {
            product.value.inventoryStatus = product.value.inventoryStatus.value
                ? product.value.inventoryStatus.value
                : product.value.inventoryStatus;
            products.value[findIndexById(product.value.id)] = product.value;
            // toast.add({severity:'success', summary: 'Successful', detail: 'Product Updated', life: 3000});
        } else {
            product.value.id = createId();
            product.value.code = createId();
            product.value.image = "product-placeholder.svg";
            product.value.inventoryStatus = product.value.inventoryStatus
                ? product.value.inventoryStatus.value
                : "INSTOCK";
            products.value.push(product.value);
            // toast.add({severity:'success', summary: 'Successful', detail: 'Product Created', life: 3000});
        }

        productDialog.value = false;
        product.value = {};
    }
};
const editProduct = (prod) => {
    product.value = { ...prod };
    productDialog.value = true;
};
const confirmDeleteProduct = (prod) => {
    product.value = prod;
    deleteProductDialog.value = true;
};
const deleteProduct = () => {
    products.value = products.value.filter(
        (val) => val.id !== product.value.id
    );
    deleteProductDialog.value = false;
    product.value = {};
    toast.add({
        severity: "success",
        summary: "Successful",
        detail: "Product Deleted",
        life: 3000,
    });
};
const findIndexById = (id) => {
    let index = -1;
    for (let i = 0; i < products.value.length; i++) {
        if (products.value[i].id === id) {
            index = i;
            break;
        }
    }

    return index;
};
const createId = () => {
    let id = "";
    var chars =
        "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    for (var i = 0; i < 5; i++) {
        id += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    return id;
};
const exportCSV = () => {
    dt.value.exportCSV();
};
const confirmDeleteSelected = () => {
    deleteProductsDialog.value = true;
};
const deleteSelectedProducts = () => {
    products.value = products.value.filter(
        (val) => !selectedProducts.value.includes(val)
    );
    deleteProductsDialog.value = false;
    selectedProducts.value = null;
    // toast.add({severity:'success', summary: 'Successful', detail: 'Products Deleted', life: 3000});
};

const getStatusLabel = (status) => {
    switch (status) {
        case "INSTOCK":
            return "success";

        case "LOWSTOCK":
            return "warning";

        case "OUTOFSTOCK":
            return "danger";

        default:
            return null;
    }
};

const clickAction = (event, val) => {
    const { index, data } = JSON.parse(JSON.stringify(val));
    const actions = props.actions[index];

    if (actions.action == 'destroy') {
        confirm.require({
            target: event.currentTarget,
            message: '¿Estas seguro que deseas eliminar?',
            header: 'Confirmación',
            icon: 'pi pi-exclamation-triangle',
            rejectProps: {
                label: 'Cancel',
                severity: 'secondary',
                outlined: true
            },
            acceptProps: {
                label: 'Si'
            },
            accept: () => { actions.callback(data); },
            // reject: () => { }
        });
    }

    if (actions.action == 'edit') {
        actions.callback(data);
        // emits('open:dialog-new', true)
    }
};

</script>

<template>
    <ConfirmPopup>
        <template #container="{ message, acceptCallback, rejectCallback }">
            <div class="rounded-full p-3">
                <span>{{ message.message }}</span>
                <div class="flex items-center gap-2 mt-3">
                    <Button label="Cancelar"  @click="rejectCallback" size="small" severity="secondary"></Button>
                    <Button label="Continuar" @click="acceptCallback" size="small"></Button>
                </div>
            </div>
        </template>
    </ConfirmPopup>
    <Toolbar class="mb-4" v-if="props.multiple">
        <template #start>
            <Button
                label="Exportar"
                icon="pi pi-upload"
                severity="help"
                class="mr-2"
                @click="exportCSV($event)"
            />
            <Button
                label="Borrar"
                icon="pi pi-trash"
                severity="danger"
                @click="confirmDeleteSelected"
                :disabled="!selectedProducts || !selectedProducts.length"
            />
        </template>
    </Toolbar>
    <DataTable
        ref="dt"
        :value="props.data"
        v-model:selection="selectedProducts"
        removableSort
        scrollable
        scrollHeight="400px"
        dataKey="id"
        :paginator="true"
        :rows="10"
        :filters="filters"
        paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
        :rowsPerPageOptions="[5, 10, 25, 50]"
        currentPageReportTemplate="Mostrando {first} a {last} de {totalRecords}"
    >
        <template #header>
            <div
                class="flex flex-wrap gap-2 align-items-center justify-between"
            >
                <Button
                    label="Nuevo"
                    icon="pi pi-plus"
                    severity="success"
                    @click="openNew"
                />
                <InputText
                    v-model="filters['global'].value"
                    placeholder="Search..."
                />
            </div>
        </template>

        <Column
            v-if="props.multiple"
            selectionMode="multiple"
            style="width: 3rem"
            :exportable="false"
        ></Column>

        <Column
            v-for="column of props.columns"
            :key="column.field"
            :field="column.field"
            :header="column.header"
            sortable
        >
            <template #body="slotProps">
                <template v-if="column.is_image">
                    <img
                        :src="`https://primefaces.org/cdn/primevue/images/product/${slotProps.data.image}`"
                        :alt="slotProps.data.image"
                        class="border-round"
                        style="width: 64px"
                    />
                </template>

                <template v-if="column.is_money">
                    {{ formatCurrency(slotProps.data[column.field]) }}
                </template>

                <template v-if="column.is_rating">
                    <Rating
                        :modelValue="slotProps.data.rating"
                        :readonly="true"
                        :cancel="false"
                    />
                </template>

                <template v-if="column.is_chip">
                    <Tag
                        :value="slotProps.data.inventoryStatus"
                        :severity="
                            getStatusLabel(slotProps.data.inventoryStatus)
                        "
                    />
                </template>

                <template v-else>
                    {{ slotProps.data[column.field] }}
                </template>
            </template>
        </Column>
        <Column v-if="actions.length" :exportable="false" :header="'Acciones'">
            <template #body="slotProps">
                <div class="flex gap-2">
                    <div v-for="(action, index) in actions" :key="index">
                        <i
                            v-if="slotProps.data.action.includes(index)"
                            :class="`button-table pi pi-${action.icon} border-${action.color}-500 text-${action.color}-500 hover:bg-${action.color}-100`"
                            @click="clickAction($event, { index: index, data: slotProps.data })"
                            >
                            <!-- @click="action.callback(slotProps.data)" -->
                        </i>
                    </div>
                </div>
            </template>
        </Column>
    </DataTable>
</template>
