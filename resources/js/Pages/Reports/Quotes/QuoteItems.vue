<template>
  <AppLayout :smallTitle="false" :title="`Itens do Orçamento nº ${quote.number}`">
    <template #header>
      <time class="font-medium text-blue-700 bg-blue-50 ml-2 px-4 py-1 inline-flex items-center rounded-full">
        {{ quote.date_formatted}}
      </time>
    </template>

    <div class="flex flex-col">
      <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
          <div class="mb-8 rounded-md flex items-center w-full">
            <!-- <div class="hidden sm:flex items-end space-x-4 w-full">
              <CompInput name="search" type="search" v-model="search" :withPadding="false" class="flex-grow w-full" placeholder="Número">Número</CompInput>
              <CompInput name="search_date" type="date" v-model="search_date" :withPadding="false" class="flex-grow w-full">Data</CompInput>

              <span class="sm:ml-3 shadow-sm rounded-md">
                <button
                  @click=" search = ''; search_date = '';"
                  class="
                    px-4 py-3
                    flex items-center
                    border border-gray-300 hover:border-gray-400
                    text-gray-700 text-sm leading-4 font-medium hover:text-gray-500
                    rounded-md
                    bg-gray-50 active:bg-gray-50
                    focus:outline-none focus:shadow-outline-gray focus:border-gray-100
                    transition duration-150 ease-in-out
                  "
                >
                  <svg class="fill-current w-4 h-4 mr-2" viewBox="0 0 20 20">
                    <path d="M18 3H8.446c-.44 0-1.071.236-1.402.525L.248 9.473a.682.682 0 000 1.053l6.796 5.947c.331.289.962.527 1.402.527H18c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-2.809 11l-2.557-2.557L10.078 14l-1.443-1.443L11.191 10 8.635 7.443 10.078 6l2.557 2.555L15.19 6l1.444 1.443L14.078 10l2.557 2.555L15.191 14z" />
                  </svg>
                  <span>Limpar</span>
                </button>
              </span>
            </div> -->
          </div>

          <div class="shadow overflow-hidden border border-gray-200 sm:rounded-lg">
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
                    <!-- <button @click="sort('service_date_search')" class="text-xs font-medium text-gray-500 uppercase tracking-wider inline-flex items-center space-x-2 whitespace-nowrap"> -->
                      <span>Data do Serviço</span>
                      <!-- <ChevronUpIcon v-if="sortDirection == 'desc' && sortProperty == 'service_date_search'" class="h-4 w-4" aria-hidden="true" />
                      <ChevronDownIcon v-if="sortDirection == 'asc' && sortProperty == 'service_date_search'" class="h-4 w-4" aria-hidden="true" />
                    </button> -->
                  </th>
                  <th scope="col" class="px-3 py-4 text-xs text-left font-medium text-gray-500 uppercase tracking-wider w-full">
                    <span>Itens do Contrato</span>
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="(item, index) in airConditionersList" :key="index" class="hover:bg-yellow-50 odd:bg-gray-100 divide-x">
                  <td class="px-3 py-2 whitespace-nowrap text-left">
                    <div class="text-sm font-semibold text-slate-700">
                      <div>{{ item.room }}</div>
                    </div>
                  </td>
                  <td class="px-3 py-2 whitespace-nowrap">
                    <div class="text-sm">
                      <span>{{ item.brand }}</span>
                    </div>
                  </td>
                  <td class="px-3 py-2 whitespace-nowrap tabular-nums text-right">
                    <div class="text-sm">
                      <div class="tabular-nums">{{ item.btu }}</div>
                    </div>
                  </td>
                  <td class="px-3 py-2 whitespace-nowrap tabular-nums text-left">
                    <Link :href="route('air_conditioners.show', item.id)">
                      <div class="text-sm font-semibold text-blue-900 tabular-nums">{{ item.identifier }}</div>
                    </Link>
                  </td>
                  <td class="px-3 py-2 whitespace-nowrap tabular-nums text-left">
                    <div class="text-sm">
                      <div class="text-sm tabular-nums">
                        {{ item.quoteItems[0].service_date_formatted }}
                        <!-- <span v-for="quoteItem in item.quoteItems" :key="quoteItem.id">{{ quoteItem.service_date_formatted }}</span> -->
                      </div>
                    </div>
                  </td>
                  <td class="px-3 py-2 whitespace-nowrap tabular-nums text-left">
                    <div 
                      v-for="quoteItem in item.quoteItems" :key="quoteItem.id" 
                      class="inline after:content-['+'] after:last:content-[''] after:px-2 after:last:px-0 after:text-blue-700 after:font-semibold text-base tabular-nums">
                        {{ quoteItem.contract_item.number }}
                        <span class="text-slate-500 text-sm">
                          (<em class="not-italic">×</em>{{ quoteItem.quantity }})
                        </span>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, computed } from 'vue'
import { ChevronDownIcon, ChevronUpIcon } from '@heroicons/vue/outline';
import CompInput from '@/Components/Input.vue';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
  air_conditioners: Object,
  quote: Object
});

const search = ref('');
const search_date = ref('');
const sortProperty = ref('room');
const sortDirection = ref('asc');

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
  // filtered = props.quote_items.filter((quote) => {
  //   return (
  //     quote.number.toString().indexOf(search.value) > -1 
  //   );
  // });

  // filtered = filtered.filter((quote) => {
  //   if(search_date.value == '' ){
  //     return ( true );
  //   }

  //   return (
  //     quote.date_search === search_date.value
  //   );
  // });

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
