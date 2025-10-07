<template>
    <Head title="Centros de costos" />
    <div>
        <div>
            <div
                class="panel px-0 pb-1.5 border-[#e0e6ed] dark:border-[#1b2e4b]"
            >
                <div class="datatable invoice-table">
                    <div class="mb-4.5 px-5 flex md:items-center md:flex-row flex-col gap-5">
                        <div class="flex">
                            <button 
                                @click="agregarCC"
                                class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-600"
                            >
                                Agregar Centro de Costos
                            </button>
                        </div>
                        <div class="ltr:ml-auto rtl:mr-auto flex">
                            <input v-model="searchQuery" type="text" class="form-input" :placeholder="$t('user.index.searchPlaceholder')" />
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

                        <template #nombre="data">
                            {{ data.cc }}
                        </template>
                        <template #requestDate="data">
                            {{ data.name }}
                        </template>

                        <template #actions="data" >
                            <div class="flex gap-4 items-center justify-center">
                                <button type="button"  @click="selectRow(data.value)" >
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
                                </button>
                                
                                <button type="button"  @click="selectRowDelete(data.value)" >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                    </svg>
                                </button>    
                            </div>
                        </template>
                    </vue3-datatable>

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
                                                        
                                                        </div>
                                                        <div class="p-5">
                                                            <form @submit.prevent="submitFormUpdate">
                                                                <h1 style="font-size: 18px; font-weight: 800;">Modificar centro de costos</h1>
                                                                <div style="padding: 15px; margin-top: 10px">
                                                                    <div class="flex mt-5">
                                                                        <label >No. de centro de costo</label>
                                                                    </div>
                                                                    <div class="flex justify-end items-center mt-2">
                                                                        <input type="text" class="form-input flex-1" id="coment" v-model="form.cc" />
                                                                    </div>
                                                                    <div class="flex mt-5">
                                                                        <label >Nombre</label>
                                                                    </div>
                                                                    <div class="flex justify-end items-center mt-2">
                                                                        <input type="text" class="form-input flex-1" id="coment" v-model="form.name" />
                                                                    </div>
                                                                </div>
                                                                <div class="flex justify-end items-center mt-8">
                                                                    <button type="submit" class="btn btn-primary" style="margin-right: 10px;">Guardar</button>
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

                    <TransitionRoot appear :show="modal3" as="template">
                        <Dialog as="div" @close="modal3 = false" class="relative z-[51]">
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
                                                            @click="modal3 = false"
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
                                                        
                                                        </div>
                                                        <div class="p-5">
                                                            <form @submit.prevent="submitFormAdd">
                                                                <div style="padding: 15px; margin-top: 0px">
                                                                    <h1 style="font-size: 18px; font-weight: 800;">Agregar centro de costos</h1>
                                                                    <div class="flex mt-5">
                                                                        <label >No. de centro de costo</label>
                                                                    </div>
                                                                    <div class="flex justify-end items-center mt-2">
                                                                        <input type="text" class="form-input flex-1" id="coment" v-model="form.cc" />
                                                                    </div>
                                                                    <div class="flex mt-5">
                                                                        <label >Nombre</label>
                                                                    </div>
                                                                    <div class="flex justify-end items-center mt-2">
                                                                        <input type="text" class="form-input flex-1" id="coment" v-model="form.name" />
                                                                    </div>
                                                                </div>
                                                                <div class="flex justify-end items-center mt-8">
                                                                    <button type="submit" class="btn btn-primary" style="margin-right: 10px;">Guardar</button>
                                                                    <button type="button" @click="modal3 = false" class="btn btn-outline-danger ">{{ $t("expenses.list.close") }}</button>
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
            </div>
        </div>
    </div>
</template>
<script lang="ts" setup>
    import { ref, onMounted, computed, reactive, toRaw } from "vue";
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

    defineOptions({
        layout: [SiteLayout, AppLayout],
    });

    const modal2 = ref(false);
    const modal3 = ref(false);

    const { t } = useI18n();
    const props = defineProps({
        centerCosts: {
            type: Array,
            required: true,
        }
    });

    const form = reactive({
        id: '',
        cc: '',
        name: '',
        status: ''
    });


    const selectRow = (data) => {
        form.id = data.id;
        form.cc = data.cc; 
        form.name = data.name; 
        modal2.value = true;
    };

    const selectRowDelete = (data) => {
        form.id = data.id;
        form.status = data.status; 

        Swal.fire({
            title: "¿Estás seguro?",
            text: "Esta acción eliminará el centro de costos '"+data.cc +"-"+data.name+"' permanentemente.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "Cancelar",
            customClass: "sweet-alerts",
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Procesando...",
                    text: "Por favor espere mientras se actualizan los datos.",
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    customClass: "sweet-alerts",
                    didOpen: () => {
                        Swal.showLoading();
                    },
                });

                router.post(`/deleteCenterCosts`, form, {
                    onSuccess: (page) => {
                        Swal.close();
                        currentData.value = page.props.centerCosts;
                        modal3.value = false;

                        Swal.fire({
                            icon: "success",
                            title: "Eliminado",
                            text: "El centro de costos ha sido eliminado correctamente.",
                            customClass: "sweet-alerts",
                        });
                    },

                    onError: (error) => {
                        console.log(error);
                        let errorMessages = "";

                        for (const key in error) {
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
                });
            }
        });
    };

    

    function agregarCC (){
        form.cc = ''; 
        form.name = ''; 
        modal3.value = true;
    };

    const currentData: any = ref([]);
    const datatable: any = ref(null);
    const searchQuery = ref("");
    const cols = computed(() => [
        { field: "cc", title: t("expenses.list.cc"), filter: false},
        { field: "name", title: t("expenses.list.name"), filter: false },
        {
            field: "actions",
            title: t("expenses.AdvanceRequestlist.actions"),
            sort: false,
            filter: false,
            headerClass: "justify-center",
        },
    ]);

    
    const filteredData = computed(() => {
        if (!searchQuery.value) {
            currentData.value = [...props.centerCosts];
            return currentData.value; // Return the full list if no query
        }

        const query = searchQuery.value.toLowerCase();
        const filteredcenterCosts = [];
        const rawcenterCosts = toRaw(props.centerCosts);

        rawcenterCosts.forEach((item, index) => {
            if (item.name?.toLowerCase().includes(query) || item.cc?.toLowerCase().includes(query) ) {
                filteredcenterCosts.push(item);
            }
        });

        currentData.value = [...filteredcenterCosts];
        return currentData.value;
    });



    function submitFormAdd() {
        Swal.fire({
            title: "Procesando...",
            text: "Por favor espere mientras se actualizan los datos.",
            allowOutsideClick: false,
            showConfirmButton: false,
            customClass: "sweet-alerts",
            didOpen: () => {
                Swal.showLoading();
            },
        });

        router.post(`/addCenterCosts`, form, {
            onSuccess: (page) => {
                Swal.close();
                currentData.value = page.props.centerCosts;
                modal3.value = false;
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

    function submitFormUpdate() {
        Swal.fire({
            title: "Procesando...",
            text: "Por favor espere mientras se actualizan los datos.",
            allowOutsideClick: false,
            showConfirmButton: false,
            customClass: "sweet-alerts",
            didOpen: () => {
                Swal.showLoading();
            },
        });

        router.post(`/updateCenterCosts`, form, {
            onSuccess: (page) => {
                Swal.close();
                currentData.value = page.props.centerCosts;
                modal2.value = false;
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
   
</script>
