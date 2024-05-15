<template>
    <Head title="Reports" />
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
                                href="/reports/create"
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
                                {{ $t("report.index.newReport") }}
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
                        :rows="props.reports"
                        :columns="cols"
                        :totalRows="props.reports?.length"
                        :hasCheckbox="false"
                        :sortable="true"
                        :search="search"
                        :pageSize="50"
                        :pageSizeOptions="[10, 20, 30, 50, 100]"
                        sortDirection="desc"
                        skin="whitespace-nowrap bh-table-hover"
                        firstArrow='<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M13 19L7 12L13 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path opacity="0.5" d="M16.9998 19L10.9998 12L16.9998 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>'
                        lastArrow='<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M11 19L17 12L11 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path opacity="0.5" d="M6.99976 19L12.9998 12L6.99976 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg> '
                        previousArrow='<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M15 5L9 12L15 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>'
                        nextArrow='<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>'
                    >
                        <template #id="data">
                            {{ data.value.id }}
                        </template>
                        <template #complete_id="data">
                            {{ data.value.complete_id }}
                        </template>
                        <template #status="data">
                            {{ $t("catalogs.status."+data.value.status_id,data.value.status && data.value.status.status ? data.value.status.status : "N/A") }}
                        </template>
                        <template #machines="data">
                            {{ data.value.machines.filter(item => item.only_dt === 0).map((item: any) => item.serial).join(', ') }}
                        </template>
                        <template #created_at="data">
                            {{ formatDate(data.value.created_at) }}
                        </template>
                        <template #assigned_to="data">
                            {{ fullName(data.value.user) }}
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
                                    :href="`/reports/${data.value.id}/edit`"
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
                                <a
                                    href="javascript:void(0)"
                                    v-if="data.value.closed === 1"
                                    class="hover:text-info"
                                    @click="showDownloadMessage(data.value.id)"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" id="file">
                                        <path 
                                            fill="currentColor" 
                                            stroke="currentColor" 
                                            stroke-width="0.5"
                                            opacity="0.7"
                                            d="M19.714 6.149 14.259.364c-.189-.199-.456-.363-.73-.363H1.979C.874.001 0 1.001 0 2.105v7c0 .552.437.896.99.896h.004c.553 0 1.006-.344 1.006-.896v-6c0-.552.427-1.104.98-1.104H12v4.104c0 1.105.874 1.896 1.98 1.896H18v1.104c0 .552.437.896.99.896h.004c.553 0 1.006-.344 1.006-.896V6.838c0-.257-.109-.503-.286-.689zM3.979 15.105a1 1 0 0 0-1-1h-1v2h1a1 1 0 0 0 1-1zm1.996-.266a3.002 3.002 0 0 1-2.996 3.162H2v1.104c0 .552-.453.896-1.006.896H.989c-.552 0-.989-.344-.989-.896v-6c0-.552.427-1.104.98-1.104h1.83c1.624 0 3.08 1.216 3.165 2.838zm5.025.266c0-.552-.469-1.104-1.02-1.104H9v4h.98c.551 0 1.02-.344 1.02-.896v-2zm2-.104v2c0 1.65-1.35 3-3 3H7.895A.895.895 0 0 1 7 19.105V12.98c0-.541.438-.979.98-.979H10c1.65 0 3 1.35 3 3zm7-1.974v.026c0 .552-.469.948-1.02.948H16v2h2.98A1.04 1.04 0 0 1 20 17.027v.026c0 .552-.469.948-1.02.948H16v1.104c0 .552-.453.896-1.006.896h-.005c-.552 0-.989-.344-.989-.896v-6c0-.552.427-1.104.98-1.104h4A1.04 1.04 0 0 1 20 13.027z">
                                        </path>
                                    </svg>
                                </a>
                                <!--
                                <Link
                                    :href="`/expenses`"
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
                                </Link>-->
                                <!--
                                <button
                                    type="button"
                                    class="hover:text-danger"
                                    @click="deleteRow(`${data.value.id}`)"
                                >
                                    <svg
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-5 h-5"
                                    >
                                        <path
                                            d="M20.5001 6H3.5"
                                            stroke="currentColor"
                                            stroke-width="1.5"
                                            stroke-linecap="round"
                                        ></path>
                                        <path
                                            d="M18.8334 8.5L18.3735 15.3991C18.1965 18.054 18.108 19.3815 17.243 20.1907C16.378 21 15.0476 21 12.3868 21H11.6134C8.9526 21 7.6222 21 6.75719 20.1907C5.89218 19.3815 5.80368 18.054 5.62669 15.3991L5.16675 8.5"
                                            stroke="currentColor"
                                            stroke-width="1.5"
                                            stroke-linecap="round"
                                        ></path>
                                        <path
                                            opacity="0.5"
                                            d="M9.5 11L10 16"
                                            stroke="currentColor"
                                            stroke-width="1.5"
                                            stroke-linecap="round"
                                        ></path>
                                        <path
                                            opacity="0.5"
                                            d="M14.5 11L14 16"
                                            stroke="currentColor"
                                            stroke-width="1.5"
                                            stroke-linecap="round"
                                        ></path>
                                        <path
                                            opacity="0.5"
                                            d="M6.5 6C6.55588 6 6.58382 6 6.60915 5.99936C7.43259 5.97849 8.15902 5.45491 8.43922 4.68032C8.44784 4.65649 8.45667 4.62999 8.47434 4.57697L8.57143 4.28571C8.65431 4.03708 8.69575 3.91276 8.75071 3.8072C8.97001 3.38607 9.37574 3.09364 9.84461 3.01877C9.96213 3 10.0932 3 10.3553 3H13.6447C13.9068 3 14.0379 3 14.1554 3.01877C14.6243 3.09364 15.03 3.38607 15.2493 3.8072C15.3043 3.91276 15.3457 4.03708 15.4286 4.28571L15.5257 4.57697C15.5433 4.62992 15.5522 4.65651 15.5608 4.68032C15.841 5.45491 16.5674 5.97849 17.3909 5.99936C17.4162 6 17.4441 6 17.5 6"
                                            stroke="currentColor"
                                            stroke-width="1.5"
                                        ></path>
                                    </svg>
                                </button>-->
                            </div>
                        </template>
                    </vue3-datatable>
                </div>
            </div>
        </div>
    </div>
</template>
<script lang="ts" setup>
import { ref, computed } from "vue";
import Vue3Datatable from "@bhplugin/vue3-datatable";
import AppLayout from "@/layouts/app-layout.vue";
import SiteLayout from "@/layouts/app.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import { useI18n } from 'vue-i18n';
import { useAppStore } from "@/stores/index";
import Swal from "sweetalert2";

const store = useAppStore();
const { t } = useI18n();
defineOptions({
    layout: [SiteLayout, AppLayout],
});
const props = defineProps({
    reports: {
        type: Array,
        required: true,
    },
});

console.log(props.reports);

const datatable: any = ref(null);
const search = ref("");
const cols = computed(() =>[
    { field: "id", title: "ID" },
    { field: "complete_id", title: t("report.index.col.fileName") },
    { field: "status", title: t("report.index.col.status") },
    { field: "machines", title: "Maquinas" },
    { field: "assigned_to", title: t("report.index.col.assigned") },
    { field: "created_at", title: t("report.index.col.creationDate") },
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

const formatDate = (dateString) => {
    const options = { year: 'numeric', month: '2-digit', day: '2-digit' };
    return new Date(dateString).toLocaleDateString('es', options);
}

const fullName = (user) => {
  return [user.nombre, user.apellido_paterno, user.apellido_materno]
    .filter(Boolean)
    .join(' ');
};

const deleteRow = (item: any = null) => {
    if (confirm("Are you sure want to delete selected row ?")) {
        if (item) {
            router.delete(`/reports/${item}`);
        }
    }
};

function showDownloadMessage(id) {
    const url = `/reports/${id}/${store.locale}/file`;
    window.location.href = url;
    Swal.fire({
        title: t("report.alert.generatingPdfTitle"),
        text: t("report.alert.generatingPdfText"),
        allowOutsideClick: false,
        showConfirmButton: false,
        customClass: "sweet-alerts",
        timer: 3000,
        timerProgressBar: true,
        didOpen: () => {
            Swal.showLoading();
        },
    });
}
</script>
