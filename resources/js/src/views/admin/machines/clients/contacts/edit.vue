<template>
    <Head title="Edit Contacts" />
    <div>
        <div class="panel border-[#e0e6ed] dark:border-[#1b2e4b] mt-5">
            <div class="mb-5">
                <ol
                    class="flex text-gray-500 font-semibold dark:text-white-dark"
                >
                    <li><Link href="/machines/clients">{{ $t('report.form.client') }}</Link></li>
                    <li class="before:content-['/'] before:px-1.5">
                        <Link
                            :href="`/machines/clients/${branch.client_id}/edit`"
                            class="text-black dark:text-white-light hover:text-black/70 dark:hover:text-white-light/70"
                            >{{ $t('branch.edit.breadcrumb.branch') }}</Link
                        >
                    </li>
                    <li class="before:content-['/'] before:px-1.5">
                        <a
                            href="javascript:;"
                            class="text-black dark:text-white-light hover:text-black/70 dark:hover:text-white-light/70"
                            >{{ $t('report.form.contacts') }}</a
                        >
                    </li>
                </ol>
            </div>
            <div class="table-responsive mt-4">
                <table>
                    <thead>
                        <tr>
                            <th>{{ $t('report.form.name') }}</th>
                            <th>Email</th>
                            <th>{{ $t('report.form.phone') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-for="(contact, index) in formContacts" :key="index">
                            <template v-if="contact.id && !contact.edit_mode">
                                <tr :class="{ 'bg-red-200': contact.is_active == 0 }">
                                    <td>{{ contact.name }}</td>
                                    <td>{{ contact.email }}</td>
                                    <td>{{ contact.phone }}</td>
                                    <td class="flex">
                                        <button
                                            type="button"
                                            class="mx-1"
                                            @click="contact.edit_mode = true"
                                        >
                                            <svg
                                                width="24"
                                                height="24"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="w-4.5 h-4.5"
                                            >
                                                <path
                                                    opacity="0.5"
                                                    d="M22 10.5V12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2H13.5"
                                                    stroke="currentColor"
                                                    stroke-width="1.5"
                                                    stroke-linecap="round"
                                                ></path>
                                                <path
                                                    d="M17.3009 2.80624L16.652 3.45506L10.6872 9.41993C10.2832 9.82394 10.0812 10.0259 9.90743 10.2487C9.70249 10.5114 9.52679 10.7957 9.38344 11.0965C9.26191 11.3515 9.17157 11.6225 8.99089 12.1646L8.41242 13.9L8.03811 15.0229C7.9492 15.2897 8.01862 15.5837 8.21744 15.7826C8.41626 15.9814 8.71035 16.0508 8.97709 15.9619L10.1 15.5876L11.8354 15.0091C12.3775 14.8284 12.6485 14.7381 12.9035 14.6166C13.2043 14.4732 13.4886 14.2975 13.7513 14.0926C13.9741 13.9188 14.1761 13.7168 14.5801 13.3128L20.5449 7.34795L21.1938 6.69914C22.2687 5.62415 22.2687 3.88124 21.1938 2.80624C20.1188 1.73125 18.3759 1.73125 17.3009 2.80624Z"
                                                    stroke="currentColor"
                                                    stroke-width="1.5"
                                                ></path>
                                                <path
                                                    opacity="0.5"
                                                    d="M16.6522 3.45508C16.6522 3.45508 16.7333 4.83381 17.9499 6.05034C19.1664 7.26687 20.5451 7.34797 20.5451 7.34797M10.1002 15.5876L8.4126 13.9"
                                                    stroke="currentColor"
                                                    stroke-width="1.5"
                                                ></path>
                                            </svg>
                                        </button>
                                        <button
                                            type="button"
                                            class="mx-1"
                                            @click="contact.is_active = contact.is_active == 1 ? 0 : 1"
                                        >
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6"><path d="M20.5001 6H3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path><path d="M18.8334 8.5L18.3735 15.3991C18.1965 18.054 18.108 19.3815 17.243 20.1907C16.378 21 15.0476 21 12.3868 21H11.6134C8.9526 21 7.6222 21 6.75719 20.1907C5.89218 19.3815 5.80368 18.054 5.62669 15.3991L5.16675 8.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path><path opacity="0.5" d="M9.5 11L10 16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path><path opacity="0.5" d="M14.5 11L14 16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path><path opacity="0.5" d="M6.5 6C6.55588 6 6.58382 6 6.60915 5.99936C7.43259 5.97849 8.15902 5.45491 8.43922 4.68032C8.44784 4.65649 8.45667 4.62999 8.47434 4.57697L8.57143 4.28571C8.65431 4.03708 8.69575 3.91276 8.75071 3.8072C8.97001 3.38607 9.37574 3.09364 9.84461 3.01877C9.96213 3 10.0932 3 10.3553 3H13.6447C13.9068 3 14.0379 3 14.1554 3.01877C14.6243 3.09364 15.03 3.38607 15.2493 3.8072C15.3043 3.91276 15.3457 4.03708 15.4286 4.28571L15.5257 4.57697C15.5433 4.62992 15.5522 4.65651 15.5608 4.68032C15.841 5.45491 16.5674 5.97849 17.3909 5.99936C17.4162 6 17.4441 6 17.5 6" stroke="currentColor" stroke-width="1.5"></path></svg>
                                        </button>
                                    </td>
                                </tr>
                            </template>
                            <template v-else>
                                <tr>
                                    <td><input type="text" class="form-input" v-model="formContacts[index].name" /></td>
                                    <td><input type="email" class="form-input" v-model="formContacts[index].email" /></td>
                                    <td><input type="tel" class="form-input" v-model="formContacts[index].phone" /></td>
                                    <td>
                                        <button type="button" v-if="contact.id" @click="contact.edit_mode = false">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6"><path opacity="0.5" d="M2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C22 4.92893 22 7.28595 22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12Z" stroke="currentColor" stroke-width="1.5"></path><path d="M8.5 12.5L10.5 14.5L15.5 9.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </template>
                    </tbody>
                </table>
                <div class="w-full flex justify-center">
                    <button
                        @click="addContact()"
                        class="btn btn-secondary gap-2"
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
            <button type="button" @click="submitContacts()" class="btn btn-primary !mt-6">{{ $t("user.create.update") }}</button>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { reactive, onMounted } from "vue";
import { Head, Link, router } from "@inertiajs/vue3";
import AppLayout from "@/layouts/app-layout.vue";
import SiteLayout from "@/layouts/app.vue";
import Swal from "sweetalert2";

defineOptions({
    layout: [SiteLayout, AppLayout],
});

const props = defineProps({
    branch: {
        type: Object,
        required: true,
    }
});

console.log(props.branch);

const formContacts = reactive([]);

onMounted(() => {
    formContacts.push(...props.branch.branch_managers);
});

function addContact() {
    formContacts.push({
        id: null,
        name: "",
        email: "",
        phone: "",
        is_active: 1
    });
}

function submitContacts() {
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
    router.put(`/machines/clients/branches/contacts/${props.branch.id}`, formContacts, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            console.log("Exitoso");
            Swal.close();
            Swal.fire({
                icon: "success",
                title: "Success!",
                html: "The update has been completed successfully.",
                customClass: "sweet-alerts",
            });
            router.visit(`/machines/clients/branches/contacts/${props.branch.id}/edit`, {
                only: ['branch'],
                preserveScroll: true,
                preserveState: false,
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