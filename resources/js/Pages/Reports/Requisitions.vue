<template>
  <AppLayout title="Relatório de Requisições">
    <template #header>
    </template>

    <div class="flex flex-col">
      <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
          <div class="mb-8 rounded-md flex items-center w-full">
            <div class="hidden sm:flex items-end space-x-4 w-full">
              <CompInput name="number" type="search" v-model="number" :withPadding="false" class="flex-grow w-full" placeholder="Número">Número</CompInput>
              <CompInput name="year" type="search" v-model="year" :withPadding="false" class="flex-grow w-full" placeholder="Ano">Ano</CompInput>

              <span class="sm:ml-3 shadow-sm rounded-md">
                <button
                  @click=" number = ''; year = '';"
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
            </div>
          </div>

          <div class="shadow overflow-hidden border border-gray-200 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-white">
                <tr>
                  <th scope="col" class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                    <button @click="sort('number')" class="text-xs font-medium text-gray-500 uppercase tracking-wider inline-flex items-center space-x-2">
                      <span>Número</span>
                      <ChevronDownIcon v-if="sortDirection == 'desc' && sortProperty == 'number'" class="h-4 w-4" aria-hidden="true" />
                      <ChevronUpIcon v-if="sortDirection == 'asc' && sortProperty == 'number'" class="h-4 w-4" aria-hidden="true" />
                    </button>
                  </th>
                  <th scope="col" class="px-6 py-4 text-xs text-left font-medium text-gray-500 uppercase tracking-wider">
                    <button @click="sort('year')" class="text-xs font-medium text-gray-500 uppercase tracking-wider inline-flex items-center mr-2 space-x-2">
                      <span>Ano</span>
                      <ChevronDownIcon v-if="sortDirection == 'desc' && sortProperty == 'year'" class="h-4 w-4" aria-hidden="true" />
                      <ChevronUpIcon v-if="sortDirection == 'asc' && sortProperty == 'year'" class="h-4 w-4" aria-hidden="true" />
                    </button>
                  </th>
                  <th scope="col" class="px-6 py-4 text-xs text-left font-medium text-gray-500 uppercase tracking-wider">
                    <button @click="sort('items')" class="text-xs font-medium text-gray-500 uppercase tracking-wider flex items-center space-x-2 whitespace-nowrap">
                      <span>QTD de Itens</span>
                      <ChevronDownIcon v-if="sortDirection == 'desc' && sortProperty == 'items'" class="h-4 w-4" aria-hidden="true" />
                      <ChevronUpIcon v-if="sortDirection == 'asc' && sortProperty == 'items'" class="h-4 w-4" aria-hidden="true" />
                    </button>
                  </th>
                  <th scope="col" class="px-6 py-4 text-xs text-right font-medium text-gray-500 uppercase tracking-wider">
                    <button @click="sort('total')" class="text-xs font-medium text-gray-500 uppercase tracking-wider inline-flex items-center space-x-2 whitespace-nowrap">
                      <span>Total</span>
                      <ChevronDownIcon v-if="sortDirection == 'desc' && sortProperty == 'total'" class="h-4 w-4" aria-hidden="true" />
                      <ChevronUpIcon v-if="sortDirection == 'asc' && sortProperty == 'total'" class="h-4 w-4" aria-hidden="true" />
                    </button>
                  </th>
                  <th class="w-full"></th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="(item, index) in requisitionsList" :key="index" class="hover:bg-yellow-50 odd:bg-gray-100">
                  <td class="px-6 py-4 whitespace-nowrap text-right">
                    <Link :href="route('reports.requisitions.requisition_items', item.id)">
                      <div class="text-lg group">
                        <div class="tabular-nums font-semibold group-hover:text-blue-700">{{ item.number }}</div>
                      </div>
                    </Link>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap tabular-nums text-right">
                    <div class="text-sm tabular-nums">{{ item.year }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap tabular-nums text-right">
                    <div class="text-sm tabular-nums">{{ item.items }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap tabular-nums text-right">
                    <div class="text-sm font-semibold tabular-nums">
                      {{ new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(item.total) }}
                    </div>
                  </td>
                  <td class="w-full"></td>
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
  requisitions: Object,
});

const number = ref('');
const year = ref(new Date().getFullYear());
const sortProperty = ref('done_at');
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

const requisitionsList = computed(() => {
  let filtered;

  filtered = props.requisitions.filter((requisition) => {
    return (
      requisition.number.toString().indexOf(number.value) > -1 
    );
  });

  filtered = filtered.filter((requisition) => {
    return (
      requisition.year.indexOf(year.value) > -1 
    );
  });

  return _.orderBy(
    filtered,
    [
      (i) => !!i[sortProperty.value],
      (i) => {
          return parseInt(i[sortProperty.value]);
      },
    ],
    sortDirection.value == 'asc' ? ['asc', 'desc'] : ['desc', 'asc']
  );
});
</script>
