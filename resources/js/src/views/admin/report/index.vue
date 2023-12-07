<template>
    <div>
        <div class="flex xl:flex-row flex-col gap-2.5">
            <div class="panel px-0 flex-1 py-6 ltr:xl:mr-6 rtl:xl:ml-6">
                <div class="flex justify-between flex-wrap px-4">
                    <div class="lg:w-1/2 w-full lg:max-w-fit">
                        <div class="flex items-center">
                            <label for="number" class="flex-1 ltr:mr-2 rtl:ml-2 mb-0">Report ID</label>
                            <input
                                id="number"
                                type="text"
                                name="inv-num"
                                class="form-input lg:w-[250px] w-2/3"
                                placeholder="#8801"
                                v-model="params.invoiceNo"
                            />
                        </div>
                        <div class="flex items-center mt-4">
                            <label for="formUserType" class="flex-1 ltr:mr-2 rtl:ml-2 mb-0">Machine Serial</label>
                            <div>
                                <select
                                    id="formUserType"
                                    class="form-select text-white-dark lg:w-[250px] w-2/3"
                                    v-model="form.selectedMachine"
                                    required
                                >
                                    <option :value="null">Open this select menu</option>
                                    <option v-for="machine in catalogMachine" :key="machine.id" :value="machine">{{ machine.id }} - {{ machine.type }} - {{ machine.customer.name }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="border-[#e0e6ed] dark:border-[#1b2e4b] my-6" />
                <div class="mt-8 px-4">
                    <div class="flex justify-between lg:flex-row flex-col">
                        <div class="lg:w-1/2 w-full ltr:lg:mr-6 rtl:lg:ml-6 mb-6">
                            <div class="text-lg">Customer Data</div>
                            <div class="mt-4 flex items-center">
                                <label for="reciever-name" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Name</label>
                                <input
                                    id="reciever-name"
                                    type="text"
                                    name="reciever-name"
                                    class="form-input flex-1"
                                    :value="form.selectedMachine?.customer.name" readonly
                                    placeholder="Enter Name"
                                />
                            </div>
                            <div class="mt-4 flex items-center">
                                <label for="reciever-email" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Address</label>
                                <input
                                    id="reciever-email"
                                    type="text"
                                    name="reciever-email"
                                    class="form-input flex-1"
                                    :value="form.selectedMachine?.customer.address" readonly
                                    placeholder="Enter Email"
                                />
                            </div>
                            <div class="mt-4 flex items-center">
                                <label for="reciever-address" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Contact</label>
                                <input
                                    id="reciever-address"
                                    type="text"
                                    name="reciever-address"
                                    class="form-input flex-1"
                                    :value="form.selectedMachine?.customer.contact" readonly
                                    placeholder="Enter Address"
                                />
                            </div>
                        </div>
                        <div class="lg:w-1/2 w-full">
                            <div class="text-lg">Machine Data</div>
                            <div class="flex items-center mt-4">
                                <label for="acno" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Serial</label>
                                <input
                                    id="acno"
                                    type="text"
                                    name="acno"
                                    class="form-input flex-1"
                                    :value="form.selectedMachine?.id" readonly
                                    placeholder="Enter Account Number"
                                />
                            </div>
                            <div class="flex items-center mt-4">
                                <label for="bank-name" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Type</label>
                                <input
                                    id="bank-name"
                                    type="text"
                                    name="bank-name"
                                    class="form-input flex-1"
                                    :value="form.selectedMachine?.type" readonly
                                    placeholder="Enter Bank Name"
                                />
                            </div>
                            <div class="flex items-center mt-4">
                                <label for="swift-code" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Segment</label>
                                <input
                                    id="swift-code"
                                    type="text"
                                    name="swift-code"
                                    class="form-input flex-1"
                                    :value="form.selectedMachine?.segment" readonly
                                    placeholder="Enter SWIFT Number"
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="border-[#e0e6ed] dark:border-[#1b2e4b] my-6" />
                <div class="mt-8 px-4">
                    <div class="flex justify-between lg:flex-row flex-col flex-wrap">
                        <div class="lg:w-1/2 w-full ltr:lg:pr-6 rtl:lg:pl-6 mb-6">
                            <div class="mt-4 flex items-center">
                                <label for="reciever-name" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Transport</label>
                                <input
                                    id="reciever-name"
                                    type="number"
                                    name="reciever-name"
                                    class="form-input flex-1"
                                    placeholder="Enter Name"
                                />
                            </div>
                            <div class="mt-4 flex items-center">
                                <label for="reciever-email" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Pieces</label>
                                <input
                                    id="reciever-email"
                                    type="number"
                                    name="reciever-email"
                                    class="form-input flex-1"
                                    placeholder="Enter Email"
                                />
                            </div>
                            <div class="mt-4 flex items-center">
                                <label for="reciever-address" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">SO GD</label>
                                <input
                                    id="reciever-address"
                                    type="number"
                                    name="reciever-address"
                                    class="form-input flex-1"
                                    placeholder="Enter Address"
                                />
                            </div>
                        </div>
                        <div class="lg:w-1/2 w-full">
                            <div class="flex items-center mt-4">
                                <label for="acno" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Machine ON</label>
                                <input
                                    id="acno"
                                    type="number"
                                    name="acno"
                                    class="form-input flex-1"
                                    placeholder="Enter Account Number"
                                />
                            </div>
                            <div class="flex items-center mt-4">
                                <label for="bank-name" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Travel time</label>
                                <input
                                    id="bank-name"
                                    type="number"
                                    name="bank-name"
                                    class="form-input flex-1"
                                    placeholder="Enter Bank Name"
                                />
                            </div>
                            <div class="flex items-center mt-4">
                                <label for="bank-name" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Type</label>
                                
                                <select
                                    id="formUserTypeeeee"
                                    class="form-select text-white-dark flex-1"
                                    required
                                >
                                    <option value="1" selected>Contract</option>
                                    <option value="2">Client</option>
                                </select>
                            
                            </div>
                        </div>
                        <div class="w-full">
                            <div class="flex items-center">
                                <label for="swift-code" class="ltr:mr-2 rtl:ml-2 w-1/6 mb-0">Error reported</label>
                                <input
                                    id="swift-code"
                                    type="text"
                                    name="swift-code"
                                    class="form-input flex-1"
                                    placeholder="Enter SWIFT Number"
                                />
                            </div>
                            <div class="mt-4 flex items-center">
                                <label for="swift-code" class="ltr:mr-2 rtl:ml-2 w-1/6 mb-0">Fault Symptom</label>
                                <textarea id="ctnTextarea" rows="3" class="form-textarea flex-1" placeholder="Enter Textarea" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="border-[#e0e6ed] dark:border-[#1b2e4b] my-6" />
                <div class="mt-8 px-4">
                    <div class="flex flex-wrap justify-evenly">
                        <label class="inline-flex">
                            <input type="radio" name="default_radio" class="form-radio" checked />
                            <span>EMC</span>
                        </label>
                        <label class="inline-flex">
                            <input type="radio" name="default_radio" class="form-radio" checked />
                            <span>INST</span>
                        </label>
                        <label class="inline-flex">
                            <input type="radio" name="default_radio" class="form-radio" checked />
                            <span>SAT</span>
                        </label>
                        <label class="inline-flex">
                            <input type="radio" name="default_radio" class="form-radio" checked />
                            <span>DEIN</span>
                        </label>
                        <label class="inline-flex">
                            <input type="radio" name="default_radio" class="form-radio" checked />
                            <span>PM</span>
                        </label>
                        <label class="inline-flex">
                            <input type="radio" name="default_radio" class="form-radio" checked />
                            <span>SITE</span>
                        </label>
                        <label class="inline-flex">
                            <input type="radio" name="default_radio" class="form-radio" checked />
                            <span>SORT</span>
                        </label>
                    </div>
                    <div class="w-full">
                        <div class="mt-4 flex items-center">
                            <label for="swift-code" class="ltr:mr-2 rtl:ml-2 w-1/6 mb-0">Actions Taken</label>
                            <textarea id="ctnTextarea" rows="3" class="form-textarea flex-1" placeholder="Enter Textarea" required></textarea>
                        </div>
                    </div>
                </div>
                <hr class="border-[#e0e6ed] dark:border-[#1b2e4b] my-6" />
                <div class="mt-8 px-4">
                    <div class="flex justify-between lg:flex-row flex-col flex-wrap">
                        <div class="lg:w-1/2 w-full ltr:lg:pr-6 rtl:lg:pl-6 mb-6">
                            <div class="mt-4 flex items-center">
                                <label for="reciever-name" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Reported</label>
                                <flat-pickr class="form-input flex-1" :config="dateTime"></flat-pickr>
                            </div>
                            <div class="mt-4 flex items-center">
                                <label for="reciever-name" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Arrival</label>
                                <flat-pickr class="form-input flex-1" :config="dateTime"></flat-pickr>
                            </div>
                        </div>
                        <div class="lg:w-1/2 w-full">
                            <div class="mt-4 flex items-center">
                                <label for="reciever-name" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Finished</label>
                                <flat-pickr class="form-input flex-1" :config="dateTime"></flat-pickr>
                            </div>
                            <div class="mt-4 flex items-center">
                                <label for="reciever-name" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Departure</label>
                                <flat-pickr class="form-input flex-1" :config="dateTime"></flat-pickr>
                            </div>
                        </div>
                        <div class="w-full flex flex-wrap justify-evenly">
                            <label class="inline-flex">
                                <input type="radio" name="default_radio2" class="form-radio" checked />
                                <span>Complete</span>
                            </label>
                            <label class="inline-flex">
                                <input type="radio" name="default_radio2" class="form-radio" checked />
                                <span>Incomplete</span>
                            </label>
                            <label class="inline-flex">
                                <input type="radio" name="default_radio2" class="form-radio" checked />
                                <span>Return</span>
                            </label>
                        </div>
                        <div class="w-full">
                            <div class="mt-4 flex items-center flex flex-wrap justify-evenly">
                                <label class="inline-flex">
                                    <input type="checkbox" class="form-checkbox rounded-full" checked />
                                    <span>Test OK</span>
                                </label>
                            </div>
                            <div class="mt-4 flex items-center">
                                <label for="bank-name" class="ltr:mr-2 rtl:ml-2 w-1/6 mb-0">DT</label>
                                <input
                                    id="bank-name"
                                    type="number"
                                    name="bank-name"
                                    class="form-input flex-1"
                                    placeholder="Enter Bank Name"
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-8">
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Part Replaced</th>
                                    <th class="w-1">Description</th>
                                    <th class="w-1">Quantity</th>
                                    <th class="w-1"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-if="items.length <= 0">
                                    <tr>
                                        <td colspan="5" class="!text-center font-semibold">No Item Available</td>
                                    </tr>
                                </template>
                                <template v-for="(item, i) in items" :key="i">
                                    <tr class="align-top">
                                        <td>
                                            <input type="text" class="form-input min-w-[200px]" placeholder="Enter Item Name" v-model="item.title" />
                                        </td>
                                        <td>
                                            <input type="text" class="form-input min-w-[200px]" placeholder="Enter Item Name" v-model="item.title" />
                                        </td>
                                        <td><input type="number" class="form-input w-32" placeholder="Quantity" v-model="item.quantity" min="0"/></td>
                                        <td>
                                            <button type="button" @click="removeItem(item)">
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
                                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mt-8 px-4">
                    <div>
                        <label for="notes">Notes</label>
                        <textarea id="notes" name="notes" class="form-textarea min-h-[130px]" placeholder="Notes...." v-model="params.notes"></textarea>
                    </div>
                </div>
            </div>
            <div class="xl:w-96 w-full xl:mt-0 mt-6">
                <div class="panel mb-5">
                    <div>
                        <label for="currency">Currency</label>
                        <select id="currency" name="currency" class="form-select" v-model="selectedCurrency">
                            <template v-for="(currency, i) in currencyList" :key="i">
                                <option :value="currency">{{ currency }}</option>
                            </template>
                        </select>
                    </div>
                    <div class="mt-4">
                        <div class="grid sm:grid-cols-2 grid-cols-1 gap-4">
                            <div>
                                <label for="tax">Tax(%) </label>
                                <input v-model="tax" id="tax" type="number" name="tax" class="form-input" placeholder="Tax" />
                            </div>
                            <div>
                                <label for="discount">Discount(%) </label>
                                <input id="discount" type="number" name="discount" class="form-input" placeholder="Discount" v-model="discount" />
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div>
                            <label for="shipping-charge">Shipping Charge($) </label>
                            <input
                                id="shipping-charge"
                                type="number"
                                name="shipping-charge"
                                class="form-input"
                                placeholder="Shipping Charge"
                                v-model="shippingCharge"
                            />
                        </div>
                    </div>
                    <div class="mt-4">
                        <label for="payment-method">Accept Payment Via</label>
                        <select id="payment-method" name="payment-method" class="form-select" v-model="paymentMethod">
                            <option value="">Select Payment</option>
                            <option value="bank">Bank Account</option>
                            <option value="paypal">Paypal</option>
                            <option value="upi">UPI Transfer</option>
                        </select>
                    </div>
                </div>
                <div class="panel">
                    <div class="grid xl:grid-cols-1 lg:grid-cols-4 sm:grid-cols-2 grid-cols-1 gap-4">
                        <button type="button" class="btn btn-success w-full gap-2">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ltr:mr-2 rtl:ml-2 shrink-0">
                                <path
                                    d="M3.46447 20.5355C4.92893 22 7.28595 22 12 22C16.714 22 19.0711 22 20.5355 20.5355C22 19.0711 22 16.714 22 12C22 11.6585 22 11.4878 21.9848 11.3142C21.9142 10.5049 21.586 9.71257 21.0637 9.09034C20.9516 8.95687 20.828 8.83317 20.5806 8.58578L15.4142 3.41944C15.1668 3.17206 15.0431 3.04835 14.9097 2.93631C14.2874 2.414 13.4951 2.08581 12.6858 2.01515C12.5122 2 12.3415 2 12 2C7.28595 2 4.92893 2 3.46447 3.46447C2 4.92893 2 7.28595 2 12C2 16.714 2 19.0711 3.46447 20.5355Z"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                />
                                <path
                                    d="M17 22V21C17 19.1144 17 18.1716 16.4142 17.5858C15.8284 17 14.8856 17 13 17H11C9.11438 17 8.17157 17 7.58579 17.5858C7 18.1716 7 19.1144 7 21V22"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                />
                                <path opacity="0.5" d="M7 8H13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                            </svg>
                            Save Report
                        </button>

                        <button type="button" class="btn btn-info w-full gap-2">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ltr:mr-2 rtl:ml-2 shrink-0">
                                <path
                                    d="M17.4975 18.4851L20.6281 9.09373C21.8764 5.34874 22.5006 3.47624 21.5122 2.48782C20.5237 1.49939 18.6511 2.12356 14.906 3.37189L5.57477 6.48218C3.49295 7.1761 2.45203 7.52305 2.13608 8.28637C2.06182 8.46577 2.01692 8.65596 2.00311 8.84963C1.94433 9.67365 2.72018 10.4495 4.27188 12.0011L4.55451 12.2837C4.80921 12.5384 4.93655 12.6658 5.03282 12.8075C5.22269 13.0871 5.33046 13.4143 5.34393 13.7519C5.35076 13.9232 5.32403 14.1013 5.27057 14.4574C5.07488 15.7612 4.97703 16.4131 5.0923 16.9147C5.32205 17.9146 6.09599 18.6995 7.09257 18.9433C7.59255 19.0656 8.24576 18.977 9.5522 18.7997L9.62363 18.79C9.99191 18.74 10.1761 18.715 10.3529 18.7257C10.6738 18.745 10.9838 18.8496 11.251 19.0285C11.3981 19.1271 11.5295 19.2585 11.7923 19.5213L12.0436 19.7725C13.5539 21.2828 14.309 22.0379 15.1101 21.9985C15.3309 21.9877 15.5479 21.9365 15.7503 21.8474C16.4844 21.5244 16.8221 20.5113 17.4975 18.4851Z"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                />
                                <path opacity="0.5" d="M6 18L21 3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                            </svg>
                            Close Report
                        </button>
                        <!--
                        <router-link to="/apps/invoice/preview" class="btn btn-primary w-full gap-2">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ltr:mr-2 rtl:ml-2 shrink-0">
                                <path
                                    opacity="0.5"
                                    d="M3.27489 15.2957C2.42496 14.1915 2 13.6394 2 12C2 10.3606 2.42496 9.80853 3.27489 8.70433C4.97196 6.49956 7.81811 4 12 4C16.1819 4 19.028 6.49956 20.7251 8.70433C21.575 9.80853 22 10.3606 22 12C22 13.6394 21.575 14.1915 20.7251 15.2957C19.028 17.5004 16.1819 20 12 20C7.81811 20 4.97196 17.5004 3.27489 15.2957Z"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                ></path>
                                <path
                                    d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                ></path>
                            </svg>
                            Preview
                        </router-link>
                        -->
                        <button type="button" class="btn btn-secondary w-full gap-2">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ltr:mr-2 rtl:ml-2 shrink-0">
                                <path
                                    opacity="0.5"
                                    d="M17 9.00195C19.175 9.01406 20.3529 9.11051 21.1213 9.8789C22 10.7576 22 12.1718 22 15.0002V16.0002C22 18.8286 22 20.2429 21.1213 21.1215C20.2426 22.0002 18.8284 22.0002 16 22.0002H8C5.17157 22.0002 3.75736 22.0002 2.87868 21.1215C2 20.2429 2 18.8286 2 16.0002L2 15.0002C2 12.1718 2 10.7576 2.87868 9.87889C3.64706 9.11051 4.82497 9.01406 7 9.00195"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                    stroke-linecap="round"
                                ></path>
                                <path
                                    d="M12 2L12 15M12 15L9 11.5M12 15L15 11.5"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                ></path>
                            </svg>
                            Download PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script lang="ts" setup>
import { ref, onMounted, reactive } from 'vue';
import { useAppStore } from '@/stores/index';
    import AppLayout from "@/layouts/app-layout.vue";
import SiteLayout from "@/layouts/app.vue";
import flatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';
const store = useAppStore();
    defineOptions({
        layout: [SiteLayout, AppLayout],
    });

    const dateTime: any = ref({
    enableTime: true,
    dateFormat: 'Y-m-d H:i',
    position: store.rtlClass === 'rtl' ? 'auto right' : 'auto left',
  });

const catalogMachine = reactive([
    {id: "173503410", type:"BPS C4",segment:"C", customer: {name: "Banco Central do Brazil", address: "Calzada Legaria 691 Col. Lomas de Sotelo Banxico CDMX", contact: "Gieselle Salavelia Hernandez Espindola"} }
]);

const form = reactive({
    selectedMachine: null,
});

    const items: any = ref([]);
    const selectedFile = ref(null);
    const params = ref({
        title: '',
        invoiceNo: '',
        to: {
            name: '',
            email: '',
            address: '',
            phone: '',
        },

        invoiceDate: '',
        dueDate: '',
        bankInfo: {
            no: '',
            name: '',
            swiftCode: '',
            country: '',
            ibanNo: '',
        },
        notes: '',
    });
    const currencyList = ref([
        'USD - US Dollar',
        'GBP - British Pound',
        'IDR - Indonesian Rupiah',
        'INR - Indian Rupee',
        'BRL - Brazilian Real',
        'EUR - Germany (Euro)',
        'TRY - Turkish Lira',
    ]);
    const selectedCurrency = ref('USD - US Dollar');
    const tax = ref<number>(0);
    const discount = ref<number>(0);
    const shippingCharge = ref<number>(0);
    const paymentMethod = ref('');

    onMounted(() => {
        //set default data
        items.value.push({
            id: 1,
            title: '',
            description: '',
            rate: 0,
            quantity: 0,
            amount: 0,
        });
    });

    const addItem = () => {
        let maxId = 0;
        if (items.value && items.value.length) {
            maxId = items.value.reduce((max: number, character: any) => (character.id > max ? character.id : max), items.value[0].id);
        }
        items.value.push({
            id: maxId + 1,
            title: '',
            description: '',
            rate: 0,
            quantity: 0,
            amount: 0,
        });
    };

    const removeItem = (item: any = null) => {
        items.value = items.value.filter((d: any) => d.id != item.id);
    };
</script>
