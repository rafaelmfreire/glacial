<template>
  <AppLayout title="Chamados">
    <template #header>
        <Link
          class="
            flex items-center gap-2
            px-5 py-2
            border border-blue-300
            hover:border-blue-400
            text-sm leading-5 font-medium text-blue-700 hover:text-blue-500
            rounded-md
            bg-blue-50 active:bg-blue-50 focus:outline-none focus:shadow-outline-blue focus:border-blue-100
            transition duration-150 ease-in-out
          "
          :href="route('tickets.create')"
        >
          <PlusCircleIcon class="w-5 h-5" />
          <span>Novo Chamado</span>
        </Link>
    </template>

    <div class="flex flex-col">
      <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
          <div class="mb-8 rounded-md flex items-center w-full">
            <div class="hidden sm:flex items-end space-x-4 w-full">
              <CompInput name="search" type="search" v-model="search" :withPadding="false" class="flex-grow w-full" placeholder="Tombamento, Sala, BTU...">Pesquisa</CompInput>
              <CompSelect class="min-w-[200px]" name="brand" :withPadding="false" v-model="brand">
                Marca
                <template #options>
                  <CompOption v-for="brand in brands" :key="brand.id.toString()" :value="brand.id.toString()">
                    {{ brand.name.toUpperCase() }}
                  </CompOption>
                </template>
              </CompSelect>
              <CompInput name="search_date" type="date" v-model="search_date" :withPadding="false" class="flex-grow w-full">Data</CompInput>
              <CompInput name="problem_informed_by" type="search" v-model="problem_informed_by" :withPadding="false" class="flex-grow w-full" placeholder="Problema, informado por...">Problema/Informante</CompInput>

              <span class="sm:ml-3 shadow-sm rounded-md">
                <button
                  @click=" search = ''; search_date = ''; problem_informed_by = ''; brand = ''; "
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
                  <th scope="col" class="pl-6 pr-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    <button @click="sort('identifier')" class="text-xs font-medium text-gray-500 uppercase tracking-wider inline-flex items-center space-x-2">
                      <span>Aparelho</span>
                      <ChevronDownIcon v-if="sortDirection == 'desc' && sortProperty == 'identifier'" class="h-4 w-4" aria-hidden="true" />
                      <ChevronUpIcon v-if="sortDirection == 'asc' && sortProperty == 'identifier'" class="h-4 w-4" aria-hidden="true" />
                    </button>
                  </th>
                  <th scope="col" class="px-3 py-3 text-xs text-right font-medium text-gray-500 uppercase tracking-wider">
                    <button @click="sort('btu')" class="text-xs font-medium text-gray-500 uppercase tracking-wider inline-flex items-center mr-2 space-x-2">
                      <span>Modelo</span>
                      <ChevronDownIcon v-if="sortDirection == 'desc' && sortProperty == 'btu'" class="h-4 w-4" aria-hidden="true" />
                      <ChevronUpIcon v-if="sortDirection == 'asc' && sortProperty == 'btu'" class="h-4 w-4" aria-hidden="true" />
                    </button>
                  </th>
                  <th scope="col" class="px-3 py-3 text-xs text-left font-medium text-gray-500 uppercase tracking-wider">
                    <button @click="sort('opened_at')" class="text-xs font-medium text-gray-500 uppercase tracking-wider flex items-center space-x-2">
                      <span>Data</span>
                      <ChevronDownIcon v-if="sortDirection == 'desc' && sortProperty == 'opened_at'" class="h-4 w-4" aria-hidden="true" />
                      <ChevronUpIcon v-if="sortDirection == 'asc' && sortProperty == 'opened_at'" class="h-4 w-4" aria-hidden="true" />
                    </button>
                  </th>
                  <th scope="col" class="px-3 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-left w-full">
                    <button @click="sort('problem')" class="text-xs font-medium text-gray-500 uppercase tracking-wider inline-flex items-center space-x-2">
                      <span>Problema</span>
                      <ChevronDownIcon v-if="sortDirection == 'desc' && sortProperty == 'problem'" class="h-4 w-4" aria-hidden="true" />
                      <ChevronUpIcon v-if="sortDirection == 'asc' && sortProperty == 'problem'" class="h-4 w-4" aria-hidden="true" />
                    </button>
                  </th>
                  <th scope="col" class="px-3 py-3 text-xs text-left font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                    <button @click="sort('informed_by')" class="text-xs font-medium text-gray-500 uppercase tracking-wider flex items-center space-x-2">
                      <span>Informado por</span>
                      <ChevronDownIcon v-if="sortDirection == 'desc' && sortProperty == 'informed_by'" class="h-4 w-4" aria-hidden="true" />
                      <ChevronUpIcon v-if="sortDirection == 'asc' && sortProperty == 'informed_by'" class="h-4 w-4" aria-hidden="true" />
                    </button>
                  </th>
                  <th scope="col" class="px-3 py-3 text-xs text-right font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                    <span>Último serviço</span>
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="(item, index) in ticketsList" :key="index" class="hover:bg-yellow-50 odd:bg-gray-100">
                  <td class="pl-6 pr-3 py-3 whitespace-nowrap text-left">
                    <Link :href="route('air_conditioners.show', item.air_conditioner_id)">
                      <div class="text-lg group">
                        <div class="tabular-nums font-semibold group-hover:text-blue-700">{{ item.identifier }}</div>
                        <div class="text-sm text-slate-500 group-hover:text-slate-700">{{ item.room }}</div>
                      </div>
                    </Link>
                  </td>
                  <td class="px-3 py-3 whitespace-nowrap tabular-nums text-right">
                    <div class="text-sm">
                      <div v-if="item.btu" class="px-3 py-1 mb-2 inline-block font-bold bg-blue-100 rounded-full text-blue-700">{{ item.btu }}</div>
                      <div class="text-xs uppercase mr-2">{{ item.brand }}</div>
                    </div>
                  </td>
                  <td class="px-3 py-3 tabular-nums whitespace-nowrap">
                    <div class="text-sm">
                      <span>{{ item.opened_at_formatted }}</span>
                    </div>
                  </td>
                  <td class="px-3 py-3">
                    <div class="text-sm font-semibold text-gray-900">
                      <span>{{ item.problem }}</span>
                    </div>
                  </td>
                  <td class="px-3 py-3 whitespace-nowrap">
                    <div class="text-sm">
                      <span>{{ item.informed_by }}</span>
                    </div>
                  </td>
                  <td class="px-3 py-3 text-right">
                    <div class="text-sm relative group">
                      <!-- <span class="px-3 py-1 whitespace-nowrap font-medium rounded-full" :class="[ item.latest_service_order.done_at > item.opened_at && item.latest_service_order.status_abbr == 'Co' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700']">{{ item.latest_service_order.status_abbr }} ‣ {{item.latest_service_order.done_at_formatted}}</span> -->
                      <div class="px-3 py-1 inline-flex items-center space-x-1 whitespace-nowrap font-medium rounded-full" :class="statusClass(item.opened_at, item.latest_service_order?.status_abbr, item.latest_service_order?.done_at)">
                        <span>{{ item.latest_service_order?.status_abbr ?? 'Nenhum' }}</span>
                        <span>{{item.latest_service_order?.done_at_formatted ?? 'serviço'}}</span>
                      </div>
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
import { ChevronDownIcon, ChevronUpIcon, PlusCircleIcon } from '@heroicons/vue/outline';
import CompInput from '@/Components/Input.vue';
import CompSelect from '@/Components/Select.vue';
import CompOption from '@/Components/Option.vue';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
  tickets: Object,
  brands: Object
});

const search = ref('');
const brand = ref(null);
const search_date = ref('');
const problem_informed_by = ref('');
const sortProperty = ref('opened_at');
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

function statusClass(date, status, serviceDate) {
  if(serviceDate > date) {
    if(status == 'Co') {
      return 'bg-green-50 text-green-700'
    } else {
      return 'bg-yellow-50 text-yellow-700'
    }
  }

  return 'bg-red-50 text-red-700'
}

const ticketsList = computed(() => {
  let filtered;

  filtered = props.tickets.filter((ticket) => {
    return (
      ticket.identifier.indexOf(search.value) > -1 
      || ticket.room?.toLowerCase().indexOf(search.value.toLowerCase()) > -1 
      || ticket.btu?.indexOf(search.value) > -1
    );
  });

  filtered = filtered.filter((ticket) => {
    return (
      ticket.problem?.toLowerCase().indexOf(problem_informed_by.value.toLowerCase()) > -1 
      || ticket.informed_by?.toLowerCase().indexOf(problem_informed_by.value.toLowerCase()) > -1 
    );
  });

  filtered = filtered.filter((ticket) => {
    if(search_date.value == '' ){
      return ( true );
    }

    return (
      ticket.opened_at_search === search_date.value
    );
  });

  filtered = filtered.filter((ticket) => {
    if (brand.value != '' && brand.value != null) {
      return ticket.brand_id == brand.value;
    }
    return true;
  });

  return _.orderBy(
    filtered,
    [
      (i) => !!i[sortProperty.value],
      (i) => {
        if(sortProperty.value == 'btu' || sortProperty.value == 'cpf'){
          return parseInt(i[sortProperty.value]);
        }
        return i[sortProperty.value] ? i[sortProperty.value].toLowerCase() : '';
      },
    ],
    sortDirection.value == 'asc' ? ['asc', 'desc'] : ['desc', 'asc']
  );
});
</script>
