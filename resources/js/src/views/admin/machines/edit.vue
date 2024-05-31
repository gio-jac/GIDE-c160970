<template>
    <Head title="Edit Machine" />
    <div>
        <div class="panel border-[#e0e6ed] dark:border-[#1b2e4b]">
            <div class="mb-5">
                <ol
                    class="flex text-gray-500 font-semibold dark:text-white-dark"
                >
                    <li><Link href="/machines">Machines</Link></li>
                    <li class="before:content-['/'] before:px-1.5">
                        <a
                            href="javascript:;"
                            class="text-black dark:text-white-light hover:text-black/70 dark:hover:text-white-light/70"
                            >Edit</a
                        >
                    </li>
                </ol>
            </div>
            <form class="space-y-5" @submit.prevent="submit">
                <div>
                    <label for="machineSerial">Serial <span class="text-red-500">*</span></label>
                    <input
                        id="machineSerial"
                        name="machineSerial"
                        type="text"
                        placeholder="Enter Machine Serial"
                        class="form-input"
                        v-model="form.serial"
                    />
                    <template v-if="errors.serial">
                        <p class="text-danger mt-1">{{ errors.serial }}</p>
                    </template>
                </div>
                <div>
                    <label for="machineModel">Machine Model <span class="text-red-500">*</span></label>
                    <select
                        id="machineModel"
                        name="machineModel"
                        class="form-input"
                        v-model="form.machine_model_id"
                    >
                        <option :value="null" disabled hidden>
                            {{ $t("report.form.default") }}
                        </option>
                        <option v-for="model in machineModels" :key="model" :value="model.id">
                            {{ model.model }}
                        </option>
                    </select>
                    <template v-if="errors.machine_model_id">
                        <p class="text-danger mt-1">{{ errors.machine_model_id }}</p>
                    </template>
                </div>
                <div>
                    <label for="machineClient">Client <span class="text-red-500">*</span></label>
                    <select
                        id="machineClient"
                        name="machineClient"
                        class="form-input"
                        v-model="form.client_id"
                    >
                        <option :value="null" disabled hidden>
                            {{ $t("report.form.default") }}
                        </option>
                        <option v-for="client in clients" :key="client" :value="client.id">
                            {{ client.name }}
                        </option>
                    </select>
                    <template v-if="errors.client_id">
                        <p class="text-danger mt-1">{{ errors.client_id }}</p>
                    </template>
                </div>
                
                <div>
                    <label for="machineProductionLine">Production Line</label>
                    <select
                        id="machineProductionLine"
                        name="machineProductionLine"
                        class="form-input"
                        v-model="form.production_line_id"
                    >
                        <option :value="null">
                            None
                        </option>
                        <option v-for="productionLine in productionLines" :key="productionLine" :value="productionLine.id">
                            {{ productionLine.name }}
                        </option>
                    </select>
                </div>
                <template v-if="form.production_line_id !== null">
                    <div>
                        <label for="machineProdLinePosition">Position</label>
                        <input
                            id="machineProdLinePosition"
                            name="machineProdLinePosition"
                            type="number"
                            min="0"
                            max="99"
                            placeholder="Enter Position"
                            class="form-input"
                            v-model="form.position"
                        />
                    </div>
                    <div>
                        <label for="machineProdLineDT">Only DT</label>
                        <label class="w-12 h-6 relative">
                            <input
                                type="checkbox"
                                class="custom_switch absolute w-full h-full opacity-0 z-10 cursor-pointer peer"
                                id="machineProdLineDT"
                                v-model="form.only_dt"
                            />
                            <span
                                for="machineProdLineDT"
                                class="bg-[#ebedf2] dark:bg-dark block h-full before:absolute before:left-1 before:bg-white dark:before:bg-white-dark dark:peer-checked:before:bg-white before:bottom-1 before:w-4 before:h-4 peer-checked:before:left-7 peer-checked:bg-primary before:transition-all before:duration-300"
                            ></span>
                        </label>
                    </div>
                </template>
                <div>
                    <label for="formActive">Active Machine</label>
                    <label class="w-12 h-6 relative">
                        <input
                            type="checkbox"
                            class="custom_switch absolute w-full h-full opacity-0 z-10 cursor-pointer peer"
                            id="formActive"
                            v-model="form.is_active"
                        />
                        <span
                            for="formActive"
                            class="bg-[#ebedf2] dark:bg-dark block h-full before:absolute before:left-1 before:bg-white dark:before:bg-white-dark dark:peer-checked:before:bg-white before:bottom-1 before:w-4 before:h-4 peer-checked:before:left-7 peer-checked:bg-primary before:transition-all before:duration-300"
                        ></span>
                    </label>
                </div>
                <button type="submit" class="btn btn-primary !mt-6">Update</button>
            </form>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { reactive, ref, onMounted } from "vue";
import Multiselect from "@suadelabs/vue3-multiselect";
import { Head, Link, router } from "@inertiajs/vue3";
import AppLayout from "@/layouts/app-layout.vue";
import SiteLayout from "@/layouts/app.vue";
import Swal from "sweetalert2";

onMounted(() => {

});

defineOptions({
    layout: [SiteLayout, AppLayout],
});

const props = defineProps({
    errors: Object,
    machineModels: {
        type: Array,
        required: true,
    },
    productionLines: {
        type: Array,
        required: true,
    },
    clients: {
        type: Array,
        required: true,
    },
    machine: {
        type: Object,
        required: true,
    }
});

const form = reactive({
    serial: props.machine.serial,
    machine_model_id: props.machine.machine_model_id,
    client_id: props.machine.client_id,
    production_line_id: props.machine.production_line_id,
    position: props.machine.position,
    only_dt: props.machine.only_dt === 1 ? true : false,
    is_active: props.machine.is_active === 1 ? true : false,
});

function submit() {
    Swal.fire({
        title: "Processing...",
        text: "Please wait while the data is being added.",
        allowOutsideClick: false,
        showConfirmButton: false,
        customClass: "sweet-alerts",
        didOpen: () => {
            Swal.showLoading();
        },
    });
    
    router.put(`/machines/${props.machine.id}`, form, {
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
