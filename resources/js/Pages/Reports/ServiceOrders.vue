<template>
  <AppLayout title="Relatório de Ordens de Serviço">
    <template #header>
    </template>

    <div class="flex flex-col">
      <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
          <div class="mb-8 rounded-md flex items-center w-full">
            <div class="hidden sm:flex items-end space-x-4 w-full">
              <CompInput name="search" type="search" v-model="search" :withPadding="false" class="flex-grow w-full" placeholder="Tombamento, Sala, BTU...">Pesquisa</CompInput>
              <CompSelect class="min-w-[150px]" name="brand" :withPadding="false" v-model="brand">
                Marca
                <template #options>
                  <CompOption v-for="brand in brands" :key="brand.id.toString()" :value="brand.id.toString()">
                    {{ brand.name.toUpperCase() }}
                  </CompOption>
                </template>
              </CompSelect>
              <CompInput name="search_date" type="date" v-model="search_date" :withPadding="false" class="flex-grow w-full">Data</CompInput>
              <CompSelect class="min-w-[150px]" :withPadding="false" name="status" v-model="status">Status
                <template #options>
                  <CompOption v-for="(index, item) in statuses" :key="index.toString()" :value="index.toString()">
                    {{ item.toUpperCase() }}
                  </CompOption>
                </template>
              </CompSelect>
              <CompInput name="technicians" type="search" v-model="technicians" :withPadding="false" class="flex-grow w-full" placeholder="Buscar...">Serviços ou Equipe</CompInput>

              <span class="sm:ml-3 shadow-sm rounded-md">
                <button
                  @click=" search = ''; status = ''; search_date = ''; technicians = ''; brand = ''; "
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
                  <svg class="fill-current w-4 h-4" viewBox="0 0 20 20">
                    <path d="M18 3H8.446c-.44 0-1.071.236-1.402.525L.248 9.473a.682.682 0 000 1.053l6.796 5.947c.331.289.962.527 1.402.527H18c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-2.809 11l-2.557-2.557L10.078 14l-1.443-1.443L11.191 10 8.635 7.443 10.078 6l2.557 2.555L15.19 6l1.444 1.443L14.078 10l2.557 2.555L15.191 14z" />
                  </svg>
                  <!-- <span>Limpar</span> -->
                </button>
              </span>
            </div>
          </div>

          <div class="shadow overflow-hidden border border-gray-200 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-white">
                <tr>
                  <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    <button @click="sort('identifier')" class="text-xs font-medium text-gray-500 uppercase tracking-wider inline-flex items-center space-x-2">
                      <span>Aparelho</span>
                      <ChevronDownIcon v-if="sortDirection == 'desc' && sortProperty == 'identifier'" class="h-4 w-4" aria-hidden="true" />
                      <ChevronUpIcon v-if="sortDirection == 'asc' && sortProperty == 'identifier'" class="h-4 w-4" aria-hidden="true" />
                    </button>
                  </th>
                  <th scope="col" class="px-4 py-3 text-xs text-right font-medium text-gray-500 uppercase tracking-wider">
                    <button @click="sort('btu')" class="text-xs font-medium text-gray-500 uppercase tracking-wider inline-flex items-center mr-2 space-x-2">
                      <span>Modelo</span>
                      <ChevronDownIcon v-if="sortDirection == 'desc' && sortProperty == 'btu'" class="h-4 w-4" aria-hidden="true" />
                      <ChevronUpIcon v-if="sortDirection == 'asc' && sortProperty == 'btu'" class="h-4 w-4" aria-hidden="true" />
                    </button>
                  </th>
                  <th scope="col" class="px-4 py-3 text-xs text-left font-medium text-gray-500 uppercase tracking-wider">
                    <button @click="sort('done_at')" class="text-xs font-medium text-gray-500 uppercase tracking-wider flex items-center space-x-2">
                      <span>Data</span>
                      <ChevronDownIcon v-if="sortDirection == 'desc' && sortProperty == 'done_at'" class="h-4 w-4" aria-hidden="true" />
                      <ChevronUpIcon v-if="sortDirection == 'asc' && sortProperty == 'done_at'" class="h-4 w-4" aria-hidden="true" />
                    </button>
                  </th>
                  <th scope="col" class="px-4 py-3 text-xs text-left font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                    <button @click="sort('technicians')" class="text-xs font-medium text-gray-500 uppercase tracking-wider flex items-center space-x-2">
                      <span>Equipe</span>
                      <ChevronDownIcon v-if="sortDirection == 'desc' && sortProperty == 'technicians'" class="h-4 w-4" aria-hidden="true" />
                      <ChevronUpIcon v-if="sortDirection == 'asc' && sortProperty == 'technicians'" class="h-4 w-4" aria-hidden="true" />
                    </button>
                  </th>
                  <th scope="col" class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-left w-full">
                    <button @click="sort('services')" class="text-xs font-medium text-gray-500 uppercase tracking-wider inline-flex items-center space-x-2">
                      <span>Serviços</span>
                      <ChevronDownIcon v-if="sortDirection == 'desc' && sortProperty == 'services'" class="h-4 w-4" aria-hidden="true" />
                      <ChevronUpIcon v-if="sortDirection == 'asc' && sortProperty == 'services'" class="h-4 w-4" aria-hidden="true" />
                    </button>
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="(item, index) in serviceOrdersList" :key="index" class="hover:bg-yellow-50 odd:bg-gray-100">
                  <td class="px-4 py-3 whitespace-nowrap text-left">
                    <Link :href="route('air_conditioners.show', item.air_conditioner_id)">
                      <div class="text-lg group">
                        <div class="tabular-nums font-semibold group-hover:text-blue-700">{{ item.identifier }}</div>
                        <div class="text-sm text-slate-500 group-hover:text-slate-700">{{ item.room }}</div>
                      </div>
                    </Link>
                  </td>
                  <td class="px-4 py-3 whitespace-nowrap tabular-nums text-right">
                    <div class="text-sm">
                      <div v-if="item.btu" class="px-3 py-1 mb-2 inline-block font-bold bg-blue-100 rounded-full text-blue-700">{{ item.btu }}</div>
                      <div class="text-xs uppercase mr-2">{{ item.brand }}</div>
                    </div>
                  </td>
                  <td class="px-4 py-3 tabular-nums whitespace-nowrap">
                    <div class="text-sm">
                      <span>{{ item.done_at_formatted }}</span>
                    </div>
                  </td>
                  <td class="px-4 py-4 whitespace-nowrap">
                    <div class="text-sm">
                      <span>{{ item.technicians }}</span>
                    </div>
                  </td>
                  <td class="px-4 py-3 w-full">
                    <div class="text-sm font-semibold text-gray-900 flex items-center space-x-4">
                      <div class="w-10 h-10 text-sm text-slate-600 uppercase font-bold bg-slate-50 border border-slate-200 p-2 flex items-center justify-center rounded-full z-10">
                        <span>{{ item.status_abbr }}</span>
                      </div>
                      <span>{{ item.services }}</span>
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
import CompSelect from '@/Components/Select.vue';
import CompOption from '@/Components/Option.vue';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
  service_orders: Object,
  brands: Object,
  statuses: Object
});

const search = ref('');
const brand = ref(null);
const status = ref(null);
const search_date = ref('');
const technicians = ref('');
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

const serviceOrdersList = computed(() => {
  let filtered;

  filtered = props.service_orders.filter((service_order) => {
    return (
      service_order.identifier.indexOf(search.value) > -1 
      || service_order.room?.toLowerCase().indexOf(search.value.toLowerCase()) > -1 
      || service_order.btu?.indexOf(search.value) > -1
    );
  });

  filtered = filtered.filter((service_order) => {
    return (
      service_order.technicians?.toLowerCase().indexOf(technicians.value.toLowerCase()) > -1 
      || service_order.services?.toLowerCase().indexOf(technicians.value.toLowerCase()) > -1 
    );
  });

  filtered = filtered.filter((service_order) => {
    if(search_date.value == '' ){
      return ( true );
    }

    return (
      service_order.done_at_search === search_date.value
    );
  });

  filtered = filtered.filter((service_order) => {
    if (brand.value != '' && brand.value != null) {
      return service_order.brand_id == brand.value;
    }
    return true;
  });

  filtered = filtered.filter((service_order) => {
    if (status.value != '' && status.value != null) {
      return service_order.status == status.value;
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
