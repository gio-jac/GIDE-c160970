<template>
    <Head title="Edit Report" />
    <div>
        <div class="flex xl:flex-row flex-col gap-2.5">
            <div class="panel px-0 flex-1 py-6 ltr:xl:mr-6 rtl:xl:ml-6">
                <div class="flex px-4">
                    <div class="w-full">
                        <div class="flex items-center">
                            <label
                                for="formMachine"
                                class="w-[100px] text-right mb-0 mr-[10px]"
                                >Machine Serial</label
                            >

                            <multiselect
                                id="formMachine"
                                :options="props.catalogMachines"
                                v-model="form.selectedMachine"
                                class="custom-multiselect flex-1"
                                :searchable="true"
                                placeholder="Select an option"
                                :custom-label="
                                    ({ serial, machine_model }) =>
                                        `${serial} - ${machine_model.model}`
                                "
                                selected-label=""
                                select-label=""
                                deselect-label=""
                            ></multiselect>
                        </div>
                    </div>
                </div>
                <div class="flex px-4 mt-4" v-if="user.type === 1">
                    <div class="w-full">
                        <div class="flex items-center">
                            <label
                                for="formUser"
                                class="w-[100px] text-right mb-0 mr-[10px]"
                                >User</label
                            >

                            <multiselect
                                id="formUser"
                                :options="catalogUsers"
                                v-model="form.selectedUser"
                                class="custom-multiselect flex-1"
                                :searchable="true"
                                placeholder="Select an option"
                                :custom-label="
                                    ({ emp, nombre, apellido_paterno }) =>
                                        `${emp} - ${nombre} ${apellido_paterno}`
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
                                for="formShift"
                                class="w-[100px] text-right mb-0 mr-[10px]"
                                >Shift</label
                            >

                            <multiselect
                                id="formShift"
                                :options="props.catalogShifts"
                                v-model="form.selectedShift"
                                class="custom-multiselect flex-1"
                                :searchable="false"
                                placeholder="Select an option"
                                :custom-label="({ name }) => `${name}`"
                                selected-label=""
                                select-label=""
                                deselect-label=""
                            ></multiselect>
                        </div>
                    </div>
                </div>

                <hr class="border-[#e0e6ed] dark:border-[#1b2e4b] my-6" />
                <div class="mt-8 px-4">
                    <div class="flex justify-between lg:flex-row flex-col">
                        <div
                            class="lg:w-1/2 w-full ltr:lg:mr-6 rtl:lg:ml-6 mb-6"
                        >
                            <div class="text-lg">Branches</div>
                            <select
                                id="formBranches"
                                name="formBranches"
                                class="form-select text-white-dark"
                                v-model="form.selectedBranch"
                                required
                            >
                                <option :value="null">
                                    Open this select menu
                                </option>
                                <option
                                    v-for="branch in form.selectedMachine
                                        ?.client.branches"
                                    :key="branch.id"
                                    :value="branch"
                                >
                                    {{ branch.address }}
                                </option>
                            </select>
                            <div class="text-lg">Contacts</div>
                            <select
                                id="formContacts"
                                name="formContacts"
                                class="form-select text-white-dark"
                                v-model="form.selectedContact"
                                required
                            >
                                <option :value="null">
                                    Open this select menu
                                </option>
                                <option
                                    v-for="contact in form.selectedBranch?.branch_managers"
                                    :key="contact.id"
                                    :value="contact"
                                >
                                    {{ contact.name }}
                                </option>
                            </select>
                            <div class="mt-4 flex items-center">
                                <label
                                    for="formClient"
                                    class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0"
                                    >Client</label
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
                                    >Name</label
                                >
                                <input
                                    id="formCustomerName"
                                    type="text"
                                    name="formCustomerName"
                                    class="form-input flex-1"
                                    readonly
                                    :value="
                                        form.selectedContact?.name
                                    "
                                />
                            </div>
                            <div class="mt-4 flex items-center">
                                <label
                                    for="formCustomerEmail"
                                    class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0"
                                    >Email</label
                                >
                                <input
                                    id="formCustomerEmail"
                                    type="email"
                                    name="formCustomerEmail"
                                    class="form-input flex-1"
                                    readonly
                                    :value="
                                        form.selectedContact?.email
                                    "
                                />
                            </div>
                            <div class="mt-4 flex items-center">
                                <label
                                    for="formCustomerPhone"
                                    class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0"
                                    >Phone</label
                                >
                                <input
                                    id="formCustomerPhone"
                                    type="tel"
                                    name="formCustomerPhone"
                                    class="form-input flex-1"
                                    readonly
                                    :value="
                                        form.selectedContact?.phone
                                    "
                                />
                            </div>
                        </div>
                        <div class="lg:w-1/2 w-full">
                            <div class="text-lg">Machine Data</div>
                            <div class="flex items-center mt-4">
                                <label
                                    for="formMachineSerial"
                                    class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0"
                                    >Serial</label
                                >
                                <input
                                    id="formMachineSerial"
                                    type="text"
                                    name="formMachineSerial"
                                    class="form-input flex-1"
                                    :value="form.selectedMachine?.serial"
                                    readonly
                                    placeholder="Enter Serial"
                                />
                            </div>
                            <div class="flex items-center mt-4">
                                <label
                                    for="formMachineType"
                                    class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0"
                                    >Type</label
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
                                    placeholder="Enter Type"
                                />
                            </div>
                            <div class="flex items-center mt-4">
                                <label
                                    for="formMachineSegment"
                                    class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0"
                                    >Segment</label
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
                                    placeholder="Enter Segment"
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
                                    for="formReportTransport"
                                    class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0"
                                    >Transport</label
                                >
                                <input
                                    id="formReportTransport"
                                    type="number"
                                    v-model="postForm.transport"
                                    name="formReportTransport"
                                    class="form-input flex-1"
                                    placeholder="Enter Transport"
                                />
                            </div>
                            <div class="mt-4 flex items-center">
                                <label
                                    for="formReportPieces"
                                    class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0"
                                    >Pieces</label
                                >
                                <input
                                    id="formReportPieces"
                                    type="text"
                                    v-model="postForm.pieces"
                                    name="formReportPieces"
                                    class="form-input flex-1"
                                    placeholder="Enter Pieces"
                                />
                            </div>
                            <div class="mt-4 flex items-center">
                                <label
                                    for="formReportSOGD"
                                    class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0"
                                    >SO GD</label
                                >
                                <input
                                    id="formReportSOGD"
                                    type="text"
                                    v-model="postForm.sogd"
                                    name="formReportSOGD"
                                    class="form-input flex-1"
                                    placeholder="Enter SO GD"
                                />
                            </div>
                        </div>
                        <div class="lg:w-1/2 w-full">
                            <div class="flex items-center mt-4">
                                <label
                                    for="formReportOnTime"
                                    class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0"
                                    >Machine ON</label
                                >
                                <input
                                    id="formReportOnTime"
                                    step="0.01"
                                    pattern="\d+(\.\d{1,2})?"
                                    type="number"
                                    v-model="postForm.time_on"
                                    name="formReportOnTime"
                                    class="form-input flex-1"
                                    placeholder="Machine time ON"
                                />
                            </div>
                            <div class="flex items-center mt-4">
                                <label
                                    for="formReportTravelTime"
                                    class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0"
                                    >Travel time</label
                                >
                                <input
                                    id="formReportTravelTime"
                                    type="text"
                                    v-model="postForm.travel_time"
                                    name="formReportTravelTime"
                                    class="form-input flex-1"
                                    placeholder="Enter Travel Time"
                                />
                            </div>
                            <div class="flex items-center mt-4">
                                <label
                                    for="formReportType"
                                    class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0"
                                    >Type</label
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
                        <div class="w-full">
                            <div class="flex justify-evenly">
                                <div>
                                    <label for="formModule">Error</label>
                                    <select
                                        id="formModule"
                                        name="formModule"
                                        class="form-select text-white-dark"
                                        v-model="postForm.module_id"
                                        required
                                    >
                                        <option :value="null">
                                            Open this select menu
                                        </option>
                                        <option
                                            v-for="tmodule in props.catalogModule"
                                            :key="tmodule.id"
                                            :value="tmodule.id"
                                        >
                                            {{ tmodule.name }}
                                        </option>
                                    </select>
                                </div>
                                <div>
                                    <label for="formFailures">Cause</label>
                                    <select
                                        id="formFailures"
                                        name="formFailures"
                                        class="form-select text-white-dark"
                                        v-model="postForm.failure_id"
                                        required
                                    >
                                        <option :value="null">
                                            Open this select menu
                                        </option>
                                        <option
                                            v-for="failure in props.catalogFailures"
                                            :key="failure.id"
                                            :value="failure.id"
                                        >
                                            {{ failure.name }}
                                        </option>
                                    </select>
                                </div>
                                <div>
                                    <label for="formTypes">Solution</label>
                                    <select
                                        id="formTypes"
                                        name="formTypes"
                                        class="form-select text-white-dark"
                                        v-model="postForm.failure_type_id"
                                        required
                                    >
                                        <option :value="null">
                                            Open this select menu
                                        </option>
                                        <option
                                            v-for="failuretype in props.catalogTypes"
                                            :key="failuretype.id"
                                            :value="failuretype.id"
                                        >
                                            {{ failuretype.name }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-4 flex items-center">
                                <label
                                    for="formReportedError"
                                    class="ltr:mr-2 rtl:ml-2 w-1/6 mb-0"
                                    >Reported Error</label
                                >
                                <textarea
                                    id="formReportedError"
                                    name="formReportedError"
                                    rows="3"
                                    v-model="postForm.reported_error"
                                    class="form-textarea flex-1"
                                    placeholder="Enter Reported Error"
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
                                >Actions Taken</label
                            >
                            <textarea
                                id="formReportActions"
                                name="formReportActions"
                                v-model="postForm.actions_taken"
                                rows="3"
                                class="form-textarea flex-1"
                                placeholder="Enter Actions Taken"
                                required
                            ></textarea>
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
                                    for="formReportReportedTime"
                                    class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0"
                                    >Reported</label
                                >
                                <flat-pickr
                                    id="formReportReportedTime"
                                    name="formReportReportedTime"
                                    v-model="postForm.reported"
                                    class="form-input flex-1"
                                    :config="dateTime"
                                ></flat-pickr>
                            </div>
                            <div class="mt-4 flex items-center">
                                <label
                                    for="formReportTimeArrival"
                                    class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0"
                                    >Arrival</label
                                >
                                <flat-pickr
                                    id="formReportTimeArrival"
                                    name="formReportTimeArrival"
                                    v-model="postForm.arrival"
                                    class="form-input flex-1"
                                    :config="dateTime"
                                ></flat-pickr>
                            </div>
                        </div>
                        <div class="lg:w-1/2 w-full">
                            <div class="mt-4 flex items-center">
                                <label
                                    for="formReportTimeFinished"
                                    class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0"
                                    >Finished</label
                                >
                                <flat-pickr
                                    id="formReportTimeFinished"
                                    name="formReportTimeFinished"
                                    v-model="postForm.finished"
                                    class="form-input flex-1"
                                    :config="dateTime"
                                ></flat-pickr>
                            </div>
                            <div class="mt-4 flex items-center">
                                <label
                                    for="formReportTimeDeparture"
                                    class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0"
                                    >Departure</label
                                >
                                <flat-pickr
                                    id="formReportTimeDeparture"
                                    name="formReportTimeDeparture"
                                    v-model="postForm.departure"
                                    class="form-input flex-1"
                                    :config="dateTime"
                                ></flat-pickr>
                            </div>
                        </div>
                        <div class="w-full flex flex-wrap justify-evenly">
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
                        <div class="w-1/3 m-auto">
                            <div
                                class="mt-4 flex items-center flex flex-wrap justify-evenly"
                            >
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
                            <div class="mt-4 flex items-center">
                                <label
                                    for="formReportDT"
                                    class="ltr:mr-2 rtl:ml-2 w-1/6 mb-0"
                                    >DT</label
                                >
                                <input
                                    id="formReportDT"
                                    type="number"
                                    v-model="postForm.dt"
                                    name="formReportDT"
                                    class="form-input flex-1"
                                    placeholder="Enter DT"
                                />
                            </div>
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
                                    >Parts</label
                                >

                                <multiselect
                                    id="formReportParts"
                                    :options="props.catalogParts"
                                    v-model="form.selectedPart"
                                    class="custom-multiselect flex-1"
                                    :searchable="true"
                                    placeholder="Select an option"
                                    :custom-label="
                                        ({ num_part, descripcion }) =>
                                            `${num_part} - ${descripcion}`
                                    "
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
                                    <th>Part Replaced</th>
                                    <th class="w-1/3">Description</th>
                                    <th class="w-1/3">Quantity</th>
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
                                            No Item Available
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
                        <label for="notes">Remarks</label>
                        <textarea
                            id="notes"
                            name="notes"
                            class="form-textarea min-h-[130px]"
                            placeholder="Remarks...."
                            v-model="postForm.notes"
                        ></textarea>
                    </div>
                </div>
                <hr class="border-[#e0e6ed] dark:border-[#1b2e4b] my-6" />
                <div class="mt-8 px-4">
                    <div
                        class="flex justify-between lg:flex-row flex-col flex-wrap"
                    >
                        <div class="w-full">
                            <div class="flex items-center">
                                <label
                                    for="formCustomerSignatureName"
                                    class="ltr:mr-2 rtl:ml-2 w-1/4 mb-0"
                                    >Customer Signature Name</label
                                >
                                <input
                                    id="formCustomerSignatureName"
                                    type="text"
                                    v-model="postForm.signature_client_name"
                                    name="formCustomerSignatureName"
                                    class="form-input flex-1"
                                    placeholder="Enter Customer Name"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="xl:w-96 w-full xl:mt-0 mt-6">
                <div
                    class="panel mb-5"
                    v-if="user.type === 2 && props.latestReports.length > 0"
                >
                    <div class="text-lg">Latest Reports</div>
                    <div class="flex flex-wrap">
                        <Link
                            v-for="(report, index) in props.latestReports"
                            class="my-1 hover:text-sky-400"
                            :href="`/reports/${report.id}/edit`"
                            :key="index"
                        >
                            {{ report.id }} - {{ report.machine.serial }} -
                            {{ report.machine.data_client.client.name }}
                        </Link>
                    </div>
                    <div class="w-full text-center mt-8">
                        <Link href="/reports">Show all</Link>
                    </div>
                </div>
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
                            Save Report
                        </button>

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
                        </button>
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
                        -->
                        <a
                            :href="`/reports/${props.report.id}/file`"
                            class="btn btn-secondary w-full gap-2"
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
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { ref, onMounted, reactive, computed } from "vue";
import { Head, usePage, router, Link } from "@inertiajs/vue3";
import { useAppStore } from "@/stores/index";
import AppLayout from "@/layouts/app-layout.vue";
import SiteLayout from "@/layouts/app.vue";
import flatPickr from "vue-flatpickr-component";
import Multiselect from "@suadelabs/vue3-multiselect";
import "@suadelabs/vue3-multiselect/dist/vue3-multiselect.css";
import "flatpickr/dist/flatpickr.css";
const store = useAppStore();

const page = usePage();
const user = computed(() => page.props.auth);

defineOptions({
    layout: [SiteLayout, AppLayout],
});

const props = defineProps({
    catalogParts: {
        type: Array,
        required: true,
    },
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
    latestReports: {
        type: Array,
        required: true,
    },
    report: { type: Object, required: true },
});

const dateTime: any = ref({
    enableTime: true,
    dateFormat: "Y-m-d H:i",
    position: store.rtlClass === "rtl" ? "auto right" : "auto left",
});

const form = reactive({
    selectedMachine: null,
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

onMounted(() => {
    //set default data
    console.log(props.report);
    form.selectedMachine = props.catalogMachines.filter(
        (data) => data.id === props.report.machine_id
    )[0];
    if (props.report.user_id)
        form.selectedUser = props.catalogUsers.filter(
            (data) => data.id === props.report.user_id
        )[0];
    form.selectedShift = props.catalogShifts.filter(
        (data) => data.id === props.report.shift_id
    )[0];
    form.selectedBranch = form.selectedMachine?.client.branches.filter(
        (data) => data.id === props.report.branch_id
    )[0];
    form.selectedContact = form.selectedBranch?.branch_managers.filter(
        (data) => data.id === props.report.branch_manager_id
    )[0];
    postForm.transport = props.report.transport;
    postForm.pieces = props.report.pieces;
    postForm.sogd = props.report.sogd;
    postForm.time_on = props.report.time_on;
    postForm.travel_time = props.report.travel_time;
    postForm.report_type_id = props.report.report_type_id;
    postForm.reported_error = props.report.reported_error;
    postForm.module_id = props.report.module_id;
    postForm.failure_id = props.report.failure_id;
    postForm.failure_type_id = props.report.failure_type_id;
    /*form.selectedModule = form.selectedMachine.machine_model.modules.filter(
        (data) => data.id === props.report.module_id
    )[0];
    form.selectedFailure = form.selectedModule.failures.filter(
        (data) => data.id === props.report.failure_id
    )[0];
    postForm.failure_type_id = props.report.failure_type_id;
    console.log(form.selectedFailure);*/
    postForm.code_id = props.report.code_id;
    postForm.actions_taken = props.report.actions_taken;
    postForm.reported = props.report.reported;
    postForm.arrival = props.report.arrival;
    postForm.finished = props.report.finished;
    postForm.departure = props.report.departure;
    postForm.status_id = props.report.status_id;
    postForm.signature_client_name = props.report.signature_client_name;
    postForm.is_tested = props.report.is_tested === 1 ? true : false;
    postForm.dt = props.report.dt;
    postForm.notes = props.report.notes;
    for (let part of props.report.parts) {
        postForm.service_parts.push({
            id: part.part.id,
            descripcion: part.part.descripcion,
            is_active: part.part.is_active,
            num_part: part.part.num_part,
            quantity: part.quantity,
        });
    }
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
    console.log(form.selectedPart);
    postForm.service_parts.push(form.selectedPart);
};

const postForm = reactive({
    machine_id: null,
    user_id: null,
    shift_id: null,
    transport: null,
    pieces: null,
    sogd: null,
    time_on: null,
    travel_time: null,
    report_type_id: 1,
    branch_id: null,
    module_id: null,
    branch_manager_id: null,
    failure_id: null,
    failure_type_id: null,
    reported_error: "",
    code_id: null,
    actions_taken: "",
    reported: null,
    arrival: null,
    finished: null,
    departure: null,
    status_id: null,
    signature_client_name: null,
    is_tested: null,
    dt: null,
    notes: "",
    service_parts: [],
});

function submit() {
    if (form.selectedMachine) postForm.machine_id = form.selectedMachine.id;

    if (form.selectedUser) postForm.user_id = form.selectedUser.id;

    if (form.selectedShift) postForm.shift_id = form.selectedShift.id;

    if (form.selectedModule) postForm.module_id = form.selectedModule.id;

    if (form.selectedFailure) postForm.failure_id = form.selectedFailure.id;

    if (form.selectedBranch) postForm.branch_id = form.selectedBranch.id;

    if (form.selectedContact) postForm.branch_manager_id = form.selectedContact.id;

    //router.post("/reports", postForm);
}
</script>
