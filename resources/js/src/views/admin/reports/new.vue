<template>
    <Head title="New Report" />
    <div>
        <div class="flex xl:flex-row flex-col gap-2.5">
            <div class="panel px-0 flex-1 py-6 ltr:xl:mr-6 rtl:xl:ml-6">
                <div class="flex px-4">
                    <div class="w-full">
                        <div class="flex items-center">
                            <label for="formServiceDate" class="w-[140px] text-right mb-0 mr-[10px]">{{ $t("report.form.serviceDate") }}
                                <span class="text-red-500">*</span>
                            </label>
                            <flat-pickr id="formServiceDate" v-model="report.service_date" class="form-input flex-1" :config="dateOnly"></flat-pickr>
                        </div>
                    </div>
                </div>
                <div class="flex px-4 mt-4" v-if="usePage().props.auth?.type === 1">
                    <div class="w-full">
                        <div class="flex items-center">
                            <label for="formUser" class="w-[140px] text-right mb-0 mr-[10px]">{{ $t("report.form.user") }}
                                <span class="text-red-500">*</span>
                            </label>
                            <multiselect v-tippy:user id="formUser" :options="catalogUsers" v-model="form.selectedUser" track-by="id" class="custom-multiselect flex-1" searchable :placeholder="DEFAULT_PLACEHOLDER" :custom-label="userLabel" v-bind="multiselectLabels"></multiselect>
                            <tippy target="user" trigger="focus">Usado para la búsqueda y selección de usuarios, utiliza el siguiente formato: <br>"EMP - Nombre PrimerApellido" </tippy>
                        </div>
                        <p v-if="errors.user_id" class="text-danger mt-1 text-center">
                            {{ errors.user_id }}
                        </p>
                    </div>
                </div>
                <div class="flex px-4 mt-4">
                    <div class="w-full">
                        <div class="flex items-center">
                            <label for="formShift" class="w-[140px] text-right mb-0 mr-[10px]">{{ $t("report.form.shift") }}
                                <span class="text-red-500">*</span>
                            </label>
                            <multiselect v-tippy:shift id="formShift" :options="props.catalogShifts" v-model="form.selectedShift" track-by="id" class="custom-multiselect flex-1" :searchable="false" :placeholder="DEFAULT_PLACEHOLDER" :custom-label="shiftCustomLabel" v-bind="multiselectLabels"></multiselect>
                            <tippy target="shift" trigger="focus">Usado para la selección del turno de la realización del reporte</tippy>
                        </div>
                        <p v-if="errors.shift_id" class="text-danger mt-1 text-center">
                            {{ errors.shift_id }}
                        </p>
                    </div>
                </div>
                <div class="flex px-4 mt-4">
                    <div class="w-full">
                        <div class="flex items-center">
                            <label for="formCatalogClient" class="w-[140px] text-right mb-0 mr-[10px]">Cliente <span class="text-red-500">*</span>
                            </label>
                            <multiselect id="formCatalogClient" :options="catalogClients" @select="onClientSelect" v-model="form.selectedClient" track-by="id" class="custom-multiselect flex-1" searchable :placeholder="DEFAULT_PLACEHOLDER" :custom-label="nameOrDash" v-bind="multiselectLabels"></multiselect>
                        </div>
                    </div>
                </div>
                <div class="flex px-4 mt-4">
                    <div class="w-full">
                        <div class="flex items-center">
                            <label for="formCatalogBranches" class="w-[140px] text-right mb-0 mr-[10px]">Sucursal <span class="text-red-500">*</span>
                            </label>
                            <multiselect @select="form.selectedContact = null" id="formCatalogBranches" :options="branchesCatalog" v-model="form.selectedBranch" track-by="id" class="custom-multiselect flex-1" searchable :placeholder="DEFAULT_PLACEHOLDER" :custom-label="branchLabel" :disabled="!branchesCatalog.length || loadingClient" v-bind="multiselectLabels"></multiselect>
                        </div>
                    </div>
                </div>
                <div class="flex px-4 mt-4">
                    <div class="w-full">
                        <div class="flex items-center">
                            <label for="formCatalogContact" class="w-[140px] text-right mb-0 mr-[10px]">Contacto <span class="text-red-500">*</span>
                            </label>
                            <multiselect id="formCatalogContact" :options="form.selectedBranch?.branch_managers ?? []" v-model="form.selectedContact" track-by="id" class="custom-multiselect flex-1" searchable :placeholder="DEFAULT_PLACEHOLDER" :custom-label="nameOrDash" :disabled="!form.selectedBranch || loadingClient" v-bind="multiselectLabels"></multiselect>
                        </div>
                    </div>
                </div>
                <hr class="border-[#e0e6ed] dark:border-[#1b2e4b] my-6" />
                <div class="mt-6 px-4">
                    <div class="flex items-center">
                        <div id="dataset-tabs" class="flex-1">
                            <div class="flex items-end gap-1 overflow-x-auto border-b border-[#e0e6ed] dark:border-[#1b2e4b] pb-0.5">
                                <!-- Active tab -->
                                <button @click="selectedTab = index" v-for="(tab, index) in tabs" :key="index" type="button" class="-mb-px px-3 h-9 inline-flex items-center rounded-t border-b-2 border-transparent text-sm text-slate-500 hover:text-slate-700 hover:border-slate-300" :class="tabButtonClass(index)"> #{{ index + 1 }}
                                </button>
                                <!-- Botón Agregar (visual, no funcional) -->
                                <div class="ml-2 -mb-px h-9 flex items-center">
                                    <button v-if="tabs.length < LIMITS.TABS_MAX" type="button" :disabled="!tabs.every(t => !!t.selectedMachine)" @click="tabs.push(createTab())" class="h-8 px-2 inline-flex items-center gap-1 rounded border border-dashed border-slate-300 dark:border-slate-600 text-xs text-slate-600 hover:border-slate-400 hover:text-slate-800 disabled:opacity-50 disabled:cursor-not-allowed disabled:border-slate-200 disabled:text-slate-400">
                                        <!-- plus icon -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14" />
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
                            <label for="formCatalogMachines" class="text-lg font-normal mb-0 mr-[10px]">{{ $t("report.form.machines") }}
                                <span class="text-red-500">*</span>
                            </label>
                            <multiselect @select="onMachineSelect" id="formCatalogMachines" :options="machinesCatalog" v-model="activeTab.selectedMachine" track-by="id" class="custom-multiselect flex-1" searchable :placeholder="DEFAULT_PLACEHOLDER" :custom-label="machineLabel" :disabled="!machinesCatalog.length || loadingClient" v-bind="multiselectLabels"></multiselect>
                        </div>
                    </div>
                    <template v-if="activeTab.selectedMachine">
                        <div class="flex flex-wrap justify-evenly mt-4">
                            <div v-for="(machine, index) in machinesListing" :key="machine.id ?? machine.serial" :class="machineCardClass(machine)" class="rounded-md p-4 mb-4">
                                <div class="text-center font-semibold"> Serial: {{ machine.serial }} - {{ machine.machine_model?.model ?? '-' }} - {{ machine.line_num
                                            ?? machine.machine_model?.model_segment?.segment
                                            ?? '-'
                                    }}
                                </div>
                                <div class="w-full" v-if="machineAt(index)">
                                    <div class="flex justify-evenly flex-wrap">
                                        <div v-for="(detail, indexDetail) in machineAt(index).machine_details" :key="indexDetail" class="flex-[100%] flex justify-evenly flex-wrap">
                                            <template v-if="!isOnlyDT(machine)">
                                                <div v-for="cfg in detailSelects" :key="cfg.key" class="p-2 flex-auto sm:flex-1">
                                                    <label :for="uid(cfg.idPrefix, selectedTab, index, indexDetail)">
                                                        {{ $t(cfg.labelKey) }}
                                                    </label>
                                                    <select :id="uid(cfg.idPrefix, selectedTab, index, indexDetail)" class="form-select text-white-dark" v-model="detail[cfg.key]" required>
                                                        <option :value="null">
                                                            {{ DEFAULT_PLACEHOLDER }}
                                                        </option>
                                                        <option v-for="opt in detailOptions[cfg.optionsKey]" :key="opt.id" :value="opt.id">
                                                            {{ getTranslation(opt) }}
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="p-2 flex-auto sm:flex-1">
                                                    <label :for="uid('formErrorDT', selectedTab, index, indexDetail)">DT (Min.)</label>
                                                    <input :id="uid('formErrorDT', selectedTab, index, indexDetail)" type="number" v-model.number="detail.dt" @input="clampField(detail as any, 'dt', DT_SPEC)" min="0" :max="LIMITS.DT_MAX" step="1" class="form-input text-white-dark" :placeholder="DT_PLACEHOLDER" />
                                                </div>
                                                <div class="flex">
                                                    <button type="button" @click="machineAt(index).machine_details.splice(indexDetail, 1)" v-if="machineAt(index)?.machine_details?.length > 1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </template>
                                        </div>
                                        <div class="w-full flex justify-center">
                                            <button v-if="canAddDetail(index)" type="button" class="btn btn-secondary gap-2" @click="machineAt(index).machine_details.push({ ...DEFAULT_DETAIL })">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="py-2" v-if="!isOnlyDT(machine)">
                                            <template v-if="toBool(machine?.machine_model?.model_segment?.is_multi_transport)">
                                                <div class="w-full flex justify-evenly flex-wrap">
                                                    <div v-for="(cfg, tIndex) in transportConfig" :key="cfg.key" class="p-2 flex-auto sm:flex-1">
                                                        <label :for="uid('formTransport', selectedTab, tIndex + 1, index)">{{ $t(cfg.labelKey) }}</label>
                                                        <input :id="uid('formTransport', selectedTab, tIndex + 1, index)" v-model.number="machineAt(index)[cfg.key]" @input="clampTransports(machineAt(index))" type="number" class="form-input" :min="LIMITS.TRANSPORT_MIN" :max="LIMITS.TRANSPORT_MAX" :step="LIMITS.TRANSPORT_STEP" placeholder="0.0" />
                                                    </div>
                                                </div>
                                            </template>
                                            <template v-else-if="machineAt(index)">
                                                <label :for="uid('formShiftTotal11', selectedTab, index)">{{ $t("report.form.transport") }}</label>
                                                <input :id="uid('formShiftTotal11', selectedTab, index)" v-model="machineAt(index).transport_1" @input="clampTransports(machineAt(index))" name="formShiftTotal11" class="form-input text-white-dark" type="number" :min="LIMITS.TRANSPORT_MIN" :max="LIMITS.TRANSPORT_MAX" :step="LIMITS.TRANSPORT_STEP" placeholder="0.0" />
                                            </template>
                                        </div>
                                        <div class="py-2">
                                            <label :for="uid('formReportDT', selectedTab, index)">DT Final (Min.)</label>
                                            <input :id="uid('formReportDT', selectedTab, index)" type="number" v-model.number="machineAt(index).dt" class="form-input text-white-dark" :placeholder="DT_PLACEHOLDER" @input="clampField(machineAt(index) as any, 'dt', DT_SPEC)" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
                <hr class="border-[#e0e6ed] dark:border-[#1b2e4b] my-6" />
                <div class="mt-8 px-4">
                    <div class="flex justify-between lg:flex-row flex-col flex-wrap">
                        <div class="lg:w-1/2 w-full ltr:lg:pr-6 rtl:lg:pl-6 mb-6">
                            <div class="mt-4 flex items-center">
                                <label for="formReportPieces" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">{{ $t("report.form.pieces") }}</label>
                                <input v-tippy:pieces id="formReportPieces" type="number" v-model.number="activeTab.pieces" name="formReportPieces" step="1" class="form-input flex-1" placeholder="0" min="0" :max="LIMITS.PIECES_MAX" @input="clampField(activeTab as any, 'pieces', PIECES_SPEC)" />
                                <tippy target="pieces" trigger="focus">Utilizado como contador de billetes <br> Máximo: 999 999 999 999 </tippy>
                            </div>
                            <div class="mt-4 flex items-center">
                                <label for="formReportSOGD" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">{{ $t("report.form.SOGD") }}</label>
                                <input v-tippy:sogd id="formReportSOGD" type="text" v-model="activeTab.sogd" name="formReportSOGD" class="form-input flex-1" :placeholder="$t('report.form.SOGDPlaceholder')" />
                                <tippy target="sogd" trigger="focus">Utilizado para capturar la orden de servicio de GD</tippy>
                            </div>
                        </div>
                        <div class="lg:w-1/2 w-full">
                            <div class="flex items-center mt-4">
                                <label for="formReportOnTime" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">{{ $t("report.form.machineOn") }}</label>
                                <input v-tippy:ontime id="formReportOnTime" :step="LIMITS.TIME_ON_STEP" type="number" v-model.number="activeTab.time_on" name="formReportOnTime" class="form-input flex-1" placeholder="0.00" :min="LIMITS.TIME_ON_MIN" :max="LIMITS.TIME_ON_MAX" @input="clampField(activeTab as any, 'time_on', TIME_ON_SPEC)" />
                                <tippy target="ontime" trigger="focus">Utilizado para registrar el tiempo de funcionamiento de la máquina <br> Máximo: 9 999 999.99 </tippy>
                            </div>
                            <div class="flex items-center mt-4">
                                <label for="formReportTravelTime" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">{{ $t("report.form.travelTime") }}</label>
                                <input v-tippy:traveltime id="formReportTravelTime" type="number" v-model.number="activeTab.travel_time" name="formReportTravelTime" class="form-input flex-1" placeholder="0" :step="LIMITS.TRAVEL_TIME_STEP" :min="LIMITS.TRAVEL_TIME_MIN" :max="LIMITS.TRAVEL_TIME_MAX" @input="clampField(activeTab as any, 'travel_time', TRAVEL_TIME_SPEC)" />
                                <tippy target="traveltime" trigger="focus">Utilizado para registrar el tiempo de traslado <br> Máximo: 10 080 minutos </tippy>
                            </div>
                            <div class="flex items-center mt-4">
                                <label for="formReportType" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">{{ $t("report.form.type") }}</label>
                                <select id="formReportType" name="formReportType" v-model.number="activeTab.report_type_id" class="form-select text-white-dark flex-1" required>
                                    <option :value="1">{{ $t("catalogs.typeReport.1") }}</option>
                                    <option :value="2">{{ $t("catalogs.typeReport.2") }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="w-full mt-4">
                            <div class="flex items-center">
                                <label for="formReportedError" class="ltr:mr-2 rtl:ml-2 w-1/6 mb-0">{{ $t("report.form.reportedError") }}</label>
                                <textarea id="formReportedError" name="formReportedError" rows="3" v-model="activeTab.reported_error" class="form-textarea flex-1" :placeholder="$t('report.form.reportedErrorPlaceholder')" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="border-[#e0e6ed] dark:border-[#1b2e4b] my-6" />
                <div class="mt-8 px-4">
                    <div class="flex flex-wrap justify-evenly">
                        <label v-for="code in catalogCodes" :key="code.id" class="inline-flex">
                            <input type="radio" name="formReportCode" class="form-radio" :value="code.id" v-model.number="activeTab.code_id" />
                            <div class="flex flex-col">
                                <span>{{ code.code }}</span>
                                <span v-if="activeTab.code_id === code.id" class="text-xs">{{ catalogI18n('catalogs.codes', code.id, code.description) }}</span>
                            </div>
                        </label>
                    </div>
                    <div class="w-full">
                        <div class="mt-4 flex items-center">
                            <label for="formReportActions" class="ltr:mr-2 rtl:ml-2 w-1/6 mb-0">{{ $t("report.form.actionsTaken") }}</label>
                            <textarea id="formReportActions" name="formReportActions" v-model="activeTab.actions_taken" rows="3" class="form-textarea flex-1" :placeholder="$t('report.form.actionsTakenPlaceholder')" required></textarea>
                        </div>
                    </div>
                </div>
                <hr class="border-[#e0e6ed] dark:border-[#1b2e4b] my-6" />
                <div class="mt-8 px-4">
                    <div class="flex flex-wrap justify-evenly">
                        <template v-if="!hasProductionLine(selectedMachine)">
                            <div class="px-2 max-w-[180px]">
                                <label for="formReportReportedTime">
                                    {{ $t("report.form.reported") }}
                                </label>
                                <flat-pickr id="formReportReportedTime" name="formReportReportedTime" v-model="activeTab.reported" class="form-input flex-1" :config="dateTime"></flat-pickr>
                            </div>
                            <div class="px-2 max-w-[180px]">
                                <label for="formReportTimeDeparture">
                                    {{ $t("report.form.departure") }}
                                </label>
                                <flat-pickr id="formReportTimeDeparture" name="formReportTimeDeparture" v-model="activeTab.departure" class="form-input flex-1" :config="dateTime"></flat-pickr>
                            </div>
                        </template>
                        <div class="px-2 max-w-[180px]">
                            <label for="formReportTimeArrival">{{ $t("report.form.arrival") }}</label>
                            <flat-pickr id="formReportTimeArrival" name="formReportTimeArrival" v-model="activeTab.arrival" class="form-input flex-1" :config="dateTime"></flat-pickr>
                        </div>
                        <div class="px-2 max-w-[180px]">
                            <label for="formReportTimeFinished">
                                {{ $t("report.form.finished") }}
                            </label>
                            <flat-pickr id="formReportTimeFinished" name="formReportTimeFinished" v-model="activeTab.finished" class="form-input flex-1" :config="dateTime"></flat-pickr>
                        </div>
                        <div class="w-full flex flex-wrap justify-evenly py-4">
                            <label v-for="status in catalogStatus" :key="status.id" class="inline-flex">
                                <input type="radio" name="formReportStatus" class="form-radio" :value="status.id" v-model.number="activeTab.status_id" />
                                <span>{{ catalogI18n('catalogs.status', status.id, status.status) }}</span>
                            </label>
                        </div>
                        <div class="w-full flex flex-wrap justify-evenly">
                            <label class="inline-flex">
                                <input type="checkbox" v-model="activeTab.is_tested" class="form-checkbox rounded-full" />
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
                                <label for="formReportParts" class="w-[100px] text-right mb-0 mr-[10px]">{{ $t("report.form.parts") }}</label>
                                <multiselect @search-change="onPartsSearch" id="formReportParts" :options="catalogParts" v-model="partSearch" track-by="id" class="custom-multiselect flex-1" searchable :placeholder="$t('report.form.partsPlaceholder')" :custom-label="partLabel" preserveSearch v-bind="multiselectLabels"></multiselect>
                                <button :disabled="!partSearch" class="btn btn-secondary gap-2" @click="addNewPart">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                                        <line x1="12" y1="5" x2="12" y2="19"></line>
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
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
                                <template v-if="activeTab.service_parts.length <= 0">
                                    <tr>
                                        <td colspan="5" class="!text-center font-semibold">
                                            {{ $t("report.form.noItems") }}
                                        </td>
                                    </tr>
                                </template>
                                <template v-for="(item, i) in activeTab.service_parts" :key="item.id ?? i">
                                    <tr class="align-top">
                                        <td>
                                            {{ item.num_part }}
                                        </td>
                                        <td>
                                            {{ item.descripcion }}
                                        </td>
                                        <td>
                                            <input type="number" class="form-input w-32" placeholder="Quantity" v-model.number="item.quantity" :step="LIMITS.PART_QTY_STEP" :max="LIMITS.PART_QTY_MAX" :min="LIMITS.PART_QTY_MIN" @input="clampField(item as any, 'quantity', PART_QTY_SPEC)" />
                                        </td>
                                        <td>
                                            <button type="button" @click="activeTab.service_parts.splice(i, 1)">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                                    <line x1="6" y1="6" x2="18" y2="18"></line>
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
                        <textarea id="notes" name="notes" class="form-textarea min-h-[130px]" :placeholder="$t('report.form.remarksPlaceholder')" v-model="activeTab.notes"></textarea>
                    </div>
                </div>
                <hr class="border-[#e0e6ed] dark:border-[#1b2e4b] my-6" />
                <div class="mt-8 px-4">
                    <div v-if="activeTab.selectedMachine" class="flex flex-wrap justify-evenly w-full">
                        <template v-for="(machine,index) in machinesListing" :key="machine.id ?? machine.serial">
                            <div v-if="!isOnlyDT(machine) && machineAt(index)" class="text-center min-w-[270px]">
                                <label :for="uid('formSignatureName', selectedTab, machine.serial)" class="mb-0">
                                    {{ machine.serial }}
                                </label>
                                <input :id="uid('formSignatureName', selectedTab, machine.serial)" type="text" :name="uid('formSignatureName', selectedTab, machine.serial)" v-model="machineAt(index).signature_client_name" class="form-input flex-1" :placeholder="$t('report.form.signatureNamePlaceholder')" />
                            </div>
                        </template>
                    </div>
                </div>
            </div>
            <div class="xl:w-96 w-full xl:mt-0 mt-6">
                <div class="panel sticky top-[75px] left-0">
                    <div class="grid xl:grid-cols-1 lg:grid-cols-4 sm:grid-cols-2 grid-cols-1 gap-4">
                        <button type="button" class="btn btn-success w-full gap-2" @click="submit">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ltr:mr-2 rtl:ml-2 shrink-0">
                                <path d="M3.46447 20.5355C4.92893 22 7.28595 22 12 22C16.714 22 19.0711 22 20.5355 20.5355C22 19.0711 22 16.714 22 12C22 11.6585 22 11.4878 21.9848 11.3142C21.9142 10.5049 21.586 9.71257 21.0637 9.09034C20.9516 8.95687 20.828 8.83317 20.5806 8.58578L15.4142 3.41944C15.1668 3.17206 15.0431 3.04835 14.9097 2.93631C14.2874 2.414 13.4951 2.08581 12.6858 2.01515C12.5122 2 12.3415 2 12 2C7.28595 2 4.92893 2 3.46447 3.46447C2 4.92893 2 7.28595 2 12C2 16.714 2 19.0711 3.46447 20.5355Z" stroke="currentColor" stroke-width="1.5" />
                                <path d="M17 22V21C17 19.1144 17 18.1716 16.4142 17.5858C15.8284 17 14.8856 17 13 17H11C9.11438 17 8.17157 17 7.58579 17.5858C7 18.1716 7 19.1144 7 21V22" stroke="currentColor" stroke-width="1.5" />
                                <path opacity="0.5" d="M7 8H13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
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
    PART_QTY_MIN: 1,
    PART_QTY_STEP: 1,
    MACHINE_DETAILS_MAX: 5,
    TABS_MAX: 10,
    TRANSPORT_MIN: 0.0,
    TRANSPORT_STEP: 0.1,
    TIME_ON_MIN: 0.00,
    TIME_ON_STEP: 0.01,
    TRAVEL_TIME_MIN: 0,
    TRAVEL_TIME_STEP: 1,
} as const;
const PIECES_SPEC      = {               min: 0,                    max: LIMITS.PIECES_MAX };
const TIME_ON_SPEC     = { decimals: 2, min: LIMITS.TIME_ON_MIN,   max: LIMITS.TIME_ON_MAX };
const TRAVEL_TIME_SPEC = {              min: LIMITS.TRAVEL_TIME_MIN, max: LIMITS.TRAVEL_TIME_MAX };
const DT_SPEC          = {              min: 0,                     max: LIMITS.DT_MAX };
const TRANSPORT_SPEC   = { decimals: 1, min: LIMITS.TRANSPORT_MIN, max: LIMITS.TRANSPORT_MAX };
const PART_QTY_SPEC = { min: LIMITS.PART_QTY_MIN, max: LIMITS.PART_QTY_MAX };
const clamp = (n: number, min: number, max: number) => Math.min(max, Math.max(min, n));
const toBool = (v: unknown): boolean => v === 1 || v === true || v === '1';

const transportConfig = [
  { key: 'transport_1' as const, labelKey: 'report.form.initialTransport' as const },
    { key: 'transport_2' as const, labelKey: 'report.form.finalTransport' as const },
  { key: 'transport_3' as const, labelKey: 'report.form.estimatedTransport' as const},
] as const;

const detailSelects = [
  { key: 'module_id' as const,       labelKey: 'report.form.error'    as const, optionsKey: 'module'  as const, idPrefix: 'formModule' },
  { key: 'failure_id' as const,      labelKey: 'report.form.cause'    as const, optionsKey: 'failure' as const, idPrefix: 'formFailures' },
  { key: 'failure_type_id' as const, labelKey: 'report.form.solution' as const, optionsKey: 'type'    as const, idPrefix: 'formTypes' },
] as const;

interface MachineDetail {
  module_id: number | null;
  failure_id: number | null;
  failure_type_id: number | null;
  dt: number | null;
}
const DEFAULT_DETAIL: MachineDetail = { module_id: null, failure_id: null, failure_type_id: null, dt: null };

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
  selectedMachine: SelectedMachine | null;
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
  service_parts: ServicePart[];
  notes: string;
}

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
const DEFAULT_PLACEHOLDER = computed(() => t('report.form.default'));
const DT_PLACEHOLDER = computed(() => t('report.form.dtPlaceholder'));
const store = useAppStore();
const catalogI18n = (base: string, id: string | number, fallback?: string) =>
  t(`${base}.${id}`, fallback);

type Part = { id: number; num_part: string; descripcion: string };
type ServicePart = { id?: number; num_part?: string; descripcion?: string; quantity?: number };
type Branch = { id: number; address?: string; city?: { name: string }; branch_managers?: Array<{ id: number; name: string }> };

const catalogParts = ref<Part[]>([]);

const loaders = reactive({
    parts: { waiting: true, searching: false},
});
defineOptions({
    layout: [SiteLayout, AppLayout],
});

const getPostTab = (i: number): PostTab => {
  if (!report.tabs[i]) {
    report.tabs[i] = { machines: [] as PostTabMachine[] };
  }
  return report.tabs[i];
};
    
const activeTab = computed(() => tabs.value[selectedTab.value]);

const selectedMachine = computed(() => activeTab.value?.selectedMachine);

const detailOptions = computed(() => ({
    module: [...props.catalogModule].sort((a, b) => getTranslation(a).localeCompare(getTranslation(b))),
    failure: [...props.catalogFailures].sort((a, b) => getTranslation(a).localeCompare(getTranslation(b))),
    type:   [...props.catalogTypes].sort((a, b) => getTranslation(a).localeCompare(getTranslation(b))),
}));

const shiftCustomLabel = (s: { id?: number; name?: string }) =>
  catalogI18n('catalogs.shift', s.id ?? '', s.name ?? '-');

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

const dateTime = computed(() => ({
  enableTime: true,
  dateFormat: "Y-m-d H:i",
  position: (store.rtlClass === 'rtl' ? 'auto right' : 'auto left'),
}));

const dateOnly = computed(() => ({
  enableTime: false,
  dateFormat: 'Y-m-d',
  position: (store.rtlClass === 'rtl' ? 'auto right' : 'auto left'),
}));

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

const multiselectLabels = {
    selectedLabel: '',
    selectLabel: '',
    deselectLabel: '',
} as const;

const partSearch = ref<Part | null>(null);

const createTab = (): Tab => ({
    selectedMachine: null,
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
const loadingClient = ref(false);
const lastClientId = ref<number | null>(null);
let clientLoadSeq = 0;
let partsTimer: ReturnType<typeof setTimeout> | null = null;
const partsCache = new Map<string, Part[]>();
const selectedTab = ref(0);

const branchesCatalog = ref<Branch[]>([]);
const machinesCatalog = ref<SelectedMachine[]>([]);

function getTranslation(item: LocalizedItem): string {
    const locale = store.locale;
    if (locale === 'es' && item.es) return item.es;
    if (locale === 'pt' && item.pt) return item.pt;
    return item.name ?? '';
}

const branchLabel = (b: Branch) =>
    `${b.address ?? '-'}${b.city?.name?.trim() ? ' · ' + b.city.name : ''}`;

const machineLabel = (m: SelectedMachine) =>
    `${m.serial?.trim() || '-'}${m.machine_model?.model?.trim() ? ' · ' + m.machine_model.model : ''}`;

const isOnlyDT = (m: any) => toBool(m?.only_dt);

const hasProductionLine = (sm: SelectedMachine | null | undefined) =>
  sm?.production_line?.id != null;

const userLabel = (u: { emp?: string; nombre?: string; apellido_paterno?: string }) =>
    `${u.emp ?? '-'} - ${([u.nombre, u.apellido_paterno].filter(Boolean).join(' ') || '-')}`;

const partLabel = (p: { num_part?: string; descripcion?: string }) =>
  `${p?.num_part?.trim() || '-'} - ${p?.descripcion?.trim() || '-'}`;

const tabButtonClass = (i: number) =>
  i === selectedTab.value ? 'border-blue-600 font-medium text-slate-900 dark:text-slate-100' : '';

const uid = (...parts: Array<string | number>) =>
  parts.filter(p => p != null && String(p).length).join('-');

const machineAt = (i: number) => getPostTab(selectedTab.value).machines[i];

const canAddDetail = (i: number) => {
  const m = machineAt(i);
  return !isOnlyDT(m) && ((m?.machine_details?.length ?? 0) < LIMITS.MACHINE_DETAILS_MAX);
};

const machineCardClass = (m: any) => {
  const onlyDT = isOnlyDT(m);
  return {
    'bg-[#ececf9]': !onlyDT,
    'bg-gray-100': onlyDT,
    'ring-2 ring-amber-500 ring-offset-1':
      machinesListing.value.length > 1 && m?.serial === selectedMachine.value?.serial,
  };
};

const addNewPart = () => {
    const ps = partSearch.value;
    if (!ps) return;
    const list = activeTab.value.service_parts;
    const i = list.findIndex(p => p.id === ps.id);
    if (i < 0) list.push({ ...ps, quantity: 1 });
    else list[i].quantity = (list[i].quantity ?? 0) + 1;
};

const report = reactive<{
  service_date: string;
  service_timezone: string;
  tabs: PostTab[];
}>({
  service_date: (() => { const n = new Date(); return `${n.getFullYear()}-${String(n.getMonth()+1).padStart(2,'0')}-${String(n.getDate()).padStart(2,'0')}` })(),
  service_timezone: Intl.DateTimeFormat().resolvedOptions().timeZone,
  tabs: [],
});

const machinesListing = computed(() => {
    const sm = selectedMachine.value;
    if (!sm) return [];
    const pl = sm.production_line;
    return (pl?.id != null && pl.machines?.length) ? pl.machines : [sm];
});

type ClampSpec = { decimals?: number; min: number; max: number };
const clampField = <T extends Record<string, any>>(obj: T, key: keyof T, { decimals = 0, min, max }: ClampSpec) => {
    const raw = Number(obj[key]) || 0;
    const normalized = decimals === 0
        ? Math.trunc(raw)
        : Math.round(raw * 10 ** decimals) / 10 ** decimals;
    obj[key] = clamp(normalized, min, max) as any;
};

const clampTransports = (m: PostTabMachine) => {
  transportConfig.forEach(cfg => clampField(m as any, cfg.key, TRANSPORT_SPEC));
};

const nameOrDash = (x: { name?: string } | null | undefined) => x?.name?.trim() || '-';

const clearClientDependentState = () => {
    tabs.value = [createTab()];
    selectedTab.value = 0;
    report.tabs = [];
    form.selectedBranch = null;
    form.selectedContact = null;
    branchesCatalog.value = [];
    machinesCatalog.value = [];
    partSearch.value = null;
    catalogParts.value = [];
    partsCache.clear();
};

async function onClientSelect(option: { id: number }) {
    if (option.id === lastClientId.value) return;
    const seq = ++clientLoadSeq;

    clearClientDependentState();
    loadingClient.value = true;
    try {
        const [ branches, machines ] = await Promise.all([
            axios.get(`/clients/${option.id}/branches`).then(r => r.data),
            axios.get(`/clients/${option.id}/machines`).then(r => r.data),
        ]);
        if (seq !== clientLoadSeq) return;

        branchesCatalog.value = branches ?? [];
        machinesCatalog.value = machines ?? [];
        lastClientId.value = option.id;
    } catch (e) {
        console.error('Failed loading client data', e);
        lastClientId.value = null;
    }finally {
        if (seq === clientLoadSeq) loadingClient.value = false;
    }
}

async function onMachineSelect(option: { serial: string }) {
    if (activeTab.value?.selectedMachine?.serial === option.serial) return;

    try {
        const { data } = await axios.get(`/machine/${option.serial}`);
        const machines = (data.production_line?.id != null && data.production_line.machines?.length)
            ? data.production_line.machines
            : [data];

        const tabIndex = selectedTab.value;
        getPostTab(tabIndex).machines = machines.map(m => ({
            machine_id: m.id,
            machine_details: [{ ...DEFAULT_DETAIL }],
            transport_1: null,
            transport_2: null,
            transport_3: null,
            dt: null,
            signature_client_name: null,
        }));
        activeTab.value.selectedMachine = data;
    } catch (e) {
        console.error("Error:", e);
        activeTab.value.selectedMachine = null;
    }
}

const onPartsSearch = (q: string) => {
    catalogParts.value = [];
    const s = (q ?? '').trim();
    if (partsTimer) clearTimeout(partsTimer);
    if (!s.length) return;
    partsTimer = setTimeout(() => runPartsAutocomplete(s), 250);
};
const runPartsAutocomplete = async (q: string) => {
    if (partsCache.has(q)) {
        catalogParts.value = partsCache.get(q)!;
        return;
    }
    loaders.parts.searching = true;
    loaders.parts.waiting = false;
    try {
        const { data } = await axios.post('/parts/autocomplete', { query: q });
        const list: Part[] = (data ?? []) as Part[];
        partsCache.set(q, list);
        catalogParts.value = list;
    }catch(e) {
        console.error("Error:", e);
    }finally {
        loaders.parts.searching = false;
        loaders.parts.waiting = true;
    }
};

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

    const tabsPayload: TabPayload[] = tabs.value.map((t, i) => ({
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
        machines: getPostTab(i).machines,
    }));

    return { ...header, tabs: tabsPayload };
}

function submit() {
    const payload = buildPayload();
    console.log(payload);
    return;
    Swal.fire({
        title: t("report.alert.processing"),
        text: t("report.alert.processingText"),
        allowOutsideClick: false,
        showConfirmButton: false,
        customClass: "sweet-alerts",
        didOpen: () => Swal.showLoading(),
    });

    router.post('/reports', payload, {
        onSuccess: () => Swal.close(),
        onError: (error) => {
            const errorMessages = Object.values(error).map((e) => `<p>${e}</p>`).join('');
            Swal.close();
            Swal.fire({ icon: "error", title: "Oops...", html: errorMessages, customClass: "sweet-alerts" });
        },
    });
}
</script>