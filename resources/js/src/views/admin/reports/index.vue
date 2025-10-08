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
                        <div class="ltr:ml-auto rtl:mr-auto flex">
                            <a v-if="user.type === 1" class="btn btn-outline-dark px-[10px] py-0 w-[45px] h-[37px] mr-2" :href="`/reports/export/${ filterDate }`">
                                <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 50 50" width="50px" height="50px"><path d="M 28.875 0 C 28.855469 0.0078125 28.832031 0.0195313 28.8125 0.03125 L 0.8125 5.34375 C 0.335938 5.433594 -0.0078125 5.855469 0 6.34375 L 0 43.65625 C -0.0078125 44.144531 0.335938 44.566406 0.8125 44.65625 L 28.8125 49.96875 C 29.101563 50.023438 29.402344 49.949219 29.632813 49.761719 C 29.859375 49.574219 29.996094 49.296875 30 49 L 30 44 L 47 44 C 48.09375 44 49 43.09375 49 42 L 49 8 C 49 6.90625 48.09375 6 47 6 L 30 6 L 30 1 C 30.003906 0.710938 29.878906 0.4375 29.664063 0.246094 C 29.449219 0.0546875 29.160156 -0.0351563 28.875 0 Z M 28 2.1875 L 28 6.53125 C 27.867188 6.808594 27.867188 7.128906 28 7.40625 L 28 42.8125 C 27.972656 42.945313 27.972656 43.085938 28 43.21875 L 28 47.8125 L 2 42.84375 L 2 7.15625 Z M 30 8 L 47 8 L 47 42 L 30 42 L 30 37 L 34 37 L 34 35 L 30 35 L 30 29 L 34 29 L 34 27 L 30 27 L 30 22 L 34 22 L 34 20 L 30 20 L 30 15 L 34 15 L 34 13 L 30 13 Z M 36 13 L 36 15 L 44 15 L 44 13 Z M 6.6875 15.6875 L 12.15625 25.03125 L 6.1875 34.375 L 11.1875 34.375 L 14.4375 28.34375 C 14.664063 27.761719 14.8125 27.316406 14.875 27.03125 L 14.90625 27.03125 C 15.035156 27.640625 15.160156 28.054688 15.28125 28.28125 L 18.53125 34.375 L 23.5 34.375 L 17.75 24.9375 L 23.34375 15.6875 L 18.65625 15.6875 L 15.6875 21.21875 C 15.402344 21.941406 15.199219 22.511719 15.09375 22.875 L 15.0625 22.875 C 14.898438 22.265625 14.710938 21.722656 14.5 21.28125 L 11.8125 15.6875 Z M 36 20 L 36 22 L 44 22 L 44 20 Z M 36 27 L 36 29 L 44 29 L 44 27 Z M 36 35 L 36 37 L 44 37 L 44 35 Z"/></svg>
                            </a>
                            <select class="form-select text-white-dark" @change="selectFilterReportsDate" :disabled="loadingData" v-model="filterDate">
                                <option value="3months" selected>Last 3 months</option>
                                <option value="all">All time</option>
                                <option v-for="year in catalogYearReports" :key="year" :value="year.year">
                                    {{ year.year }}
                                </option>
                            </select>
                            <select
                                class="form-select text-white-dark"
                                v-model="selectedCountry"
                            >
                                <option value="">{{ $t("user.index.all") }}</option>
                                <option
                                    v-for="country in props.catalogCountry"
                                    :key="country.id"
                                    :value="country.id"
                                >
                                    {{ country.name }}
                                </option>
                            </select>
                            <input
                                v-model="search"
                                type="text"
                                class="form-input"
                                :placeholder="
                                    $t('user.index.searchPlaceholder')
                                "
                            />
                        </div>
                    </div>

                    <vue3-datatable
                        :key="reports"
                        ref="datatable"
                        :rows="currentData"
                        :columns="cols"
                        :totalRows="currentData?.length"
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
                            {{
                                $t(
                                    "catalogs.status." + data.value.status_id,
                                    data.value.status &&
                                        data.value.status.status
                                        ? data.value.status.status
                                        : "N/A"
                                )
                            }}
                        </template>
                        <template #machines="data">
                            {{
                                data.value.machines
                            }}
                        </template>
                        <template #created_at="data">
                            {{ formatDate(data.value.created_at) }}
                        </template>
                        <!--<template #assigned_to="data">
                            {{ fullName(data.value.user) }}
                        </template>-->
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
                                    <!--
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" id="file">
                                        <path 
                                            fill="currentColor" 
                                            stroke="currentColor" 
                                            stroke-width="0.5"
                                            opacity="0.7"
                                            d="M19.714 6.149 14.259.364c-.189-.199-.456-.363-.73-.363H1.979C.874.001 0 1.001 0 2.105v7c0 .552.437.896.99.896h.004c.553 0 1.006-.344 1.006-.896v-6c0-.552.427-1.104.98-1.104H12v4.104c0 1.105.874 1.896 1.98 1.896H18v1.104c0 .552.437.896.99.896h.004c.553 0 1.006-.344 1.006-.896V6.838c0-.257-.109-.503-.286-.689zM3.979 15.105a1 1 0 0 0-1-1h-1v2h1a1 1 0 0 0 1-1zm1.996-.266a3.002 3.002 0 0 1-2.996 3.162H2v1.104c0 .552-.453.896-1.006.896H.989c-.552 0-.989-.344-.989-.896v-6c0-.552.427-1.104.98-1.104h1.83c1.624 0 3.08 1.216 3.165 2.838zm5.025.266c0-.552-.469-1.104-1.02-1.104H9v4h.98c.551 0 1.02-.344 1.02-.896v-2zm2-.104v2c0 1.65-1.35 3-3 3H7.895A.895.895 0 0 1 7 19.105V12.98c0-.541.438-.979.98-.979H10c1.65 0 3 1.35 3 3zm7-1.974v.026c0 .552-.469.948-1.02.948H16v2h2.98A1.04 1.04 0 0 1 20 17.027v.026c0 .552-.469.948-1.02.948H16v1.104c0 .552-.453.896-1.006.896h-.005c-.552 0-.989-.344-.989-.896v-6c0-.552.427-1.104.98-1.104h4A1.04 1.04 0 0 1 20 13.027z">
                                        </path>
                                    </svg>-->
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
import { ref, computed, watch } from "vue";
import Vue3Datatable from "@bhplugin/vue3-datatable";
import AppLayout from "@/layouts/app-layout.vue";
import SiteLayout from "@/layouts/app.vue";
import { Head, Link, router, usePage } from "@inertiajs/vue3";
import { useI18n } from "vue-i18n";
import { useAppStore } from "@/stores/index";
import Swal from "sweetalert2";

const store = useAppStore();
const { t } = useI18n();
const page = usePage();
const user = computed(() => page.props.auth);
defineOptions({
    layout: [SiteLayout, AppLayout],
});
const props = defineProps({
    reports: {
        type: Array,
        required: true,
    },
    catalogCountry: {
        type: Array,
        required: true,
    },
    catalogYearReports: {
        type: Array,
        required: true,
    }
});
const search = ref("");
const selectedCountry = ref("");
const loadingData = ref(false);
const filterDate = ref("3months");

const transformReport = (report) => ({
    ...report,
    machines: report.machines.filter((machine) => machine.only_dt === 0).map((machine) => machine.serial).join(', '),
});

const currentData = computed(() => { 
    const countryId = selectedCountry.value ? parseInt(selectedCountry.value) : null;

    return props.reports
        .filter(report => !countryId || report.branch.city.country_id === countryId)
        .map(transformReport);
});

const selectFilterReportsDate = (event) => {
    loadingData.value = true;
    router.get('/reports/filterByDate', { filter: event.target.value }, {
        preserveState: true,
        replace: true,
        only: ['reports'],
        onFinish: () => {
            loadingData.value = false;
        }
    });
};

watch(
    () => props.reports,
    () => {
        search.value = '';
        selectedCountry.value = '';
    }
);

const datatable: any = ref(null);
const cols = computed(() => {
    let baseCols = [
        { field: "id", title: "ID" },
        { field: "complete_id", title: t("report.index.col.fileName") },
        { field: "status", title: t("report.index.col.status") },
        { field: "machines", title: t("report.index.col.idmachines") },
        { field: "created_at", title: t("report.index.col.creationDate") },
        {
            field: "actions",
            title: t("user.index.col.actions"),
            sort: false,
            headerClass: "justify-center",
        },
    ]

    if (page.props.auth.type === 1) {
        baseCols.splice(4, 0, { field: "user_full_name", title: t("report.index.col.assigned") });
    }
    
    return baseCols;
});
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
    const options = { year: "numeric", month: "2-digit", day: "2-digit" };
    return new Date(dateString).toLocaleDateString("es", options);
};

const fullName = (user) => {
    return [user.nombre, user.apellido_paterno, user.apellido_materno]
        .filter(Boolean)
        .join(" ");
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
