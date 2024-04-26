<template>
    <Head title="New Report" />
    <div>
        <div class="flex xl:flex-row flex-col gap-2.5">
            <div class="panel px-0 flex-1 py-6 ltr:xl:mr-6 rtl:xl:ml-6">
                <div class="flex px-4">
                    <div class="w-full">
                        <div class="flex items-center">
                            <label
                                for="formMachine"
                                class="w-[125px] text-right mb-0 mr-[10px]"
                                >{{ $t("report.form.machineSerial") }}
                                <span class="text-red-500">*</span></label
                            >

                            <multiselect
                                id="formMachine"
                                :options="props.catalogMachines"
                                v-model="form.selectedMachine"
                                class="custom-multiselect flex-1"
                                :searchable="true"
                                :placeholder="$t('report.form.default')"
                                :custom-label="
                                    ({ serial, machine_model }) =>
                                        `${serial} - ${machine_model.model}`
                                "
                                selected-label=""
                                select-label=""
                                deselect-label=""
                            ></multiselect>
                        </div>
                        <template v-if="errors.machines">
                            <p class="text-danger mt-1 text-center">
                                {{ errors.machines }}
                            </p>
                        </template>
                    </div>
                </div>
                <div class="flex px-4 mt-4" v-if="user.type === 1">
                    <div class="w-full">
                        <div class="flex items-center">
                            <label
                                for="formUser"
                                class="w-[125px] text-right mb-0 mr-[10px]"
                                >{{ $t("report.form.user") }} <span class="text-red-500">*</span></label
                            >

                            <multiselect
                                id="formUser"
                                :options="catalogUsers"
                                v-model="form.selectedUser"
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
                                class="w-[125px] text-right mb-0 mr-[10px]"
                                >{{ $t("report.form.shift") }}
                                <span class="text-red-500">*</span></label
                            >

                            <multiselect
                                id="formShift"
                                :options="props.catalogShifts"
                                v-model="form.selectedShift"
                                class="custom-multiselect flex-1"
                                :searchable="false"
                                :placeholder="$t('report.form.default')"
                                :custom-label="({ name }) => `${name}`"
                                selected-label=""
                                select-label=""
                                deselect-label=""
                            ></multiselect>
                        </div>
                        <template v-if="errors.shift_id">
                            <p class="text-danger mt-1 text-center">
                                {{ errors.shift_id }}
                            </p>
                        </template>
                    </div>
                </div>
                <hr class="border-[#e0e6ed] dark:border-[#1b2e4b] my-6" />
                <div class="mt-8 px-4">
                    <div class="text-lg">{{ $t("report.form.machines") }}</div>
                    <template v-if="form.selectedMachine">
                        <div
                            class="flex flex-wrap justify-evenly"
                            v-if="
                                form.selectedMachine.production_line &&
                                form.selectedMachine.production_line.machines
                                    .length > 0
                            "
                        >
                            <div
                                v-for="(machine, index) in form.selectedMachine
                                    .production_line.machines"
                                :key="machine"
                                :class="{
                                    'bg-[#ececf9]': machine.only_dt !== 1,
                                    'bg-gray-100': machine.only_dt === 1,
                                }"
                                class="rounded-md p-4 mb-4"
                            >
                                <div class="text-center font-semibold">
                                    Serial: {{ machine.serial }} -
                                    {{ machine.machine_model.model }} -
                                    {{
                                        machine.machine_model.model_segment
                                            .segment
                                    }}
                                </div>
                                <div class="w-full">
                                    <div class="flex justify-evenly flex-wrap">
                                        <div
                                            v-for="(
                                                detail, indexDetail
                                            ) in postForm.machines[index]
                                                .machine_details"
                                            :key="detail"
                                            class="flex-[100%] flex justify-evenly flex-wrap"
                                        >
                                            <div
                                                class="p-2 flex-auto sm:flex-1"
                                                v-if="machine.only_dt !== 1"
                                            >
                                                <label
                                                    :for="
                                                        'formModule' +
                                                        index +
                                                        indexDetail
                                                    "
                                                    >{{ $t("report.form.error") }}</label
                                                >
                                                <select
                                                    :id="
                                                        'formModule' +
                                                        index +
                                                        indexDetail
                                                    "
                                                    :name="
                                                        'formModule' +
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
                                                        v-for="tmodule in props.catalogModule"
                                                        :key="tmodule"
                                                        :value="tmodule.id"
                                                    >
                                                        {{ tmodule.name }}
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
                                                        v-for="failure in props.catalogFailures"
                                                        :key="failure"
                                                        :value="failure.id"
                                                    >
                                                        {{ failure.name }}
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
                                                        v-for="failuretype in props.catalogTypes"
                                                        :key="failuretype"
                                                        :value="failuretype.id"
                                                    >
                                                        {{ failuretype.name }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <button
                                            v-if="machine.only_dt !== 1"
                                            class="btn btn-secondary gap-2"
                                            @click="
                                                addMachineDetail(
                                                    postForm.machines[index]
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

                                        <div
                                            class="flex-[100%]"
                                            v-if="machine.only_dt !== 1"
                                        >
                                            <template
                                                v-if="
                                                    machine.machine_model
                                                        .model_segment
                                                        .is_multi_transport ===
                                                    1
                                                "
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
                                                            v-model="
                                                                postForm
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
                                                            v-model="
                                                                postForm
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
                                                            v-model="
                                                                postForm
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
                                            <template v-else>
                                                <label for="formShiftTotal11"
                                                    >{{ $t("report.form.transport") }}</label
                                                >
                                                <input
                                                    id="formShiftTotal11"
                                                    v-model="
                                                        postForm.machines[index]
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
                                                >DT (Min.)</label
                                            >
                                            <input
                                                :id="'formReportDT' + index"
                                                type="number"
                                                v-model="
                                                    postForm.machines[index].dt
                                                "
                                                :name="'formReportDT' + index"
                                                class="form-input text-white-dark"
                                                :placeholder="$t('report.form.dtPlaceholder')"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-else>
                            <div class="bg-gray-100 rounded-md p-4">
                                <div class="text-center font-semibold">
                                    Serial: {{ form.selectedMachine.serial }} -
                                    {{
                                        form.selectedMachine.machine_model.model
                                    }}
                                    -
                                    {{
                                        form.selectedMachine.machine_model
                                            .model_segment.segment
                                    }}
                                </div>
                                <div class="w-full">
                                    <div class="flex justify-evenly flex-wrap">
                                        <div
                                            v-for="(
                                                detail, indexDetail
                                            ) in postForm.machines[0]
                                                .machine_details"
                                            :key="detail"
                                            class="flex-[100%] flex justify-evenly flex-wrap"
                                        >
                                            <div
                                                class="p-2 flex-auto sm:flex-1"
                                            >
                                                <label
                                                    :for="
                                                        'formModule1' +
                                                        indexDetail
                                                    "
                                                    >{{ $t("report.form.error") }}</label
                                                >
                                                <select
                                                    :id="
                                                        'formModule1' +
                                                        indexDetail
                                                    "
                                                    :name="
                                                        'formModule1' +
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
                                                        v-for="tmodule in props.catalogModule"
                                                        :key="tmodule"
                                                        :value="tmodule.id"
                                                    >
                                                        {{ tmodule.name }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div
                                                class="p-2 flex-auto sm:flex-1"
                                            >
                                                <label
                                                    :for="
                                                        'formFailures1' +
                                                        indexDetail
                                                    "
                                                    >{{ $t("report.form.cause") }}</label
                                                >
                                                <select
                                                    :id="
                                                        'formFailures1' +
                                                        indexDetail
                                                    "
                                                    :name="
                                                        'formFailures1' +
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
                                                        v-for="failure in props.catalogFailures"
                                                        :key="failure"
                                                        :value="failure.id"
                                                    >
                                                        {{ failure.name }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div
                                                class="p-2 flex-auto sm:flex-1"
                                            >
                                                <label
                                                    :for="
                                                        'formTypes1' +
                                                        indexDetail
                                                    "
                                                    >{{ $t("report.form.solution") }}</label
                                                >
                                                <select
                                                    :id="
                                                        'formTypes1' +
                                                        indexDetail
                                                    "
                                                    :name="
                                                        'formTypes1' +
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
                                                        v-for="failuretype in props.catalogTypes"
                                                        :key="failuretype"
                                                        :value="failuretype.id"
                                                    >
                                                        {{ failuretype.name }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <button
                                            class="btn btn-secondary gap-2"
                                            @click="
                                                addMachineDetail(
                                                    postForm.machines[0]
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
                                        <div class="flex-[100%]">
                                            <div
                                                class="w-full flex justify-evenly flex-wrap"
                                            >
                                                <div class="py-2">
                                                    <label
                                                        for="formShiftTotal11"
                                                        >{{ $t("report.form.transport") }}</label
                                                    >
                                                    <input
                                                        id="formShiftTotal11"
                                                        type="number"
                                                        v-model="
                                                            postForm.machines[0]
                                                                .transport_1
                                                        "
                                                        @input="
                                                            transportValidation(
                                                                0
                                                            )
                                                        "
                                                        name="formShiftTotal11"
                                                        class="form-input text-white-dark"
                                                        min="0.0"
                                                        max="9999.9"
                                                        step="0.1"
                                                        placeholder="0.0"
                                                    />
                                                </div>
                                                <div class="py-2">
                                                    <label for="formReportDT1"
                                                        >DT (Min.)</label
                                                    >
                                                    <input
                                                        id="formReportDT1"
                                                        type="number"
                                                        v-model="
                                                            postForm.machines[0]
                                                                .dt
                                                        "
                                                        name="formReportDT1"
                                                        class="form-input text-white-dark"
                                                        :placeholder="$t('report.form.dtPlaceholder')"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

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
                                id="formBranches"
                                :options="
                                    form.selectedMachine
                                        ? form.selectedMachine.client.branches
                                        : []
                                "
                                v-model="form.selectedBranch"
                                class="custom-multiselect flex-1"
                                :searchable="true"
                                :custom-label="({ address }) => `${address}`"
                                :placeholder="$t('report.form.branchPlaceholder')"
                                selected-label=""
                                select-label=""
                                deselect-label=""
                            ></multiselect>

                            <template v-if="errors.branch_id">
                                <p class="text-danger mt-1 text-center">
                                    {{ errors.branch_id }}
                                </p>
                            </template>
                            <div class="text-lg">
                                {{ $t("report.form.contacts") }} <span class="text-red-500">*</span>
                            </div>
                            <select
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
                                    type="tel"
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
                                    id="formReportPieces"
                                    type="text"
                                    v-model="postForm.pieces"
                                    name="formReportPieces"
                                    class="form-input flex-1"
                                    :placeholder="$t('report.form.piecesPlaceholder')"
                                />
                            </div>
                            <div class="mt-4 flex items-center">
                                <label
                                    for="formReportSOGD"
                                    class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0"
                                    >{{ $t("report.form.SOGD") }}</label
                                >
                                <input
                                    id="formReportSOGD"
                                    type="text"
                                    v-model="postForm.sogd"
                                    name="formReportSOGD"
                                    class="form-input flex-1"
                                    :placeholder="$t('report.form.SOGDPlaceholder')"
                                />
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
                                    id="formReportOnTime"
                                    step="0.01"
                                    pattern="\d+(\.\d{1,2})?"
                                    type="number"
                                    v-model="postForm.time_on"
                                    name="formReportOnTime"
                                    class="form-input flex-1"
                                    placeholder="0.00"
                                />
                            </div>
                            <div class="flex items-center mt-4">
                                <label
                                    for="formReportTravelTime"
                                    class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0"
                                    >{{ $t("report.form.travelTime") }}</label
                                >
                                <input
                                    id="formReportTravelTime"
                                    type="text"
                                    v-model="postForm.travel_time"
                                    name="formReportTravelTime"
                                    class="form-input flex-1"
                                    :placeholder="$t('report.form.travelTimePlaceholder')"
                                />
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
                                    v-model="postForm.report_type_id"
                                    class="form-select text-white-dark flex-1"
                                    required
                                >
                                    <option value="1" selected>Contract</option>
                                    <option value="2">Client</option>
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
                                    v-model="postForm.reported_error"
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
                            v-for="(code, index) in catalogCodes"
                            :key="index"
                            class="inline-flex"
                        >
                            <input
                                type="radio"
                                name="formReportCode"
                                class="form-radio"
                                :value="code.id"
                                v-model="postForm.code_id"
                            />
                            <div class="flex flex-col">
                                <span>{{ code.code }}</span>
                                <span
                                    v-if="postForm.code_id === code.id"
                                    class="text-xs"
                                    >{{ code.description }}</span
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
                                v-model="postForm.actions_taken"
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
                            v-if="!form.selectedMachine?.production_line_id"
                        >
                            <label for="formReportReportedTime">
                                {{ $t("report.form.reported") }}
                            </label>
                            <flat-pickr
                                id="formReportReportedTime"
                                name="formReportReportedTime"
                                v-model="postForm.reported"
                                class="form-input flex-1"
                                :config="dateTime"
                            ></flat-pickr>
                        </div>
                        <div
                            class="px-2 max-w-[180px]"
                            v-if="!form.selectedMachine?.production_line_id"
                        >
                            <label for="formReportTimeDeparture">
                                {{ $t("report.form.departure") }}
                            </label>
                            <flat-pickr
                                id="formReportTimeDeparture"
                                name="formReportTimeDeparture"
                                v-model="postForm.departure"
                                class="form-input flex-1"
                                :config="dateTime"
                            ></flat-pickr>
                        </div>
                        <div class="px-2 max-w-[180px]">
                            <label for="formReportTimeArrival">{{ $t("report.form.arrival") }}</label>
                            <flat-pickr
                                id="formReportTimeArrival"
                                name="formReportTimeArrival"
                                v-model="postForm.arrival"
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
                                v-model="postForm.finished"
                                class="form-input flex-1"
                                :config="dateTime"
                            ></flat-pickr>
                        </div>
                        <div class="w-full flex flex-wrap justify-evenly py-4">
                            <label
                                v-for="(status, index) in catalogStatus"
                                :key="index"
                                class="inline-flex"
                            >
                                <input
                                    type="radio"
                                    name="formReportStatus"
                                    class="form-radio"
                                    :value="status.id"
                                    v-model="postForm.status_id"
                                />
                                <span>{{ status.status }}</span>
                            </label>
                        </div>
                        <div class="w-full flex flex-wrap justify-evenly">
                            <label class="inline-flex">
                                <input
                                    type="checkbox"
                                    v-model="postForm.is_tested"
                                    class="form-checkbox rounded-full"
                                    checked
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
                                    v-model="form.selectedPart"
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
                                    v-if="postForm.service_parts.length <= 0"
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
                                    v-for="(item, i) in postForm.service_parts"
                                    :key="i"
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
                                                value="1"
                                                min="0"
                                            />
                                        </td>
                                        <td>
                                            <button
                                                type="button"
                                                @click="removeItem(item)"
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
                            v-model="postForm.notes"
                        ></textarea>
                    </div>
                </div>
                <hr class="border-[#e0e6ed] dark:border-[#1b2e4b] my-6" />
                <div class="mt-8 px-4">
                    <div
                        v-if="form.selectedMachine"
                        class="flex flex-wrap justify-evenly w-full"
                    >
                        <template
                            v-for="(machine,index) in getMachines()"
                            :key="machine"
                        >
                            <div
                                v-if="machine.only_dt !== 1"
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
                                    v-model="postForm.machines[index].signature_client_name"
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
import { ref, onMounted, reactive, computed, watch } from "vue";
import { Head, usePage, router, Link } from "@inertiajs/vue3";
import { useAppStore } from "@/stores/index";
import AppLayout from "@/layouts/app-layout.vue";
import SiteLayout from "@/layouts/app.vue";
import flatPickr from "vue-flatpickr-component";
import Multiselect from "@suadelabs/vue3-multiselect";
import "@suadelabs/vue3-multiselect/dist/vue3-multiselect.css";
import "flatpickr/dist/flatpickr.css";
import Swal from "sweetalert2";
import { useI18n } from 'vue-i18n';

const { t } = useI18n();
const store = useAppStore();

const page = usePage();
const user = computed(() => page.props.auth);
const catalogParts = ref([]);
defineOptions({
    layout: [SiteLayout, AppLayout],
});

const props = defineProps({
    errors: Object,
    catalogCodes: {
        type: Array,
        required: true,
    },
    catalogUsers: {
        type: Array,
        required: true,
    },
    catalogStatus: {
        type: Array,
        required: true,
    },
    catalogMachines: {
        type: Array,
        required: true,
    },
    catalogShifts: {
        type: Array,
        required: true,
    },
    catalogModule: {
        type: Array,
        required: true,
    },
    catalogFailures: {
        type: Array,
        required: true,
    },
    catalogTypes: {
        type: Array,
        required: true,
    },
});

console.log(props.catalogMachines);

const dateTime: any = ref({
    enableTime: true,
    dateFormat: "Y-m-d H:i",
    position: store.rtlClass === "rtl" ? "auto right" : "auto left",
});

const form = reactive({
    selectedMachine: null,
    selectedMachine2: null,
    selectedBranch: null,
    selectedModule: null,
    selectedFailure: null,
    selectedContact: null,
    selectedShift: null,
    selectedPart: null,
    addNewPart: [],
    selectedCode: null,
    selectedUser: null,
    selectedStatus: null,
});

const items: any = ref([]);
const selectedFile = ref(null);
const params = ref({
    title: "",
    invoiceNo: "",
    to: {
        name: "",
        email: "",
        address: "",
        phone: "",
    },

    invoiceDate: "",
    dueDate: "",
    bankInfo: {
        no: "",
        name: "",
        swiftCode: "",
        country: "",
        ibanNo: "",
    },
    notes: "",
});
const currencyList = ref([
    "USD - US Dollar",
    "GBP - British Pound",
    "IDR - Indonesian Rupiah",
    "INR - Indian Rupee",
    "BRL - Brazilian Real",
    "EUR - Germany (Euro)",
    "TRY - Turkish Lira",
]);
const selectedCurrency = ref("USD - US Dollar");
const tax = ref<number>(0);
const discount = ref<number>(0);
const shippingCharge = ref<number>(0);
const paymentMethod = ref("");

onMounted(() => {
    //set default data
    items.value.push({
        id: 1,
        title: "",
        description: "",
        rate: 0,
        quantity: 0,
        amount: 0,
    });
});

const addItem = () => {
    let maxId = 0;
    if (items.value && items.value.length) {
        maxId = items.value.reduce(
            (max: number, character: any) =>
                character.id > max ? character.id : max,
            items.value[0].id
        );
    }
    items.value.push({
        id: maxId + 1,
        title: "",
        description: "",
        rate: 0,
        quantity: 0,
        amount: 0,
    });
};

const showMachineLabel = (option) => {
    return "test";
};

const removeItem = (item: any = null) => {
    postForm.service_parts = postForm.service_parts.filter(
        (d: any) => d.id != item.id
    );
};

const addNewPart = () => {
    if (form.selectedPart) postForm.service_parts.push(form.selectedPart);
};

const preloadingTime: any = ref({
    noCalendar: true,
    enableTime: true,
    dateFormat: "H:i",
    position: store.rtlClass === "rtl" ? "auto right" : "auto left",
});

const updateMachines = (selectedMachine) => {
    if (!selectedMachine) return;

    const totalMachines = selectedMachine.production_line?.machines.length || 1;

    postForm.machines = Array.from({ length: totalMachines }, (_, index) => {
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
                },
            ],
            transport_time_1: null,
            transport_time_2: null,
            transport_1: null,
            transport_2: null,
            transport_3: null,
            dt: null,
            signature_client_name: null,
        };
    });

    console.log(`There are ${totalMachines} machines in production line`);
};

watch(() => form.selectedMachine, updateMachines, { immediate: true });

const postForm = reactive({
    user_id: null,
    shift_id: null,
    pieces: null,
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
    machines: [] as Array<any>,
    service_parts: [],
});

function getMachines() {
    return form.selectedMachine?.production_line?.machines || [form.selectedMachine];
}

function transportValidation(index) {
    const machine = postForm.machines[index];
    const transportFields = ["transport_1", "transport_2", "transport_3"];

    transportFields.forEach((field) => {
        if (machine[field] !== null) {
            machine[field] = Math.max(
                0,
                Math.min(Number(machine[field]), 99999.9)
            );
        }
    });
}

let timeoutId = ref(null);
function selectPartChange(searchQuery, id) {
    catalogParts.value = [];
    if (searchQuery.length <= 0) {
        if (timeoutId.value) clearTimeout(timeoutId.value);
        return;
    }

    if (timeoutId.value) clearTimeout(timeoutId.value);
    timeoutId.value = setTimeout(() => {
        fetch("/parts/autocomplete", {
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
                catalogParts.value = data;
            })
            .catch((error) => {
                console.error("Error:", error);
            });
    }, 1500);
}

function addMachineDetail(machine) {
    if (machine.length < 5) {
        machine.push({
            module_id: null,
            failure_id: null,
            failure_type_id: null,
        });
    }
}

function submit() {
    if (form.selectedUser) postForm.user_id = form.selectedUser.id;

    if (form.selectedShift) postForm.shift_id = form.selectedShift.id;

    if (form.selectedBranch) postForm.branch_id = form.selectedBranch.id;

    if (form.selectedContact)
        postForm.branch_manager_id = form.selectedContact.id;

    console.log(postForm);
    
    Swal.fire({
        title: t("report.alert.processing"),
        text: t("report.alert.processingText"),
        allowOutsideClick: false,
        showConfirmButton: false,
        customClass: "sweet-alerts",
        didOpen: () => {
            Swal.showLoading();
        },
    });
    router.post("/reports", postForm, {
        onSuccess: () => {
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
</script>
