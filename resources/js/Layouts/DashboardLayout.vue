<script setup>
import { ref, onMounted } from "vue";
import { Link } from "@inertiajs/vue3";
import Alert from "@/Components/Alert.vue";
import Footer from "@/Components/Footer.vue";
import useStoreAuth from "@/Composables/useStoreAuth.js";
import useStoreModule from "@/Composables/useStoreModule.js";
import Spinner from "@/Components/Spinner/Spinner.vue";
import { spinner } from "@/helpers.js";
import { router } from '@inertiajs/vue3'
const { logout } = useStoreAuth();
const { index, itemsMenu } = useStoreModule();
spinner();

// V A R I A B L E S
const items = ref([
    {
        label: 'Home',
        icon: 'pi pi-home'
    },
    {
        label: 'Features',
        icon: 'pi pi-star'
    },
    {
        label: 'Projects',
        icon: 'pi pi-search',
        items: [
            {
                label: 'Core',
                icon: 'pi pi-bolt',
                shortcut: '⌘+S'
            },
            {
                label: 'Blocks',
                icon: 'pi pi-server',
                shortcut: '⌘+B'
            },
            {
                label: 'UI Kit',
                icon: 'pi pi-pencil',
                shortcut: '⌘+U'
            },
            {
                separator: true
            },
            {
                label: 'Templates',
                icon: 'pi pi-palette',
                items: [
                    {
                        label: 'Apollo',
                        icon: 'pi pi-palette',
                        badge: 2
                    },
                    {
                        label: 'Ultima',
                        icon: 'pi pi-palette',
                        badge: 3
                    }
                ]
            }
        ]
    },
    {
        label: 'Contact',
        icon: 'pi pi-envelope',
        badge: 3
    }
]);

const menu   = ref(null);
const alerts = ref([]);

// F U N C T I O N S
const toggle = (event) => menu.value.toggle(event);

const logoutEvnt = async () => {
    await logout((response) => {
        const { severity, detail, status } = response;
        alerts.value = [];
        alerts.value.push({ severity: severity, detail: detail })
        if (status) {
            setTimeout(() => {
                router.get(route('login'));
            }, 2000);
        }
    });
}

onMounted(() => {
    index();
    spinner(false);
});
</script>

<template>
    <Spinner/>
    <Alert :alerts="alerts" />
    <div class="flex flex-col h-screen">

    <header class="container-custom">
        <Menubar :model="items" class="container-content border-0 bg-white">
            <template #start >
                <div class="pr-8">
                    <Link :href="route('dashboard')">
                        <img src="logo.png" alt="" class="w-32">
                    </Link>
                </div>
            </template>
            <template #item="{ item, props, hasSubmenu, root }">
                <a v-ripple class="flex items-center" v-bind="props.action">
                    <span :class="item.icon" />
                    <span class="ml-2">{{ item.label }}</span>
                    <Badge v-if="item.badge" :class="{ 'ml-auto': !root, 'ml-2': root }" :value="item.badge" />
                    <span v-if="item.shortcut" class="ml-auto border border-surface-200 dark:border-surface-500 rounded-md bg-surface-100 dark:bg-surface-800 text-xs p-1">{{ item.shortcut }}</span>
                    <i v-if="hasSubmenu" :class="['pi pi-angle-down text-primary-500 dark:text-primary-400-500 dark:text-primary-400', { 'pi-angle-down ml-2': root, 'pi-angle-right ml-auto': !root }]"></i>
                </a>
            </template>
            <template #end>
                <div class="flex items-center gap-2">
                    <Avatar image="https://primefaces.org/cdn/primevue/images/avatar/amyelsner.png" shape="circle" @click="toggle" class="cursor-pointer"/>
                    <Menu :model="itemsMenu" ref="menu" popup>
                        <template #item="{ item, props }">
                            <Link v-if="item.route" v-ripple :href="route(item.route)" :target="item.target" v-bind="props.action">
                                <span :class="item.icon" />
                                <span class="ml-2">{{ item.label }}</span>
                            </Link>
                            <a v-else v-ripple :target="item.target" v-bind="props.action" @click="logoutEvnt">
                                <span :class="item.icon" />
                                <span class="ml-2">{{ item.label }}</span>
                            </a>
                        </template>
                    </Menu>
                </div>
            </template>
        </Menubar>
    </header>

    <div class="border-b-slate-200 border-y container-custom">
        <div class="container-content">
            <h1 class="font-semibold text-xl text-gray-800 leading-tight py-4 ">
                <slot name="title"></slot>
            </h1>
        </div>
    </div>

    <main class="py-10 bg-slate-100 flex-grow">
        <div class="container-custom space-y-16">
            <div class="max-w-7xl mx-auto px-4 lg:px-8 min-h-96 ">
                    <slot name="content"/>
            </div>
        </div>
    </main>
    <Footer/>
</div>

</template>
