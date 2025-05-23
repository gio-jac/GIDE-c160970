<template>
    <Head title="Edit Solution" />
    <div>
        <div class="panel border-[#e0e6ed] dark:border-[#1b2e4b]">
            <div class="mb-5">
                <ol
                    class="flex text-gray-500 font-semibold dark:text-white-dark"
                >
                    <li><Link href="/reports/solutions">{{ $t('sidebar.solutions') }}</Link></li>
                    <li class="before:content-['/'] before:px-1.5">
                        <a
                            href="javascript:;"
                            class="text-black dark:text-white-light hover:text-black/70 dark:hover:text-white-light/70"
                            >{{ $t("user.create.breadcrumb.edit") }}</a
                        >
                    </li>
                </ol>
            </div>
            <form class="space-y-5" @submit.prevent="submit">
                <div :class="{ 'has-error': errors.code }">
                    <label for="formClient">{{ $t('solutions.new.nameSolutionEN') }} <span class="text-red-500">*</span></label>
                    <input
                        id="formClient"
                        type="text"
                        :placeholder="$t('solutions.new.nameSolutionPlaceholderEN')"
                        class="form-input"
                        v-model="form.name"
                    />
                    <template v-if="errors.name">
                        <p class="text-danger mt-1">{{ errors.name }}</p>
                    </template>
                </div>
                <div :class="{ 'has-error': errors.code }">
                    <label for="formClientES">{{ $t('solutions.new.nameSolutionES') }}</label>
                    <input
                        id="formClientES"
                        type="text"
                        :placeholder="$t('solutions.new.nameSolutionPlaceholderES')"
                        class="form-input"
                        v-model="form.es"
                    />
                    <template v-if="errors.es">
                        <p class="text-danger mt-1">{{ errors.es }}</p>
                    </template>
                </div>
                <div :class="{ 'has-error': errors.code }">
                    <label for="formClientPT">{{ $t('solutions.new.nameSolutionPT') }}</label>
                    <input
                        id="formClientPT"
                        type="text"
                        :placeholder="$t('solutions.new.nameSolutionPlaceholderPT')"
                        class="form-input"
                        v-model="form.pt"
                    />
                    <template v-if="errors.pt">
                        <p class="text-danger mt-1">{{ errors.pt }}</p>
                    </template>
                </div>
                <div>
                    <label for="formActive">{{ $t("solutions.edit.activeSolution") }}</label>
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
                <button type="submit" class="btn btn-primary !mt-6">{{ $t("user.create.update") }}</button>
            </form>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { reactive, watch } from "vue";
import { Head, Link, router } from "@inertiajs/vue3";
import AppLayout from "@/layouts/app-layout.vue";
import SiteLayout from "@/layouts/app.vue";
import Swal from "sweetalert2";

defineOptions({
    layout: [SiteLayout, AppLayout],
});

const props = defineProps({
    errors: Object,
    solution: {
        type: Object,
        required: true,
    }
});

const form = reactive({
    name: (props.solution.name ?? '').toUpperCase(),
    es: (props.solution.es ?? '').toUpperCase(),
    pt: (props.solution.pt ?? '').toUpperCase(),
    is_active: props.solution.is_active === 1 ? true : false,
    requested_translation: false,
});

watch(() => form.name, (newValue) => {
    form.name = newValue.toUpperCase();
});

watch(() => form.es, (newValue) => {
    form.es = newValue.toUpperCase();
});

watch(() => form.pt, (newValue) => {
    form.pt = newValue.toUpperCase();
});

function submit() {
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
    router.put(`/reports/solutions/${props.solution.id}`, form, {
        onSuccess: () => {
            console.log("Exitoso");
            Swal.close();
            Swal.fire({
                icon: "success",
                title: "Success!",
                html: "The update has been completed successfully.",
                customClass: "sweet-alerts",
            });
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