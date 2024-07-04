<template>
    <Head title="New Client" />
    <div>
        <div class="panel border-[#e0e6ed] dark:border-[#1b2e4b]">
            <div class="mb-5">
                <ol
                    class="flex text-gray-500 font-semibold dark:text-white-dark"
                >
                    <li><Link href="/machines/clients">Clients</Link></li>
                    <li class="before:content-['/'] before:px-1.5">
                        <a
                            href="javascript:;"
                            class="text-black dark:text-white-light hover:text-black/70 dark:hover:text-white-light/70"
                            >New</a
                        >
                    </li>
                </ol>
            </div>
            <form class="space-y-5" @submit.prevent="submit">
                <div :class="{ 'has-error': errors.code }">
                    <label for="formClient">Client</label>
                    <input
                        id="formClient"
                        type="text"
                        placeholder="Enter Client name"
                        class="form-input"
                        v-model="form.name"
                    />
                    <template v-if="errors.name">
                        <p class="text-danger mt-1">{{ errors.name }}</p>
                    </template>
                </div>
                <div>
                    <label for="formActive">Is assignable?</label>
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
                <button type="submit" class="btn btn-primary !mt-6">Add</button>
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
