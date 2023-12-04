<template>
    <Head title="Users New Type" />
    <div>
        <div class="panel border-[#e0e6ed] dark:border-[#1b2e4b]">
            <div class="mb-5">
                <ol
                    class="flex text-gray-500 font-semibold dark:text-white-dark"
                >
                    <li><Link href="/users">Users</Link></li>
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
                <div :class="{ 'has-error': errors.EMP }">
                    <label for="formEMP">Employee ID</label>
                    <input
                        id="formEMP"
                        type="text"
                        placeholder="Enter Type Name"
                        class="form-input"
                        v-model="form.EMP"
                    />
                    <template v-if="errors.EMP">
                        <p class="text-danger mt-1">{{ errors.EMP }}</p>
                    </template>
                </div>
                <div :class="{ 'has-error': errors.nombre }">
                    <label for="formNombre">Name</label>
                    <input
                        id="formNombre"
                        type="text"
                        placeholder="Enter Name"
                        class="form-input"
                        v-model="form.nombre"
                    />
                    <template v-if="errors.nombre">
                        <p class="text-danger mt-1">{{ errors.nombre }}</p>
                    </template>
                </div>
                <div :class="{ 'has-error': errors.apellido_paterno }">
                    <label for="formPaternalSurname">Paternal surname</label>
                    <input
                        id="formPaternalSurname"
                        type="text"
                        placeholder="Enter Paternal Surname"
                        class="form-input"
                        v-model="form.apellido_paterno"
                    />
                    <template v-if="errors.apellido_paterno">
                        <p class="text-danger mt-1">{{ errors.apellido_paterno }}</p>
                    </template>
                </div>
                <div :class="{ 'has-error': errors.apellido_materno }">
                    <label for="formMaternalSurname">Maternal surname</label>
                    <input
                        id="formMaternalSurname"
                        type="text"
                        placeholder="Enter Maternal Surname"
                        class="form-input"
                        v-model="form.apellido_materno"
                    />
                    <template v-if="errors.apellido_materno">
                        <p class="text-danger mt-1">{{ errors.apellido_materno }}</p>
                    </template>
                </div>
                <div :class="{ 'has-error': errors.user_type_id }">
                    <label for="formUserType">User Type</label>
                    <div class="mb-5">
                        <multiselect
                            v-model="input1"
                            :options="options"
                            class="custom-multiselect"
                            :searchable="false"
                            :preselect-first="true"
                            :allow-empty="false"
                            selected-label=""
                            select-label=""
                            deselect-label=""
                        ></multiselect>
                    </div>
                    <template v-if="errors.user_type_id">
                        <p class="text-danger mt-1">{{ errors.user_type_id }}</p>
                    </template>
                </div>
                <div :class="{ 'has-error': errors.user_title_id }">
                    <label for="formUserTitle">User Title</label>
                    <input
                        id="formUserTitle"
                        type="text"
                        placeholder="Enter Title"
                        class="form-input"
                        v-model="form.user_title_id"
                    />
                    <template v-if="errors.user_title_id">
                        <p class="text-danger mt-1">{{ errors.user_title_id }}</p>
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
import { reactive, ref } from "vue";
import Multiselect from '@suadelabs/vue3-multiselect';
import { Head, Link, router } from "@inertiajs/vue3";
import AppLayout from "@/layouts/app-layout.vue";
import SiteLayout from "@/layouts/app.vue";

const input1 = ref('Orange');
const options = ref(['Orange', 'White', 'Purple']);

defineOptions({
    layout: [SiteLayout, AppLayout],
});
defineProps({ errors: Object });

const form = reactive({
    tipo: null,
    is_active: true,
});

function submit() {
    router.post('/users/types', form);
}
</script>
