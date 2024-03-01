<template>
    <Head title="Expenses" />
    <div>
        <div class="flex xl:flex-row flex-col gap-2.5">
            <div class="panel px-0 flex-1 py-6 ltr:xl:mr-6 rtl:xl:ml-6">
                <div class="flex px-4">
                    <!-- without spacing -->
                    <div
                        class="border border-[#d3d3d3] dark:border-[#3b3f5c] rounded font-semibold w-full"
                    >
                        <div
                            v-for="week in weekDays"
                            :key="week.id"
                            class="border-b border-[#d3d3d3] dark:border-[#3b3f5c]"
                        >
                            <button
                                type="button"
                                class="p-4 w-full flex items-center text-white-dark dark:bg-[#1b2e4b]"
                                :class="{ '!text-primary': accordians2 === week.id }"
                                @click="
                                    accordians2 === week.id
                                        ? (accordians2 = null)
                                        : (accordians2 = week.id)
                                "
                            >
                                {{ week.name }}
                                <div
                                    class="ltr:ml-auto rtl:mr-auto"
                                    :class="{ 'rotate-180': accordians2 === week.id }"
                                >
                                    <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            d="M19 9L12 15L5 9"
                                            stroke="currentColor"
                                            stroke-width="1.5"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        ></path>
                                    </svg>
                                </div>
                            </button>
                            <vue-collapsible :isOpen="accordians2 === week.id">
                                <div
                                    class="space-y-2 p-4 text-white-dark text-[13px]"
                                >
                                    <form>
                                        <div class="flex flex-row flex-wrap">
                                            <div>
                                                <label for="gridEmail"
                                                    >City and State</label
                                                >
                                                <input
                                                    id="gridEmail"
                                                    type="text"
                                                    placeholder="Enter City and State"
                                                    class="form-input"
                                                />
                                            </div>
                                            <div>
                                                <label for="gridPassword"
                                                    >Expense type</label
                                                >
                                                <select
                                                    id="gridPassword"
                                                    class="form-select text-white-dark"
                                                    v-model="expenseType"
                                                >
                                                    <option :value="0">
                                                        Open this select menu
                                                    </option>
                                                    <option :value="1">
                                                        Lodging
                                                    </option>
                                                    <option :value="2">
                                                        Transportation
                                                    </option>
                                                    <option :value="3">
                                                        Meals
                                                    </option>
                                                    <option :value="4">
                                                        Entertainment
                                                    </option>
                                                    <option :value="5">
                                                        Miscelaneus
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="flex flex-row flex-wrap">
                                            <div v-if="expenseType === 2">
                                                <label for="gridTransport"
                                                    >Transport Type</label
                                                >
                                                <select
                                                    id="gridTransport"
                                                    class="form-select text-white-dark"
                                                >
                                                    <option>
                                                        Open this select menu
                                                    </option>
                                                    <option>
                                                        AIR, RAIL, ETC
                                                    </option>
                                                    <option>
                                                        RENTAL CAR, LIMO, ETC
                                                    </option>
                                                    <option>
                                                        LOCAL TAXI, TOLLS &
                                                        PUBLIC TRNSIT
                                                    </option>
                                                    <option>
                                                        AUTO EXPENSES
                                                    </option>
                                                </select>
                                            </div>
                                            <div v-if="expenseType === 3">
                                                <label for="gridMeal"
                                                    >Meal Type</label
                                                >
                                                <select
                                                    id="gridMeal"
                                                    class="form-select text-white-dark"
                                                >
                                                    <option>
                                                        Open this select menu
                                                    </option>
                                                    <option>BREAKFAST</option>
                                                    <option>LUNCH</option>
                                                    <option>DINNER</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div
                                            class="flex flex-row flex-wrap"
                                            v-if="
                                                expenseType === 3 ||
                                                expenseType === 4
                                            "
                                        >
                                            <div>
                                                <label for="gridEmail"
                                                    >Location Name</label
                                                >
                                                <input
                                                    id="gridEmail"
                                                    type="text"
                                                    placeholder="Enter Location Name"
                                                    class="form-input"
                                                />
                                            </div>
                                            <div>
                                                <label for="gridEmail"
                                                    >Time and Place</label
                                                >
                                                <input
                                                    id="gridEmail"
                                                    type="text"
                                                    placeholder="Enter Time and Place"
                                                    class="form-input"
                                                />
                                            </div>
                                            <div>
                                                <label for="gridEmail"
                                                    >Nature and Purpose</label
                                                >
                                                <input
                                                    id="gridEmail"
                                                    type="text"
                                                    placeholder="Enter Nature and Purpose"
                                                    class="form-input"
                                                />
                                            </div>
                                            <div>
                                                <label for="gridEmail"
                                                    >Tip</label
                                                >
                                                <input
                                                    id="gridEmail"
                                                    type="number"
                                                    placeholder="Enter Tip"
                                                    class="form-input"
                                                />
                                            </div>
                                        </div>
                                        <div
                                            class="flex flex-row flex-wrap"
                                            v-if="
                                                expenseType === 2 ||
                                                expenseType === 5
                                            "
                                        >
                                            <div>
                                                <label for="gridEmail"
                                                    >Description</label
                                                >
                                                <input
                                                    id="gridEmail"
                                                    type="text"
                                                    placeholder="Enter Description"
                                                    class="form-input"
                                                />
                                            </div>
                                        </div>
                                        <div class="flex flex-row flex-wrap">
                                            <div>
                                                <label for="gridAmount"
                                                    >Amount</label
                                                >
                                                <input
                                                    id="gridAmount"
                                                    type="number"
                                                    placeholder="Enter Amount"
                                                    class="form-input"
                                                />
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </vue-collapsible>
                        </div>
                    </div>
                </div>
            </div>
            <div class="xl:w-96 w-full xl:mt-0 mt-6">
                <div class="panel sticky top-[75px] left-0">
                    <div
                        class="grid xl:grid-cols-1 lg:grid-cols-4 sm:grid-cols-2 grid-cols-1 gap-4"
                    >
                        <div>
                            <label for="gridAFH">Days Away</label>
                            <input
                                id="gridAFH"
                                type="number"
                                placeholder="Enter Days Away"
                                class="form-input"
                            />
                        </div>
                        <div>
                            <label for="gridAPA">Personal Affairs</label>
                            <input
                                id="gridAPA"
                                type="number"
                                placeholder="Enter Personal Affairs"
                                class="form-input"
                            />
                        </div>
                        <div>
                            <label for="gridPercentage"
                                >% Personal Affairs</label
                            >
                            <input
                                id="gridPercentage"
                                type="text"
                                value="%0"
                                class="form-input"
                            />
                        </div>
                        <div>
                            <label for="gridPercentage"
                                >Purpose of travel</label
                            >
                            <input
                                id="gridPurpose"
                                type="text"
                                placeholder="Enter Purpose of travel"
                                class="form-input"
                            />
                        </div>
                        <div class="flex flex-wrap justify-evenly">
                            <label class="inline-flex">
                                <input
                                    type="radio"
                                    name="default_radio"
                                    class="form-radio"
                                    checked
                                />
                                <span>USD</span>
                            </label>
                            <label class="inline-flex">
                                <input
                                    type="radio"
                                    name="default_radio"
                                    class="form-radio"
                                    checked
                                />
                                <span>MXN</span>
                            </label>
                            <label class="inline-flex">
                                <input
                                    type="radio"
                                    name="default_radio"
                                    class="form-radio"
                                    checked
                                />
                                <span>Real</span>
                            </label>
                        </div>
                        <div class="flex flex-wrap justify-evenly">
                            <label class="inline-flex">
                                <input
                                    type="radio"
                                    name="default_radio2"
                                    class="form-radio"
                                    checked
                                />
                                <span>DEDUCT ADVANCE</span>
                            </label>
                            <label class="inline-flex">
                                <input
                                    type="radio"
                                    name="default_radio2"
                                    class="form-radio"
                                    checked
                                />
                                <span>DEVIT</span>
                            </label>
                        </div>
                        <div>
                            <label for="gridAPA">MY ADVANCE</label>
                            <input
                                id="gridAPA"
                                type="number"
                                placeholder="Enter Advance"
                                class="form-input"
                            />
                        </div>
                        <div>
                            <label for="gridAPA">TO RETURN</label>
                            <input
                                id="gridAPA"
                                type="text"
                                value="$0.00"
                                class="form-input"
                            />
                        </div>
                        <button
                            type="button"
                            class="btn btn-success w-full gap-2"
                        >
                            <svg
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5 ltr:mr-2 rtl:ml-2 shrink-0"
                            >
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
                                <path
                                    opacity="0.5"
                                    d="M7 8H13"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                    stroke-linecap="round"
                                />
                            </svg>
                            Save Report
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { ref, onMounted, reactive, computed } from "vue";
import { Head, usePage, router, Link } from "@inertiajs/vue3";
import { useAppStore } from "@/stores/index";
import AppLayout from "@/layouts/app-layout.vue";
import SiteLayout from "@/layouts/app.vue";
import "@suadelabs/vue3-multiselect/dist/vue3-multiselect.css";
import "flatpickr/dist/flatpickr.css";
import VueCollapsible from "vue-height-collapsible/vue3";
const accordians2: any = ref(1);
const store = useAppStore();
const expenseType: any = ref(0);
const weekDays: any = ref([{id:0, name:"Sunday"},{id:1, name:"Monday"},{id:2, name:"Tuesday"},{id:3, name:"Wednesday"},{id:4, name:"Thursday"},{id:5, name:"Friday"},{id:6, name:"Saturday"}]);

const page = usePage();
const user = computed(() => page.props.auth);

defineOptions({
    layout: [SiteLayout, AppLayout],
});
</script>
