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
                <div :class="{ 'has-error': errors.emp }">
                    <label for="formEmp">Employee ID</label>
                    <input
                        id="formEmp"
                        type="text"
                        placeholder="Enter Type Name"
                        class="form-input"
                        v-model="form.emp"
                    />
                    <template v-if="errors.emp">
                        <p class="text-danger mt-1">{{ errors.emp }}</p>
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
                        <p class="text-danger mt-1">
                            {{ errors.apellido_paterno }}
                        </p>
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
                        <p class="text-danger mt-1">
                            {{ errors.apellido_materno }}
                        </p>
                    </template>
                </div>
                <div :class="{ 'has-error': errors.telefono }">
                    <label for="formTelefono">Phone</label>
                    <input
                        id="formTelefono"
                        type="tel"
                        placeholder="Enter Phone"
                        class="form-input"
                        v-model="form.telefono"
                    />
                    <template v-if="errors.telefono">
                        <p class="text-danger mt-1">
                            {{ errors.telefono }}
                        </p>
                    </template>
                </div>
                <div :class="{ 'has-error': errors.email }">
                    <label for="formEmail">Email</label>
                    <input
                        id="formEmail"
                        type="email"
                        placeholder="Enter Email"
                        class="form-input"
                        v-model="form.email"
                    />
                    <template v-if="errors.email">
                        <p class="text-danger mt-1">
                            {{ errors.email }}
                        </p>
                    </template>
                </div>
                <div :class="{ 'has-error': errors.password }">
                    <label for="formPassword">Password</label>
                    <input
                        id="formPassword"
                        type="password"
                        placeholder="Enter Password"
                        class="form-input"
                        v-model="form.password"
                    />
                    <template v-if="errors.password">
                        <p class="text-danger mt-1">
                            {{ errors.password }}
                        </p>
                    </template>
                </div>
                <div :class="{ 'has-error': errors.user_type_id }">
                    <label for="formUserType">User Type</label>
                    <div>
                        <select
                            id="formUserType"
                            class="form-select text-white-dark"
                            v-model="form.user_type_id"
                            required
                        >
                            <option :value="null">Open this select menu</option>
                            <option v-for="userType in props.catalogUserTypes" :key="userType.id" :value="userType.id">{{ userType.tipo }}</option>
                        </select>
                    </div>
                    <template v-if="errors.user_type_id">
                        <p class="text-danger mt-1">
                            {{ errors.user_type_id }}
                        </p>
                    </template>
                </div>
                <div :class="{ 'has-error': errors.user_title_id }">
                    <label for="formUserTitle">Title</label>
                    <div>
                        <select
                            id="formUserTitle"
                            class="form-select text-white-dark"
                            v-model="form.user_title_id"
                            required
                        >
                            <option :value="null">Open this select menu</option>
                            <option v-for="userTitle in props.catalogUserTitles" :key="userTitle.id" :value="userTitle.id">{{ userTitle.titulo }}</option>
                        </select>
                    </div>
                    <template v-if="errors.user_title_id">
                        <p class="text-danger mt-1">
                            {{ errors.user_title_id }}
                        </p>
                    </template>
                </div>
                <button type="submit" class="btn btn-primary !mt-6">Add</button>
            </form>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { reactive, ref } from "vue";
import Multiselect from "@suadelabs/vue3-multiselect";
import { Head, Link, router } from "@inertiajs/vue3";
import AppLayout from "@/layouts/app-layout.vue";
import SiteLayout from "@/layouts/app.vue";

defineOptions({
    layout: [SiteLayout, AppLayout],
});

const props = defineProps({
    catalogUserTypes: {
        type: Array,
        required: true,
    },
    catalogUserTitles: {
        type: Array,
        required: true,
    },
    errors: Object
});

const form = reactive({
    emp: null,
    email: null,
    password: null,
    nombre: null,
    apellido_paterno: null,
    apellido_materno: null,
    telefono: null,
    user_type_id: null,
    user_title_id: null,
});

function submit() {
    router.post("/users", form);
}
</script>
