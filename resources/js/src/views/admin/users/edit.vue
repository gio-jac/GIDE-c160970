<template>
    <Head title="Users Edit" />
    <div>
        <div class="panel border-[#e0e6ed] dark:border-[#1b2e4b]">
            <div class="mb-5">
                <ol
                    class="flex text-gray-500 font-semibold dark:text-white-dark"
                >
                    <li><Link href="/users">{{ $t("user.create.breadcrumb.users") }}</Link></li>
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
                <div :class="{ 'has-error': errors.emp }">
                    <label for="formEmp">{{ $t("user.create.emp") }}</label>
                    <input
                        id="formEmp"
                        type="text"
                        :placeholder="$t('user.create.empPlaceholder')"
                        class="form-input"
                        v-model="form.emp"
                    />
                    <template v-if="errors.emp">
                        <p class="text-danger mt-1">{{ errors.emp }}</p>
                    </template>
                </div>
                <div :class="{ 'has-error': errors.nombre }">
                    <label for="formNombre">{{ $t("user.create.name") }}</label>
                    <input
                        id="formNombre"
                        type="text"
                        :placeholder="$t('user.create.namePlaceholder')"
                        class="form-input"
                        v-model="form.nombre"
                    />
                    <template v-if="errors.nombre">
                        <p class="text-danger mt-1">{{ errors.nombre }}</p>
                    </template>
                </div>
                <div :class="{ 'has-error': errors.apellido_paterno }">
                    <label for="formPaternalSurname">{{ $t("user.create.firstSurname") }}</label>
                    <input
                        id="formPaternalSurname"
                        type="text"
                        :placeholder="$t('user.create.firstSurnamePlaceholder')"
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
                    <label for="formMaternalSurname">{{ $t("user.create.secondSurname") }}</label>
                    <input
                        id="formMaternalSurname"
                        type="text"
                        :placeholder="$t('user.create.secondSurnamePlaceholder')"
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
                    <label for="formTelefono">{{ $t("user.create.phone") }}</label>
                    <input
                        id="formTelefono"
                        type="tel"
                        :placeholder="$t('user.create.phonePlaceholder')"
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
                    <label for="formEmail">{{ $t("user.create.email") }}</label>
                    <input
                        id="formEmail"
                        type="email"
                        :placeholder="$t('user.create.emailPlaceholder')"
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
                    <label for="formPassword">{{ $t("user.create.password") }}</label>
                    <input
                        id="formPassword"
                        type="password"
                        :placeholder="$t('user.create.passwordPlaceholder')"
                        class="form-input"
                        v-model="form.password"
                    />
                    <template v-if="errors.password">
                        <p class="text-danger mt-1">
                            {{ errors.password }}
                        </p>
                    </template>
                    <p class="text-danger mt-1">{{ $t("user.create.passwordWarning") }}</p>
                </div>
                <div :class="{ 'has-error': errors.user_type_id }">
                    <label for="formUserType">{{ $t("user.create.profile") }}</label>
                    <div>
                        <select
                            id="formUserType"
                            class="form-select text-white-dark"
                            v-model="form.user_type_id"
                            required
                        >
                            <option :value="null">{{ $t("user.create.profile.default") }}</option>
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
                    <label for="formUserTitle">{{ $t("user.create.positions") }}</label>
                    <div>
                        <select
                            id="formUserTitle"
                            class="form-select text-white-dark"
                            v-model="form.user_title_id"
                            required
                        >
                            <option :value="null">{{ $t("user.create.positions.default") }}</option>
                            <option v-for="userTitle in props.catalogUserTitles" :key="userTitle.id" :value="userTitle.id">{{ userTitle.titulo }}</option>
                        </select>
                    </div>
                    <template v-if="errors.user_title_id">
                        <p class="text-danger mt-1">
                            {{ errors.user_title_id }}
                        </p>
                    </template>
                </div>
                <div>
                    <label for="formActive">{{ $t("user.create.activeUser") }}</label>
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
    user: {
        type: Object,
        required: true,
    },
    errors: Object
});

const form = reactive({
    emp: props.user.emp,
    email: props.user.email,
    password: null,
    nombre: props.user.nombre,
    apellido_paterno: props.user.apellido_paterno,
    apellido_materno: props.user.apellido_materno,
    telefono: props.user.telefono,
    user_type_id: props.user.user_type_id,
    user_title_id: props.user.user_title_id,
    is_active: props.user.is_active === 1 ? true : false,
});

console.log(props.user);

function submit() {
    router.put(`/users/${props.user.id}`, form);
}
</script>
