<template>
    <Head title="Expenses" />
    <div>
        <div class="flex xl:flex-row flex-col gap-2.5">
            <div class="px-0 flex-1 ltr:xl:mr-6 rtl:xl:ml-6">
                <div class="border border-[#d3d3d3] rounded dark:border-[#1b2e4b]">
                            <button
                                type="button"
                                class="p-4 w-full flex items-center text-white-dark dark:bg-[#1b2e4b]"
                                :class="{ '!text-primary': accordiansExpenses === 0 }"
                                @click="accordiansExpenses === 0 ? (accordiansExpenses = null) : (accordiansExpenses = 0)"
                            >
                            {{ $t("expense.edit.expenseGeneral" ) }}
                                <div class="ltr:ml-auto rtl:mr-auto" :class="{ 'rotate-180': accordians1 === 1 }">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4">
                                        <path d="M19 9L12 15L5 9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                            </button>
                            <vue-collapsible :isOpen="accordiansExpenses === 0" style="margin: 20px;">
                                <!-- panel gastos general -->
                                <div class="border border-[#d3d3d3] dark:border-[#3b3f5c] rounded font-semibold w-full" >
                                    <div v-for="(week, index ) in ExpenseGeneral" :key="week.id" class="border-b border-[#d3d3d3] dark:border-[#3b3f5c]" >
                                        <button
                                            type="button"
                                            class="p-4 w-full flex items-center text-white-dark dark:bg-[#1b2e4b]"
                                            :class="{ '!text-primary': accordians2 === week.id }"
                                            @click=" accordians2 === week.id ? (accordians2 = null) : (accordians2 = week.id) "
                                        >
                                        <div class="flex flex-row" style="text-align: left;">
                                            <span class="basis-1/4" style="width: 220px;">{{ $t("expense.edit.expenseDate."+index)}}  {{ formatDateNormal(week.date) }} </span>
                                            <span class="basis-1/4" style="width: 200px;">{{ $t("expense.edit.totalConcepts" ) }} {{ week.totalConcepts }} </span> 
                                            <span class="basis-1/4" style="width: 350px;">{{ $t("expense.edit.totalwaist" ) }} {{ formatCurrencyNum(week.totalExpense) }}</span>
                                        </div>
                                            
                                            <div  class="ltr:ml-auto rtl:mr-auto" :class="{ 'rotate-180': accordians2 === week.id }">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M19 9L12 15L5 9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                </svg>
                                            </div>
                                        </button>
                                        <vue-collapsible :isOpen="accordians2 === week.id">
                                            <div v-if="expense.status == 0" class="space-y-2 p-4 text-white-dark text-[13px]">
                                                <form @submit.prevent="submitForm(index)">
                                                    <div class="flex flex-row flex-wrap">
                                                        <div style="margin-right: 10px;">
                                                            <label for="selectExpense">{{ $t("expense.edit.expenseType") }}</label>
                                                            <select  class="form-select text-white-dark" v-model="week.selectExpense" required>
                                                                <option :value="0">
                                                                    {{ $t("expense.edit.expenseType.1") }}
                                                                </option>
                                                                <option :value="1">
                                                                    {{ $t("expense.edit.expenseType.2") }}
                                                                </option>
                                                                <option :value="2">
                                                                    {{ $t("expense.edit.expenseType.3") }}
                                                                </option>
                                                                <option :value="3">
                                                                    {{ $t("expense.edit.expenseType.4") }}
                                                                </option>
                                                                <option :value="4">
                                                                    {{ $t("expense.edit.expenseType.5") }}
                                                                </option>
                                                                <option :value="5">
                                                                    {{ $t("expense.edit.expenseType.6") }}
                                                                </option>
                                                                <option :value="6">
                                                                    {{ $t("expense.edit.expenseType.7") }}
                                                                </option>
                                                                <option :value="7">
                                                                    {{ $t("expense.edit.expenseType.8") }}
                                                                </option>
                                                                <option :value="8">
                                                                    {{ $t("expense.edit.expenseType.9") }}
                                                                </option>
                                                                <option :value="9">
                                                                    {{ $t("expense.edit.expenseType.10") }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div style="margin-right: 10px; margin-left: 10px">
                                                            <label for="inputCity">{{ $t("expense.edit.city") }}</label>
                                                            <input  type="text"  class="form-input" v-model="week.inputCity" required/>
                                                        </div>
                                                        <div style="margin-right: 10px; margin-left: 10px">
                                                            <label for="inputAmount">{{ $t("expense.edit.amount") }}</label>
                                                            <input  type="number" step=".01" class="form-input" v-model="week.inputAmount" @input="updateMaxTip(index)" required/>
                                                        </div>
                                                        <div v-if="week.selectExpense == '5' || week.selectExpense == '6' || week.selectExpense == '7'" style="margin-right: 10px; margin-left: 10px">
                                                            <label for="inputTip">{{ $t("expense.edit.tip") }}</label>
                                                            <input  type="number" step=".01" class="form-input" v-model="week.inputTip" @input="updateTip(index)" required/>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary" style="height: fit-content; margin-top: 25px;">{{ $t("expense.edit.add") }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="space-y-2 p-4 text-white-dark text-[13px]">
                                                <table border="1">
                                                    <thead>
                                                    <tr style="background-color: #2196f3 !important; color: black;">
                                                        <th>{{ $t("expense.edit.expenseType") }}</th>
                                                        <th>{{ $t("expense.edit.city") }}</th>
                                                        <th>{{ $t("expense.edit.amount") }}</th>
                                                        <th>{{ $t("expense.edit.tip") }}</th>
                                                        <th>{{ $t("expense.edit.tickets") }}</th>
                                                        <th>{{ $t("expense.edit.actions") }}</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr v-for="(entry, entryIndex) in week.entries" :key="entryIndex">
                                                        <td> {{ entry.selectExpense === 0 ? $t("expense.edit.expenseType.1")  
                                                            : entry.selectExpense === 1 ? $t("expense.edit.expenseType.2")
                                                            : entry.selectExpense === 2 ? $t("expense.edit.expenseType.3") 
                                                            : entry.selectExpense === 3 ? $t("expense.edit.expenseType.4") 
                                                            : entry.selectExpense === 4 ? $t("expense.edit.expenseType.5") 
                                                            : entry.selectExpense === 5 ? $t("expense.edit.expenseType.6") 
                                                            : entry.selectExpense === 6 ? $t("expense.edit.expenseType.7") 
                                                            : entry.selectExpense === 7 ? $t("expense.edit.expenseType.8") 
                                                            : entry.selectExpense === 8 ? $t("expense.edit.expenseType.9") 
                                                            : $t("expense.edit.expenseType.10")
                                                        }}</td>
                                                        <td>{{ entry.city }}</td>
                                                        <td>{{ formatCurrencyNum(entry.amount) }}</td>
                                                        <td>{{ formatCurrencyNum(entry.tip) }}</td>
                                                        <td>
                                                            <input type="checkbox" :checked="hasMultipleTickets(index, entryIndex)" disabled>
                                                        </td>
                                                        <td class="flex"> 
                                                            <button v-if="expense.status == 0" class="btn btn-danger" @click="deleteEntry(index, entryIndex)">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                                                </svg>
                                                            </button>
                                                            <button class="ml-2 btn btn-primary" @click="ticketsExpenseOther(index, entryIndex)">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sticky" viewBox="0 0 16 16">
                                                                    <path d="M2.5 1A1.5 1.5 0 0 0 1 2.5v11A1.5 1.5 0 0 0 2.5 15h6.086a1.5 1.5 0 0 0 1.06-.44l4.915-4.914A1.5 1.5 0 0 0 15 8.586V2.5A1.5 1.5 0 0 0 13.5 1zM2 2.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 .5.5V8H9.5A1.5 1.5 0 0 0 8 9.5V14H2.5a.5.5 0 0 1-.5-.5zm7 11.293V9.5a.5.5 0 0 1 .5-.5h4.293z"/>
                                                                </svg> 
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </vue-collapsible>
                                    </div>
                                </div>
                            </vue-collapsible>
                </div>
                <div class="border border-[#d3d3d3] rounded dark:border-[#1b2e4b] rounded mt-5">
                            <button
                                type="button"
                                class="p-4 w-full flex items-center text-white-dark dark:bg-[#1b2e4b]"
                                :class="{ '!text-primary': accordiansExpenses === 1 }"
                                @click="accordiansExpenses === 1 ? (accordiansExpenses = null) : (accordiansExpenses = 1)"
                            >
                            {{ $t("expense.edit.expenseMeals") }}
                                <div class="ltr:ml-auto rtl:mr-auto" :class="{ 'rotate-180': accordians1 === 1 }">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4">
                                        <path d="M19 9L12 15L5 9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                            </button>
                            <vue-collapsible :isOpen="accordiansExpenses === 1" style="margin: 20px;">
                                <!-- panel gastos general -->
                                <div class="border border-[#d3d3d3] dark:border-[#3b3f5c] rounded font-semibold w-full" >
                                    <div v-for="(meal, index ) in ExpenseMeals" :key="meal.id" class="border-b border-[#d3d3d3] dark:border-[#3b3f5c]" >
                                        <button
                                            type="button"
                                            class="p-4 w-full flex items-center text-white-dark dark:bg-[#1b2e4b]"
                                            :class="{ '!text-primary': accordiansMeals === meal.id }"
                                            @click=" accordiansMeals === meal.id ? (accordiansMeals = null) : (accordiansMeals = meal.id) "
                                        >
                                        <div class="flex flex-row" style="text-align: left;">
                                            <span class="basis-1/4" style="width: 220px;">{{ $t("expense.edit.expenseDate."+index)}}   {{ formatDateNormal(meal.date) }}</span>
                                            <span class="basis-1/4" style="width: 200px;">{{ $t("expense.edit.totalConcepts" ) }} {{ meal.totalConcepts }}</span> 
                                            <span class="basis-1/4" style="width: 350px;">{{ $t("expense.edit.totalwaist" ) }} {{ formatCurrencyNum(meal.totalExpense) }}</span>
                                        </div>
                                            
                                            <div  class="ltr:ml-auto rtl:mr-auto" :class="{ 'rotate-180': accordiansMeals === meal.id }">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M19 9L12 15L5 9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                </svg>
                                            </div>
                                        </button>
                                        <vue-collapsible :isOpen="accordiansMeals === meal.id">
                                            <div v-if="expense.status == 0" class="space-y-2 p-4 text-white-dark text-[13px]">
                                                <form @submit.prevent="submitFormMeal(index)">
                                                    <div class="flex flex-row flex-wrap">
                                                        <div style="margin-right: 10px; margin-left: 10px">
                                                            <label for="restaurant">{{ $t("expense.edit.restaurant" ) }}</label>
                                                            <input  type="text"  class="form-input" v-model="meal.restaurant" required/>
                                                            <input type="hidden" v-model="meal.idMeal">
                                                        </div>
                                                        <div style="margin-right: 10px; margin-left: 10px">
                                                            <label for="time">{{ $t("expense.edit.time" ) }}</label>
                                                            <input  type="time"  class="form-input" v-model="meal.time" required/>
                                                        </div>
                                                        <div style="margin-right: 10px; margin-left: 10px">
                                                            <label for="city">{{ $t("expense.edit.city") }}</label>
                                                            <input  type="text"  class="form-input" v-model="meal.city" disabled/>
                                                        </div>
                                                        <div style="margin-right: 10px; margin-left: 10px">
                                                            <label for="selectExpense">{{ $t("expense.edit.expenseType") }}</label>
                                                            <select  class="form-select text-white-dark" v-model="meal.selectExpense" disabled>
                                                                <option :value="0">
                                                                    {{ $t("expense.edit.expenseType.1") }}
                                                                </option>
                                                                <option :value="1">
                                                                    {{ $t("expense.edit.expenseType.2") }}
                                                                </option>
                                                                <option :value="2">
                                                                    {{ $t("expense.edit.expenseType.3") }}
                                                                </option>
                                                                <option :value="3">
                                                                    {{ $t("expense.edit.expenseType.4") }}
                                                                </option>
                                                                <option :value="4">
                                                                    {{ $t("expense.edit.expenseType.5") }}
                                                                </option>
                                                                <option :value="5">
                                                                    {{ $t("expense.edit.expenseType.6") }}
                                                                </option>
                                                                <option :value="6">
                                                                    {{ $t("expense.edit.expenseType.7") }}
                                                                </option>
                                                                <option :value="7">
                                                                    {{ $t("expense.edit.expenseType.8") }}
                                                                </option>
                                                                <option :value="8">
                                                                    {{ $t("expense.edit.expenseType.9") }}
                                                                </option>
                                                                <option :value="9">
                                                                    {{ $t("expense.edit.expenseType.10") }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div style="margin-right: 10px; margin-left: 10px">
                                                            <label for="amount">{{ $t("expense.edit.amount") }}</label>
                                                            <input  type="number" step=".01" class="form-input" v-model="meal.amount" disabled/>
                                                        </div>
                                                        <div  style="margin-right: 10px; margin-left: 10px">
                                                            <label for="tip">{{ $t("expense.edit.tip") }}</label>
                                                            <input  type="number" step=".01" class="form-input" v-model="meal.tip" disabled/>
                                                        </div>
                                                        <button type="submit" class="btn btn-warning" style="height: fit-content; margin-top: 25px;">{{ $t("user.create.update") }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="space-y-2 p-4 text-white-dark text-[13px]">
                                                <table border="1">
                                                    <thead>
                                                    <tr style="background-color: #2196f3 !important; color: black;">
                                                        <th>{{ $t("expense.edit.restaurant") }}</th>
                                                        <th>{{ $t("expense.edit.city") }}</th>
                                                        <th>{{ $t("expense.edit.time") }}</th>
                                                        <th>{{ $t("expense.edit.expenseType") }}</th>
                                                        <th>{{ $t("expense.edit.amount") }}</th>
                                                        <th>{{ $t("expense.edit.tip") }}</th>
                                                        <th>{{ $t("expense.edit.actions") }}</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr v-for="(entryMeal, entryIndex) in meal.entries" :key="entryIndex">
                                                        <td>{{ entryMeal.restaurant }}</td>
                                                        <td>{{ entryMeal.city }}</td>
                                                        <td>{{ entryMeal.time }}</td>
                                                        <td> {{ entryMeal.selectExpense === '0' ? $t("expense.edit.expenseType.1")  
                                                            : entryMeal.selectExpense === '1' ? $t("expense.edit.expenseType.2")
                                                            : entryMeal.selectExpense === '2' ? $t("expense.edit.expenseType.3") 
                                                            : entryMeal.selectExpense === '3' ? $t("expense.edit.expenseType.4") 
                                                            : entryMeal.selectExpense === '4' ? $t("expense.edit.expenseType.5") 
                                                            : entryMeal.selectExpense === '5' ? $t("expense.edit.expenseType.6") 
                                                            : entryMeal.selectExpense === '6' ? $t("expense.edit.expenseType.7") 
                                                            : entryMeal.selectExpense === '7' ? $t("expense.edit.expenseType.8") 
                                                            : entryMeal.selectExpense === '8' ? $t("expense.edit.expenseType.9") 
                                                            : $t("expense.edit.expenseType.10")
                                                        }}</td>
                                                        
                                                        <td>{{ formatCurrencyNum(entryMeal.amount) }}</td>
                                                        <td>{{ formatCurrencyNum(entryMeal.tip) }}</td>
                                                        <td class="flex">
                                                            <button v-if="expense.status == 0" class="btn btn-warning" @click="modifyExpenseMeal(index, entryIndex)">
                                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5">
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
                                                            
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </vue-collapsible>
                                    </div>
                                </div>
                            </vue-collapsible>
                </div>
                <div class="border border-[#d3d3d3] rounded dark:border-[#1b2e4b] rounded mt-5">
                            <button
                                type="button"
                                class="p-4 w-full flex items-center text-white-dark dark:bg-[#1b2e4b]"
                                :class="{ '!text-primary': accordiansExpenses === 2 }"
                                @click="accordiansExpenses === 2 ? (accordiansExpenses = null) : (accordiansExpenses = 2)"
                            >
                            {{ $t("expense.edit.expenseOther") }}
                                <div class="ltr:ml-auto rtl:mr-auto" :class="{ 'rotate-180': accordiansExpenses === 2 }">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4">
                                        <path d="M19 9L12 15L5 9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                            </button>
                            <vue-collapsible :isOpen="accordiansExpenses === 2" style="margin: 20px;">
                                <!-- panel gastos general -->
                                <div class="border border-[#d3d3d3] dark:border-[#3b3f5c] rounded font-semibold w-full" >
                                    <div v-for="(other, index ) in ExpenseOther" :key="other.id" class="border-b border-[#d3d3d3] dark:border-[#3b3f5c]" >
                                        <button
                                            type="button"
                                            class="p-4 w-full flex items-center text-white-dark dark:bg-[#1b2e4b]"
                                            :class="{ '!text-primary': accordiansOtherExpenses === other.id }"
                                            @click=" accordiansOtherExpenses === other.id ? (accordiansOtherExpenses = null) : (accordiansOtherExpenses = other.id) "
                                        >
                                        <div class="flex flex-row" style="text-align: left;">
                                            <span class="basis-1/4" style="width: 220px;">{{ $t("expense.edit.expenseDate."+index)}}   {{ formatDateNormal(other.date) }}</span>
                                            <span class="basis-1/4" style="width: 200px;">{{ $t("expense.edit.totalConcepts") }} {{ other.totalConcepts }}</span> 
                                            <span class="basis-1/4" style="width: 350px;">{{ $t("expense.edit.totalwaist") }} {{ formatCurrencyNum(other.totalExpense) }}</span>
                                        </div>
                                            <div  class="ltr:ml-auto rtl:mr-auto" :class="{ 'rotate-180': accordiansOtherExpenses === other.id }">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M19 9L12 15L5 9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                </svg>
                                            </div>
                                        </button>
                                        <vue-collapsible :isOpen="accordiansOtherExpenses === other.id">
                                            <div v-if="expense.status == 0" class="space-y-2 p-4 text-white-dark text-[13px]">
                                                <form @submit.prevent="submitFormOther(index)">
                                                    <div class="flex flex-row flex-wrap">
                                                        <div style="margin-right: 10px; margin-left: 10px">
                                                            <label for="selectExpense">{{ $t("expense.edit.expenseType") }}</label>
                                                            <select  class="form-select text-white-dark" v-model="other.selectExpense" disabled>
                                                                <option :value="0">
                                                                    {{ $t("expense.edit.expenseType.1") }}
                                                                </option>
                                                                <option :value="1">
                                                                    {{ $t("expense.edit.expenseType.2") }}
                                                                </option>
                                                                <option :value="2">
                                                                    {{ $t("expense.edit.expenseType.3") }}
                                                                </option>
                                                                <option :value="3">
                                                                    {{ $t("expense.edit.expenseType.4") }}
                                                                </option>
                                                                <option :value="4">
                                                                    {{ $t("expense.edit.expenseType.5") }}
                                                                </option>
                                                                <option :value="5">
                                                                    {{ $t("expense.edit.expenseType.6") }}
                                                                </option>
                                                                <option :value="6">
                                                                    {{ $t("expense.edit.expenseType.7") }}
                                                                </option>
                                                                <option :value="7">
                                                                    {{ $t("expense.edit.expenseType.8") }}
                                                                </option>
                                                                <option :value="8">
                                                                    {{ $t("expense.edit.expenseType.9") }}
                                                                </option>
                                                                <option :value="9">
                                                                    {{ $t("expense.edit.expenseType.10") }}
                                                                </option>
                                                            </select>
                                                            <input type="hidden" v-model="other.idOther">
                                                        </div>
                                                        <div style="margin-right: 10px; margin-left: 10px">
                                                            <label for="time">{{ $t("expense.edit.description") }}</label>
                                                            <input  type="text"  class="form-input" v-model="other.description" required/>
                                                        </div>
                                                        <div style="margin-right: 10px;">
                                                            <label for="purpose">{{ $t("expense.edit.expense") }}</label>
                                                            <input  type="text"  class="form-input" v-model="other.amount" disabled/>
                                                        </div>
                                                        <button type="submit" class="btn btn-warning" style="height: fit-content; margin-top: 25px;">{{ $t("user.create.update") }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="space-y-2 p-4 text-white-dark text-[13px]">
                                                <table border="1">
                                                    <thead>
                                                        <tr style="background-color: #2196f3 !important; color: black;">
                                                            <th>{{ $t("expense.edit.expenseType") }}</th>
                                                            <th>{{ $t("expense.edit.description") }}</th>
                                                            <th>{{ $t("expense.edit.amount") }}</th>
                                                            <th>{{ $t("expense.edit.actions") }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr v-for="(entryOther, entryIndex) in other.entries" :key="entryIndex">
                                                        <td> {{ entryOther.selectExpense === 0 ? $t("expense.edit.expenseType.1")  
                                                            : entryOther.selectExpense === 1 ? $t("expense.edit.expenseType.2")
                                                            : entryOther.selectExpense === 2 ? $t("expense.edit.expenseType.3") 
                                                            : entryOther.selectExpense === 3 ? $t("expense.edit.expenseType.4") 
                                                            : entryOther.selectExpense === 4 ? $t("expense.edit.expenseType.5") 
                                                            : entryOther.selectExpense === 5 ? $t("expense.edit.expenseType.6") 
                                                            : entryOther.selectExpense === 6 ? $t("expense.edit.expenseType.7") 
                                                            : entryOther.selectExpense === 7 ? $t("expense.edit.expenseType.8") 
                                                            : entryOther.selectExpense === 8 ? $t("expense.edit.expenseType.9") 
                                                            : $t("expense.edit.expenseType.10")
                                                        }}</td>
                                                        <td>{{ entryOther.description }}</td>
                                                        <td>{{ formatCurrencyNum(entryOther.amount) }}</td>
                                                        <td >
                                                            <button v-if="expense.status == 0" class="btn btn-warning" @click="modifyExpenseOther(index, entryIndex)">
                                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5">
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
                                                            
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </vue-collapsible>
                                    </div>
                                </div>
                            </vue-collapsible>
                </div>  
            </div>
            <TransitionRoot appear :show="modalTicket" as="template">
                <Dialog as="div" @close="modalTicket = false" class="relative z-[51]">
                    <TransitionChild
                        as="template"
                        enter="duration-300 ease-out"
                        enter-from="opacity-0"
                        enter-to="opacity-100"
                        leave="duration-200 ease-in"
                        leave-from="opacity-100"
                        leave-to="opacity-0"
                    >
                    <DialogOverlay class="fixed inset-0 bg-[black]/60" />
                    </TransitionChild>
                    <div 
                        ref="dialog"
                        :style="{ top: `${modalPosition.y}px`, left: `${modalPosition.x}px` }"
                        @mousedown="startDragging"
                        @mouseup="stopDragging"
                        @mousemove="drag"
                        class="fixed inset-0 overflow-y-auto"
                    >
                        <div class="flex min-h-full items-center justify-center px-4 py-8">
                            <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0 scale-95" enter-to="opacity-100 scale-100" leave="duration-200 ease-in" leave-from="opacity-100 scale-100" leave-to="opacity-0 scale-95" >
                                <DialogPanel class="panel border-0 p-0 rounded-lg overflow-hidden w-full max-w-5xl text-black dark:text-white-dark">
                                    <button type="button" class="absolute top-4 ltr:right-4 rtl:left-4 text-gray-400 hover:text-gray-800 dark:hover:text-gray-600 outline-none"
                                        @click="modalTicket = false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6">
                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                        </svg>
                                    </button>
                                    <div class="text-lg font-bold bg-[#fbfbfb] dark:bg-[#121c2c] ltr:pl-5 rtl:pr-5 py-3 ltr:pr-[50px] rtl:pl-[50px]">
                                        {{ $t("expense.edit.ticketFrom") }} "{{ titleTicket.value === 0 ? $t("expense.edit.expenseType.1")  
                                                            : titleTicket.value === 1 ? $t("expense.edit.expenseType.2")
                                                            : titleTicket.value === 2 ? $t("expense.edit.expenseType.3") 
                                                            : titleTicket.value === 3 ? $t("expense.edit.expenseType.4") 
                                                            : titleTicket.value === 4 ? $t("expense.edit.expenseType.5") 
                                                            : titleTicket.value === 5 ? $t("expense.edit.expenseType.6") 
                                                            : titleTicket.value === 6 ? $t("expense.edit.expenseType.7") 
                                                            : titleTicket.value === 7 ? $t("expense.edit.expenseType.8") 
                                                            : titleTicket.value === 8 ? $t("expense.edit.expenseType.9") 
                                                            : $t("expense.edit.expenseType.10")
                                                        }}"      
                                    </div>
                                    <div class="p-5">
                                        <div v-if="expense.status == 0" class="space-y-2 p-4 text-white-dark text-[13px]">
                                            <form @submit.prevent="submitFormTicket">
                                                <div class="flex flex-row flex-wrap">
                                                    <div style="margin-right: 10px; width: 150px;">
                                                        <label for="selectExpense">{{ $t("expense.edit.ticketType") }}</label>
                                                        <select  class="form-select text-white-dark" v-model="tickets.typeTicket" required>
                                                            <option :value="0">
                                                                {{ $t("expense.edit.ticket") }}
                                                            </option>
                                                            <option :value="1">
                                                                {{ $t("expense.edit.ticketBox") }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div  style="margin-right: 10px; margin-left: 10px">
                                                        <label >{{ $t("expense.edit.amount") }}</label>
                                                        <input  type="number" step=".01" class="form-input" v-model="tickets.amount" required/>
                                                    </div>
                                                    <div v-if="tickets.typeTicket == 1" style="margin-right: 10px; margin-left: 10px">
                                                        <label >{{ $t("expense.edit.concept") }}</label>
                                                        <input  type="text" step=".01" class="form-input" v-model="tickets.concept" required/>
                                                    </div>
                                                    <div v-if="tickets.typeTicket == 0" style="margin-right: 10px; margin-left: 10px">
                                                        <label >{{ $t("expense.edit.photo") }}</label>
                                                        <input type="file" @change="onFileChange" accept="image/*" id="imagenTicket" required>
                                                    </div>
                                                    <button type="submit" class="btn btn-warning" style="height: fit-content; margin-top: 25px;">{{ $t("expense.edit.add") }}</button>
                                                </div> 
                                            </form>      
                                        </div>                 
                                            <div v-if="tickets.file" style="margin-right: 10px; ">
                                                <h2>{{ $t("expense.edit.preview") }}</h2>
                                                <img :src="tickets.file" alt="Image preview" style="height: 200px;"/>
                                            </div>
                                            <div class="space-y-2 p-4 text-white-dark text-[13px]">
                                                <table border="1">
                                                    <thead>
                                                    <tr style="background-color: #2196f3 !important; color: black;">
                                                        <th>{{ $t("expense.edit.ticketType") }}</th>
                                                        <th>{{ $t("expense.edit.amount") }}</th>
                                                        <th>{{ $t("expense.edit.concept") }}</th>
                                                        <th>{{ $t("expense.edit.actions") }}</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr v-for="(ticket, entryIndex) in tickets.entries" :key="entryIndex">
                                                        <td> {{ ticket.typeTicket === 0 ? $t("expense.edit.ticketType.1")  
                                                            : $t("expense.edit.ticketType.2")
                                                        }}</td>
                                                        <td>{{ ticket.amount }}</td>
                                                        <td>{{ ticket.concept }}</td>
                                                        <td class="flex">
                                                            <button v-if="ticket.typeTicket === 0" class="btn btn-primary" @click="ticketsOpenFile(ticket)">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-image" viewBox="0 0 16 16">
                                                                    <path d="M8.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
                                                                    <path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2M3 2a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v8l-2.083-2.083a.5.5 0 0 0-.76.063L8 11 5.835 9.7a.5.5 0 0 0-.611.076L3 12z"/>
                                                                </svg>
                                                            </button>
                                                            <button v-if="expense.status == 0" class="ml-2 btn btn-danger" @click="deleteEntryTicket(ticket)">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                                                </svg>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                    </div>
                                </DialogPanel>
                            </TransitionChild>
                        </div>
                    </div>
                </Dialog>
            </TransitionRoot>
            
            <div class="xl:w-96 w-full xl:mt-0 mt-6">
                <div class="border border-[#d3d3d3] rounded dark:border-[#1b2e4b]">
                    <button
                        type="button"
                        class="p-4 w-full flex items-center text-white-dark dark:bg-[#1b2e4b]"
                        :class="{ '!text-primary': accordians1 === 1 }"
                        @click="accordians1 === 1 ? (accordians1 = null) : (accordians1 = 1)"
                    >
                        {{ $t("expense.edit.calculatorMoney") }}
                        <div class="ltr:ml-auto rtl:mr-auto" :class="{ 'rotate-180': accordians1 === 1 }">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4">
                                <path d="M19 9L12 15L5 9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                    </button>
                    <vue-collapsible :isOpen="accordians1 === 1">
                        <div class="panel sticky top-[75px] left-0">
                            <div class="grid xl:grid-cols-1 lg:grid-cols-4 sm:grid-cols-2 grid-cols-1 gap-4">
                                <div v-if="expense.status == 0">
                                    <div class="form-group">
                                        <label for="exchangeRate">{{ $t("expense.edit.typeCoin") }}</label>
                                        <input type="text" id="exchangeRate" class="form-input" v-model="formCalculator.moneda" required />
                                    </div>
                                    <div class="form-group mt-5">
                                        <label for="exchangeRate">{{ $t("expense.edit.typeChange") }}</label>
                                        <input type="number" id="exchangeRate" class="form-input" step=".000001" v-model.number="formCalculator.exchangeRate" required/>
                                    </div>
                                    <div class="form-group mt-5">
                                        <label for="amount">{{ $t("expense.edit.amountChange") }}</label>
                                        <input type="number" class="form-input" id="amount" step=".000001" v-model.number="formCalculator.amount" required />
                                    </div>
                                    <div class="flex mt-5">
                                        <button class="btn btn-primary" @click="calculateTotal()">{{ $t("expense.edit.calculateTimes") }}</button>
                                        <button class="btn btn-primary ml-2" @click="calculateTotalDivi()">{{ $t("expense.edit.calculateDivide") }}</button>
                                    </div>
                                </div>
                                <div class="space-y-2 text-white-dark text-[13px]">
                                    <div class="table-container" style="max-width: 100%; overflow-x: auto;">
                                        <table border="1">
                                            <thead>
                                                <tr style="background-color: #2196f3 !important; color: black;">
                                                    <th>{{ $t("expense.edit.coin") }}</th>
                                                    <th>{{ $t("report.form.quantity") }}</th>
                                                    <th>{{ $t("report.form.change") }}</th>
                                                    <th>{{ $t("expense.edit.total") }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(cambio, entryIndex) in formCalculator.entries" :key="entryIndex">
                                                    <td>{{ cambio.currency }}</td>
                                                    <td>{{ formatCurrencyCalcu(cambio.amount) }}</td>
                                                    <td>{{ formatCurrencyCalcu(cambio.change) }}</td>
                                                    <td>{{ formatCurrencyCalcu(cambio.total) }}</td>
                                                    <td>
                                                        <button v-if="expense.status == 0" class="btn btn-danger" @click="deleteEntryCalculator(cambio.id, entryIndex)">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                                            </svg>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </vue-collapsible>
                </div>
                <div class="border border-[#d3d3d3] dark:border-[#1b2e4b] rounded mt-5">
                    <button
                        type="button"
                        class="p-4 w-full flex items-center text-white-dark dark:bg-[#1b2e4b]"
                        :class="{ '!text-primary': accordians1 === 2 }"
                        @click="accordians1 === 2 ? (accordians1 = null) : (accordians1 = 2)"
                    >
                        {{ $t("expense.edit.generalData") }}
                        <div class="ltr:ml-auto rtl:mr-auto" :class="{ 'rotate-180': accordians1 === 2 }">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4">
                                <path d="M19 9L12 15L5 9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                    </button>
                    <vue-collapsible :isOpen="accordians1 === 2">
                        <div class="panel sticky top-[75px] left-0">
                            <div class="grid xl:grid-cols-1 lg:grid-cols-4 sm:grid-cols-2 grid-cols-1 gap-4">
                                <div style="border: solid 1px; padding: 15px; margin-top: 10px">
                                    
                                    <div class="flex flex-row justify-evenly ">
                                        <b class="basis-1/2">{{ $t('expenses.AdvanceRequestlist.applicant') }}</b>
                                        <label class="basis-1/2" style="color: #4361ee;">{{ expense.nombre }} {{ expense.apellido_paterno }} {{ expense.apellido_materno }}</label>
                                    </div>
                                    <div class="flex flex-row justify-evenly ">
                                        <b class="basis-1/2">{{ $t('expenses.AdvanceRequestlist.NoEmp') }}</b>
                                        <label class="basis-1/2" style="color: #4361ee;">{{expense.emp}}</label>
                                    </div>
                                    <div class="flex flex-row justify-evenly ">
                                        <b class="basis-1/2">{{ $t('expenses.AdvanceRequestlist.purposeTravel') }}</b>
                                        <label class="basis-1/2" style="color: #4361ee;">{{expense.purposeTravel}}</label>
                                    </div>
                                    <div class="flex flex-row justify-evenly ">
                                        <b class="basis-1/2">{{ $t('expenses.AdvanceRequestlist.CCTravel') }} </b>
                                        <label class="basis-1/2" style="color: #4361ee;">{{expense.cc}} {{expense.costCenter}}</label>
                                    </div>
                                    <div class="flex flex-row justify-evenly ">
                                        <b class="basis-1/2">{{ $t('expenses.AdvanceRequestlist.departmentTravel') }}</b>
                                        <label class="basis-1/2" style="color: #4361ee;">{{expense.department}}</label>
                                    </div>
                                    <div class="flex flex-row justify-evenly ">
                                        <b class="basis-1/2">{{ $t('expenses.AdvanceRequestlist.purposeDestiny') }}</b>
                                        <label class="basis-1/2" style="color: #4361ee;">{{expense.destiny}}</label>
                                    </div>
                                    <div class="flex flex-row justify-evenly ">
                                        <b class="basis-1/2">{{ $t('expenses.AdvanceRequestlist.payAdvanceTravel') }}</b>
                                        <label class="basis-1/2" style="color: #4361ee;">${{formatCurrencyNum(expense.payAdvance)}}</label>
                                    </div>
                                    <div class="flex flex-row justify-evenly ">
                                        <b class="basis-1/2">{{ $t('expenses.AdvanceRequestlist.dateDepositTravel') }}</b>
                                        <label class="basis-1/2" style="color: #4361ee;">{{formatDate(expense.depositDate)}}</label>
                                    </div>
                                    <div class="flex flex-row justify-evenly ">
                                        <b class="basis-1/2">{{ $t('expenses.AdvanceRequestlist.approveByAdvancePay') }}</b>
                                        <label class="basis-1/2" style="color: #4361ee;">{{expense.approveByAdvancePay}}</label>
                                    </div>
                                    <div class="flex flex-row justify-evenly ">
                                        <b class="basis-1/2">{{ $t('expenses.AdvanceRequestlist.comentTravel') }}</b>
                                        <label class="basis-1/2" style="color: #4361ee;">{{expense.coment}}</label>
                                    </div>
                                    <div v-if="expense.status != 0">
                                        <div class="flex flex-row justify-evenly ">
                                            <b class="basis-1/2">{{ $t('expense.edit.daysAway') }}</b>
                                            <label class="basis-1/2" style="color: #4361ee;">{{expense.daysAway}}</label>
                                        </div>
                                        <div class="flex flex-row justify-evenly ">
                                            <b class="basis-1/2">{{ $t('expense.edit.daysAwayPersonal') }}</b>
                                            <label class="basis-1/2" style="color: #4361ee;">{{expense.daysPersonalAffairs}}</label>
                                        </div>
                                        <div class="flex flex-row justify-evenly ">
                                            <b class="basis-1/2">{{ $t('expense.edit.daysAwayTotal') }}</b>
                                            <label class="basis-1/2" style="color: #4361ee;">{{expense.totalDaysAway}}</label>
                                        </div>
                                        <div class="flex flex-row justify-evenly ">
                                            <b class="basis-1/2">{{ $t('expense.edit.totalExpense') }}:</b>
                                            <label class="basis-1/2" style="color: #4361ee;">${{ formatCurrencyNum(expense.totalExpense) }}</label>
                                        </div>
                                        <div class="flex flex-row justify-evenly ">
                                            <b class="basis-1/2">{{ $t('expense.edit.returnExpense') }}:</b>
                                            <label class="basis-1/2" style="color: #4361ee;">${{ formatCurrencyNum(expense.payToReturn) }}</label>
                                        </div>
                                    </div>
                                </div>
                                <button v-if="expense.status == 1" class="ml-2 btn btn-primary" @click="excelReport(expense.uuid)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-medical" viewBox="0 0 16 16">
                                        <path d="M7.5 5.5a.5.5 0 0 0-1 0v.634l-.549-.317a.5.5 0 1 0-.5.866L6 7l-.549.317a.5.5 0 1 0 .5.866l.549-.317V8.5a.5.5 0 1 0 1 0v-.634l.549.317a.5.5 0 1 0 .5-.866L8 7l.549-.317a.5.5 0 1 0-.5-.866l-.549.317zm-2 4.5a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1z"/>
                                        <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>
                                    </svg>
                                    {{ $t('expense.edit.report') }}                              
                                </button>
                                <button v-if="expense.status == 1 && userAuth == 1" class="ml-2 btn btn-success" @click="aproveReport()">
                                    {{ $t('expense.edit.approve') }}                            
                                </button>
                                <button v-if="expense.status == 1 && userAuth == 1" class="ml-2 btn btn-danger" @click="noAproveReport()">
                                    {{ $t('expense.edit.notApprove') }}                             
                                </button>
                                <form  v-if="expense.status == 0" @submit.prevent="submitFormFinishReport">
                                    <div class="m-4">
                                        <label for="daysAway">{{ $t("expense.edit.daysAway") }}</label>
                                        <input  type="number" class="form-input" v-model.number="expense.daysAway" required/>
                                    </div>
                                    <div class="m-4">
                                        <label for="daysAwayPersonal">{{ $t("expense.edit.daysAwayPersonal") }}</label>
                                        <input  type="number" class="form-input" v-model.number="expense.daysPersonalAffairs" required />
                                    </div>
                                    <div class="m-4">
                                        <label for="daysAwayTotal">{{ $t("expense.edit.daysAwayTotal") }}</label>
                                        <input  type="number" class="form-input" v-model.number="expense.totalDaysAway" required/>
                                    </div>
                                    <div class="flex flex-wrap justify-evenly m-4">
                                        <label class="inline-flex">
                                            <input
                                                type="radio"
                                                name="default_radio2"
                                                class = "form-radio"
                                                value = "0"
                                                v-model= "expense.methodOfReimbursment"
                                            />
                                            <span>{{ $t("expense.edit.deductAdvance") }}</span>
                                        </label>
                                        <label class="inline-flex">
                                            <input
                                                type="radio"
                                                name="default_radio2"
                                                class = "form-radio"
                                                value = "1"
                                                v-model= "expense.methodOfReimbursment"
                                            />
                                            <span>{{ $t("expense.edit.devit") }}</span>
                                        </label>
                                    </div>
                                    <div class=" m-4">
                                        <label for="approveBy">{{ $t("expenses.list.approveBy") }}</label>
                                        <input id="approveBy" type="text" class="form-input"  v-model="expense.approveBy" required />
                                    </div>
                                    <div class="text-center m-4">
                                        <label style="font-size: 24px; font-weight: 700;" for="totalExpense">{{ $t("expense.edit.totalExpense") }}</label>
                                        <h1 style="font-size: 24px; font-weight: 700; margin-top: 10px; padding-top: 10px;"> ${{ formatCurrencyNum(expense.totalExpense) }}</h1>
                                    </div>
                                    <div id="divReturn" class="text-center m-4" style="padding: 15px;">
                                        <label style="font-size: 24px; font-weight: 700;" for="totalExpense">{{ $t("expense.edit.returnExpense") }}</label>
                                        <h1 style="font-size: 24px; font-weight: 700; margin-top: 10px; padding-top: 10px;">${{ formatCurrencyNum(expense.payToReturn) }}</h1>

                                    </div>
                                    <button type="submit" class="btn btn-success  gap-2 m-4">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"  class="w-5 h-5 ltr:mr-2 rtl:ml-2 shrink-0" >
                                            <path d="M3.46447 20.5355C4.92893 22 7.28595 22 12 22C16.714 22 19.0711 22 20.5355 20.5355C22 19.0711 22 16.714 22 12C22 11.6585 22 11.4878 21.9848 11.3142C21.9142 10.5049 21.586 9.71257 21.0637 9.09034C20.9516 8.95687 20.828 8.83317 20.5806 8.58578L15.4142 3.41944C15.1668 3.17206 15.0431 3.04835 14.9097 2.93631C14.2874 2.414 13.4951 2.08581 12.6858 2.01515C12.5122 2 12.3415 2 12 2C7.28595 2 4.92893 2 3.46447 3.46447C2 4.92893 2 7.28595 2 12C2 16.714 2 19.0711 3.46447 20.5355Z" stroke="currentColor" stroke-width="1.5"/>
                                            <path d="M17 22V21C17 19.1144 17 18.1716 16.4142 17.5858C15.8284 17 14.8856 17 13 17H11C9.11438 17 8.17157 17 7.58579 17.5858C7 18.1716 7 19.1144 7 21V22" stroke="currentColor" stroke-width="1.5"/>
                                            <path opacity="0.5" d="M7 8H13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                        </svg>
                                        {{ $t("expense.edit.finishReport") }}
                                    </button>
                                </form>
                                <form  v-if="expense.status == 2 && userAuth == 1" @submit.prevent="submitFormTransferRequestReport">
                                    <div class="m-4">
                                        <label>{{ $t("expense.edit.conceptApprove") }}</label>
                                        <textarea v-model="concept.value" class="form-input"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-success  gap-2 m-4">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"  class="w-5 h-5 ltr:mr-2 rtl:ml-2 shrink-0" >
                                            <path d="M3.46447 20.5355C4.92893 22 7.28595 22 12 22C16.714 22 19.0711 22 20.5355 20.5355C22 19.0711 22 16.714 22 12C22 11.6585 22 11.4878 21.9848 11.3142C21.9142 10.5049 21.586 9.71257 21.0637 9.09034C20.9516 8.95687 20.828 8.83317 20.5806 8.58578L15.4142 3.41944C15.1668 3.17206 15.0431 3.04835 14.9097 2.93631C14.2874 2.414 13.4951 2.08581 12.6858 2.01515C12.5122 2 12.3415 2 12 2C7.28595 2 4.92893 2 3.46447 3.46447C2 4.92893 2 7.28595 2 12C2 16.714 2 19.0711 3.46447 20.5355Z" stroke="currentColor" stroke-width="1.5"/>
                                            <path d="M17 22V21C17 19.1144 17 18.1716 16.4142 17.5858C15.8284 17 14.8856 17 13 17H11C9.11438 17 8.17157 17 7.58579 17.5858C7 18.1716 7 19.1144 7 21V22" stroke="currentColor" stroke-width="1.5"/>
                                            <path opacity="0.5" d="M7 8H13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                        </svg>
                                        {{ $t("expense.edit.reportTransfer") }}
                                    </button>
                                </form>
                                
                            </div>
                        </div>            
                    </vue-collapsible>
                </div>
                
            </div>
        </div>
    </div>

    <TransitionRoot appear :show="modalTicketPrev" as="template">
                <Dialog as="div" @close="closeModalTicketPrev()" class="relative z-[51]">
                    <TransitionChild
                        as="template"
                        enter="duration-300 ease-out"
                        enter-from="opacity-0"
                        enter-to="opacity-100"
                        leave="duration-200 ease-in"
                        leave-from="opacity-100"
                        leave-to="opacity-0"
                    >
                    <DialogOverlay class="fixed inset-0 bg-[black]/60" />
                    </TransitionChild>
                    <div class="fixed inset-0 overflow-y-auto">
                        <div class="flex min-h-full items-center justify-center px-4 py-8">
                            <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0 scale-95" enter-to="opacity-100 scale-100" leave="duration-200 ease-in" leave-from="opacity-100 scale-100" leave-to="opacity-0 scale-95" >
                                <DialogPanel class="panel border-0 p-0 rounded-lg overflow-hidden w-full max-w-xl text-black dark:text-white-dark">
                                    <button type="button" class="absolute top-4 ltr:right-4 rtl:left-4 text-gray-400 hover:text-gray-800 dark:hover:text-gray-600 outline-none"
                                        @click="closeModalTicketPrev()">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6">
                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                        </svg>
                                    </button>
                                    <div class="text-lg font-bold bg-[#fbfbfb] dark:bg-[#121c2c] ltr:pl-5 rtl:pr-5 py-3 ltr:pr-[50px] rtl:pl-[50px]">
                                        {{ $t("expense.edit.ticketView") }}
                                    </div>
                                    <div class="p-5">
                                        <img :src="selectedImageUrl" id="imagenTicketPrev" @load="handleImageTicketLoad" alt="Image">
                                    </div>
                                </DialogPanel>
                            </TransitionChild>
                        </div>
                    </div>
                </Dialog>
    </TransitionRoot>
</template>

<script lang="ts" setup>
    import { ref,  reactive, onMounted, computed  } from "vue";
    import {  router  } from "@inertiajs/vue3";
    import { TransitionRoot, TransitionChild, Dialog, DialogPanel, DialogOverlay } from '@headlessui/vue';
    import AppLayout from "@/layouts/app-layout.vue";
    import SiteLayout from "@/layouts/app.vue";
    import "@suadelabs/vue3-multiselect/dist/vue3-multiselect.css";
    import "flatpickr/dist/flatpickr.css";
    import VueCollapsible from "vue-height-collapsible/vue3";
    import { useI18n } from 'vue-i18n';
    import Swal from "sweetalert2";

    const accordians2: any = ref(0);
    const accordians1: any = ref(2);
    const accordiansExpenses: any = ref(0);
    const accordiansMeals: any = ref(0);
    const accordiansOtherExpenses: any = ref(0);
    const modalTicket = ref(false);
    const modalTicketPrev = ref(false);
    const selectedImageUrl = ref('');
    const titleTicket: any = reactive({
        value: ''
    });
    const concept: any = reactive({
        value: ''
    });

    const dialog = ref(null);
    const isDragging = ref(false);
    const modalPosition = reactive({ x: 0, y: 0 });
    const offset = reactive({ x: 0, y: 0 });

    const startDragging = (event) => {
      isDragging.value = true;
      offset.x = event.clientX - modalPosition.x;
      offset.y = event.clientY - modalPosition.y;
    };

    const drag = (event) => {
      if (isDragging.value) {
        modalPosition.x = event.clientX - offset.x;
        modalPosition.y = event.clientY - offset.y;
      }
    };

    const stopDragging = () => {
      isDragging.value = false;
    };

    const { t } = useI18n();

    defineOptions({
        layout: [SiteLayout, AppLayout],
    });

    const props = defineProps({
        userAuth: {
            type: Object,
            required: true,
        },
        expense: {
            type: Object,
            required: true,
        },
        centerControls: {
            type: Array,
            required: true,
        },
        departments: {
            type: Array,
            required: true,
        },
        expenseGenerals: {
            type: Array,
            required: true,
        },
        expenseMeals: {
            type: Array,
            required: true,
        },
        expenseOthers: {
            type: Array,
            required: true,
        },
        expenseTickets: {
            type: Array,
            required: true,
        },
        expenseCalculator: {
            type: Array,
            required: true,
        }
    });

    
    const userAuth: any = ref(props.userAuth);
    const expense: any = ref(props.expense);
    const expenseGenerals: any = ref(props.expenseGenerals);
    const expenseMeal: any = ref(props.expenseMeals);
    const expenseOthers: any = ref(props.expenseOthers);
    const expenseTickets: any = ref(props.expenseTickets);
    const expenseCalculator: any = ref(props.expenseCalculator);
    const formCalculator: any = reactive({
        change: 0,
        amount: 0,
        total: 0,
        currency: '',
        entries: expenseCalculator
    });

    // Función para formatear la fecha
    const generateDates = (startDate) => {
        const dates: any = []
        const date = new Date(startDate)
        for (let i = 0; i < 7; i++) {
            dates.push(new Date(date));
            date.setDate(date.getDate() - 1)
        }
        return dates
    }

    const formatDateNormal = (date) => {
        const currentDate = new Date(date);
        const year = currentDate.getFullYear();
        const month = String(currentDate.getMonth() + 1).padStart(2, '0');
        const day = String(currentDate.getDate()).padStart(2, '0');
        return `${day}-${month}-${year}`;
    };

    const formatDate = (date) => {
        if(date != null){
            const currentDate = new Date(date+' 13:00');
            const year = currentDate.getFullYear();
            const month = String(currentDate.getMonth() + 1).padStart(2, '0');
            const day = String(currentDate.getDate()).padStart(2, '0');
            return `${day}-${month}-${year}`;
        }else{
            return '';
        }
        
    };
    
    // Propiedad computada para generar el array de fechas
    const startDate = new Date((props.expense.endingDate+' 13:00')) // Puedes cambiar esta fecha a la que necesites
    const dates = generateDates(startDate);

    const tickets: any = reactive({
        index: 0,
        entrieIndex: 0,
        typeTicket: 0,
        amount: '',
        concept: '',
        file: null,
        entries: [],
    });

    const ExpenseGeneral: any = ref(dates.map((date, index) => ({
        id: index,
        date: date,
        selectExpense: '',
        inputCity: '',
        inputTip: 0,
        entries: [],
        totalConcepts: 0,
        totalExpense: 0.0,
        inputAmount: 0
    })));

    const ExpenseMeals: any = ref(dates.map((date, index) => ({
        id: index,
        date: date,
        idMeal: '',
        restaurant: '',
        time: '',
        selectExpense: '',
        city: '',
        tip: 0,
        entries: [],
        totalConcepts: 0,
        totalExpense: 0.0,
        amount: 0
    })));

    const ExpenseOther: any = ref(dates.map((date, index) => ({
        id: index,
        idOther: '',
        date: date,
        selectExpense: '',
        description: '',
        entries: [],
        totalConcepts: 0,
        totalExpense: 0.0,
        amount: 0
    })));

    //funciones Gastos generales
        function totalExpense(){
            var total = 0;
            for(const exp of ExpenseGeneral.value){
                total = total + parseFloat(exp.totalExpense);
            }
            expense.value.totalExpense = total;
            expense.value.payToReturn = parseFloat(expense.value.payAdvance) - total;

            if(expense.value.payToReturn < 0){
                expense.value.payToReturn = expense.value.payToReturn * (-1);
                const divReturn = document.getElementById('divReturn');
                if(divReturn != null)
                    divReturn.style.background = '#e7515ae0';
            }else{
                const divReturn = document.getElementById('divReturn');
                if(divReturn != null)
                    divReturn.style.background = 'lightblue';
            }
        }

        // Método para ajustar la propina si excede el máximo permitido
        const updateTip = (index) => {
            const maxTip = ExpenseGeneral.value[index].inputAmount * 0.10;
            if (ExpenseGeneral.value[index].inputTip > maxTip) {
                ExpenseGeneral.value[index].inputTip = maxTip;
            }
        };

        const updateMaxTip = (index) => {
            ExpenseGeneral.value[index].inputTip = 0;
        };

        const submitForm = (index) => {
            
            Swal.fire({
                title: t("expense.edit.process"),
                text: t("expense.edit.processData"),
                allowOutsideClick: false,
                showConfirmButton: false,
                customClass: "sweet-alerts",
                didOpen: () => {
                    Swal.showLoading();
                },
            });

            const formGeneral = ExpenseGeneral.value[index]
            const newEntryGeneral = {
                id: generateUUID(),
                uuidExpense: props.expense.uuid,
                idExpense: props.expense.id,
                city: formGeneral.inputCity,
                amount: formGeneral.inputAmount,
                selectExpense: formGeneral.selectExpense,
                tip: formGeneral.inputTip,
                date: formGeneral.date,
                tickets: [] 
            };

            const form = {
                general: newEntryGeneral,
                meal: {},
                other: {}
            };

            if(formGeneral.selectExpense == 5 || formGeneral.selectExpense == 6 || formGeneral.selectExpense == 7){
                var formMeals = ExpenseMeals.value[index]
                var newEntryMeal = {
                    idGeneral: newEntryGeneral.id,
                    city: formGeneral.inputCity,
                    amount: formGeneral.inputAmount,
                    selectExpense: formGeneral.selectExpense,
                    tip: formGeneral.inputTip,
                    restaurant: '',
                    time: ''
                };

                form.meal = newEntryMeal; 
            }else{
                var formOther = ExpenseOther.value[index]
                var newEntryOther = {
                    idGeneral: newEntryGeneral.id,
                    amount: formGeneral.inputAmount,
                    selectExpense: formGeneral.selectExpense,
                    description: ''
                };

                form.other = newEntryOther;
            }
                
            
            router.post(`/createExpensesGeneral`, form, {
                onSuccess: (page) => {
                    expenseGenerals.value = page.props.expenseGenerals;
                    expenseMeal.value = page.props.expenseMeals;
                    expenseOthers.value = page.props.expenseOthers;
                    expenseTickets.value = page.props.expenseTickets;
                    agregarExpensesTablas();

                        // Limpiar el formulario después de agregar la entrada
                    formGeneral.inputCity = '';
                    formGeneral.inputAmount = 0;
                    formGeneral.selectExpense = '';
                    formGeneral.inputTip = 0;

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

        const submitFormMeal = (index) => {

            // actualizamos el entrie del meal 
            const formMeal = ExpenseMeals.value[index];
            for(const meal of formMeal.entries){
                if(meal.id == formMeal.idMeal){
                    Swal.fire({
                        title: t("expense.edit.process"),
                        text: t("expense.edit.processData"),
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        customClass: "sweet-alerts",
                        didOpen: () => {
                            Swal.showLoading();
                        },
                    });

                    const form = new FormData();
                    form.append('uuidExpense', props.expense.uuid);
                    form.append('id', meal.id);
                    form.append('restaurant', formMeal.restaurant);
                    form.append('time', formMeal.time);

                    router.post(`/updateExpensesMeals`, form, {
                        onSuccess: (page) => {
                            expenseMeal.value = page.props.expenseMeals;
                            agregarExpensesTablas();
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
            }

            // Limpiar el formulario después de agregar la entrada

            formMeal.restaurant = '';
            formMeal.time = '';
            formMeal.purpose = '';
            formMeal.city = '';
            formMeal.tip = '';
            formMeal.amount = '';
            formMeal.idMeal = '';

        }

        const submitFormOther = (index) => {

            
            // actualizamos el entrie del meal 
            
                const formOther = ExpenseOther.value[index];
                for(const other of formOther.entries){
                    if(other.id == formOther.idOther){
                        Swal.fire({
                            title: t("expense.edit.process"),
                            text: t("expense.edit.processData"),
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            customClass: "sweet-alerts",
                            didOpen: () => {
                                Swal.showLoading();
                            },
                        });
                        const form = new FormData();
                        form.append('uuidExpense', props.expense.uuid);
                        form.append('id', other.id);
                        form.append('description', formOther.description);

                        router.post(`/updateExpensesOthers`, form, {
                            onSuccess: (page) => {
                                expenseOthers.value = page.props.expenseOthers;
                                agregarExpensesTablas();
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
                }
            
            

            // Limpiar el formulario después de agregar la entrada

            formOther.description = '';
            formOther.selectExpense = '';
            formOther.amount = '';
            formOther.idOther = '';

        }

        const submitFormFinishReport = (index) => {
            Swal.fire({
                title: t("expense.edit.process"),
                text: t("expense.edit.processData"),
                allowOutsideClick: false,
                showConfirmButton: false,
                customClass: "sweet-alerts",
                didOpen: () => {
                    Swal.showLoading();
                },
            });
            const form = new FormData();
            form.append('expense', JSON.stringify(expense.value));

            router.post(`/finishExpensesReports`, form, {
                onSuccess: (page) => {
                    location.reload();            
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
    
        const deleteEntry = (formIndex: number, entryIndex: number) => {

            Swal.fire({
                title: t("expense.edit.process"),
                text: t("expense.edit.processData"),
                allowOutsideClick: false,
                showConfirmButton: false,
                customClass: "sweet-alerts",
                didOpen: () => {
                    Swal.showLoading();
                },
            });

            const form = new FormData();
            form.append('uuidExpense', props.expense.uuid);
            form.append('datos', JSON.stringify(ExpenseGeneral.value[formIndex].entries[entryIndex]));

            router.post(`/deleteExpensesGeneral`, form, {
                    onSuccess: (page) => {
                        expenseGenerals.value = page.props.expenseGenerals;
                        expenseMeal.value = page.props.expenseMeals;
                        expenseOthers.value = page.props.expenseOthers;
                        expenseTickets.value = page.props.expenseTickets;
                        agregarExpensesTablas();
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

        const modifyExpenseMeal = (formIndex: number, entryIndex: number) => {
            ExpenseMeals.value[formIndex].restaurant = ExpenseMeals.value[formIndex].entries[entryIndex].restaurant;
            ExpenseMeals.value[formIndex].time = ExpenseMeals.value[formIndex].entries[entryIndex].time;
            ExpenseMeals.value[formIndex].selectExpense = ExpenseMeals.value[formIndex].entries[entryIndex].selectExpense;
            ExpenseMeals.value[formIndex].city = ExpenseMeals.value[formIndex].entries[entryIndex].city;
            ExpenseMeals.value[formIndex].tip = ExpenseMeals.value[formIndex].entries[entryIndex].tip;
            ExpenseMeals.value[formIndex].amount = ExpenseMeals.value[formIndex].entries[entryIndex].amount;
            ExpenseMeals.value[formIndex].idMeal = ExpenseMeals.value[formIndex].entries[entryIndex].id;
        }
        
        const modifyExpenseOther = (formIndex: number, entryIndex: number) => {
            ExpenseOther.value[formIndex].description = ExpenseOther.value[formIndex].entries[entryIndex].description;
            ExpenseOther.value[formIndex].selectExpense = ExpenseOther.value[formIndex].entries[entryIndex].selectExpense;
            ExpenseOther.value[formIndex].amount = ExpenseOther.value[formIndex].entries[entryIndex].amount;
            ExpenseOther.value[formIndex].idOther = ExpenseOther.value[formIndex].entries[entryIndex].id;
        }

    // funciones de tickets de comprobacion
        function submitFormTicket(e) {

            Swal.fire({
                title: t("expense.edit.process"),
                text: t("expense.edit.processData"),
                allowOutsideClick: false,
                showConfirmButton: false,
                customClass: "sweet-alerts",
                didOpen: () => {
                    Swal.showLoading();
                },
            });

            const form = new FormData();
            const datos = {
                idGeneral: ExpenseGeneral.value[tickets.index].entries[tickets.entrieIndex].id,
                idExpense: props.expense.id,
                uuidExpense: props.expense.uuid,
                amount: tickets.amount,
                concept: tickets.concept,
                typeTicket: tickets.typeTicket,
                file: tickets.file
            };

            const imageInput = document.getElementById('imagenTicket') as HTMLInputElement;
            

            if (imageInput ) {
                const files = imageInput.files;
                if(files && files.length > 0){
                    const image = files[0];
                    form.append('image', image);
                }
            }
            form.append('datos', JSON.stringify(datos));
            
            router.post(`/createTicketsExpense`, form, {
                    onSuccess: (page) => {
                        var datosTicket = page.props.expenseTickets[page.props.expenseTickets.length - 1];
                        ExpenseGeneral.value[tickets.index].entries[tickets.entrieIndex].tickets.push(datosTicket);
                        tickets.typeTicket = 0;
                        tickets.amount = '';
                        tickets.concept = '';
                        tickets.file = null;
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

        function deleteEntryTicket(ticket){
            Swal.fire({
                title: t("expense.edit.process"),
                text: t("expense.edit.processData"),
                allowOutsideClick: false,
                showConfirmButton: false,
                customClass: "sweet-alerts",
                didOpen: () => {
                    Swal.showLoading();
                },
            });

            const form = new FormData();
            form.append('uuidExpense', props.expense.uuid);
            form.append('datos', JSON.stringify(ticket));
            router.post(`/deleteTicketsExpense`, form, {
                onSuccess: (page) => {

                    for (var x in ExpenseGeneral.value[tickets.index].entries[tickets.entrieIndex].tickets){
                        if(ExpenseGeneral.value[tickets.index].entries[tickets.entrieIndex].tickets[x].id == ticket.id){
                            ExpenseGeneral.value[tickets.index].entries[tickets.entrieIndex].tickets.splice(x, 1);
                        }
                        
                    }

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

        const ticketsExpenseOther = (formIndex: number, entryIndex: number) => {
            tickets.index = formIndex;
            tickets.entrieIndex = entryIndex;
            tickets.file = null;
            tickets.typeTicket = 0;
            tickets.amount=  '';
            tickets.concept = '';
            titleTicket.value = ExpenseGeneral.value[tickets.index].entries[tickets.entrieIndex].selectExpense;
            tickets.entries = ExpenseGeneral.value[tickets.index].entries[tickets.entrieIndex].tickets;
            modalTicket.value = true;
        } 

        function hasMultipleTickets(formIndex, entryIndex){
            return ExpenseGeneral.value[formIndex].entries[entryIndex].tickets.length > 0;
        }

        function ticketsOpenFile(ticket){
            modalTicket.value = false;
            modalTicketPrev.value = true;
            Swal.showLoading();
            selectedImageUrl.value = "/imagesTickets/" + ticket.id;
            
        }

        function closeModalTicketPrev(){
            modalTicketPrev.value = false;
            modalTicket.value = true;
        }

        function onFileChange(event) {
            const file = event.target.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    tickets.file = e.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                tickets.file = null;
            }
        }

        function handleImageTicketLoad(){
            Swal.close();
        }

    // fin funciones tickets    

    function deleteEntryCalculator(id, entryIndex){
        Swal.fire({
            title: t("expense.edit.process"),
            text: t("expense.edit.processData"),
            allowOutsideClick: false,
            showConfirmButton: false,
            customClass: "sweet-alerts",
            didOpen: () => {
                Swal.showLoading();
            },
        });

        const form = new FormData();
        form.append('id', id);
        form.append('uuid', props.expense.uuid);

        router.post(`/deleteCalculatorsExpense`, form, {
            onSuccess: (page) => {
                formCalculator.entries.splice(entryIndex, 1);
                formCalculator.moneda = '';
                formCalculator.amount = '';
                formCalculator.total = '';
                formCalculator.exchangeRate = '';       
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

    function calculateTotalDivi(){
        Swal.fire({
            title: t("expense.edit.process"),
            text: t("expense.edit.processData"),
            allowOutsideClick: false,
            showConfirmButton: false,
            customClass: "sweet-alerts",
            didOpen: () => {
                Swal.showLoading();
            },
        });

        formCalculator.total = formCalculator.amount / formCalculator.exchangeRate;
        const newEntry = {
            amount: formCalculator.amount,
            currency: formCalculator.moneda,
            total: formCalculator.total,
            change: formCalculator.exchangeRate,
                
        };

        const form = new FormData();

        form.append('datos', JSON.stringify(newEntry));
        form.append('id', props.expense.id);
        form.append('uuid', props.expense.uuid);
            
        router.post(`/createCalculatorsExpense`, form, {
            onSuccess: (page) => {
                formCalculator.entries.push(newEntry);
                formCalculator.moneda = '';
                formCalculator.amount = '';
                formCalculator.total = '';
                formCalculator.exchangeRate = '';       
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
    
    function calculateTotal() {
        Swal.fire({
            title: t("expense.edit.process"),
            text: t("expense.edit.processData"),
            allowOutsideClick: false,
            showConfirmButton: false,
            customClass: "sweet-alerts",
            didOpen: () => {
                Swal.showLoading();
            },
        });

        formCalculator.total = formCalculator.exchangeRate * formCalculator.amount;
        const newEntry = {
            amount: formCalculator.amount,
            currency: formCalculator.moneda,
            total: formCalculator.total,
            change: formCalculator.exchangeRate,
                
        };

        const form = new FormData();

        form.append('datos', JSON.stringify(newEntry));
        form.append('id', props.expense.id);
        form.append('uuid', props.expense.uuid);
            
        router.post(`/createCalculatorsExpense`, form, {
            onSuccess: (page) => {
                formCalculator.entries.push(newEntry);
                formCalculator.moneda = '';
                formCalculator.amount = '';
                formCalculator.total = '';
                formCalculator.exchangeRate = '';       
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

    function generateUUID() {
        // Crea un array de 16 bytes (128 bits)
        const array = new Uint8Array(16);
        // Llena el array con valores aleatorios
        window.crypto.getRandomValues(array);

        // Convierte los valores en un UUID v4
        array[6] = (array[6] & 0x0f) | 0x40; // Versión 4
        array[8] = (array[8] & 0x3f) | 0x80; // Variante 10xx

        const hex = Array.from(array, byte => ('00' + byte.toString(16)).slice(-2));

        return [
            hex.slice(0, 4).join(''),
            hex.slice(4, 6).join(''),
            hex.slice(6, 8).join(''),
            hex.slice(8, 10).join(''),
            hex.slice(10, 16).join('')
        ].join('-');
    }

    function formatCurrencyNum(num) {
        num = num.toString().replace(/\$|\,/g, '');
        if (isNaN(num))
            num = "0";
        var sign = (num == (num = Math.abs(num)));
        num = Math.floor(num * 100 + 0.50000000001);
        var cents = num % 100;
        num = Math.floor(num / 100).toString();
        if (cents < 10)
            cents = "0" + cents;
        for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
            num = num.substring(0, num.length - (4 * i + 3)) + ',' +
                        num.substring(num.length - (4 * i + 3));
        return (((sign) ? '' : '-') + num + '.' + cents);
    }

    function formatCurrencyCalcu(num) {
        num = num.toString().replace(/\$|\,/g, '');
        if (isNaN(num))
            num = "0";
        
        var sign = (num == (num = Math.abs(num)));
        
        // Multiplicamos por 10^6 (1,000,000) para obtener 6 decimales
        num = Math.floor(num * 1000000 + 0.50000000001);
        
        // Obtenemos los decimales (últimos 6 dígitos)
        var cents = num % 1000000;
        
        // Formateamos el número entero
        num = Math.floor(num / 1000000).toString();
        
        // Convertimos los decimales a cadena y aseguramos que sean 6 dígitos
        cents = cents.toString().padStart(6, '0');
        
        // Añadimos las comas en los miles para el número entero
        for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++) {
            num = num.substring(0, num.length - (4 * i + 3)) + ',' +
                num.substring(num.length - (4 * i + 3));
        }
        
        // Devolvemos el número formateado con signo, número entero y decimales
        return (((sign) ? '' : '-') + num + '.' + cents);
    }

    function agregarExpensesTablas(){
        let index = 0;
        for(const expGerenal of ExpenseGeneral.value){
            var fecha = formatDateNormal(expGerenal.date);
            ExpenseGeneral.value[index].entries = [];
            ExpenseGeneral.value[index].totalConcepts = 0;
            ExpenseGeneral.value[index].totalExpense = 0;
                for(var x in expenseGenerals.value){
                    if(fecha == formatDate(expenseGenerals.value[x].dateExpense)){
                        expenseGenerals.value[x].tickets = [];

                        for(var y in expenseTickets.value){
                            if(expenseGenerals.value[x].id ==  expenseTickets.value[y].uuid){
                                expenseGenerals.value[x].tickets.push(expenseTickets.value[y]);
                            }
                        }
                        
                        ExpenseGeneral.value[index].entries.push(expenseGenerals.value[x]);
                        ExpenseGeneral.value[index].totalConcepts = ExpenseGeneral.value[index].entries.length;
                        ExpenseGeneral.value[index].totalExpense = parseFloat(ExpenseGeneral.value[index].totalExpense) + parseFloat(expenseGenerals.value[x].amount) + parseFloat(expenseGenerals.value[x].tip);
                    }
                }
            index++;
        }
        
        totalExpense();
        index = 0;
        for(const expMeals of ExpenseMeals.value){
            var fecha = formatDateNormal(expMeals.date);
            ExpenseMeals.value[index].entries = [];
            ExpenseMeals.value[index].totalConcepts = 0;
            ExpenseMeals.value[index].totalExpense = 0;
                for(var x in expenseMeal.value){
                    if(fecha == formatDate(expenseMeal.value[x].dateExpense)){
                        ExpenseMeals.value[index].entries.push(expenseMeal.value[x]);
                        ExpenseMeals.value[index].totalConcepts = ExpenseMeals.value[index].entries.length;
                        ExpenseMeals.value[index].totalExpense = parseFloat(ExpenseMeals.value[index].totalExpense) + parseFloat(expenseMeal.value[x].amount) + parseFloat(expenseMeal.value[x].tip);
                    }
                }
            index++;
        }

        index = 0;
        
        for(const expOther of ExpenseOther.value){
            var fecha = formatDateNormal(expOther.date);
            ExpenseOther.value[index].entries = [];
            ExpenseOther.value[index].totalConcepts = 0;
            ExpenseOther.value[index].totalExpense = 0;
                for(var x in expenseOthers.value){
                    if(fecha == formatDate(expenseOthers.value[x].dateExpense)){
                        ExpenseOther.value[index].entries.push(expenseOthers.value[x]);
                        ExpenseOther.value[index].totalConcepts = ExpenseOther.value[index].entries.length;
                        ExpenseOther.value[index].totalExpense = parseFloat(ExpenseOther.value[index].totalExpense) + parseFloat(expenseOthers.value[x].amount);
                    }
                }
            index++;
        }
    }

    function aproveReport(){
        Swal.fire({
                title: t("expense.edit.process"),
                text: t("expense.edit.processData"),
                allowOutsideClick: false,
                showConfirmButton: false,
                customClass: "sweet-alerts",
                didOpen: () => {
                    Swal.showLoading();
                },
            });
            const form = new FormData();
            form.append('id', expense.value.id);
            form.append('uuid', expense.value.uuid);
            form.append('approve', '2');

            router.post(`/approveExpensesReports`, form, {
                onSuccess: (page) => {
                    expense.value = page.props.expense;
                    location.reload();
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

    function noAproveReport(){
        Swal.fire({
                title: t("expense.edit.process"),
                text: t("expense.edit.processData"),
                allowOutsideClick: false,
                showConfirmButton: false,
                customClass: "sweet-alerts",
                didOpen: () => {
                    Swal.showLoading();
                },
            });
            const form = new FormData();
            form.append('id', expense.value.id);
            form.append('uuid', expense.value.uuid);
            form.append('approve', '0');

            router.post(`/approveExpensesReports`, form, {
                onSuccess: (page) => {
                    expense.value = page.props.expense;   
                    location.reload();     
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

    
    function submitFormTransferRequestReport(){
        Swal.fire({
                title: t("expense.edit.process"),
                text: t("expense.edit.processData"),
                allowOutsideClick: false,
                showConfirmButton: false,
                customClass: "sweet-alerts",
                didOpen: () => {
                    Swal.showLoading();
                },
            });
            const form = new FormData();
            form.append('id', expense.value.id);
            form.append('uuid', expense.value.uuid);
            form.append('concept', concept.value);

            router.post(`/requestTransferExpensesReports`, form, {
                onSuccess: (page) => {
                    expense.value = page.props.expense;   
                    location.reload();     
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

    agregarExpensesTablas();
    
    onMounted(() => {
        totalExpense();
    });

    function excelReport(id) {
        const url = `/expensesReportExcel/${id}`;
        window.location.href = url;
        Swal.fire({
            title: t("report.alert.generatingPdfTitle"),
            text: t("report.alert.generatingPdfText"),
            allowOutsideClick: false,
            showConfirmButton: false,
            customClass: "sweet-alerts",
            timer: 3000,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
            },
        });
    }

</script>
