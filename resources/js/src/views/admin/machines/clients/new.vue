<template>
    <Head title="New Client" />
    <div>
        <div class="panel border-[#e0e6ed] dark:border-[#1b2e4b]">
            <div class="mb-5">
                <ol
                    class="flex text-gray-500 font-semibold dark:text-white-dark"
                >
                    <li><Link href="/machines/clients">{{ $t('sidebar.clients') }}</Link></li>
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
                    <label for="formClient">{{ $t('report.form.client') }}</label>
                    <input
                        id="formClient"
                        type="text"
                        :placeholder="$t('client.new.clientNamePlaceholder')"
                        class="form-input"
                        v-model="form.name"
                    />
                    <template v-if="errors.name">
                        <p class="text-danger mt-1">{{ errors.name }}</p>
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
    is_active: true,
});

function submit() {
    router.post('/machines/clients', form);
}
</script>
