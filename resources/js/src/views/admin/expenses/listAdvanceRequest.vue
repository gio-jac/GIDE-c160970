<template>
    <Head title="Solicitud de anticipos" />
    <div>
        <div>
            <div
                class="panel px-0 pb-1.5 border-[#e0e6ed] dark:border-[#1b2e4b]"
            >
                <div class="datatable invoice-table">
                    <div class="mb-4.5 px-5 flex md:items-center md:flex-row flex-col gap-5">
                        <div class="ltr:ml-auto rtl:mr-auto flex">
                            <input v-model="search" type="text" class="form-input" :placeholder="$t('user.index.searchPlaceholder')" />
                        </div>
                    </div>

                    <vue3-datatable
                        ref="datatable"
                        :rows="currentData"
                        :columns="cols"
                        :totalRows="currentData?.length"
                        :hasCheckbox="false"
                        :sortable="true"
                        :search="search"
                        :columnFilter="true"
                        skin="whitespace-nowrap bh-table-hover"
                        firstArrow='<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M13 19L7 12L13 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path opacity="0.5" d="M16.9998 19L10.9998 12L16.9998 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>'
                        lastArrow='<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M11 19L17 12L11 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path opacity="0.5" d="M6.99976 19L12.9998 12L6.99976 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg> '
                        previousArrow='<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M15 5L9 12L15 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>'
                        nextArrow='<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>'
                    >

                        <template #nombre="data">
                            {{ formatName(data.value) }}
                        </template>
                        <template #requestDate="data">
                            {{ formatDateNormal(data.value.requestDate) }}
                        </template>
                        <template #depositDate="data">
                            {{ formatDateReference(data.value.depositDate) }}
                        </template>

                        <template #status="data">
                            <div class="flex items-center font-semibold">
                                <span
                                    class="badge"
                                    :class="[ classStatus(data.value.status) ]"
                                    >{{ formatStatus(data.value.status) }}</span
                                >
                            </div>
                        </template>
                        
                        <template #actions="data">
                            <div class="flex gap-4 items-center justify-center">
                                <button type="button" class="btn btn-warning" @click="selectRow(data.value)" v-if="data.value.status === 0">
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
                                <button type="button" class="btn btn-info" @click="selectRowSearch(data.value)" v-else-if="data.value.status === 1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                                    </svg>
                                </button>
                                <a
                                    href="javascript:void(0)"
                                    v-if="data.value.status === 1"
                                    class="hover:text-info"
                                    @click="showDownloadMessage(data.value.id)"
                                >
                                    <svg
                                        fill="#000000"
                                        height="24px"
                                        width="24px"
                                        version="1.1"
                                        id="Capa_1"
                                        xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                        viewBox="0 0 58 58"
                                        xml:space="preserve"
                                    >
                                        <g>
                                            <path
                                                stroke="currentColor"
                                                fill="currentColor"
                                                d="M50.95,12.187l-0.771-0.771L40.084,1.321L39.313,0.55C38.964,0.201,38.48,0,37.985,0H8.963C7.777,0,6.5,0.916,6.5,2.926V39
                                            v16.537V56c0,0.837,0.842,1.653,1.838,1.91c0.05,0.013,0.098,0.032,0.15,0.042C8.644,57.983,8.803,58,8.963,58h40.074
                                            c0.16,0,0.319-0.017,0.475-0.048c0.052-0.01,0.1-0.029,0.15-0.042C50.658,57.653,51.5,56.837,51.5,56v-0.463V39V13.978
                                            C51.5,13.211,51.408,12.645,50.95,12.187z M47.935,12H39.5V3.565L47.935,12z M8.963,56c-0.071,0-0.135-0.026-0.198-0.049
                                            C8.609,55.877,8.5,55.721,8.5,55.537V41h41v14.537c0,0.184-0.109,0.339-0.265,0.414C49.172,55.974,49.108,56,49.037,56H8.963z
                                            M8.5,39V2.926C8.5,2.709,8.533,2,8.963,2h28.595C37.525,2.126,37.5,2.256,37.5,2.391V14h11.609c0.135,0,0.264-0.025,0.39-0.058
                                            c0,0.015,0.001,0.021,0.001,0.036V39H8.5z"
                                            />
                                            <path
                                                stroke="currentColor"
                                                fill="currentColor"
                                                d="M22.042,44.744c-0.333-0.273-0.709-0.479-1.128-0.615c-0.419-0.137-0.843-0.205-1.271-0.205h-2.898V54h1.641v-3.637h1.217
                                            c0.528,0,1.012-0.077,1.449-0.232s0.811-0.374,1.121-0.656c0.31-0.282,0.551-0.631,0.725-1.046c0.173-0.415,0.26-0.877,0.26-1.388
                                            c0-0.483-0.103-0.918-0.308-1.306S22.375,45.018,22.042,44.744z M21.42,48.073c-0.101,0.278-0.232,0.494-0.396,0.649
                                            c-0.164,0.155-0.344,0.267-0.54,0.335c-0.196,0.068-0.395,0.103-0.595,0.103h-1.504v-3.992h1.23c0.419,0,0.756,0.066,1.012,0.198
                                            c0.255,0.132,0.453,0.296,0.595,0.492c0.141,0.196,0.234,0.401,0.28,0.615c0.045,0.214,0.068,0.403,0.068,0.567
                                            C21.57,47.451,21.52,47.795,21.42,48.073z"
                                            />
                                            <path
                                                stroke="currentColor"
                                                fill="currentColor"
                                                d="M31.954,45.4c-0.424-0.446-0.957-0.805-1.6-1.073s-1.388-0.403-2.235-0.403h-3.035V54h3.814
                                            c0.127,0,0.323-0.016,0.588-0.048c0.264-0.032,0.556-0.104,0.875-0.219c0.319-0.114,0.649-0.285,0.991-0.513
                                            s0.649-0.54,0.923-0.937s0.499-0.889,0.677-1.477s0.267-1.297,0.267-2.126c0-0.602-0.105-1.188-0.314-1.757
                                            C32.694,46.355,32.378,45.847,31.954,45.4z M30.758,51.73c-0.492,0.711-1.294,1.066-2.406,1.066h-1.627v-7.629h0.957
                                            c0.784,0,1.422,0.103,1.914,0.308s0.882,0.474,1.169,0.807s0.48,0.704,0.581,1.114c0.1,0.41,0.15,0.825,0.15,1.244
                                            C31.496,49.989,31.25,51.02,30.758,51.73z"
                                            />
                                            <polygon
                                                stroke="currentColor"
                                                fill="currentColor"
                                                points="35.598,54 37.266,54 37.266,49.461 41.477,49.461 41.477,48.34 37.266,48.34 37.266,45.168 41.9,45.168 
                                            41.9,43.924 35.598,43.924 	"
                                            />
                                            <path
                                                stroke="currentColor"
                                                fill="currentColor"
                                                d="M38.428,22.961c-0.919,0-2.047,0.12-3.358,0.358c-1.83-1.942-3.74-4.778-5.088-7.562c1.337-5.629,0.668-6.426,0.373-6.802
                                            c-0.314-0.4-0.757-1.049-1.261-1.049c-0.211,0-0.787,0.096-1.016,0.172c-0.576,0.192-0.886,0.636-1.134,1.215
                                            c-0.707,1.653,0.263,4.471,1.261,6.643c-0.853,3.393-2.284,7.454-3.788,10.75c-3.79,1.736-5.803,3.441-5.985,5.068
                                            c-0.066,0.592,0.074,1.461,1.115,2.242c0.285,0.213,0.619,0.326,0.967,0.326h0c0.875,0,1.759-0.67,2.782-2.107
                                            c0.746-1.048,1.547-2.477,2.383-4.251c2.678-1.171,5.991-2.229,8.828-2.822c1.58,1.517,2.995,2.285,4.211,2.285
                                            c0.896,0,1.664-0.412,2.22-1.191c0.579-0.811,0.711-1.537,0.39-2.16C40.943,23.327,39.994,22.961,38.428,22.961z M20.536,32.634
                                            c-0.468-0.359-0.441-0.601-0.431-0.692c0.062-0.556,0.933-1.543,3.07-2.744C21.555,32.19,20.685,32.587,20.536,32.634z
                                            M28.736,9.712c0.043-0.014,1.045,1.101,0.096,3.216C27.406,11.469,28.638,9.745,28.736,9.712z M26.669,25.738
                                            c1.015-2.419,1.959-5.09,2.674-7.564c1.123,2.018,2.472,3.976,3.822,5.544C31.031,24.219,28.759,24.926,26.669,25.738z
                                            M39.57,25.259C39.262,25.69,38.594,25.7,38.36,25.7c-0.533,0-0.732-0.317-1.547-0.944c0.672-0.086,1.306-0.108,1.811-0.108
                                            c0.889,0,1.052,0.131,1.175,0.197C39.777,24.916,39.719,25.05,39.57,25.259z"
                                            />
                                        </g>
                                    </svg>
                                </a>
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
                                                            <form @submit.prevent="submitForm">
                                                                <h1 style="font-size: 18px; font-weight: 800;">Datos generales</h1>
                                                                <div style="border: solid 1px; padding: 15px; margin-top: 20px">
                                                                    <label >{{ $t('expenses.AdvanceRequestlist.applicant') }} {{ form.name }}</label>
                                                                    <label >{{ $t('expenses.AdvanceRequestlist.NoEmp') }} {{form.emp}}</label>
                                                                    <label >{{ $t('expenses.AdvanceRequestlist.purposeTravel') }} {{form.purposeTravel}}</label>
                                                                    <label >{{ $t('expenses.AdvanceRequestlist.destiny') }}: {{form.destinyFrom}}</label>
                                                                    <label >{{ $t('expenses.AdvanceRequestlist.destinyTo') }}: {{form.destinyTo}}</label>
                                                                    <label >{{ $t('expenses.AdvanceRequestlist.dateTravel') }} {{ formatDateRange(form.endingDate) }}</label>
                                                                    <label >{{ $t('expenses.AdvanceRequestlist.payAdvanceTravel') }} ${{form.payAdvance}}</label>
                                                                    <label >{{ $t('expenses.AdvanceRequestlist.applicant') }} {{formatDateNormal(form.requestDate)}}</label>
                                                                    <label >{{ $t('expenses.AdvanceRequestlist.CCTravel') }} {{form.cc}}</label>
                                                                    <label >{{ $t('expenses.AdvanceRequestlist.departmentTravel') }} {{form.department}}</label>
                                                                </div>
                                                                <div class="flex mt-5">
                                                                    <label >{{ $t('expenses.AdvanceRequestlist.dateDepositTravel') }}</label>
                                                                </div>
                                                                <div class="flex justify-end items-center mt-2">
                                                                    <input type="date" class="form-input flex-1" id="depositDate" v-model="form.depositDate" required />
                                                                </div>
                                                                <div class="flex mt-5">
                                                                    <label >{{ $t('expenses.AdvanceRequestlist.referenceTravel') }}</label>
                                                                </div>
                                                                <div class="flex justify-end items-center mt-2">
                                                                    <button type="button" @click="generarReferencia()" class="btn btn-outline-primary mr-8">{{ $t('expenses.AdvanceRequestlist.trigger') }}</button>
                                                                    <input type="text" class="form-input flex-1" id="reference" v-model="form.reference" required />
                                                                </div>
                                                                <div class="flex mt-5">
                                                                    <label >{{ $t('expenses.AdvanceRequestlist.approveByAdvancePay') }}</label>
                                                                </div>
                                                                <div class="flex justify-end items-center mt-2">
                                                                    <input type="text" class="form-input flex-1"  v-model="form.approveBy" />
                                                                </div>
                                                                <div class="flex mt-5">
                                                                    <label >{{ $t('expenses.AdvanceRequestlist.comentTravel') }}</label>
                                                                </div>
                                                                <div class="flex justify-end items-center mt-2">
                                                                    <input type="text" class="form-input flex-1" id="coment" v-model="form.coment" />
                                                                </div>
                                                                <div class="flex justify-end items-center mt-8">
                                                                    <button type="submit" class="btn btn-primary" style="margin-right: 10px;">{{ $t("expenses.AdvanceRequestlist.authorize") }}</button>
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
                                                            <form @submit.prevent="submitForm">
                                                                <h1 style="font-size: 18px; font-weight: 800;">Datos generales</h1>
                                                                <div style="border: solid 1px; padding: 15px; margin-top: 20px">
                                                                    <label >{{ $t('expenses.AdvanceRequestlist.applicant') }} {{ form.name }}</label>
                                                                    <label >{{ $t('expenses.AdvanceRequestlist.NoEmp') }} {{form.emp}}</label>
                                                                    <label >{{ $t('expenses.AdvanceRequestlist.purposeTravel') }} {{form.purposeTravel}}</label>
                                                                    <label >{{ $t('expenses.AdvanceRequestlist.destiny') }}: {{form.destinyFrom}}</label>
                                                                    <label >{{ $t('expenses.AdvanceRequestlist.destinyTo') }}: {{form.destinyTo}}</label>
                                                                    <label >{{ $t('expenses.AdvanceRequestlist.dateTravel') }} {{ formatDateRange(form.endingDate) }}</label>
                                                                    <label >{{ $t('expenses.AdvanceRequestlist.payAdvanceTravel') }} ${{form.payAdvance}}</label>
                                                                    <label >{{ $t('expenses.AdvanceRequestlist.applicant') }} {{formatDateNormal(form.requestDate)}}</label>
                                                                    <label >{{ $t('expenses.AdvanceRequestlist.CCTravel') }} {{form.cc}}</label>
                                                                    <label >{{ $t('expenses.AdvanceRequestlist.departmentTravel') }} {{form.department}}</label>
                                                                    <label >{{ $t('expenses.AdvanceRequestlist.dateDepositTravel') }} {{formatDateReference(form.depositDate)}}</label>
                                                                    <label >{{ $t('expenses.AdvanceRequestlist.referenceTravel') }} {{form.reference}}</label>
                                                                    <label >{{ $t('expenses.AdvanceRequestlist.comentTravel') }} {{form.coment}}</label>
                                                                </div>
                                                                
                                                                <div class="flex justify-end items-center mt-8">
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
    import { ref, onMounted, computed, reactive } from "vue";
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
        advanceRequests: {
            type: Array,
            required: true,
        },
    });

    const currentData: any = ref(null);
    const form = reactive({
        id: '',
        reference: '',
        name: '',
        nombre: '',
        apellido_paterno: '',
        apellido_materno: '',
        emp: '',
        purposeTravel: '',
        destinyFrom: '',
        destinyTo: '',
        endingDate: '',
        depositDate: '',
        payAdvance: '',
        requestDate: '',
        cc: '',
        approveBy: '',
        department: '',
        coment: ''
    });

    const selectRow = (data) => {
        form.id = data.id;
        form.reference = ''; 
        form.coment = ''; 
        form.depositDate =  ''; 
        form.name = data.nombre + ' ' + data.apellido_paterno + ' ' + data.apellido_materno;
        form.nombre = data.nombre;
        form.apellido_paterno = data.apellido_paterno;
        form.apellido_materno = data.apellido_materno;
        form.emp = data.emp; 
        form.purposeTravel = data.purposeTravel; 
        form.destinyFrom =  data.destinyFrom; 
        form.destinyTo =  data.destinyTo; 
        form.endingDate = data.endingDate; 
        form.payAdvance = data.payAdvance; 
        form.requestDate =  data.requestDate; 
        form.approveBy = data.approveBy;
        form.cc = data.cc + " " + data.name; 
        form.department =  data.department; 
        modal2.value = true;
    };

    const selectRowSearch = (data) => {
        form.id = data.id;
        form.reference = data.reference; 
        form.coment = data.coment; 
        form.name = data.nombre + ' ' + data.apellido_paterno + ' ' + data.apellido_materno;
        form.nombre = data.nombre;
        form.apellido_paterno = data.apellido_paterno;
        form.apellido_materno = data.apellido_materno;
        form.emp = data.emp; 
        form.purposeTravel = data.purposeTravel; 
        form.destinyFrom =  data.destinyFrom; 
        form.destinyTo =  data.destinyTo; 
        form.endingDate = data.endingDate; 
        form.payAdvance = data.payAdvance; 
        form.requestDate =  data.requestDate; 
        form.approveBy =  data.approveBy; 
        form.depositDate =  data.depositDate; 
        form.cc = data.cc + " " + data.name; 
        form.department =  data.department; 
        modal3.value = true;
    };

    
    
    
    const datatable: any = ref(null);
    const search = ref("");
    const cols = computed(() => [
        { field: "nombre", title: t("expenses.AdvanceRequestlist.nombre"), filter: false},
        { field: "destinyTo", title: t("expenses.AdvanceRequestlist.destinyTo"), filter: false },
        { field: "payAdvance", title: t("expenses.AdvanceRequestlist.payAdvance"), filter: false },
        { field: "requestDate", title: t("expenses.liAdvanceRequestlistst.requestDate"), filter: false },
        { field: "reference", title: t("expenses.AdvanceRequestlist.reference"), filter: false },
        { field: "status", title: t("expenses.AdvanceRequestlist.status"), filter: false},
        {
            field: "actions",
            title: t("expenses.AdvanceRequestlist.actions"),
            sort: false,
            filter: false,
            headerClass: "justify-center",
        },
    ]);

    onMounted(() => {
        currentData.value = [...props.advanceRequests];
    });

    const formatStatus = (status) => {
        if (status === 0) {
            return 'Proceso';
        } else if (status === 1 ) {
            return 'Aprovado';
        }else{
            return 'Negado';
        }
    };

    function classStatus(status){
        if(status == 0)
            return 'bg-yellow-500';
        if(status == 1)
            return 'bg-green-500';
        if(status == 2)
            return 'bg-red-500'
    }

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
        const currentDate = new Date(date);
        const year = currentDate.getFullYear();
        const month = String(currentDate.getMonth() + 1).padStart(2, '0');
        const day = String(currentDate.getDate()).padStart(2, '0');
        return `${day}-${month}-${year}`;
    };

    const formatDateReference = (date) => {
        if(date != null){
            const currentDate = new Date(date+' 13:00:00');
            const year = currentDate.getFullYear();
            const month = String(currentDate.getMonth() + 1).padStart(2, '0');
            const day = String(currentDate.getDate()).padStart(2, '0');
            return `${day}.${month}.${year}`;
        }else{
            return '';
        }
        
    };

    function formatName(value){
        if(!value.apellido_materno)
            value.apellido_materno = '';
        return value.nombre + ' ' + value.apellido_paterno + ' ' + value.apellido_materno;
    }

    function generarReferencia(){
        if(form.depositDate == null)
            Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    html: 'Tiene que seleccionar una fecha de deposito',
                    customClass: "sweet-alerts",
            });
        else
            form.reference = form.emp + ' ' + form.nombre.charAt(0) + form.apellido_paterno + ' ' + form.destinyTo + ' ' + formatDateReference(form.depositDate);
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
        router.post(`/updateAdvancePayExpenses`, form, {
            onSuccess: (page) => {
                Swal.close();
                currentData.value = page.props.advanceRequests;
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

    function showDownloadMessage(id) {
        const url = `/advanceRequestReports/${id}/file`;
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
