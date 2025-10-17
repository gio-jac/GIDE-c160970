<template>
    <Head title="New Report" />
    <div>
        <div class="flex xl:flex-row flex-col gap-2.5">
            <div class="panel px-0 flex-1 py-6 ltr:xl:mr-6 rtl:xl:ml-6">
                <div class="flex px-4">
                    <div class="w-full">
                        <div class="flex items-center">
                            <label
                                for="formServiceDate"
                                class="w-[140px] text-right mb-0 mr-[10px]"
                                >{{ $t("report.form.serviceDate") }}
                                <span class="text-red-500">*</span></label
                            >

                            <flat-pickr id="formServiceDate" v-model="postForm.service_date" class="form-input flex-1" :config="basic"></flat-pickr>
                        </div>
                    </div>
                </div>
                <div class="flex px-4 mt-4" v-if="user.type === 1">
                    <div class="w-full">
                        <div class="flex items-center">
                            <label
                                for="formUser"
                                class="w-[140px] text-right mb-0 mr-[10px]"
                                >{{ $t("report.form.user") }} <span class="text-red-500">*</span></label
                            >

                            <multiselect
                                v-tippy:user
                                id="formUser"
                                :options="catalogUsers"
                                v-model="form.selectedUser"
                                track-by="id"
                                class="custom-multiselect flex-1"
                                :searchable="true"
                                :placeholder="$t('report.form.default')"
                                :custom-label="
                                    ({ emp, nombre, apellido_paterno }) =>
                                        `${emp} - ${nombre} ${apellido_paterno}`
                                "
                                selected-label=""
                                select-label=""
                                deselect-label=""
                            ></multiselect>
                            <tippy target="user" trigger="focus">Usado para la búsqueda y selección de usuarios, utiliza el siguiente formato:<br>"EMP - Nombre PrimerApellido"</tippy>
                        </div>
                        <template v-if="errors.user_id">
                            <p class="text-danger mt-1 text-center">
                                {{ errors.user_id }}
                            </p>
                        </template>
                    </div>
                </div>
                <div class="flex px-4 mt-4">
                    <div class="w-full">
                        <div class="flex items-center">
                            <label
                                for="formShift"
                                class="w-[140px] text-right mb-0 mr-[10px]"
                                >{{ $t("report.form.shift") }}
                                <span class="text-red-500">*</span></label
                            >

                            <multiselect
                                v-tippy:shift
                                id="formShift"
                                :options="props.catalogShifts"
                                v-model="form.selectedShift"
                                track-by="id"
                                class="custom-multiselect flex-1"
                                :searchable="false"
                                :placeholder="$t('report.form.default')"
                                :custom-label="({ id, name }) => `${$t('catalogs.shift.'+id, name)}`"
                                selected-label=""
                                select-label=""
                                deselect-label=""
                            ></multiselect>
                            <tippy target="shift" trigger="focus">Usado para la selección del turno de la realización del reporte</tippy>
                        </div>
                        <template v-if="errors.shift_id">
                            <p class="text-danger mt-1 text-center">
                                {{ errors.shift_id }}
                            </p>
                        </template>
                    </div>
                </div>
                <div class="flex px-4 mt-4">
                    <div class="w-full">
                        <div class="flex items-center">
                            <label
                                for="formCatalogClient"
                                class="w-[140px] text-right mb-0 mr-[10px]"
                                >Cliente <span class="text-red-500">*</span></label
                            >
                            <multiselect
                                id="formCatalogClient"
                                :options="catalogClients"
                                @select="selectedClientChange"
                                v-model="form.selectedClient"
                                track-by="id"
                                class="custom-multiselect flex-1"
                                :searchable="true"
                                :placeholder="$t('report.form.default')"
                                :custom-label="
                                    ({ name }) =>
                                        `${name}`
                                "
                                selected-label=""
                                select-label=""
                                deselect-label=""
                            ></multiselect>
                        </div>
                    </div>
                </div>
                <div class="flex px-4 mt-4">
                    <div class="w-full">
                        <div class="flex items-center">
                            <label
                                for="formCatalogBranches"
                                class="w-[140px] text-right mb-0 mr-[10px]"
                                >Sucursal <span class="text-red-500">*</span></label
                            >
                            <multiselect
                                @select="() => form.selectedContact = null"
                                id="formCatalogBranches"
                                :options="branchesCatalog"
                                v-model="form.selectedBranch"
                                track-by="id"
                                class="custom-multiselect flex-1"
                                :searchable="true"
                                :placeholder="$t('report.form.default')"
                                :custom-label="
                                    ({ address,city }) =>
                                        ` ${city.name} - ${address}`
                                "
                                :disabled="branchesCatalog.length === 0"
                                selected-label=""
                                select-label=""
                                deselect-label=""
                            ></multiselect>
                        </div>
                    </div>
                </div>
                <div class="flex px-4 mt-4">
                    <div class="w-full">
                        <div class="flex items-center">
                            <label
                                for="formCatalogContact"
                                class="w-[140px] text-right mb-0 mr-[10px]"
                                >Contacto <span class="text-red-500">*</span></label
                            >
                            <multiselect
                                id="formCatalogContact"
                                :options="form.selectedBranch ? form.selectedBranch.branch_managers : []"
                                v-model="form.selectedContact"
                                track-by="id"
                                class="custom-multiselect flex-1"
                                :searchable="true"
                                :placeholder="$t('report.form.default')"
                                :custom-label="
                                    ({ name }) =>
                                        ` ${name}`
                                "
                                :disabled="!form.selectedBranch"
                                selected-label=""
                                select-label=""
                                deselect-label=""
                            ></multiselect>
                        </div>
                    </div>
                </div>


                <!-- 
                <div class="flex px-4 mt-4">
                    <div class="w-full">
                        <div class="flex items-center">
                            <label
                                for="formMachineModel"
                                class="w-[140px] text-right mb-0 mr-[10px]"
                                >{{ $t("report.form.machineModel") }}
                                <span class="text-red-500">*</span></label
                            >

                            <multiselect
                                id="formMachineModel"
                                :options="catalogMachineModels"
                                @select="machineModelChange"
                                v-model="form.selectedMachineModel"
                                class="custom-multiselect flex-1"
                                :searchable="true"
                                :placeholder="$t('report.form.default')"
                                :custom-label="
                                    ({ model }) =>
                                        `${model}`
                                "
                                selected-label=""
                                select-label=""
                                deselect-label=""
                            ></multiselect>
                        </div>
                    </div>
                </div>
                <div class="flex px-4 mt-4">
                    <div class="w-full">
                        <div class="flex items-center">
                            <label
                                for="formMachine"
                                class="w-[140px] text-right mb-0 mr-[10px]"
                                >{{ $t("report.form.machineSerial") }}
                                <span class="text-red-500">*</span></label
                            >

                            <multiselect
                                @select="machineChange"
                                id="formMachine"
                                :options="catalogMachines"
                                v-model="form.selectedSearchMachine"
                                class="custom-multiselect flex-1"
                                :searchable="true"
                                :placeholder="$t('report.form.default')"
                                :custom-label="
                                    ({ serial }) =>
                                        `${serial}`
                                "
                                selected-label=""
                                select-label=""
                                deselect-label=""
                            ></multiselect>
                            <tippy target="machineid" trigger="focus">Usado para la búsqueda y selección de máquina, utiliza el siguiente formato:<br>"Serial - Modelo de máquina"</tippy>
                            <div class="w-[50px] flex justify-end pr-[15px]">
                                <div v-if="loaders.machines.waiting" class="waiting-loader"></div>
                                <div v-if="loaders.machines.searching" class="searching-loader mr-[-9px]"></div>
                            </div>
                        </div>
                        <template v-if="errors.machines">
                            <p class="text-danger mt-1 text-center">
                                {{ errors.machines }}
                            </p>
                        </template>
                    </div>
                </div>-->
                
                
                <hr class="border-[#e0e6ed] dark:border-[#1b2e4b] my-6" />

                <div class="mt-6 px-4">
                    <div class="flex items-center">
                        <div id="dataset-tabs" class="flex-1">
                            <div
                                class="flex items-end gap-1 overflow-x-auto border-b border-[#e0e6ed] dark:border-[#1b2e4b] pb-0.5"
                            >
                                <!-- Active tab -->
                                <button
                                    @click="selectedTab = index"
                                    v-for="(tab, index) in tabs"
                                    :key="tab.id"
                                    type="button"
                                    class="-mb-px px-3 h-9 inline-flex items-center rounded-t border-b-2 border-transparent text-sm text-slate-500 hover:text-slate-700 hover:border-slate-300"
                                    :class="index === selectedTab ? 'border-blue-600 font-medium text-slate-900 dark:text-slate-100' : ''"
                                >
                                    #{{ index + 1 }}
                                </button>

                                <!-- Botón Agregar (visual, no funcional) -->
                                <div class="ml-2 -mb-px h-9 flex items-center">
                                <button
                                    v-if="tabs.length < 10"
                                    type="button"
                                    :disabled="disableAddTab"
                                    @click="addTab()"
                                    class="h-8 px-2 inline-flex items-center gap-1 rounded border border-dashed border-slate-300 dark:border-slate-600 text-xs text-slate-600 hover:border-slate-400 hover:text-slate-800 disabled:opacity-50 disabled:cursor-not-allowed disabled:border-slate-200 disabled:text-slate-400"
                                >
                                    <!-- plus icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14"/>
                                    </svg>
                                </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-8 px-4">
                    
                    <div class="w-full">
                        <div class="flex items-center">
                            <label
                                for="formCatalogMachines"
                                class="text-lg font-normal mb-0 mr-[10px]"
                                >{{ $t("report.form.machines") }} <span class="text-red-500">*</span></label
                            >
                            <multiselect
                                @select="machineChangeNew"
                                id="formCatalogMachines"
                                :options="machinesCatalog"
                                v-model="activeTab.selectedMachine"
                                track-by="id"
                                class="custom-multiselect flex-1"
                                :searchable="true"
                                :placeholder="$t('report.form.default')"
                                :custom-label="
                                    ({ serial,machine_model }) =>
                                        `${machine_model.model} - ${serial}`
                                "
                                :disabled="machinesCatalog.length === 0"
                                selected-label=""
                                select-label=""
                                deselect-label=""
                            ></multiselect>
                        </div>
                    </div>
                        
                    <template v-if="activeTab.selectedMachine">
                        <div
                            class="flex flex-wrap justify-evenly mt-4"
                        >
                            <div
                                v-for="(machine, index) in machinesListing"
                                :key="`${activeTab.id}-${machine.id ?? machine.serial ?? index}`"
                                :class="{
                                    'bg-[#ececf9]': machine.only_dt !== 1,
                                    'bg-gray-100': machine.only_dt === 1,
                                    'ring-2 ring-amber-500 ring-offset-1': machinesListing.length > 1 && machine.serial === activeTab.selectedMachine?.serial
                                }"
                                class="rounded-md p-4 mb-4"
                            >
                                <div class="text-center font-semibold">
                                    Serial: {{ machine.serial }} -
                                    {{ machine.machine_model?.model ?? '-' }} -
                                    {{
                                        machine.line_num
                                            ?? machine.machine_model?.model_segment?.segment
                                            ?? '-'
                                    }}
                                </div>
                                <div class="w-full" v-if="activePostTab?.machines?.[index]">
                                    <div class="flex justify-evenly flex-wrap">
                                        <div
                                            v-for="(
                                                detail, indexDetail
                                            ) in activePostTab.machines[index]
                                                .machine_details"
                                            :key="indexDetail"
                                            class="flex-[100%] flex justify-evenly flex-wrap"
                                        >
                                            <div
                                                class="p-2 flex-auto sm:flex-1"
                                                v-if="machine.only_dt !== 1"
                                            >
                                                <label
                                                    :for="
                                                        'formModule' + selectedTab +
                                                        index +
                                                        indexDetail
                                                    "
                                                    >{{ $t("report.form.error") }}</label
                                                >
                                                <select
                                                    :id="
                                                        'formModule' + selectedTab +
                                                        index +
                                                        indexDetail
                                                    "
                                                    :name="
                                                        'formModule' + selectedTab +
                                                        index +
                                                        indexDetail
                                                    "
                                                    class="form-select text-white-dark"
                                                    v-model="detail.module_id"
                                                    required
                                                >
                                                    <option :value="null">
                                                        {{ $t("report.form.default") }}
                                                    </option>
                                                    <option
                                                        v-for="tmodule in moduleOptions"
                                                        :key="tmodule.id"
                                                        :value="tmodule.id"
                                                    >
                                                        {{ getTranslation(tmodule) }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div
                                                class="p-2 flex-auto sm:flex-1"
                                                v-if="machine.only_dt !== 1"
                                            >
                                                <label
                                                    :for="
                                                        'formFailures' +
                                                        index +
                                                        indexDetail
                                                    "
                                                    >{{ $t("report.form.cause") }}</label
                                                >
                                                <select
                                                    :id="
                                                        'formFailures' +
                                                        index +
                                                        indexDetail
                                                    "
                                                    :name="
                                                        'formFailures' +
                                                        index +
                                                        indexDetail
                                                    "
                                                    class="form-select text-white-dark"
                                                    v-model="detail.failure_id"
                                                    required
                                                >
                                                    <option :value="null">
                                                        {{ $t("report.form.default") }}
                                                    </option>
                                                    <option
                                                        v-for="failure in failureOptions"
                                                        :key="failure.id"
                                                        :value="failure.id"
                                                    >
                                                        {{ getTranslation(failure) }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div
                                                class="p-2 flex-auto sm:flex-1"
                                                v-if="machine.only_dt !== 1"
                                            >
                                                <label
                                                    :for="
                                                        'formTypes' +
                                                        index +
                                                        indexDetail
                                                    "
                                                    >{{ $t("report.form.solution") }}</label
                                                >
                                                <select
                                                    :id="
                                                        'formTypes' +
                                                        index +
                                                        indexDetail
                                                    "
                                                    :name="
                                                        'formTypes' +
                                                        index +
                                                        indexDetail
                                                    "
                                                    class="form-select text-white-dark"
                                                    v-model="
                                                        detail.failure_type_id
                                                    "
                                                    required
                                                >
                                                    <option :value="null">
                                                        {{ $t("report.form.default") }}
                                                    </option>
                                                    <option
                                                        v-for="failuretype in typeOptions"
                                                        :key="failuretype.id"
                                                        :value="failuretype.id"
                                                    >
                                                        {{ getTranslation(failuretype) }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div
                                                class="p-2 flex-auto sm:flex-1"
                                                v-if="machine.only_dt !== 1"
                                            >
                                                <label :for="
                                                        'formErrorDT' +
                                                        index +
                                                        indexDetail
                                                    "
                                                    >DT (Min.)</label
                                                >
                                                <input
                                                    :id="
                                                        'formErrorDT' +
                                                        index +
                                                        indexDetail
                                                    "
                                                    :name="
                                                        'formErrorDT' +
                                                        index +
                                                        indexDetail
                                                    "
                                                    type="number"
                                                    v-model.number="detail.dt"
                                                    @input="clampDt(detail)"
                                                    min="0"
                                                    max="999999"
                                                    step="1"
                                                    class="form-input text-white-dark"
                                                    :placeholder="$t('report.form.dtPlaceholder')"
                                                />
                                            </div>
                                            <div
                                                class="flex"
                                                v-if="machine.only_dt !== 1"
                                            >
                                                <button
                                                    type="button"
                                                    @click="removeMachineDetail(index,indexDetail)"
                                                    v-if="activePostTab.machines[index]?.machine_details?.length > 1"
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
                                                        <line
                                                            x1="18"
                                                            y1="6"
                                                            x2="6"
                                                            y2="18"
                                                        ></line>
                                                        <line
                                                            x1="6"
                                                            y1="6"
                                                            x2="18"
                                                            y2="18"
                                                        ></line>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full flex justify-center">
                                            <button
                                                v-if="machine.only_dt !== 1 && activePostTab?.machines?.[index]?.machine_details?.length < 5"
                                                type="button"
                                                class="btn btn-secondary gap-2"
                                                @click="
                                                    addMachineDetail(
                                                        activePostTab.machines[index]
                                                            .machine_details
                                                    )
                                                "
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
                                                    <line
                                                        x1="12"
                                                        y1="5"
                                                        x2="12"
                                                        y2="19"
                                                    ></line>
                                                    <line
                                                        x1="5"
                                                        y1="12"
                                                        x2="19"
                                                        y2="12"
                                                    ></line>
                                                </svg>
                                            </button>
                                        </div>
                                        <div
                                            class="py-2"
                                            v-if="machine.only_dt !== 1"
                                        >
                                            <template
                                                v-if="machine.machine_model?.model_segment?.is_multi_transport === 1"
                                            >
                                                <div
                                                    class="w-full flex justify-evenly flex-wrap"
                                                >
                                                    <div
                                                        class="p-2 flex-auto sm:flex-1"
                                                    >
                                                        <label
                                                            :for="
                                                                'formTransport1' +
                                                                index
                                                            "
                                                            >{{ $t("report.form.initialTransport") }}</label
                                                        >
                                                        <input
                                                            :id="
                                                                'formTransport1' +
                                                                index
                                                            "
                                                            :name="
                                                                'formTransport1' +
                                                                index
                                                            "
                                                            v-model.number="
                                                                postForm.tabs[
                                                                    selectedTab]
                                                                    .machines[
                                                                    index
                                                                ].transport_1
                                                            "
                                                            @input="
                                                                transportValidation(
                                                                    index
                                                                )
                                                            "
                                                            type="number"
                                                            class="form-input"
                                                            min="0.0"
                                                            max="9999.9"
                                                            step="0.1"
                                                            placeholder="0.0"
                                                        />
                                                    </div>

                                                    <div
                                                        class="p-2 flex-auto sm:flex-1"
                                                    >
                                                        <label
                                                            :for="
                                                                'formTransport2' +
                                                                index
                                                            "
                                                            >{{ $t("report.form.finalTransport") }}</label
                                                        >
                                                        <input
                                                            :id="
                                                                'formTransport2' +
                                                                index
                                                            "
                                                            :name="
                                                                'formTransport2' +
                                                                index
                                                            "
                                                            v-model.number="
                                                                activePostTab
                                                                    .machines[
                                                                    index
                                                                ].transport_2
                                                            "
                                                            @input="
                                                                transportValidation(
                                                                    index
                                                                )
                                                            "
                                                            type="number"
                                                            class="form-input"
                                                            min="0.0"
                                                            max="9999.9"
                                                            step="0.1"
                                                            placeholder="0.0"
                                                        />
                                                    </div>
                                                    <div
                                                        class="p-2 flex-auto sm:flex-1"
                                                    >
                                                        <label
                                                            :for="
                                                                'formTransport3' +
                                                                index
                                                            "
                                                            >{{ $t("report.form.estimatedTransport") }}</label
                                                        >
                                                        <input
                                                            :id="
                                                                'formTransport3' +
                                                                index
                                                            "
                                                            :name="
                                                                'formTransport3' +
                                                                index
                                                            "
                                                            v-model.number="
                                                                activePostTab
                                                                    .machines[
                                                                    index
                                                                ].transport_3
                                                            "
                                                            @input="
                                                                transportValidation(
                                                                    index
                                                                )
                                                            "
                                                            type="number"
                                                            class="form-input"
                                                            min="0.0"
                                                            max="9999.9"
                                                            step="0.1"
                                                            placeholder="0.0"
                                                        />
                                                    </div>
                                                </div>
                                            </template>
                                            <template v-else-if="activePostTab?.machines?.[index]">
                                                <label for="formShiftTotal11"
                                                    >{{ $t("report.form.transport") }}</label
                                                >
                                                <input
                                                    id="formShiftTotal11"
                                                    v-model="
                                                        activePostTab.machines[index]
                                                            .transport_1
                                                    "
                                                    @input="
                                                        transportValidation(
                                                            index
                                                        )
                                                    "
                                                    name="formShiftTotal11"
                                                    class="form-input text-white-dark"
                                                    type="number"
                                                    min="0.0"
                                                    max="9999.9"
                                                    step="0.1"
                                                    placeholder="0.0"
                                                />
                                            </template>
                                        </div>
                                        <div class="py-2">
                                            <label :for="'formReportDT' + index"
                                                >DT Final (Min.)</label
                                            >
                                            <input
                                                :id="'formReportDT' + index"
                                                type="number"
                                                v-model.number="activePostTab.machines[index].dt"
                                                :name="'formReportDT' + index"
                                                class="form-input text-white-dark"
                                                :placeholder="$t('report.form.dtPlaceholder')"
                                                @input="clampDt(activePostTab.machines[index])"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
                <!-- 
                <hr class="border-[#e0e6ed] dark:border-[#1b2e4b] my-6" />
                <div class="mt-8 px-4">
                    <div class="flex justify-between lg:flex-row flex-col">
                        <div
                            class="lg:w-1/2 w-full ltr:lg:mr-6 rtl:lg:ml-6 mb-6"
                        >
                            <div class="text-lg">
                                {{ $t("report.form.branches") }} <span class="text-red-500">*</span>
                            </div>

                            <multiselect
                                v-tippy:branches
                                id="formBranches"
                                :disabled="form.selectedMachine ? false : true"
                                :options="
                                    form.selectedMachine
                                        ? form.selectedMachine.client.branches
                                        : []
                                "
                                v-model="form.selectedBranch"
                                class="custom-multiselect flex-1"
                                :searchable="true"
                                :custom-label="({ city }) => `${city.name}`"
                                :placeholder="$t('report.form.branchPlaceholder')"
                                selected-label=""
                                select-label=""
                                deselect-label=""
                            ></multiselect>
                            <tippy target="branches" placement="left" trigger="focus">Selección de la dirección de la sucursal asociada al cliente de la máquina seleccionada</tippy>

                            <template v-if="errors.branch_id">
                                <p class="text-danger mt-1 text-center">
                                    {{ errors.branch_id }}
                                </p>
                            </template>
                            <div class="text-lg">
                                {{ $t("report.form.contacts") }} <span class="text-red-500">*</span>
                            </div>
                            <select
                                v-tippy:contacts
                                id="formContacts"
                                name="formContacts"
                                class="form-select text-white-dark"
                                v-model="form.selectedContact"
                                required
                            >
                                <option :value="null">
                                    {{ $t("report.form.default") }}
                                </option>
                                <option
                                    v-for="contact in form.selectedBranch
                                        ?.branch_managers"
                                    :key="contact.id"
                                    :value="contact"
                                >
                                    {{ contact.name }}
                                </option>
                            </select>
                            <tippy target="contacts" placement="left" trigger="focus">Selección del contacto asociado a la dirección de la sucursal seleccionada</tippy>

                            <template v-if="errors.branch_manager_id">
                                <p class="text-danger mt-1 text-center">
                                    {{ errors.branch_manager_id }}
                                </p>
                            </template>
                            <div class="mt-4 flex items-center">
                                <label
                                    for="formClient"
                                    class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0"
                                    >{{ $t("report.form.client") }}</label
                                >
                                <input
                                    id="formClient"
                                    type="text"
                                    name="formClient"
                                    class="form-input flex-1"
                                    readonly
                                    :value="form.selectedMachine?.client.name"
                                />
                            </div>
                            <div class="mt-4 flex items-center">
                                <label
                                    for="formCustomerName"
                                    class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0"
                                    >{{ $t("report.form.name") }}</label
                                >
                                <input
                                    id="formCustomerName"
                                    type="text"
                                    name="formCustomerName"
                                    class="form-input flex-1"
                                    readonly
                                    :value="form.selectedContact?.name"
                                />
                            </div>
                            <div class="mt-4 flex items-center">
                                <label
                                    for="formCustomerEmail"
                                    class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0"
                                    >{{ $t("report.form.email") }}</label
                                >
                                <input
                                    id="formCustomerEmail"
                                    type="email"
                                    name="formCustomerEmail"
                                    class="form-input flex-1"
                                    readonly
                                    :value="form.selectedContact?.email"
                                />
                            </div>
                            <div class="mt-4 flex items-center">
                                <label
                                    for="formCustomerPhone"
                                    class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0"
                                    >{{ $t("report.form.phone") }}</label
                                >
                                <input
                                    id="formCustomerPhone"
                                    type="text"
                                    name="formCustomerPhone"
                                    class="form-input flex-1"
                                    readonly
                                    :value="form.selectedContact?.phone"
                                />
                            </div>
                        </div>
                        <div class="lg:w-1/2 w-full">
                            <div class="text-lg">{{ $t("report.form.machineData") }}</div>
                            <div class="flex items-center mt-4">
                                <label
                                    for="formMachineSerial"
                                    class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0"
                                    >{{ $t("report.form.serial") }}</label
                                >
                                <input
                                    id="formMachineSerial"
                                    type="text"
                                    name="formMachineSerial"
                                    class="form-input flex-1"
                                    :value="form.selectedMachine?.serial"
                                    readonly
                                />
                            </div>
                            <div class="flex items-center mt-4">
                                <label
                                    for="formMachineType"
                                    class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0"
                                    >{{ $t("report.form.type") }}</label
                                >
                                <input
                                    id="formMachineType"
                                    type="text"
                                    name="formMachineType"
                                    class="form-input flex-1"
                                    :value="
                                        form.selectedMachine?.machine_model
                                            .model
                                    "
                                    readonly
                                />
                            </div>
                            <div class="flex items-center mt-4">
                                <label
                                    for="formMachineSegment"
                                    class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0"
                                    >{{ $t("report.form.segment") }}</label
                                >
                                <input
                                    id="formMachineSegment"
                                    type="text"
                                    name="formMachineSegment"
                                    class="form-input flex-1"
                                    :value="
                                        form.selectedMachine?.machine_model
                                            .model_segment.segment
                                    "
                                    readonly
                                />
                            </div>
                        </div>
                    </div>
                </div>-->
                <hr class="border-[#e0e6ed] dark:border-[#1b2e4b] my-6" />
                <div class="mt-8 px-4">
                    <div
                        class="flex justify-between lg:flex-row flex-col flex-wrap"
                    >
                        <div
                            class="lg:w-1/2 w-full ltr:lg:pr-6 rtl:lg:pl-6 mb-6"
                        >
                            <div class="mt-4 flex items-center">
                                <label
                                    for="formReportPieces"
                                    class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0"
                                    >{{ $t("report.form.pieces") }}</label
                                >
                                <input
                                    v-tippy:pieces
                                    id="formReportPieces"
                                    type="number"
                                    v-model.number="activeTab.pieces"
                                    name="formReportPieces"
                                    step="1"
                                    class="form-input flex-1"
                                    placeholder="0"
                                    min="0"
                                    max="999999999999"
                                    @input="partsValidation"
                                />
                                <tippy target="pieces" trigger="focus">Utilizado como contador de billetes<br> Máximo: 999 999 999 999</tippy>
                            </div>
                            <div class="mt-4 flex items-center">
                                <label
                                    for="formReportSOGD"
                                    class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0"
                                    >{{ $t("report.form.SOGD") }}</label
                                >
                                <input
                                    v-tippy:sogd
                                    id="formReportSOGD"
                                    type="text"
                                    v-model="activeTab.sogd"
                                    name="formReportSOGD"
                                    class="form-input flex-1"
                                    :placeholder="$t('report.form.SOGDPlaceholder')"
                                />
                                <tippy target="sogd" trigger="focus">Utilizado para capturar la orden de servicio de GD</tippy>
                            </div>
                        </div>
                        <div class="lg:w-1/2 w-full">
                            <div class="flex items-center mt-4">
                                <label
                                    for="formReportOnTime"
                                    class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0"
                                    >{{ $t("report.form.machineOn") }}</label
                                >
                                <input
                                    v-tippy:ontime
                                    id="formReportOnTime"
                                    step="0.01"
                                    type="number"
                                    v-model.number="activeTab.time_on"
                                    name="formReportOnTime"
                                    class="form-input flex-1"
                                    placeholder="0.00"
                                    min="0.00"
                                    max="9999999.99"
                                    @input="machineOnValidation"
                                />
                                <tippy target="ontime" trigger="focus">Utilizado para registrar el tiempo de funcionamiento de la máquina<br> Máximo: 9 999 999.99</tippy>
                            </div>
                            <div class="flex items-center mt-4">
                                <label
                                    for="formReportTravelTime"
                                    class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0"
                                    >{{ $t("report.form.travelTime") }}</label
                                >
                                <input
                                    v-tippy:traveltime
                                    id="formReportTravelTime"
                                    type="number"
                                    v-model.number="activeTab.travel_time"
                                    name="formReportTravelTime"
                                    class="form-input flex-1"
                                    placeholder="0"
                                    step="1"
                                    min="0"
                                    max="10080"
                                    @input="travelTimeValidation"
                                />
                                <tippy target="traveltime" trigger="focus">Utilizado para registrar el tiempo de traslado<br> Máximo: 10 080 minutos</tippy>
                            </div>
                            <div class="flex items-center mt-4">
                                <label
                                    for="formReportType"
                                    class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0"
                                    >{{ $t("report.form.type") }}</label
                                >

                                <select
                                    id="formReportType"
                                    name="formReportType"
                                    v-model.number="activeTab.report_type_id"
                                    class="form-select text-white-dark flex-1"
                                    required
                                >
                                    <option :value="1" selected>{{ $t("catalogs.typeReport.1") }}</option>
                                    <option :value="2">{{ $t("catalogs.typeReport.2") }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="w-full mt-4">
                            <div class="flex items-center">
                                <label
                                    for="formReportedError"
                                    class="ltr:mr-2 rtl:ml-2 w-1/6 mb-0"
                                    >{{ $t("report.form.reportedError") }}</label
                                >
                                <textarea
                                    id="formReportedError"
                                    name="formReportedError"
                                    rows="3"
                                    v-model="activeTab.reported_error"
                                    class="form-textarea flex-1"
                                    :placeholder="$t('report.form.reportedErrorPlaceholder')"
                                    required
                                ></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="border-[#e0e6ed] dark:border-[#1b2e4b] my-6" />
                <div class="mt-8 px-4">
                    <div class="flex flex-wrap justify-evenly">
                        <label
                            v-for="(code) in catalogCodes"
                            :key="code.id"
                            class="inline-flex"
                        >
                            <input
                                type="radio"
                                name="formReportCode"
                                class="form-radio"
                                :value="code.id"
                                v-model.number="activeTab.code_id"
                            />
                            <div class="flex flex-col">
                                <span>{{ code.code }}</span>
                                <span
                                    v-if="activeTab.code_id === code.id"
                                    class="text-xs"
                                    >{{ $t("catalogs.codes."+code.id, code.description) }}</span
                                >
                            </div>
                        </label>
                    </div>
                    <div class="w-full">
                        <div class="mt-4 flex items-center">
                            <label
                                for="formReportActions"
                                class="ltr:mr-2 rtl:ml-2 w-1/6 mb-0"
                                >{{ $t("report.form.actionsTaken") }}</label
                            >
                            <textarea
                                id="formReportActions"
                                name="formReportActions"
                                v-model="activeTab.actions_taken"
                                rows="3"
                                class="form-textarea flex-1"
                                :placeholder="$t('report.form.actionsTakenPlaceholder')"
                                required
                            ></textarea>
                        </div>
                    </div>
                </div>
                <hr class="border-[#e0e6ed] dark:border-[#1b2e4b] my-6" />
                <div class="mt-8 px-4">
                    <div class="flex flex-wrap justify-evenly">
                        <div
                            class="px-2 max-w-[180px]"
                            v-if="!activeTab.selectedMachine?.production_line_id"
                        >
                            <label for="formReportReportedTime">
                                {{ $t("report.form.reported") }}
                            </label>
                            <flat-pickr
                                id="formReportReportedTime"
                                name="formReportReportedTime"
                                v-model="activeTab.reported"
                                class="form-input flex-1"
                                :config="dateTime"
                            ></flat-pickr>
                        </div>
                        <div
                            class="px-2 max-w-[180px]"
                            v-if="!activeTab.selectedMachine?.production_line_id"
                        >
                            <label for="formReportTimeDeparture">
                                {{ $t("report.form.departure") }}
                            </label>
                            <flat-pickr
                                id="formReportTimeDeparture"
                                name="formReportTimeDeparture"
                                v-model="activeTab.departure"
                                class="form-input flex-1"
                                :config="dateTime"
                            ></flat-pickr>
                        </div>
                        <div class="px-2 max-w-[180px]">
                            <label for="formReportTimeArrival">{{ $t("report.form.arrival") }}</label>
                            <flat-pickr
                                id="formReportTimeArrival"
                                name="formReportTimeArrival"
                                v-model="activeTab.arrival"
                                class="form-input flex-1"
                                :config="dateTime"
                            ></flat-pickr>
                        </div>
                        <div class="px-2 max-w-[180px]">
                            <label for="formReportTimeFinished">
                                {{ $t("report.form.finished") }}
                            </label>
                            <flat-pickr
                                id="formReportTimeFinished"
                                name="formReportTimeFinished"
                                v-model="activeTab.finished"
                                class="form-input flex-1"
                                :config="dateTime"
                            ></flat-pickr>
                        </div>
                        <div class="w-full flex flex-wrap justify-evenly py-4">
                            <label
                                v-for="(status) in catalogStatus"
                                :key="status.id"
                                class="inline-flex"
                            >
                                <input
                                    type="radio"
                                    name="formReportStatus"
                                    class="form-radio"
                                    :value="status.id"
                                    v-model="activeTab.status_id"
                                />
                                <span>{{ $t("catalogs.status."+status.id,status.status) }}</span>
                            </label>
                        </div>
                        <div class="w-full flex flex-wrap justify-evenly">
                            <label class="inline-flex">
                                <input
                                    type="checkbox"
                                    v-model="activeTab.is_tested"
                                    class="form-checkbox rounded-full"
                                />
                                <span>Test OK</span>
                            </label>
                        </div>
                    </div>
                </div>
                <hr class="border-[#e0e6ed] dark:border-[#1b2e4b] my-6" />
                <div class="mt-8">
                    <div class="flex px-4">
                        <div class="w-full">
                            <div class="flex items-center">
                                <label
                                    for="formReportParts"
                                    class="w-[100px] text-right mb-0 mr-[10px]"
                                    >{{ $t("report.form.parts") }}</label
                                >

                                <multiselect
                                    @search-change="selectPartChange"
                                    id="formReportParts"
                                    :options="catalogParts"
                                    v-model="partSearch"
                                    track-by="id"
                                    class="custom-multiselect flex-1"
                                    :searchable="true"
                                    :placeholder="$t('report.form.partsPlaceholder')"
                                    :custom-label="
                                        ({ num_part, descripcion }) =>
                                            `${num_part} - ${descripcion}`
                                    "
                                    :preserveSearch="true"
                                    selected-label=""
                                    select-label=""
                                    deselect-label=""
                                ></multiselect>
                                <button
                                    :disabled="!partSearch"
                                    class="btn btn-secondary gap-2"
                                    @click="addNewPart"
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
                                        <line
                                            x1="12"
                                            y1="5"
                                            x2="12"
                                            y2="19"
                                        ></line>
                                        <line
                                            x1="5"
                                            y1="12"
                                            x2="19"
                                            y2="12"
                                        ></line>
                                    </svg>
                                </button>
                                <div class="w-[50px] flex justify-end pr-[15px]">
                                    <div v-if="loaders.parts.waiting" class="waiting-loader"></div>
                                    <div v-if="loaders.parts.searching" class="searching-loader mr-[-9px]"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive mt-4">
                        <table>
                            <thead>
                                <tr>
                                    <th>{{ $t("report.form.partReplaced") }}</th>
                                    <th class="w-1/3">{{ $t("report.form.description") }}</th>
                                    <th class="w-1/3">{{ $t("report.form.quantity") }}</th>
                                    <th class="w-1"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <template
                                    v-if="activeTab.service_parts.length <= 0"
                                >
                                    <tr>
                                        <td
                                            colspan="5"
                                            class="!text-center font-semibold"
                                        >
                                            {{ $t("report.form.noItems") }}
                                        </td>
                                    </tr>
                                </template>
                                <template
                                    v-for="(item, i) in activeTab.service_parts"
                                    :key="item.id ?? i"
                                >
                                    <tr class="align-top">
                                        <td>
                                            {{ item.num_part }}
                                        </td>
                                        <td>
                                            {{ item.descripcion }}
                                        </td>
                                        <td>
                                            <input
                                                type="number"
                                                class="form-input w-32"
                                                placeholder="Quantity"
                                                v-model="item.quantity"
                                                step="1"
                                                max="255"
                                                min="1"
                                                @input="partQtyValidation(i)"
                                            />
                                        </td>
                                        <td>
                                            <button
                                                type="button"
                                                @click="removeItem(i)"
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
                                                    <line
                                                        x1="18"
                                                        y1="6"
                                                        x2="6"
                                                        y2="18"
                                                    ></line>
                                                    <line
                                                        x1="6"
                                                        y1="6"
                                                        x2="18"
                                                        y2="18"
                                                    ></line>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mt-8 px-4">
                    <div>
                        <label for="notes">{{ $t("report.form.remarks") }}</label>
                        <textarea
                            id="notes"
                            name="notes"
                            class="form-textarea min-h-[130px]"
                            :placeholder="$t('report.form.remarksPlaceholder')"
                            v-model="activeTab.notes"
                        ></textarea>
                    </div>
                </div>
                <hr class="border-[#e0e6ed] dark:border-[#1b2e4b] my-6" />
                <div class="mt-8 px-4">
                    <div
                        v-if="activeTab.selectedMachine && activePostTab"
                        class="flex flex-wrap justify-evenly w-full"
                    >
                        <template
                            v-for="(machine,index) in machinesListing"
                            :key="`${activeTab.id}-${machine.id ?? machine.serial ?? index}`"
                        >
                            <div
                                v-if="machine.only_dt !== 1 && activePostTab?.machines?.[index]"
                                class="text-center min-w-[270px]"
                            >
                                <label
                                    :for="`formSignatureName-${machine.serial}`"
                                    class="mb-0"
                                >
                                    {{ machine.serial }}
                                </label>
                                <input
                                    :id="`formSignatureName-${machine.serial}`"
                                    type="text"
                                    :name="`formSignatureName-${machine.serial}`"
                                    v-model="activePostTab.machines[index].signature_client_name"
                                    class="form-input flex-1"
                                    :placeholder="$t('report.form.signatureNamePlaceholder')"
                                />
                            </div>
                        </template>
                    </div>
                </div>
            </div>
            <div class="xl:w-96 w-full xl:mt-0 mt-6">
                <!--
                <div class="panel mb-5" v-if="user.type === 2">
                    <div class="text-lg">Active reports</div>
                    <div class="flex flex-wrap justify-evenly text-center">
                        <button
                            type="button"
                            class="btn btn-outline-primary my-2"
                        >
                            4d25f6c6
                        </button>
                        <button
                            type="button"
                            class="btn btn-outline-primary my-2"
                        >
                            80dffdc4
                        </button>
                        <button
                            type="button"
                            class="btn btn-outline-primary my-2"
                        >
                            b5048b20
                        </button>
                        <button
                            type="button"
                            class="btn btn-outline-primary my-2"
                        >
                            62b7e603
                        </button>
                        <button
                            type="button"
                            class="btn btn-outline-primary my-2"
                        >
                            5c44f51b
                        </button>
                        <button
                            type="button"
                            class="btn btn-outline-primary my-2"
                        >
                            6e4283bc
                        </button>
                        <button
                            type="button"
                            class="btn btn-outline-primary my-2"
                        >
                            3f7dad51
                        </button>
                        <button
                            type="button"
                            class="btn btn-outline-primary my-2"
                        >
                            152b38ec
                        </button>
                        <button
                            type="button"
                            class="btn btn-outline-primary my-2"
                        >
                            c217f4ef
                        </button>
                        <button
                            type="button"
                            class="btn btn-outline-primary my-2"
                        >
                            b0684858
                        </button>
                    </div>
                    <div class="w-full text-center mt-8">
                        <a href="#">Show all</a>
                    </div>
                </div>-->
                <div class="panel sticky top-[75px] left-0">
                    <div
                        class="grid xl:grid-cols-1 lg:grid-cols-4 sm:grid-cols-2 grid-cols-1 gap-4"
                    >
                        <button
                            type="button"
                            class="btn btn-success w-full gap-2"
                            @click="submit"
                        >
                            <svg
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5 ltr:mr-2 rtl:ml-2 shrink-0"
                            >
                                <path
                                    d="M3.46447 20.5355C4.92893 22 7.28595 22 12 22C16.714 22 19.0711 22 20.5355 20.5355C22 19.0711 22 16.714 22 12C22 11.6585 22 11.4878 21.9848 11.3142C21.9142 10.5049 21.586 9.71257 21.0637 9.09034C20.9516 8.95687 20.828 8.83317 20.5806 8.58578L15.4142 3.41944C15.1668 3.17206 15.0431 3.04835 14.9097 2.93631C14.2874 2.414 13.4951 2.08581 12.6858 2.01515C12.5122 2 12.3415 2 12 2C7.28595 2 4.92893 2 3.46447 3.46447C2 4.92893 2 7.28595 2 12C2 16.714 2 19.0711 3.46447 20.5355Z"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                />
                                <path
                                    d="M17 22V21C17 19.1144 17 18.1716 16.4142 17.5858C15.8284 17 14.8856 17 13 17H11C9.11438 17 8.17157 17 7.58579 17.5858C7 18.1716 7 19.1144 7 21V22"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                />
                                <path
                                    opacity="0.5"
                                    d="M7 8H13"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                    stroke-linecap="round"
                                />
                            </svg>
                            {{ $t('report.form.saveReport') }}
                        </button>
                        <!--
                        <button type="button" class="btn btn-info w-full gap-2">
                            <svg
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-6 h-6"
                            >
                                <path
                                    opacity="0.5"
                                    d="M2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C22 4.92893 22 7.28595 22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12Z"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                ></path>
                                <path
                                    d="M8.5 12.5L10.5 14.5L15.5 9.5"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                ></path>
                            </svg>
                            Close Report
                        </button>-->
                        <!--
                        <router-link to="/apps/invoice/preview" class="btn btn-primary w-full gap-2">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ltr:mr-2 rtl:ml-2 shrink-0">
                                <path
                                    opacity="0.5"
                                    d="M3.27489 15.2957C2.42496 14.1915 2 13.6394 2 12C2 10.3606 2.42496 9.80853 3.27489 8.70433C4.97196 6.49956 7.81811 4 12 4C16.1819 4 19.028 6.49956 20.7251 8.70433C21.575 9.80853 22 10.3606 22 12C22 13.6394 21.575 14.1915 20.7251 15.2957C19.028 17.5004 16.1819 20 12 20C7.81811 20 4.97196 17.5004 3.27489 15.2957Z"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                ></path>
                                <path
                                    d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                ></path>
                            </svg>
                            Preview
                        </router-link>
                        --><!--
                        <a href="" class="btn btn-secondary w-full gap-2">
                            <svg
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5 ltr:mr-2 rtl:ml-2 shrink-0"
                            >
                                <path
                                    opacity="0.5"
                                    d="M17 9.00195C19.175 9.01406 20.3529 9.11051 21.1213 9.8789C22 10.7576 22 12.1718 22 15.0002V16.0002C22 18.8286 22 20.2429 21.1213 21.1215C20.2426 22.0002 18.8284 22.0002 16 22.0002H8C5.17157 22.0002 3.75736 22.0002 2.87868 21.1215C2 20.2429 2 18.8286 2 16.0002L2 15.0002C2 12.1718 2 10.7576 2.87868 9.87889C3.64706 9.11051 4.82497 9.01406 7 9.00195"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                    stroke-linecap="round"
                                ></path>
                                <path
                                    d="M12 2L12 15M12 15L9 11.5M12 15L15 11.5"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                ></path>
                            </svg>
                            Download PDF
                        </a>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
const LIMITS = {
  PIECES_MAX: 999_999_999_999,
  TIME_ON_MAX: 9_999_999.99,
  TRAVEL_TIME_MAX: 10_080,
  DT_MAX: 999_999,
  TRANSPORT_MAX: 9_999.9,
  PART_QTY_MAX: 255,
  MACHINE_DETAILS_MAX: 5,
};
const clamp = (n: number, min: number, max: number) => Math.min(max, Math.max(min, n));

import { ref, reactive, computed } from "vue";
import { Head, usePage, router } from "@inertiajs/vue3";
import { useAppStore } from "@/stores/index";
import AppLayout from "@/layouts/app-layout.vue";
import SiteLayout from "@/layouts/app.vue";
import flatPickr from "vue-flatpickr-component";
import Multiselect from "@suadelabs/vue3-multiselect";
import "@suadelabs/vue3-multiselect/dist/vue3-multiselect.css";
import "flatpickr/dist/flatpickr.css";
import Swal from "sweetalert2";
import { useI18n } from 'vue-i18n';
import axios from 'axios';

const { t } = useI18n();
const store = useAppStore();

const page = usePage();
const user = computed(() => page.props.auth);
const catalogParts = ref([]);
//const catalogMachines = ref([]);
const loaders = ref({
    //machines: { waiting: true, searching: false },
    parts: { waiting: true, searching: false},
});
defineOptions({
    layout: [SiteLayout, AppLayout],
});

const ensurePostTab = (i: number) => (postForm.tabs[i] ??= { machines: [] });

const activeTab = computed(() => tabs.value[selectedTab.value]);
const activePostTab = computed(() => postForm.tabs[selectedTab.value]);

type LocalizedItem = { id: number; name?: string; es?: string; pt?: string };

const props = defineProps<{
    errors: Record<string, string>;
    catalogCodes: Array<{ id: number; code: string; description?: string }>;
    catalogUsers: Array<{ id: number; emp: string; nombre: string; apellido_paterno: string }>;
    catalogStatus: Array<{ id: number; status: string }>;
    catalogShifts: Array<{ id: number; name: string }>;
    catalogModule: Array<LocalizedItem>;
    catalogFailures: Array<LocalizedItem>;
    catalogTypes: Array<LocalizedItem>;
    catalogMachineModels: Array<{ id: number; model: string }>;
    catalogClients: Array<{ id: number; name: string }>;
}>();

const dateTime: any = ref({
    enableTime: true,
    dateFormat: "Y-m-d H:i",
    position: store.rtlClass === "rtl" ? "auto right" : "auto left",
});

const basic: any = ref({
    dateFormat: 'Y-m-d',
    position: store.rtlClass === 'rtl' ? 'auto right' : 'auto left',
});

const form = reactive({
    selectedClient: null,
    selectedBranch: null,
    selectedContact: null,
    selectedShift: null,
    selectedUser: null,
});

const disableAddTab = computed(() => tabs.value.some(t => !t.selectedMachine))

const partSearch = ref(null);

let tabId = 0;

const createTab = () => ({
    id: ++tabId,
    selectedClient: null,
    selectedMachine: null,
    selectedBranch: null,
    selectedContact: null,
    selectedShift: null,
    selectedUser: null,
    machines: [],
    pieces: null,
    sogd: null,
    time_on: null,
    travel_time: null,
    report_type_id: 1,
    reported_error: "",
    code_id: null,
    actions_taken: "",
    reported: null,
    departure: null,
    arrival: null,
    finished: null,
    status_id: null,
    is_tested: null,
    service_parts: [],
    notes: "",
});

const tabs = ref([createTab()]);
const selectedTab = ref(0);
function addTab() {
    tabs.value.push(createTab());
    postForm.tabs.push({ machines: [] });
}

const branchesCatalog = ref([]);
const machinesCatalog = ref([]);

const currentLocale = computed(() => store.locale);

function getTranslation(item) {
    if(currentLocale.value === 'es' && item.es) {
        return item.es;
    }else if (currentLocale.value === 'pt' && item.pt) {
        return item.pt;
    }
    return item.name;
}

type Translatable = { name?: string; es?: string; pt?: string };
const sortByTranslation = <T extends Translatable>(arr: T[]) =>
    [...arr].sort((a, b) => getTranslation(a).localeCompare(getTranslation(b)));

const moduleOptions = computed(() => sortByTranslation(props.catalogModule));
const failureOptions = computed(() => sortByTranslation(props.catalogFailures));
const typeOptions = computed(() => sortByTranslation(props.catalogTypes));  

const removeItem = (index: number) => {
    tabs.value[selectedTab.value].service_parts.splice(index, 1);
};

function removeMachineDetail(index, indexDetail) {
    const m = postForm.tabs[selectedTab.value]?.machines?.[index];
    if (!m?.machine_details || m.machine_details.length <= 1) return;
    m.machine_details.splice(indexDetail, 1);
};

const addNewPart = () => {
    if (!partSearch.value) return;
    const existingPartIndex = tabs.value[selectedTab.value].service_parts.findIndex(part => part.id === partSearch.value.id);
    if (existingPartIndex !== -1) {
        tabs.value[selectedTab.value].service_parts[existingPartIndex].quantity += 1;
    } else {
        tabs.value[selectedTab.value].service_parts.push({ ...partSearch.value, quantity: 1 });
    }
};

const updateMachines = (selectedMachine) => {
    if (!selectedMachine) return;

    if (selectedMachine.production_line?.id === null) {
        selectedMachine.production_line = null;
    }

    const totalMachines = selectedMachine.production_line?.machines?.length ?? 1;

    ensurePostTab(selectedTab.value).machines = Array.from({ length: totalMachines }, (_, index) => {
        const machineId =
            totalMachines === 1
                ? selectedMachine.id
                : selectedMachine.production_line.machines[index].id;

        return {
            machine_id: machineId,
            machine_details: [
                {
                    module_id: null,
                    failure_id: null,
                    failure_type_id: null,
                    dt: null,
                },
            ],
            transport_1: null,
            transport_2: null,
            transport_3: null,
            dt: null,
            signature_client_name: null,
        };
    });
};

/*watch(() => tabs.value.map(t => t.selectedMachine), (arr) => {
    const i = selectedTab.value;
    updateMachines(arr[i]);
}, { immediate: true, deep: false });*/

function getCurrentDate() {
  const now = new Date();
  const year = now.getFullYear();
  const month = String(now.getMonth() + 1).padStart(2, '0');
  const day = String(now.getDate()).padStart(2, '0');
  return `${year}-${month}-${day}`;
}

const postForm = reactive({
    user_id: null,
    shift_id: null,
    pieces: null,
    service_date: getCurrentDate(),
    service_timezone: new Date().toString().match(/([A-Z]+[\+-][0-9]+)/)[1],
    sogd: null,
    time_on: null,
    travel_time: null,
    report_type_id: 1,
    branch_id: null,
    branch_manager_id: null,
    reported_error: "",
    code_id: null,
    actions_taken: "",
    reported: null,
    arrival: null,
    finished: null,
    departure: null,
    status_id: null,
    is_tested: null,
    notes: "",
    tabs: [{ machines: [] }] as Array<any>,
    machines: [] as Array<any>,
    service_parts: [],
});

const machinesListing = computed(() => {
    const tab = tabs.value?.[selectedTab.value];
    const sel = tab?.selectedMachine;
    const list = sel?.production_line?.machines;
    return Array.isArray(list) && list.length ? list : (sel ? [sel] : []);
});

function transportValidation(index: number) {
    const m = activePostTab.value?.machines?.[index];
    if (!m) return;

    (["transport_1", "transport_2", "transport_3"] as const).forEach(k => {
        const n = Number(m[k]) || 0;
        m[k] = clamp(Math.round(n * 10) / 10, 0, LIMITS.TRANSPORT_MAX);
    });
}

const clampIntField = <T extends Record<string, any>>(obj: T, key: keyof T, min: number, max: number) => {
  const n = Math.trunc(Number(obj[key]) || 0);
  obj[key] = clamp(n, min, max) as any;
};

const clampFixedField = <T extends Record<string, any>>(obj: T, key: keyof T, decimals: number, min: number, max: number) => {
  const factor = 10 ** decimals;
  const n = Number(obj[key]) || 0;
  obj[key] = clamp(Math.round(n * factor) / factor, min, max) as any;
};

function partQtyValidation(index: number) {
    const p = activeTab.value.service_parts[index];
    const n = Math.trunc(Number(p.quantity) || 1);
    p.quantity = clamp(n, 1, LIMITS.PART_QTY_MAX);
}

function machineOnValidation() {
  clampFixedField(activeTab.value, 'time_on', 2, 0, LIMITS.TIME_ON_MAX);
}

const clampDt = (target: { dt: number | null }) => {
    const n = Math.trunc(Number(target.dt) || 0);
    target.dt = clamp(n, 0, LIMITS.DT_MAX);
};

function partsValidation() {
  clampIntField(activeTab.value, 'pieces', 0, LIMITS.PIECES_MAX);
}

function travelTimeValidation() {
  clampIntField(activeTab.value, 'travel_time', 0, LIMITS.TRAVEL_TIME_MAX);
}

async function selectedClientChange(selectedOption) {
    tabId = 0;
    tabs.value = [createTab()];
    selectedTab.value = 0;
    postForm.tabs = [{ machines: [] }];

    form.selectedBranch = null;
    form.selectedContact = null;
    branchesCatalog.value = [];
    machinesCatalog.value = [];
    try {
        const [ branchesRes, machinesRes ] = await Promise.all([
            axios.get(`/clients/${selectedOption.id}/branches`),
            axios.get(`/clients/${selectedOption.id}/machines`)
        ]);

        branchesCatalog.value = branchesRes.data;
        machinesCatalog.value = machinesRes.data;
    } catch (e) {
        branchesCatalog.value = []
        machinesCatalog.value = []
    }
}
/*
function machineModelChange(selectedOption) {
    loaders.value.machines.searching = true;
    loaders.value.machines.waiting = false;

    fetch(`/machines/model/${selectedOption.id}`, {
        method: "get",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": page.props.csrf,
        },
    })
        .then((response) => response.json())
        .then((data) => {
            machinesCatalog.value = data;
        })
        .catch((error) => {
            console.error("Error:", error);
        })
        .finally(() => {
            loaders.value.machines.searching = false;
            loaders.value.machines.waiting = true;
        });
}*/

async function machineChangeNew(selectedOption) {
    try {
        const { data } = await axios.get(`/machine/${selectedOption.serial}`);
        ensurePostTab(selectedTab.value);
        updateMachines(data);
        tabs.value[selectedTab.value].selectedMachine = data;
    } catch (e) {
        console.error("Error:", e);
        tabs.value[selectedTab.value].selectedMachine = null;
    }
}

/*
function machineChange(selectedOption) {
    loaders.value.machines.searching = true;
    loaders.value.machines.waiting = false;

    fetch(`/machine/${selectedOption.serial}`, {
        method: "get",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": page.props.csrf,
        },
    })
        .then((response) => response.json())
        .then((data) => {
            form.selectedMachine = data;
        })
        .catch((error) => {
            console.error("Error:", error);
        })
        .finally(() => {
            loaders.value.machines.searching = false;
            loaders.value.machines.waiting = true;
        });
}*/

let partsDebounce: number | null = null;
//let timeoutIdMachine = ref(null);
function selectPartChange(searchQuery: string) {
    catalogParts.value = [];
    if (!searchQuery?.length) {
        if (partsDebounce) clearTimeout(partsDebounce);
        return;
    }

    if (partsDebounce) clearTimeout(partsDebounce);
    partsDebounce = window.setTimeout(() => {
        loaders.value.parts.searching = true;
        loaders.value.parts.waiting = false;

        axios
            .post("/parts/autocomplete", { query: searchQuery })
            .then(({ data }) => {
                catalogParts.value = data ?? [];
            })
            .catch((error) => {
                console.error("Error:", error);
            })
            .finally(() => {
                loaders.value.parts.searching = false;
                loaders.value.parts.waiting = true;
            });
    }, 750);
}

/*
function selectMachineChange(searchQuery, id) {
    machinesCatalog.value = [];
    if (searchQuery.length <= 0) {
        if (timeoutIdMachine.value) clearTimeout(timeoutIdMachine.value);
        return;
    }

    if (timeoutIdMachine.value) clearTimeout(timeoutIdMachine.value);
    timeoutIdMachine.value = setTimeout(() => {
        loaders.value.machines.searching = true;
        loaders.value.machines.waiting = false;
        fetch("/machines/autocomplete", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": page.props.csrf,
                // 'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: JSON.stringify({ query: searchQuery }),
        })
            .then((response) => response.json())
            .then((data) => {
                machinesCatalog.value = data;
            })
            .catch((error) => {
                console.error("Error:", error);
            })
            .finally(() => {
                loaders.value.machines.searching = false;
                loaders.value.machines.waiting = true;
            });
    }, 750);
}*/

function addMachineDetail(machine) {
    if (machine.length < 5) {
        machine.push({
            module_id: null,
            failure_id: null,
            failure_type_id: null,
            dt: null,
        });
    }
}

function buildPayload() {
    const header = {
        user_id: form.selectedUser?.id ?? null,
        shift_id: form.selectedShift?.id ?? null,
        branch_id: form.selectedBranch?.id ?? null,
        branch_manager_id: form.selectedContact?.id ?? null,
        service_date: postForm.service_date,
        service_timezone: postForm.service_timezone,
    };

    const tabsPayLoad = tabs.value.map((t, i) => ({
        selected_machine_id: t.selectedMachine?.id ?? null,
        pieces: t.pieces ?? 0,
        sogd: t.sogd ?? null,
        time_on: t.time_on ?? 0,
        travel_time: t.travel_time ?? 0,
        report_type_id: t.report_type_id ?? 1,
        reported_error: t.reported_error ?? "",
        code_id: t.code_id ?? null,
        actions_taken: t.actions_taken ?? "",
        reported: t.reported ?? null,
        departure: t.departure ?? null,
        arrival: t.arrival ?? null,
        finished: t.finished ?? null,
        status_id: t.status_id ?? null,
        is_tested: !!t.is_tested,
        service_parts: (t.service_parts ?? []).map(p => ({ id: p.id, quantity: p.quantity })),
        notes: t.notes ?? "",
        machines: postForm.tabs[i]?.machines ?? [],
    }));

    return { ...header, tabs: tabsPayLoad };
}

function submit() {
    const payload = buildPayload();

    console.log(payload);
    
    Swal.fire({
        title: t("report.alert.processing"),
        text: t("report.alert.processingText"),
        allowOutsideClick: false,
        showConfirmButton: false,
        customClass: "sweet-alerts",
        didOpen: () => Swal.showLoading(),
    });

    router.post("/reports", payload, {
        onSuccess: () => Swal.close(),
        onError: (error) => {
            let errorMessages = "";
            for (const key in error) errorMessages += `<p>${error[key]}</p>`;
            Swal.close();
            Swal.fire({ icon: "error", title: "Oops...", html: errorMessages, customClass: "sweet-alerts" });
        },
    });
}
</script>