<template>
    <Head title="Expenses" />
    <div>
        <div>
            <div
                class="panel px-0 pb-1.5 border-[#e0e6ed] dark:border-[#1b2e4b]"
            >
                <div class="datatable invoice-table">
                    <div class="mb-4.5 px-5 flex md:items-center md:flex-row flex-col gap-5" >
                        <div class="flex items-center gap-2">
                            <button type="button" class="btn btn-info" @click="modal2 = true">{{ $t("expenses.list.newExpense") }}</button>
                            <TransitionRoot appear :show="modal2" as="template">
                                <Dialog as="div" @close="modal2 = false" class="relative z-[51]">
                                    <TransitionChild
                                            as="template"
                                            enter="duration-300 ease-out"
                                            enter-from="opacity-0"
                                            enter-to="opacity-100"
                                            leave="duration-200 ease-in"
                                            leave-from="opacity-100"
                                            leave-to="opacity-0"
                                        >
                                        <DialogOverlay class="fixed inset-0 bg-[black]/60" />
                                    </TransitionChild>

                                    <div class="fixed inset-0 overflow-y-auto">
                                        <div class="flex min-h-full items-center justify-center px-4 py-8">
                                            <TransitionChild
                                                as="template"
                                                enter="duration-300 ease-out"
                                                enter-from="opacity-0 scale-95"
                                                enter-to="opacity-100 scale-100"
                                                leave="duration-200 ease-in"
                                                leave-from="opacity-100 scale-100"
                                                leave-to="opacity-0 scale-95"
                                            >
                                                <DialogPanel class="panel border-0 p-0 rounded-lg overflow-hidden w-full max-w-lg text-black dark:text-white-dark">
                                                    <button
                                                        type="button"
                                                        class="absolute top-4 ltr:right-4 rtl:left-4 text-gray-400 hover:text-gray-800 dark:hover:text-gray-600 outline-none"
                                                        @click="modal2 = false"
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
                                                            class="w-6 h-6"
                                                        >
                                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                                        </svg>
                                                    </button>
                                                    <div
                                                        class="text-lg font-bold bg-[#fbfbfb] dark:bg-[#121c2c] ltr:pl-5 rtl:pr-5 py-3 ltr:pr-[50px] rtl:pl-[50px]"
                                                    >
                                                    {{ $t("expenses.list.newExpense") }}
                                                    </div>
                                                    <div class="p-5">
                                                        <form @submit.prevent="submitForm">
                                                            <div>
                                                                <label for="travelReason">Razón de viaje</label>
                                                                <input type="text" class="form-input flex-1" id="travelReason" v-model="form.travelReason" required />
                                                            </div>
                                                            <div class="mt-5">
                                                                <label for="travelReason">Centro de costos</label>
                                                                <select  class="form-select text-white-dark" v-model="form.travelCenterCost">
                                                                    <option v-for="centerCost in props.centerCosts" :key="centerCost.id" :value="centerCost.id">
                                                                        {{ centerCost.cc }} - {{ centerCost.name }}
                                                                    </option>
                                                                </select>
                                                            </div>
                                                            <div class="mt-5">
                                                                <label for="travelReason">Departamento</label>
                                                                <select  class="form-select text-white-dark" v-model="form.travelDepartment">
                                                                    <option v-for="department in props.departments" :key="department.id" :value="department.id">
                                                                        {{ department.department }}
                                                                    </option>
                                                                </select>
                                                            </div>
                                                            <div class="mt-5">
                                                                <label for="travelReason">Destino desde</label>
                                                                <input type="text" class="form-input flex-1" id="traveldestiny" v-model="form.travelDestinyFrom" required />
                                                            </div>
                                                            <div class="mt-5">
                                                                <label for="travelReason">Destino hasta</label>
                                                                <input type="text" class="form-input flex-1" id="traveldestiny" v-model="form.travelDestinyTo" required />
                                                            </div>
                                                            <div class="mt-5">
                                                                <label for="travelReason">Anticipo</label>
                                                                <input type="number" class="form-input flex-1" step="0.01" id="travelAdvance" v-model="form.travelAdvance" required />
                                                            </div>
                                                            <div class="mt-5">
                                                                <label for="travelDate">Fecha inicio de viaje</label>
                                                                <input type="date" class="form-input flex-1" id="travelDateStart" v-model="form.travelDateStart"  @change="validateDateStart" required />
                                                            </div>
                                                            <div class="flex justify-end items-center mt-8">
                                                                <button type="submit" class="btn btn-primary" style="margin-right: 10px;">{{ $t("expenses.list.create") }}</button>
                                                                <button type="button" @click="modal2 = false" class="btn btn-outline-danger ">{{ $t("expenses.list.close") }}</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </DialogPanel>
                                            </TransitionChild>
                                        </div>
                                    </div>
                                </Dialog>
                            </TransitionRoot>
                        </div>
                        <div class="ltr:ml-auto rtl:mr-auto flex">
                            <input
                                v-model="searchQuery"
                                type="text"
                                class="form-input"
                                :placeholder="$t('user.index.searchPlaceholder')"
                            />
                        </div>
                    </div>

                    <vue3-datatable
                        ref="datatable"
                        :rows="filteredData"
                        :columns="cols"
                        :totalRows="filteredData?.length"
                        :hasCheckbox="false"
                        :sortable="true"
                        :search="searchQuery"
                        :columnFilter="false"
                        skin="whitespace-nowrap bh-table-hover"
                        firstArrow='<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M13 19L7 12L13 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path opacity="0.5" d="M16.9998 19L10.9998 12L16.9998 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>'
                        lastArrow='<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M11 19L17 12L11 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path opacity="0.5" d="M6.99976 19L12.9998 12L6.99976 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg> '
                        previousArrow='<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M15 5L9 12L15 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>'
                        nextArrow='<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>'
                    >
                   
                    <template #endingDate="data">
                        {{ formatDateRange(data.value.endingDate) }}
                    </template>
                    
                    <template #status_text="data">
                        <div class="flex items-center font-semibold">
                            <span class="badge" :class="[ classStatus(data.value.status) ]" >{{ data.value.status_text }}</span>
                        </div>
                    </template>
                        
                        <template #actions="data">
                            <div class="flex gap-4 items-center justify-center">
                                <Link :href="`/expenses/${data.value.uuid}`" class="hover:text-info" v-if="data.value.status === 0">
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
                                <Link :href="`/expenses/${data.value.uuid}`" class="hover:text-info" v-if="data.value.status === 1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-circle" viewBox="0 0 16 16">
                                        <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0"/>
                                        <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z"/>
                                    </svg>
                                </Link>
                                <a href="javascript:void(0)" v-if="data.value.status != 0" class="hover:text-info"  @click="downloadReportExpense(data.value.uuid)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-spreadsheet" viewBox="0 0 16 16">
                                        <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V9H3V2a1 1 0 0 1 1-1h5.5zM3 12v-2h2v2zm0 1h2v2H4a1 1 0 0 1-1-1zm3 2v-2h3v2zm4 0v-2h3v1a1 1 0 0 1-1 1zm3-3h-3v-2h3zm-7 0v-2h3v2z"/>
                                    </svg>
                                </a>
                                <a href="javascript:void(0)" v-if="data.value.status == 3" class="hover:text-info" @click="downloadReportTransfer(data.value.uuid)" >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filetype-pdf" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM1.6 11.85H0v3.999h.791v-1.342h.803q.43 0 .732-.173.305-.175.463-.474a1.4 1.4 0 0 0 .161-.677q0-.375-.158-.677a1.2 1.2 0 0 0-.46-.477q-.3-.18-.732-.179m.545 1.333a.8.8 0 0 1-.085.38.57.57 0 0 1-.238.241.8.8 0 0 1-.375.082H.788V12.48h.66q.327 0 .512.181.185.183.185.522m1.217-1.333v3.999h1.46q.602 0 .998-.237a1.45 1.45 0 0 0 .595-.689q.196-.45.196-1.084 0-.63-.196-1.075a1.43 1.43 0 0 0-.589-.68q-.396-.234-1.005-.234zm.791.645h.563q.371 0 .609.152a.9.9 0 0 1 .354.454q.118.302.118.753a2.3 2.3 0 0 1-.068.592 1.1 1.1 0 0 1-.196.422.8.8 0 0 1-.334.252 1.3 1.3 0 0 1-.483.082h-.563zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638z"/>
                                    </svg>
                                </a>
                                <Link :href="`/expenses/${data.value.uuid}`" class="hover:text-info" v-if="data.value.status === 2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cash-coin" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0"/>
                                        <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195z"/>
                                        <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083q.088-.517.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z"/>
                                        <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 6 6 0 0 1 3.13-1.567"/>
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
import { ref, onMounted, computed, reactive, toRaw  } from "vue";
import Vue3Datatable from "@bhplugin/vue3-datatable";
import AppLayout from "@/layouts/app-layout.vue";
import SiteLayout from "@/layouts/app.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import { useI18n } from 'vue-i18n';
import { TransitionRoot, TransitionChild, Dialog, DialogPanel, DialogOverlay } from '@headlessui/vue';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import Swal from "sweetalert2";

const modal2 = ref(false);
defineOptions({
    layout: [SiteLayout, AppLayout],
});
const { t } = useI18n();
const props = defineProps({
    expenses: {
        type: Array,
        required: true,
    },
    centerCosts: {
        type: Array,
        required: true,
    },
    departments: {
        type: Array,
        required: true,
    },
});

    const form = reactive({
        travelReason: '',
        traveldepartment: '',
        travelCenterCost: '',
        traveldestinyFrom: '',
        traveldestinyTo: '',
        travelAdvance: '',
        travelDateStart: '',
        travelDateFinish: ''
    });

    function validateDateStart() {
        const selectedDate = new Date(form.travelDateStart);
        if (selectedDate.getDay() !== 6) {
            Swal.fire({
                icon: "error",
                title: t("expenses.list.error") ,
                html: t("expenses.list.errorDateTravelStart"),
                customClass: "sweet-alerts",
            });
            form.travelDateStart = '';
        }
    }

    function validateDateEnd() {
        const selectedDate = new Date(form.travelDateFinish);
        if (selectedDate.getDay() !== 5) {
            Swal.fire({
                icon: "error",
                title: t("expenses.list.error") ,
                html: t("expenses.list.errorDateTravelEnd"),
                customClass: "sweet-alerts",
            });
            form.travelDateFinish = '';
        }
    }

    function submitForm() {
        Swal.fire({
            title: "Processing...",
            text: "Please wait while the data is being updated.",
            allowOutsideClick: false,
            showConfirmButton: false,
            customClass: "sweet-alerts",
            didOpen: () => {
                Swal.showLoading();
            },
        });
        router.post(`/createExpenses`, form, {
            onSuccess: (page) => {
                console.log("Exitoso");
                Swal.close();
            },
            onError: (error) => {
                console.log(error);
                let errorMessages = "";

                for (const key in error) {
                    const fieldName = key.replace("_id", "");
                    errorMessages += `<p>${error[key]}</p>`;
                }
                Swal.close();
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    html: errorMessages,
                    customClass: "sweet-alerts",
                });
            },
            onFinish: () => {},
        });
    }

    const currentData: any = ref([]);
    const datatable: any = ref(null);
    const searchQuery = ref("");
    const cols = computed(() => [
        { field: "nombre_completo", title: t("expenses.list.name")},
        { field: "reference", title: t("expenses.AdvanceRequestlist.reference")},
        { field: "endingDate", title: t("expenses.list.endingDate") },
        { field: "cc_department", title: t("expenses.list.department")+'/'+t("expenses.list.cc") },
        { field: "totalExpense", title: t("expenses.list.totalExpense") },
        { field: "status_text", title: t("expenses.list.status")},
        {
            field: "actions",
            title: t("expenses.list.actions"),
            sort: false,
            filter: false,
            headerClass: "justify-center",
        },
    ]);

    onMounted(() => {
        currentData.value = [...props.expenses];
    });

    const filteredData = computed(() => {
        if (!searchQuery.value) {
            currentData.value = [...props.expenses];
            return currentData.value; // Return the full list if no query
        }

        const query = searchQuery.value.toLowerCase();
        const filteredExpenses = [];
        const rawExpenses = toRaw(props.expenses);

        rawExpenses.forEach((item, index) => {
            if (item.nombre_completo?.toLowerCase().includes(query) || item.reference?.toLowerCase().includes(query) 
            || item.endingDate?.toLowerCase().includes(query) || item.cc_department?.toLowerCase().includes(query) 
            || item.status_text?.toLowerCase().includes(query)) {
                filteredExpenses.push(item);
            }
        });

        currentData.value = [...filteredExpenses];
        return currentData.value;
    });

    const formatStatus = (status) => {

        if (status === 0) {
            return 'Proceso';
        } else if (status === 1 ) {
            return 'Por aprobar';
        }else{
            return 'Aprobado';
        }

    };

    const formatDateRange = (data) => {
        const currentDate = new Date(data);
        currentDate.setDate(currentDate.getDate() +1);
        const sixDaysAgoDate = new Date(currentDate);
        sixDaysAgoDate.setDate(currentDate.getDate() - 6);

        const formatDate = (date) => {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${day}-${month}-${year}`;
        };

        const formattedCurrentDate = formatDate(currentDate);
        const formattedSixDaysAgoDate = formatDate(sixDaysAgoDate);

        return `${formattedSixDaysAgoDate} - ${formattedCurrentDate}`;
    };

    const formatDateNormal = (date) => {
        if(date != null){
            const currentDate = new Date(date);
            currentDate.setDate(currentDate.getDate() +1);
            const year = currentDate.getFullYear();
            const month = String(currentDate.getMonth() + 1).padStart(2, '0');
            const day = String(currentDate.getDate()).padStart(2, '0');
            return `${day}-${month}-${year}`;
        }else{
            return '';
        }
        
    };

    function classStatus(status){
        if(status == 0)
            return 'bg-yellow-500';
        if(status == 1)
            return 'bg-green-500';
        if(status == 2)
            return 'bg-blue-500'
        if(status == 3)
            return 'bg-blue-500'
    }

    function formatName(value){
        if(!value.apellido_materno)
            value.apellido_materno = '';
        return value.nombre + ' ' + value.apellido_paterno + ' ' + value.apellido_materno;
    }

    function downloadReportTransfer(id) {
        const url = `/transferRequestReports/${id}/file`;
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

    function downloadReportExpense(id) {
        const url = `/expensesReportExcel/${id}`;
        window.location.href = url;
        Swal.fire({
            title: t("report.alert.generatingExcelTitle"),
            text: t("report.alert.generatingExcelText"),
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
