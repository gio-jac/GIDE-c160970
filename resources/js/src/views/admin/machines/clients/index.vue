<template>
    <Head title="Clients" />
    <div>
        <div>
            <div
                class="panel px-0 pb-1.5 border-[#e0e6ed] dark:border-[#1b2e4b]"
            >
                <div class="datatable invoice-table">
                    <div
                        class="mb-4.5 px-5 flex md:items-center md:flex-row flex-col gap-5"
                    >
                        <div class="flex items-center gap-2">
                            <Link
                                href="/machines/clients/create"
                                class="btn btn-primary gap-2"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="24px"
                                    height="24px"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="w-5 h-5"
                                >
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                {{ $t('client.index.newClient') }}
                            </Link>
                        </div>
                        <div class="ltr:ml-auto rtl:mr-auto">
                            <input
                                v-model="search"
                                type="text"
                                class="form-input"
                                :placeholder="$t('user.index.searchPlaceholder')"
                            />
                        </div>
                    </div>

                    <vue3-datatable
                        ref="datatable"
                        :rows="props.clients"
                        :columns="cols"
                        :totalRows="props.clients?.length"
                        :hasCheckbox="false"
                        :sortable="true"
                        :search="search"
                        skin="whitespace-nowrap bh-table-hover"
                        firstArrow='<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M13 19L7 12L13 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path opacity="0.5" d="M16.9998 19L10.9998 12L16.9998 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>'
                        lastArrow='<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M11 19L17 12L11 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path opacity="0.5" d="M6.99976 19L12.9998 12L6.99976 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg> '
                        previousArrow='<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M15 5L9 12L15 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>'
                        nextArrow='<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>'
                    >
                        <template #tipo="data">
                            {{ data.value.tipo }}
                        </template>
                        <template #is_active="data">
                            <div class="flex items-center font-semibold">
                                <span
                                    class="badge"
                                    :class="[
                                        data.value.is_active === 1
                                            ? 'bg-green-500'
                                            : 'bg-red-500',
                                    ]"
                                    >&nbsp;</span
                                >
                            </div>
                        </template>
                        <template #actions="data">
                            <div class="flex gap-4 items-center justify-center">
                                <Link
                                    :href="`/machines/clients/${data.value.id}/edit`"
                                    class="hover:text-info"
                                >
                                    <svg
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-4.5 h-4.5"
                                    >
                                        <path
                                            opacity="0.5"
                                            d="M22 10.5V12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2H13.5"
                                            stroke="currentColor"
                                            stroke-width="1.5"
                                            stroke-linecap="round"
                                        ></path>
                                        <path
                                            d="M17.3009 2.80624L16.652 3.45506L10.6872 9.41993C10.2832 9.82394 10.0812 10.0259 9.90743 10.2487C9.70249 10.5114 9.52679 10.7957 9.38344 11.0965C9.26191 11.3515 9.17157 11.6225 8.99089 12.1646L8.41242 13.9L8.03811 15.0229C7.9492 15.2897 8.01862 15.5837 8.21744 15.7826C8.41626 15.9814 8.71035 16.0508 8.97709 15.9619L10.1 15.5876L11.8354 15.0091C12.3775 14.8284 12.6485 14.7381 12.9035 14.6166C13.2043 14.4732 13.4886 14.2975 13.7513 14.0926C13.9741 13.9188 14.1761 13.7168 14.5801 13.3128L20.5449 7.34795L21.1938 6.69914C22.2687 5.62415 22.2687 3.88124 21.1938 2.80624C20.1188 1.73125 18.3759 1.73125 17.3009 2.80624Z"
                                            stroke="currentColor"
                                            stroke-width="1.5"
                                        ></path>
                                        <path
                                            opacity="0.5"
                                            d="M16.6522 3.45508C16.6522 3.45508 16.7333 4.83381 17.9499 6.05034C19.1664 7.26687 20.5451 7.34797 20.5451 7.34797M10.1002 15.5876L8.4126 13.9"
                                            stroke="currentColor"
                                            stroke-width="1.5"
                                        ></path>
                                    </svg>
                                </Link>
                            </div>
                        </template>
                    </vue3-datatable>
                </div>
            </div>
        </div>
    </div>
</template>
<script lang="ts" setup>
import { ref,computed } from "vue";
import Vue3Datatable from "@bhplugin/vue3-datatable";
import AppLayout from "@/layouts/app-layout.vue";
import SiteLayout from "@/layouts/app.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import { useI18n } from 'vue-i18n';

const { t } = useI18n();
defineOptions({
    layout: [SiteLayout, AppLayout],
});
const props = defineProps({
    clients: {
        type: Array,
        required: true,
    },
});

const datatable: any = ref(null);
const search = ref("");
const cols = computed(() => [
    { field: "id", title: "ID" },
    { field: "name", title: t('user.index.col.name') },
    { field: "is_active", title: t("user.index.col.active") },
    {
        field: "actions",
        title: t("user.index.col.actions"),
        sort: false,
        headerClass: "justify-center",
    },
]);
const searchText = ref("");
const columns = ref(["titulo", "is_active", "actions"]);
const tableOption = ref({
    headings: {
        id: (h: any, row: any, index: number) => {
            return "#";
        },
    },
    perPage: 10,
    perPageValues: [10, 20, 30, 50, 100],
    skin: "table-hover",
    columnsClasses: { actions: "actions !text-center w-1" },
    pagination: { show: true, nav: "scroll", chunk: 10 },
    texts: {
        count: "Showing {from} to {to} of {count} entries",
        filter: "",
        filterPlaceholder: "Search...",
        limit: "",
    },
    resizableColumns: false,
    sortable: ["titulo", "is_active"],
    sortIcon: {
        base: "sort-icon-none",
        up: "sort-icon-asc",
        down: "sort-icon-desc",
    },
});

const deleteRow = (item: any = null) => {
    if (confirm("Are you sure want to delete selected row ?")) {
        if (item) {
            router.delete(`/reports/codes/${item}`);
        }
    }
};
</script>
