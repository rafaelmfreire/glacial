<template>
  <AppLayout title="Ares Condionados">
    <template #header>
      <div class="flex items-center justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Ares Condicionados</h2>
        <Link class="flex items-center gap-2 px-5 py-2 border border-indigo-300 hover:border-indigo-400 text-sm leading-5 font-medium rounded-md text-indigo-700 bg-indigo-50 hover:text-indigo-500 focus:outline-none focus:shadow-outline-indigo focus:border-indigo-100 active:bg-indigo-50 transition duration-150 ease-in-out " 
          :href="route('air_conditioners.create')">
          <PlusCircleIcon class="w-5 h-5" />
          <span>Novo ar</span>
        </Link>
      </div>
    </template>

    <div class="flex flex-col">
      <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
          <div class="shadow overflow-hidden border border-gray-200 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-white">
                <tr>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    <button @click="sort('identifier')" class="text-xs font-medium text-gray-500 uppercase tracking-wider flex items-center space-x-2">
                      <span>Tombamento</span>
                      <ChevronDownIcon v-if="sortDirection == 'desc' && sortProperty == 'identifier'" class="h-4 w-4" aria-hidden="true" />
                      <ChevronUpIcon v-if="sortDirection == 'asc' && sortProperty == 'identifier'" class="h-4 w-4" aria-hidden="true" />
                    </button>
                  </th>
                  <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-right">
                    <button @click="sort('btu')" class="text-xs font-medium text-gray-500 uppercase tracking-wider inline-flex items-center space-x-2">
                      <span>BTU</span>
                      <ChevronDownIcon v-if="sortDirection == 'desc' && sortProperty == 'btu'" class="h-4 w-4" aria-hidden="true" />
                      <ChevronUpIcon v-if="sortDirection == 'asc' && sortProperty == 'btu'" class="h-4 w-4" aria-hidden="true" />
                    </button>
                  </th>
                  <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                    <button @click="sort('brand')" class="text-xs font-medium text-gray-500 uppercase tracking-wider flex items-center space-x-2">
                      <span>Marca</span>
                      <ChevronDownIcon v-if="sortDirection == 'desc' && sortProperty == 'brand'" class="h-4 w-4" aria-hidden="true" />
                      <ChevronUpIcon v-if="sortDirection == 'asc' && sortProperty == 'brand'" class="h-4 w-4" aria-hidden="true" />
                    </button>
                  </th>
                  <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                    <button @click="sort('room')" class="text-xs font-medium text-gray-500 uppercase tracking-wider flex items-center space-x-2">
                      <span>Sala</span>
                      <ChevronDownIcon v-if="sortDirection == 'desc' && sortProperty == 'room'" class="h-4 w-4" aria-hidden="true" />
                      <ChevronUpIcon v-if="sortDirection == 'asc' && sortProperty == 'room'" class="h-4 w-4" aria-hidden="true" />
                    </button>
                  </th>
                  <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                    <button @click="sort('cpf')" class="text-xs font-medium text-gray-500 uppercase tracking-wider inline-flex items-center space-x-2">
                      <span>CPF</span>
                      <ChevronDownIcon v-if="sortDirection == 'desc' && sortProperty == 'cpf'" class="h-4 w-4" aria-hidden="true" />
                      <ChevronUpIcon v-if="sortDirection == 'asc' && sortProperty == 'cpf'" class="h-4 w-4" aria-hidden="true" />
                    </button>
                  </th>
                  <th scope="col" class="relative px-6 py-3">
                    <span class="sr-only">Alterar</span>
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="(item, index) in airConditionersList" :key="index" class="hover:bg-yellow-50 odd:bg-gray-100">
                  <td class="px-6 py-4 whitespace-nowrap tabular-nums text-right">
                    <div class="text-sm font-bold">
                      {{ item.identifier }}
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm tabular-nums text-right space-x-2">
                      {{ item.btu }}
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm tabular-nums space-x-2">
                      {{ item.brand }}
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap w-full">
                    <div class="text-sm tabular-nums">
                      {{ item.room }}
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-right tabular-nums">
                      {{ item.cpf }}
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a class="text-blue-600 hover:text-blue-900 cursor-pointer">Alterar</a>
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
import { Link } from '@inertiajs/inertia-vue3';
import { reactive, ref, nextTick, computed } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { PlusCircleIcon, ChevronDownIcon, ChevronUpIcon } from '@heroicons/vue/outline';
import LinkButton from '@/Components/LinkButton.vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
  airConditioners: Object,
  errors: Object,
});

const form = reactive({
  room: null,
  btu: null,
  identifier: null,
  cpf: null,
});
const sortProperty = ref('room');
const sortDirection = ref('asc');

async function submit() {
  this.loading = true;
  Inertia.post(route('contract_items.store'), this.form, {
    preserveState: (page) => Object.keys(page.props.errors).length,
    onSuccess: (page) => {
      this.showCreateForm = false;
    },
  });
  this.loading = false;
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
  return _.orderBy(
    props.airConditioners, 
    [
      i => !!i[sortProperty.value],
      i => {
        return i[sortProperty.value] ? i[sortProperty.value].toLowerCase() : ''
      }
    ],
    sortDirection.value == 'asc' ? ['asc', 'desc'] : ['desc', 'asc']
  );
});
</script>
