<template>
  <AppLayout :smallTitle="false" :title="`Itens da Requisição nº ${requisition.number}/${requisition.year}`">
    <template #header>
      <span class="font-medium text-green-700 bg-green-50 ml-2 px-4 py-1 inline-flex items-center rounded-full">
        Total: {{ new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(requisition.total) }}
      </span>
    </template>

    <div class="flex flex-col">
      <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8 ">
          <div class="sm:rounded-lg shadow border border-gray-200 mb-16">
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
                    <th scope="col" class="px-3 py-4 text-xs text-left font-medium text-gray-500 uppercase tracking-wider">
                      <!-- <button @click="sort('identifier')" class="text-xs font-medium text-gray-500 uppercase tracking-wider inline-flex items-center space-x-2 whitespace-nowrap"> -->
                        <span>Orçamento</span>
                        <!-- <ChevronUpIcon v-if="sortDirection == 'desc' && sortProperty == 'identifier'" class="h-4 w-4" aria-hidden="true" />
                        <ChevronDownIcon v-if="sortDirection == 'asc' && sortProperty == 'identifier'" class="h-4 w-4" aria-hidden="true" />
                      </button> -->
                    </th>
                    <th scope="col" class="px-3 py-4 text-xs text-left font-medium text-gray-500 uppercase tracking-wider w-full">
                      <span>Itens do Contrato</span>
                    </th>
                    <th scope="col" class="px-3 py-4 text-xs text-right font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                      <span>Total</span>
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="(item, index) in airConditionersList" :key="index" class=" divide-x" :class="[ air_conditioner_identifier == item.identifier ? 'bg-green-50' : 'odd:bg-gray-50']">
                    <td class="px-3 py-2 whitespace-nowrap text-left cursor-default">
                      <div class="text-sm font-semibold text-slate-700">
                        <div>{{ item.room }}</div>
                      </div>
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap cursor-default">
                      <div class="text-sm">
                        <span>{{ item.brand }}</span>
                      </div>
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap tabular-nums text-right cursor-default">
                      <div class="text-sm">
                        <div class="tabular-nums">{{ item.btu }}</div>
                      </div>
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap tabular-nums text-left">
                      <Link :href="route('air_conditioners.show', item.id)">
                        <div class="text-sm font-semibold text-blue-900 hover:text-blue-600 tabular-nums">{{ item.identifier }}</div>
                      </Link>
                    </td>
                    <td @click="load(item.id, item.identifier, item.requisitionItems[0].quote.id, item.requisitionItems[0].quote.number)" class="px-3 py-2 whitespace-nowrap tabular-nums text-right group cursor-pointer">
                        <div class="text-sm group-hover:text-blue-600 tabular-nums">{{ getQuoteNumbers(item.requisitionItems) }}</div>
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap tabular-nums text-left cursor-default">
                      <div
                        v-for="requisitionItem in item.requisitionItems" :key="requisitionItem.id"
                        class="inline after:content-['+'] after:last:content-[''] after:px-2 after:last:px-0 after:text-blue-700 after:font-semibold text-base tabular-nums">
                          <div class="inline group">
                            <span class="group-hover:text-blue-600 group-hover:cursor-default">{{ requisitionItem.contract_item.number }}</span>
                            <div class="hidden group-hover:flex items-center absolute -bottom-12 left-0 max-w-5xl border border-blue-300 rounded-full">
                              <div class="text-xs font-medium bg-blue-50 text-blue-700 py-2 px-3 rounded-l-full whitespace-no-wrap">
                                {{ requisitionItem.contract_item.title }}
                              </div>
                              <div class="text-xs font-semibold bg-blue-200 text-blue-900 py-2 px-3 rounded-r-full whitespace-no-wrap">
                                {{ new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(requisitionItem.contract_item.item_value) }}
                              </div>
                            </div>
                          </div>
                          <span class="text-slate-500 text-sm">
                            (<em class="not-italic">×</em>{{ requisitionItem.quantity }})
                          </span>
                      </div>
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap tabular-nums text-right">
                      <div class="text-sm font-semibold tabular-nums">
                        {{ new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(calcTotal(item.requisitionItems)) }}
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>


          <div v-if="quote_items">
            <h2 class="font-medium text-gray-700 text-xl pt-4 mb-4">
              <span class="bg-green-100 border border-gray-200 text-green-900 px-4 py-2 rounded-full tabular-nums">
                {{ air_conditioner_identifier }}
              </span> 
              Lista de itens do orçamento nº <span class="text-blue-700 hover:text-blue-600"><Link :href="route('reports.quotes.quote_items', c_quote_id)">{{ number }}</Link></span>
            </h2>
            <div v-if="quote_items.length > 0" class="shadow overflow-x-auto border border-gray-200 sm:rounded-lg mt-8">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-white">
                  <tr class="divide-x">
                    <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <span>Item</span>
                    </th>
                    <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <span>QTD</span>
                    </th>
                    <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[115px]">
                        <span>Valor</span>
                    </th>
                    <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[115px]">
                        <span>Total</span>
                    </th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <span>Data</span>
                    </th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-full">
                        <span>Descrição</span>
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="quoteItem in resort(quote_items, 'contract_item.number', 'asc')" :key="quoteItem.id" class="hover:bg-yellow-50 odd:bg-gray-100 divide-x group">
                    <td class="px-4 py-2 whitespace-nowrap tabular-nums text-right">
                      <div class="text-sm text-slate-800">
                        {{ quoteItem.contract_item.number }}
                      </div>
                    </td>
                    <td class="px-4 py-2 whitespace-nowrap tabular-nums text-right">
                      <div class="text-sm text-slate-800">
                        {{ quoteItem.quantity }}
                      </div>
                    </td>
                    <td class="px-4 py-2 whitespace-nowrap tabular-nums text-right">
                      <div class="text-sm text-slate-800 tracking-tight">
                        {{ new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(quoteItem.contract_item.item_value) }}
                      </div>
                    </td>
                    <td class="px-4 py-2 whitespace-nowrap tabular-nums text-right">
                      <div class="text-sm text-slate-800 font-semibold tracking-tight">
                        {{ new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(quoteItem.contract_item.item_value * quoteItem.quantity) }}
                      </div>
                    </td>
                    <td class="px-4 py-2 whitespace-nowrap tabular-nums text-right">
                      <div class="text-sm text-slate-800">
                        {{ quoteItem.service_date_formatted }}
                      </div>
                    </td>
                    <td class="px-4 py-2 whitespace-nowrap tabular-nums">
                      <div class="text-sm text-slate-800">
                        {{ quoteItem.contract_item.title }}
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div v-else class="text-slate-500 text-sm mt-8 ml-4">Não foram encontrados itens de orçamento referentes à este aparelho.</div>
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
import CompInput from '@/Components/Input.vue';
import { Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
  air_conditioners: Object,
  requisition: Object,
  quote_items: Object
});

const number = ref('');
const air_conditioner_identifier = ref('');
const c_quote_id = ref('')
const search = ref('');
const search_date = ref('');
const sortProperty = ref('room');
const sortDirection = ref('asc');

async function load(air_conditioner, identifier, quote_id, quote_number) {
  Inertia.reload({
    only: ['quote_items'],
    data: { 
      air_conditioner_id: air_conditioner,
      quote_id: quote_id,
    },
    onSuccess: page => { 
      air_conditioner_identifier.value = identifier
      number.value = quote_number 
      c_quote_id.value = quote_id
    }
  });
}

function resort(list, property, direction) {
  return _.orderBy(list, property, direction);
}

function getQuoteNumbers(items) {
  let numbers = [];
  items.forEach(item => {
    if(!numbers.includes(item.quote.number)) {
      numbers.push(item.quote.number)
    }
  })
  return numbers.toString();
}

function calcTotal(items) {
  let total = 0;
  items.forEach(item => {
    total += item.quantity * item.contract_item.item_value;
  });
  return total;
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
        if(sortProperty.value == 'items' || sortProperty.value == 'number' || sortProperty.value == 'year'){
          return parseInt(i[sortProperty.value]);
        }
        return i[sortProperty.value] ? i[sortProperty.value].toLowerCase() : '';
      },
    ],
    sortDirection.value == 'desc' ? ['asc', 'desc'] : ['desc', 'asc']
  );
});
</script>
