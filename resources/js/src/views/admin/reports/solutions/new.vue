<template>
    <Head title="New Solution" />
    <div>
        <div class="panel border-[#e0e6ed] dark:border-[#1b2e4b]">
            <div class="mb-5">
                <ol
                    class="flex text-gray-500 font-semibold dark:text-white-dark"
                >
                    <li><Link href="/reports/solutions">Solutions</Link></li>
                    <li class="before:content-['/'] before:px-1.5">
                        <a
                            href="javascript:;"
                            class="text-black dark:text-white-light hover:text-black/70 dark:hover:text-white-light/70"
                            >{{ $t('user.create.breadcrumb.new') }}</a
                        >
                    </li>
                </ol>
            </div>
            <form class="space-y-5" @submit.prevent="submit">
                <div :class="{ 'has-error': errors.code }">
                    <label for="formClient">Solution Name (EN) <span class="text-red-500">*</span></label>
                    <input
                        id="formClient"
                        type="text"
                        placeholder="Enter Solution Name (EN)"
                        class="form-input"
                        v-model="form.name"
                    />
                    <template v-if="errors.name">
                        <p class="text-danger mt-1">{{ errors.name }}</p>
                    </template>
                </div>
                <div :class="{ 'has-error': errors.code }">
                    <label for="formClientES">Solution Name (ES)</label>
                    <input
                        id="formClientES"
                        type="text"
                        placeholder="Enter Solution Name (ES)"
                        class="form-input"
                        v-model="form.es"
                    />
                    <template v-if="errors.es">
                        <p class="text-danger mt-1">{{ errors.es }}</p>
                    </template>
                </div>
                <div :class="{ 'has-error': errors.code }">
                    <label for="formClientPT">Solution Name (PT)</label>
                    <input
                        id="formClientPT"
                        type="text"
                        placeholder="Enter Solution Name (PT)"
                        class="form-input"
                        v-model="form.pt"
                    />
                    <template v-if="errors.pt">
                        <p class="text-danger mt-1">{{ errors.pt }}</p>
                    </template>
                </div>
                <button type="submit" class="btn btn-primary !mt-6">{{ $t("user.create.add") }}</button>
            </form>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { reactive } from "vue";
import { Head, Link, router } from "@inertiajs/vue3";
import AppLayout from "@/layouts/app-layout.vue";
import SiteLayout from "@/layouts/app.vue";

defineOptions({
    layout: [SiteLayout, AppLayout],
});
defineProps({ errors: Object });

const form = reactive({
    name: null,
    es: null,
    pt: null,
    is_active: true,
});

function submit() {
    router.post('/reports/solutions', form);
}
</script>
