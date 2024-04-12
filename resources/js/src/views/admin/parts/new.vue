<template>
    <Head title="New Part" />
    <div>
        <div class="panel border-[#e0e6ed] dark:border-[#1b2e4b]">
            <div class="mb-5">
                <ol
                    class="flex text-gray-500 font-semibold dark:text-white-dark"
                >
                    <li><Link href="/parts">Parts</Link></li>
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
                <div :class="{ 'has-error': errors.num_part }">
                    <label for="formPartId">Part ID</label>
                    <input
                        id="formPartId"
                        type="text"
                        placeholder="Enter Part ID"
                        class="form-input"
                        v-model="form.num_part"
                    />
                    <template v-if="errors.num_part">
                        <p class="text-danger mt-1">{{ errors.num_part }}</p>
                    </template>
                </div>
                <div :class="{ 'has-error': errors.descripcion }">
                    <label for="formDescription">Description</label>
                    <input
                        id="formDescription"
                        type="text"
                        placeholder="Enter description"
                        class="form-input"
                        v-model="form.descripcion"
                    />
                    <template v-if="errors.descripcion">
                        <p class="text-danger mt-1">{{ errors.descripcion }}</p>
                    </template>
                </div>
                <div>
                    <label for="formActive">Is visible?</label>
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
        <!--
        <div class="panel border-[#e0e6ed] dark:border-[#1b2e4b] mt-5">
            <form class="space-y-5" @submit.prevent="submitExcel">
                <div class="custom-file-container" data-upload-id="myFirstImage">
                    <div class="label-container"><label>Excel Upload </label> <a href="javascript:;" class="custom-file-container__image-clear" title="Clear Image">×</a></div>
                    <label class="custom-file-container__custom-file">
                        <input type="file" v-on:change="onFileChange" class="custom-file-container__custom-file__custom-file-input" />
                        <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                        <span class="custom-file-container__custom-file__custom-file-control ltr:pr-20 rtl:pl-20"></span>
                    </label>
                    <div class="custom-file-container__image-preview" style="display:none;"></div>
                </div>
                <button type="submit" class="btn btn-primary !mt-6">Add</button>
            </form>
        </div>-->
    </div>
</template>

<script lang="ts" setup>
import { reactive, ref, onMounted } from "vue";
import Multiselect from "@suadelabs/vue3-multiselect";
import { Head, Link, router } from "@inertiajs/vue3";
import AppLayout from "@/layouts/app-layout.vue";
import SiteLayout from "@/layouts/app.vue";
import FileUploadWithPreview from 'file-upload-with-preview';
import Swal from "sweetalert2";

onMounted(() => {
    /*
    new FileUploadWithPreview('myFirstImage', {
        images: {
            baseImage: '',
            backgroundImage: '',
        },
    });*/
});

defineOptions({
    layout: [SiteLayout, AppLayout],
});

const props = defineProps({
    errors: Object
});

const form = reactive({
    num_part: null,
    descripcion: null,
    is_active: true,
});

const formExcel = reactive({
    your_file: null,
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
    router.post("/parts", form, {
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

function onFileChange(e) {
    var files = e.target.files || e.dataTransfer.files;
    formExcel.your_file = files[0];
}

function submitExcel() {
    //console.log(formExcel);
    router.post("/parts/excel", formExcel);
}
</script>
