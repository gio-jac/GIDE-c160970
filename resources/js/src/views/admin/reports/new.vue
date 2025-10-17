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

                            <flat-pickr id="formServiceDate" v-model="report.service_date" class="form-input flex-1" :config="basic"></flat-pickr>
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
                                :custom-label="labelUser"
                                v-bind="multiselectLabels"
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
                                :custom-label="labelShift"
                                v-bind="multiselectLabels"
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
                                @select="onClientSelect"
                                v-model="form.selectedClient"
                                track-by="id"
                                class="custom-multiselect flex-1"
                                :searchable="true"
                                :placeholder="$t('report.form.default')"
                                :custom-label="labelClient"
                                v-bind="multiselectLabels"
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
                                @select="onBranchSelect"
                                id="formCatalogBranches"
                                :options="branchesCatalog"
                                v-model="form.selectedBranch"
                                track-by="id"
                                class="custom-multiselect flex-1"
                                :searchable="true"
                                :placeholder="$t('report.form.default')"
                                :custom-label="labelBranch"
                                :disabled="branchesCatalog.length === 0"
                                v-bind="multiselectLabels"
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
                                :options="branchManagers"
                                v-model="form.selectedContact"
                                track-by="id"
                                class="custom-multiselect flex-1"
                                :searchable="true"
                                :placeholder="$t('report.form.default')"
                                :custom-label="labelContact"
                                :disabled="!hasSelectedBranch"
                                v-bind="multiselectLabels"
                            ></multiselect>
                        </div>
                    </div>
                </div>
                
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
                                    v-if="tabs.length < LIMITS.TABS_MAX"
                                    type="button"
                                    :disabled="!canAddTab"
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
                                @select="onMachineSelect"
                                id="formCatalogMachines"
                                :options="machinesCatalog"
                                v-model="activeTab.selectedMachine"
                                track-by="id"
                                class="custom-multiselect flex-1"
                                :searchable="true"
                                :placeholder="$t('report.form.default')"
                                :custom-label="labelMachine"
                                :disabled="machinesCatalog.length === 0"
                                v-bind="multiselectLabels"
                            ></multiselect>
                        </div>
                    </div>
                        
                    <template v-if="activeTab.selectedMachine">
                        <div
                            class="flex flex-wrap justify-evenly mt-4"
                        >
                            <div
                                v-for="(machine, index) in machinesListing"
                                :key="machineKey(machine, index)"
                                :class="{
                                    'bg-[#ececf9]': !isDTOnly(machine),
                                    'bg-gray-100': isDTOnly(machine),
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
                                            <template v-if="!isDTOnly(machine)">
                                                <div
                                                    v-for="cfg in detailSelects"
                                                    :key="cfg.key"
                                                    class="p-2 flex-auto sm:flex-1"
                                                >
                                                    <label :for="`${cfg.idPrefix}${cfg.includeTab ? selectedTab : ''}${index}${indexDetail}`">
                                                        {{ $t(cfg.labelKey) }}
                                                    </label>
                                                    <select
                                                        :id="`${cfg.idPrefix}${cfg.includeTab ? selectedTab : ''}${index}${indexDetail}`"
                                                        class="form-select text-white-dark"
                                                        v-model="detail[cfg.key]"
                                                        required
                                                    >
                                                        <option :value="null">
                                                            {{ $t("report.form.default") }}
                                                        </option>
                                                        <option
                                                            v-for="opt in detailOptions[cfg.optionsKey]"
                                                            :key="opt.id"
                                                            :value="opt.id"
                                                        >
                                                            {{ getTranslation(opt) }}
                                                        </option>
                                                    </select>
                                                </div>
                                            </template>
                                            <div
                                                class="p-2 flex-auto sm:flex-1"
                                                v-if="!isDTOnly(machine)"
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
                                                    type="number"
                                                    v-model.number="detail.dt"
                                                    @input="clampDt(detail)"
                                                    min="0"
                                                    :max="LIMITS.DT_MAX"
                                                    step="1"
                                                    class="form-input text-white-dark"
                                                    :placeholder="$t('report.form.dtPlaceholder')"
                                                />
                                            </div>
                                            <div
                                                class="flex"
                                                v-if="!isDTOnly(machine)"
                                            >
                                                <button
                                                    type="button"
                                                    @click="removeMachineDetailAt(index, indexDetail)"
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
                                                v-if="!isDTOnly(machine) && activePostTab?.machines?.[index]?.machine_details?.length < 5"
                                                type="button"
                                                class="btn btn-secondary gap-2"
                                                @click="addMachineDetailAt(index)"
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
                                            v-if="!isDTOnly(machine)"
                                        >
                                            <template v-if="isMultiTransport(machine)">
                                                <div class="w-full flex justify-evenly flex-wrap">
                                                    <div
                                                        v-for="cfg in transportConfig"
                                                        :key="cfg.key"
                                                        class="p-2 flex-auto sm:flex-1"
                                                    >
                                                        <label :for="`formTransport${cfg.idx}${index}`">{{ $t(cfg.labelKey) }}</label>
                                                        <input
                                                            :id="`formTransport${cfg.idx}${index}`"
                                                            v-model.number="activePostTab.machines[index][cfg.key]"
                                                            @input="transportValidation(index)"
                                                            type="number"
                                                            class="form-input"
                                                            min="0.0"
                                                            :max="LIMITS.TRANSPORT_MAX"
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
                                                    :max="LIMITS.TRANSPORT_MAX"
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
                                    :max="LIMITS.PIECES_MAX"
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
                                    :max="LIMITS.TIME_ON_MAX"
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
                                    :max="LIMITS.TRAVEL_TIME_MAX"
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
                                    <option :value="1">{{ $t("catalogs.typeReport.1") }}</option>
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
                                    v-model.number="activeTab.status_id"
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
                                    :custom-label="labelPart"
                                    :preserveSearch="true"
                                    v-bind="multiselectLabels"
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
                                                v-model.number="item.quantity"
                                                step="1"
                                                :max="LIMITS.PART_QTY_MAX"
                                                min="1"
                                                @input="partQtyValidation(i)"
                                            />
                                        </td>
                                        <td>
                                            <button
                                                type="button"
                                                @click="removePartAt(i)"
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
                        v-if="hasActiveMachine && activePostTab"
                        class="flex flex-wrap justify-evenly w-full"
                    >
                        <template
                            v-for="(machine,index) in machinesListing"
                            :key="machineKey(machine, index)"
                        >
                            <div
                                v-if="!isDTOnly(machine) && activePostTab?.machines?.[index]"
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
    TABS_MAX: 10,
} as const;
const clamp = (n: number, min: number, max: number) => Math.min(max, Math.max(min, n));

const transportConfig = [
  { key: 'transport_1' as const, labelKey: 'report.form.initialTransport' as const, idx: 1 },
  { key: 'transport_2' as const, labelKey: 'report.form.finalTransport'   as const, idx: 2 },
  { key: 'transport_3' as const, labelKey: 'report.form.estimatedTransport' as const, idx: 3 },
] as const;

const detailSelects = [
  { key: 'module_id' as const,       labelKey: 'report.form.error'    as const, optionsKey: 'module'  as const, idPrefix: 'formModule',  includeTab: true  },
  { key: 'failure_id' as const,      labelKey: 'report.form.cause'    as const, optionsKey: 'failure' as const, idPrefix: 'formFailures',includeTab: false },
  { key: 'failure_type_id' as const, labelKey: 'report.form.solution' as const, optionsKey: 'type'    as const, idPrefix: 'formTypes',   includeTab: false },
] as const;

interface MachineDetail {
  module_id: number | null;
  failure_id: number | null;
  failure_type_id: number | null;
  dt: number | null;
}

interface PostTabMachine {
  machine_id: number;
  machine_details: MachineDetail[];
  transport_1: number | null;
  transport_2: number | null;
  transport_3: number | null;
  dt: number | null;
  signature_client_name: string | null;
}

type PostTab = { machines: PostTabMachine[] };

type SelectedMachine = {
  id: number;
  serial: string;
  only_dt?: number;
  line_num?: number | string;
  production_line?: {
    id: number | null;
    machines: Array<{
      id: number;
      serial?: string;
      only_dt?: number;
      machine_model?: { model?: string; model_segment?: { segment?: string; is_multi_transport?: number } };
    }>;
  } | null;
  machine_model?: { model?: string; model_segment?: { segment?: string; is_multi_transport?: number } };
};

interface Tab {
  id: number;
  selectedClient: { id: number; name?: string } | null;
  selectedMachine: SelectedMachine | null;
  selectedBranch: { id: number; address?: string; city?: { name: string }; branch_managers?: Array<{ id: number; name: string }> } | null;
  selectedContact: { id: number; name?: string; email?: string; phone?: string } | null;
  selectedShift: { id: number; name?: string } | null;
  selectedUser: { id: number; emp?: string; nombre?: string; apellido_paterno?: string } | null;
  pieces: number | null;
  sogd: string | null;
  time_on: number | null;
  travel_time: number | null;
  report_type_id: 1 | 2;
  reported_error: string;
  code_id: number | null;
  actions_taken: string;
  reported: string | null;
  departure: string | null;
  arrival: string | null;
  finished: string | null;
  status_id: number | null;
  is_tested: boolean | null;
  service_parts: Array<{ id?: number; num_part?: string; descripcion?: string; quantity?: number }>;
  notes: string;
}

const API = {
  reports: '/reports',
  partsAutocomplete: '/parts/autocomplete',
  clientBranches: (id: number) => `/clients/${id}/branches`,
  clientMachines: (id: number) => `/clients/${id}/machines`,
  machineBySerial: (serial: string) => `/machine/${serial}`,
} as const;

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
type Part = { id: number; num_part: string; descripcion: string };
type Branch = NonNullable<Tab['selectedBranch']>;
type Machine = SelectedMachine;

const catalogParts = ref<Part[]>([]);
type LoaderFlags = { waiting: boolean; searching: boolean };
const loaders = reactive<{ parts: LoaderFlags }>({
    parts: { waiting: true, searching: false},
});
defineOptions({
    layout: [SiteLayout, AppLayout],
});

const createPostTab = (): PostTab => ({ machines: [] as PostTabMachine[] });
const ensurePostTab = (i: number): PostTab =>
    (report.tabs[i] ??= createPostTab());

const activeTab = computed(() => tabs.value[selectedTab.value]);
const activePostTab = computed(() => report.tabs[selectedTab.value]);

const hasSelectedBranch = computed<boolean>(() => !!form.selectedBranch);
const hasActiveMachine = computed<boolean>(() => !!activeTab.value?.selectedMachine);

const isDTOnly = (m?: { only_dt?: number } | null) => m?.only_dt === 1;
const isMultiTransport = (
    m?: { machine_model?: { model_segment?: { is_multi_transport?: number } } } | null
) => m?.machine_model?.model_segment?.is_multi_transport === 1;

const branchManagers = computed(() =>
  form.selectedBranch?.branch_managers ?? []
);

const detailOptions = computed(() => ({
  module: moduleOptions.value,
  failure: failureOptions.value,
  type:   typeOptions.value,
}));

const toMachineList = (selected: SelectedMachine | null) => {
    if (!selected) return [];
    const pl = selected.production_line;
    const hasLine = pl && pl.id != null && pl.machines?.length;
    return hasLine ? pl.machines : [selected];
};

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
    catalogClients: Array<{ id: number; name: string }>;
}>();

const datePosition = computed(() => (store.rtlClass === 'rtl' ? 'auto right' : 'auto left'));

function makePickerConfig(dateFormat: string, enableTime = false) {
  return { enableTime, dateFormat, position: datePosition.value };
}

const dateTime = computed(() => makePickerConfig("Y-m-d H:i", true));

const basic = computed(() => makePickerConfig('Y-m-d'));

interface HeaderSelection {
  selectedClient: { id: number; name?: string } | null;
  selectedBranch: Branch | null;
  selectedContact: { id: number; name?: string; email?: string; phone?: string } | null;
  selectedShift: { id: number; name?: string } | null;
  selectedUser: { id: number; emp?: string; nombre?: string; apellido_paterno?: string } | null;
}

const form = reactive<HeaderSelection>({
    selectedClient: null,
    selectedBranch: null,
    selectedContact: null,
    selectedShift: null,
    selectedUser: null,
});

function onBranchSelect() {
    form.selectedContact = null;
}

const labelUser = (u: { emp: string; nombre: string; apellido_paterno: string }) =>
  `${u.emp} - ${u.nombre} ${u.apellido_paterno}`;

const labelShift = (s: { id: number; name: string }) =>
  `${t('catalogs.shift.' + s.id, s.name)}`;

const labelClient = (c: { name: string }) => `${c.name}`;

const labelBranch = (b: { address: string; city: { name: string } }) => `${b.city.name} - ${b.address}`;

const labelContact = (c: { name: string }) => `${c.name}`;

const labelMachine = (m: { serial: string; machine_model?: { model?: string } }) =>
    `${m.machine_model?.model ?? '-'} - ${m.serial}`;

const labelPart = (p: { num_part: string; descripcion: string }) =>
  `${p.num_part} - ${p.descripcion}`;

const multiselectLabels = {
    selectedLabel: '',
    selectLabel: '',
    deselectLabel: '',
} as const;

const canAddTab = computed(() => tabs.value.every(t => !!t.selectedMachine));

const partSearch = ref<Part | null>(null);

const createMachineDetail = (): MachineDetail => ({
  module_id: null,
  failure_id: null,
  failure_type_id: null,
  dt: null,
});

const createPostTabMachine = (machine_id: number): PostTabMachine => ({
  machine_id,
  machine_details: [createMachineDetail()],
  transport_1: null,
  transport_2: null,
  transport_3: null,
  dt: null,
  signature_client_name: null,
});

let tabId = 0;

const createTab = (): Tab => ({
    id: ++tabId,
    selectedClient: null,
    selectedMachine: null,
    selectedBranch: null,
    selectedContact: null,
    selectedShift: null,
    selectedUser: null,
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

const tabs = ref<Tab[]>([createTab()]);
const selectedTab = ref<number>(0);
function addTab() {
    tabs.value.push(createTab());
    report.tabs.push(createPostTab());
}

const branchesCatalog = ref<Branch[]>([]);
const machinesCatalog = ref<Machine[]>([]);

const currentLocale = computed(() => store.locale);

function getTranslation(item: LocalizedItem): string {
    const { value: locale } = currentLocale;
    if (locale === 'es' && item.es) return item.es;
    if (locale === 'pt' && item.pt) return item.pt;
    return item.name ?? '';
}

type Translatable = { name?: string; es?: string; pt?: string };
const sortByTranslation = <T extends Translatable>(arr: T[]) =>
    [...arr].sort((a, b) => getTranslation(a).localeCompare(getTranslation(b)));

const moduleOptions = computed(() => sortByTranslation(props.catalogModule));
const failureOptions = computed(() => sortByTranslation(props.catalogFailures));
const typeOptions = computed(() => sortByTranslation(props.catalogTypes));  

const removePartAt = (index: number) => {
    activeTab.value.service_parts.splice(index, 1);
};

function removeMachineDetailAt(i: number, j: number): void {
    const m = activePostTab.value?.machines?.[i];
    if (!m?.machine_details || m.machine_details.length <= 1) return;
    m.machine_details.splice(j, 1);
};

const addNewPart = () => {
    if (!partSearch.value) return;
    const existingPartIndex = activeTab.value.service_parts.findIndex(p => p.id === partSearch.value.id);
    if (existingPartIndex === -1) {
        activeTab.value.service_parts.push({ ...partSearch.value, quantity: 1 });
        return;
    }
    const item = activeTab.value.service_parts[existingPartIndex];
    item.quantity = (item.quantity ?? 0) + 1;
};

const updateMachines = (selectedMachine: SelectedMachine | null) => {
    if (!selectedMachine) return;

    const list = toMachineList(selectedMachine);

    ensurePostTab(selectedTab.value).machines = list.map((m) => createPostTabMachine(m.id));
};

const machineKey = (m: { id?: number; serial?: string }, idx: number) =>
  `${activeTab.value.id}-${m.id ?? m.serial ?? idx}`;

const tzToken = () => {
    const m = new Date().toString().match(/([A-Z]+[\+-]\d{4})/);
    return m?.[1] ?? 'UTC+0000';
};

const TODAY_YYYY_MM_DD = (() => {
  const now = new Date();
  const y = now.getFullYear();
  const m = String(now.getMonth() + 1).padStart(2, '0');
  const d = String(now.getDate()).padStart(2, '0');
  return `${y}-${m}-${d}`;
})();

const report = reactive<{
  service_date: string;
  service_timezone: string;
  tabs: PostTab[];
}>({
  service_date: TODAY_YYYY_MM_DD,
  service_timezone: tzToken(),
  tabs: [createPostTab()],
});

const machinesListing = computed(() => {
    const sm = activeTab.value?.selectedMachine ?? null;
    return toMachineList(sm);
});

function transportValidation(index: number) {
    const m = activePostTab.value?.machines?.[index];
    if (!m) return;

    transportConfig.forEach(({ key }) => {
        clampField(m as Record<string, unknown>, key, { decimals: 1, min: 0, max: LIMITS.TRANSPORT_MAX });
    });
}

const clampField = <T extends Record<string, any>>(obj: T, key: keyof T, { decimals = 0, min, max }: { decimals?: number; min: number; max: number }) => {
    const raw = Number(obj[key]) || 0;
    const normalized = decimals === 0
        ? Math.trunc(raw)
        : Math.round(raw * 10 ** decimals) / 10 ** decimals;
    obj[key] = clamp(normalized, min, max) as any;
};

function clampActiveTab<K extends keyof Tab>(key: K, cfg: { decimals?: number; min: number; max: number }) {
  clampField(activeTab.value as unknown as Record<string, any>, key as string, cfg);
}

function partQtyValidation(index: number) {
    const p = activeTab.value.service_parts[index];
    if (!p) return;
    clampField(p as Record<string, unknown>, 'quantity', { min: 1, max: LIMITS.PART_QTY_MAX });
}

function machineOnValidation() {
    clampActiveTab('time_on', { decimals: 2, min: 0, max: LIMITS.TIME_ON_MAX });
}

const clampDt = (target: { dt: number | null }) => {
    clampField(target, 'dt', { min: 0, max: LIMITS.DT_MAX });
};

function partsValidation() {
    clampActiveTab('pieces', { min: 0, max: LIMITS.PIECES_MAX });
}

function travelTimeValidation() {
    clampActiveTab('travel_time', { min: 0, max: LIMITS.TRAVEL_TIME_MAX });
}

async function onClientSelect(option: { id: number }) {
    if (form.selectedClient?.id === option.id) return;

    tabId = 0;
    tabs.value = [createTab()];
    selectedTab.value = 0;
    report.tabs = [createPostTab()];

    form.selectedBranch = null;
    form.selectedContact = null;
    branchesCatalog.value = [];
    machinesCatalog.value = [];
    try {
        const [ branchesRes, machinesRes ] = await Promise.all([
            axios.get(API.clientBranches(option.id)),
            axios.get(API.clientMachines(option.id)),
        ]);

        branchesCatalog.value = branchesRes.data;
        machinesCatalog.value = machinesRes.data;
    } catch (e) {
        branchesCatalog.value = []
        machinesCatalog.value = []
    }
}

async function onMachineSelect(option: { serial: string }) {
    if (activeTab.value?.selectedMachine?.serial === option.serial) return;

    try {
        const { data } = await axios.get(API.machineBySerial(option.serial));
        ensurePostTab(selectedTab.value);
        updateMachines(data);
        activeTab.value.selectedMachine = data;
    } catch (e) {
        console.error("Error:", e);
        activeTab.value.selectedMachine = null;
    }
}

const debounce = <F extends (...args: any[]) => void>(fn: F, ms = 300) => {
  let id: number | undefined;
  return (...args: Parameters<F>) => {
    if (id) clearTimeout(id);
    id = window.setTimeout(() => fn(...args), ms);
  };
};

const runPartsAutocomplete = debounce((q: string) => {
  loaders.parts.searching = true;
  loaders.parts.waiting = false;
  axios
    .post(API.partsAutocomplete, { query: q })
    .then(({ data }) => {
      catalogParts.value = data ?? [];
    })
    .catch((error) => console.error("Error:", error))
    .finally(() => {
      loaders.parts.searching = false;
      loaders.parts.waiting = true;
    });
}, 750);

function selectPartChange(searchQuery: string) {
    catalogParts.value = [];
    if (!searchQuery?.length) return;

    runPartsAutocomplete(searchQuery);
}

function addMachineDetailAt(i: number): void {
    const list = activePostTab.value?.machines?.[i]?.machine_details;
    if (!list) return;
    if (list.length < LIMITS.MACHINE_DETAILS_MAX) {
        list.push(createMachineDetail());
    }
}

type ServicePartPayload = { id: number; quantity: number };
type TabPayload = {
  selected_machine_id: number | null;
  pieces: number;
  sogd: string | null;
  time_on: number;
  travel_time: number;
  report_type_id: 1 | 2;
  reported_error: string;
  code_id: number | null;
  actions_taken: string;
  reported: string | null;
  departure: string | null;
  arrival: string | null;
  finished: string | null;
  status_id: number | null;
  is_tested: boolean;
  service_parts: ServicePartPayload[];
  notes: string;
  machines: PostTabMachine[];
};
type ReportHeader = {
  user_id: number | null;
  shift_id: number | null;
  branch_id: number | null;
  branch_manager_id: number | null;
  service_date: string;
  service_timezone: string;
};
type ReportPayload = ReportHeader & { tabs: TabPayload[] };

function buildPayload(): ReportPayload {
    const header: ReportHeader = {
        user_id: form.selectedUser?.id ?? null,
        shift_id: form.selectedShift?.id ?? null,
        branch_id: form.selectedBranch?.id ?? null,
        branch_manager_id: form.selectedContact?.id ?? null,
        service_date: report.service_date,
        service_timezone: report.service_timezone,
    };

    const tabsPayLoad: TabPayload[] = tabs.value.map((t, i) => ({
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
        service_parts: (t.service_parts ?? [])
            .filter((p): p is { id: number; quantity?: number } => p.id != null)
            .map((p) => ({
                id: Number(p.id),
                quantity: clamp(Math.trunc(Number(p.quantity ?? 1)), 1, LIMITS.PART_QTY_MAX),
            })),
        notes: t.notes ?? "",
        machines: report.tabs[i]?.machines ?? [],
    }));

    return { ...header, tabs: tabsPayLoad };
}

function submit() {
    const payload = buildPayload();
    
    Swal.fire({
        title: t("report.alert.processing"),
        text: t("report.alert.processingText"),
        allowOutsideClick: false,
        showConfirmButton: false,
        customClass: "sweet-alerts",
        didOpen: () => Swal.showLoading(),
    });

    router.post(API.reports, payload, {
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