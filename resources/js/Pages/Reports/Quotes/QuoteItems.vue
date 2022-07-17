<template>
  <AppLayout :smallTitle="false" :title="`Itens do Orçamento nº ${quote.number}`">
    <template #header>
      <time class="font-medium text-blue-700 bg-blue-50 ml-2 px-4 py-1 inline-flex items-center rounded-full">
        {{ quote.date_formatted}}
      </time>
    </template>

    <div class="flex flex-col">
      <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8 ">
          <div class="sm:rounded-lg shadow border border-gray-200 mb-12">
            <div class="relative">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-white">
                  <tr class="divide-x">
                    <th scope="col" class="px-3 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      <button @click="sort('room')" class="text-xs font-medium text-gray-500 uppercase tracking-wider inline-flex items-center space-x-2">
                        <span>Sala</span>
                        <ChevronUpIcon v-if="sortDirection == 'desc' && sortProperty == 'room'" class="h-4 w-4" aria-hidden="true" />
                        <ChevronDownIcon v-if="sortDirection == 'asc' && sortProperty == 'room'" class="h-4 w-4" aria-hidden="true" />
                      </button>
                    </th>
                    <th scope="col" class="px-3 py-4 text-xs text-left font-medium text-gray-500 uppercase tracking-wider">
                      <button @click="sort('brand')" class="text-xs font-medium text-gray-500 uppercase tracking-wider inline-flex items-center mr-2 space-x-2">
                        <span>Marca</span>
                        <ChevronUpIcon v-if="sortDirection == 'desc' && sortProperty == 'brand'" class="h-4 w-4" aria-hidden="true" />
                        <ChevronDownIcon v-if="sortDirection == 'asc' && sortProperty == 'brand'" class="h-4 w-4" aria-hidden="true" />
                      </button>
                    </th>
                    <th scope="col" class="px-3 py-4 text-xs text-right font-medium text-gray-500 uppercase tracking-wider">
                      <button @click="sort('btu')" class="text-xs font-medium text-gray-500 uppercase tracking-wider inline-flex items-center space-x-2 whitespace-nowrap">
                        <span>BTU</span>
                        <ChevronUpIcon v-if="sortDirection == 'desc' && sortProperty == 'btu'" class="h-4 w-4" aria-hidden="true" />
                        <ChevronDownIcon v-if="sortDirection == 'asc' && sortProperty == 'btu'" class="h-4 w-4" aria-hidden="true" />
                      </button>
                    </th>
                    <th scope="col" class="px-3 py-4 text-xs text-left font-medium text-gray-500 uppercase tracking-wider">
                      <button @click="sort('identifier')" class="text-xs font-medium text-gray-500 uppercase tracking-wider inline-flex items-center space-x-2 whitespace-nowrap">
                        <span>Tombamento</span>
                        <ChevronUpIcon v-if="sortDirection == 'desc' && sortProperty == 'identifier'" class="h-4 w-4" aria-hidden="true" />
                        <ChevronDownIcon v-if="sortDirection == 'asc' && sortProperty == 'identifier'" class="h-4 w-4" aria-hidden="true" />
                      </button>
                    </th>
                    <th scope="col" class="px-3 py-4 text-xs text-left font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                      <span>Data do Serviço</span>
                    </th>
                    <th scope="col" class="px-3 py-4 text-xs text-left font-medium text-gray-500 uppercase tracking-wider w-full">
                      <span>Itens do Contrato</span>
                    </th>
                    <th scope="col" class="px-3 py-4 text-xs text-right font-medium text-gray-500 uppercase tracking-wider w-full">
                      <span>Total</span>
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="(item, index) in airConditionersList" :key="index" class=" divide-x" :class="[identifier == item.identifier ? 'bg-green-50' : 'odd:bg-gray-50']">
                    <td @click="load(item.id, item.identifier)" class="px-3 py-2 whitespace-nowrap text-left cursor-default">
                      <div class="text-sm font-semibold text-slate-700">
                        <div>{{ item.room }}</div>
                      </div>
                    </td>
                    <td @click="load(item.id, item.identifier)" class="px-3 py-2 whitespace-nowrap cursor-default">
                      <div class="text-sm">
                        <span>{{ item.brand }}</span>
                      </div>
                    </td>
                    <td @click="load(item.id, item.identifier)" class="px-3 py-2 whitespace-nowrap tabular-nums text-right cursor-default">
                      <div class="text-sm">
                        <div class="tabular-nums">{{ item.btu }}</div>
                      </div>
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap tabular-nums text-left">
                      <Link :href="route('air_conditioners.show', item.id)">
                        <div class="text-sm font-semibold text-blue-900 hover:text-blue-600 tabular-nums">{{ item.identifier }}</div>
                      </Link>
                    </td>
                    <td @click="load(item.id, item.identifier)" class="px-3 py-2 whitespace-nowrap tabular-nums text-left cursor-default">
                      <div class="text-sm">
                        <div class="text-sm tabular-nums">
                          {{ getServiceDates(item.quoteItems) }}
                        </div>
                      </div>
                    </td>
                    <td @click="load(item.id, item.identifier)" class="px-3 py-2 whitespace-nowrap tabular-nums text-left cursor-default">
                      <div
                        v-for="quoteItem in item.quoteItems" :key="quoteItem.id"
                        class="inline after:content-['+'] after:last:content-[''] after:px-2 after:last:px-0 after:text-blue-700 after:font-semibold text-base tabular-nums whitespace-pre-wrap">
                          <div class="inline group">
                            <span class="group-hover:text-blue-600 group-hover:cursor-default">{{ quoteItem.contract_item.number }}</span>
                            <div class="hidden group-hover:flex items-center absolute -bottom-12 left-0 max-w-5xl border border-blue-300 rounded-full">
                              <div class="text-xs font-medium bg-blue-50 text-blue-700 py-2 px-3 rounded-l-full whitespace-nowrap">
                                {{ quoteItem.contract_item.title }}
                              </div>
                              <div class="text-xs font-semibold bg-blue-200 text-blue-900 py-2 px-3 rounded-r-full whitespace-nowrap">
                                {{ new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(quoteItem.contract_item.item_value) }}
                              </div>
                            </div>
                          </div>
                          <span class="text-slate-500 text-sm">
                            (<em class="not-italic">×</em>{{ quoteItem.quantity }})
                          </span>
                      </div>
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap tabular-nums text-right">
                      <div class="text-sm font-semibold tabular-nums">
                        {{ new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(calcTotal(item.quoteItems)) }}
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div>
            <div class="mt-8">
              <div  v-if="service_orders">
                <h2 class="font-medium text-gray-700 text-xl pt-4 mb-4"><span class="bg-green-100 border border-gray-200 text-green-900 px-4 py-2 rounded-full tabular-nums">{{ identifier }}</span> Lista de ordens de serviço</h2>
                <ul v-if="service_orders.length > 0" class="mt-6">
                  <li v-for="serviceOrder in service_orders" :key="serviceOrder.id" class="flex items-start relative">
                    <div class="absolute right-full top-[2.5rem] bottom-0 w-px bg-slate-200 block -mr-5"></div>
                    <div class="w-10 h-10 text-sm text-slate-400 uppercase font-bold bg-slate-50 border border-slate-200 p-2 mr-5 flex items-center justify-center rounded-full z-10">
                      {{ serviceOrder.status_abbr }}
                    </div>
                    <div>
                      <div class="flex items-center space-x-3 mb-2 mt-1">
                        <h3 class="font-bold text-lg">
                          {{ serviceOrder.technicians }}
                        </h3>
                        <time class="font-medium text-xs text-blue-700 bg-blue-50 ml-2 px-2 py-1 inline-flex items-center rounded-full">
                          <CalendarIcon class="h-4 w-4 mr-1 text-blue-400/60 inline"/>
                          <span>{{ serviceOrder.date_diff }}</span>
                        </time>
                        <time class="text-xs text-gray-400">{{ serviceOrder.done_date }}</time>
                      </div>
                      <p class="text-slate-500 text-sm mb-12 whitespace-pre-line">{{ serviceOrder.services }}</p>
                    </div>
                  </li>
                </ul>
                <div v-else class="text-slate-500 text-sm mt-8 ml-4">Ainda não foram cadastradas Ordens de Serviço para este aparelho.</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, computed } from 'vue'
import { ChevronDownIcon, ChevronUpIcon, CalendarIcon } from '@heroicons/vue/outline';
import { SearchIcon } from '@heroicons/vue/solid';
import CompInput from '@/Components/Input.vue';
import { Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
  air_conditioners: Object,
  quote: Object,
  service_orders: Object
});

const identifier = ref('');
const search = ref('');
const search_date = ref('');
const sortProperty = ref('room');
const sortDirection = ref('asc');

function getServiceDates(items) {
  let dates = [];
  items.forEach(item => {
    if(!dates.includes(item.service_date_formatted)) {
      dates.push(item.service_date_formatted)
    }
  })
  return dates.toString();
}

function calcTotal(items) {
  let total = 0;
  items.forEach(item => {
    total += item.quantity * item.contract_item.item_value;
  });
  return total;
}

async function load(air_conditioner_id, air_conditioner_identifier) {
  Inertia.reload({
    only: ['service_orders'],
    data: { air_conditioner: air_conditioner_id },
    onSuccess: page => { 
      identifier.value = air_conditioner_identifier 
    }
  });
}

function sort(property) {
  if (sortProperty.value == property) {
    if (sortDirection.value == 'asc') {
      sortDirection.value = 'desc';
    } else {
      sortDirection.value = 'asc';
    }
  }
  sortProperty.value = property;
}

const airConditionersList = computed(() => {
  let filtered;

  filtered = props.air_conditioners;

  return _.orderBy(
    filtered,
    [
      (i) => !!i[sortProperty.value],
      (i) => {
        if(sortProperty.value == 'items' || sortProperty.value == 'number'){
          return parseInt(i[sortProperty.value]);
        }
        return i[sortProperty.value] ? i[sortProperty.value].toLowerCase() : '';
      },
    ],
    sortDirection.value == 'desc' ? ['asc', 'desc'] : ['desc', 'asc']
  );
});
</script>
