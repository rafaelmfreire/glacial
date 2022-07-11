<template>
  <AppLayout title="Itens do Contrato">
    <template #header>
    </template>

    <div class="flex flex-col">
      <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
          <div class="shadow overflow-hidden border border-gray-200 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-white">
                <tr>
                  <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                    <button @click="sort('number')" class="text-xs font-medium text-gray-500 uppercase tracking-wider flex items-center space-x-2">
                      <span>Número</span>
                      <ChevronDownIcon v-if="sortDirection == 'desc' && sortProperty == 'number'" class="h-4 w-4" aria-hidden="true" />
                      <ChevronUpIcon v-if="sortDirection == 'asc' && sortProperty == 'number'" class="h-4 w-4" aria-hidden="true" />
                    </button>
                  </th>
                  <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-right">
                    <button @click="sort('item_value')" class="text-xs font-medium text-gray-500 uppercase tracking-wider inline-flex items-center space-x-2">
                      <span>Valor</span>
                      <ChevronDownIcon v-if="sortDirection == 'desc' && sortProperty == 'item_value'" class="h-4 w-4" aria-hidden="true" />
                      <ChevronUpIcon v-if="sortDirection == 'asc' && sortProperty == 'item_value'" class="h-4 w-4" aria-hidden="true" />
                    </button>
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    <button @click="sort('title')" class="text-xs font-medium text-gray-500 uppercase tracking-wider flex items-center space-x-2">
                      <span>Item</span>
                      <ChevronDownIcon v-if="sortDirection == 'desc' && sortProperty == 'title'" class="h-4 w-4" aria-hidden="true" />
                      <ChevronUpIcon v-if="sortDirection == 'asc' && sortProperty == 'title'" class="h-4 w-4" aria-hidden="true" />
                    </button>
                  </th>
                  <th scope="col" class="relative px-6 py-3">
                    <span class="sr-only">Alterar</span>
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr class="bg-gray-100 hover:bg-yellow-50">
                  <td v-if="!showCreateForm" class="px-6 py-6 whitespace-nowrap" colspan="4">
                    <div class="text-sm font-medium">
                      <a @click="create()" class="text-blue-400 hover:text-blue-500 flex items-center gap-1 cursor-pointer"> <PlusCircleIcon class="h-5 w-5" /> Novo Item </a>
                    </div>
                  </td>
                  <td v-show="showCreateForm" class="px-6 py-4 whitespace-nowrap" colspan="4">
                    <form @submit.prevent="submit()" class="flex flex-col sm:flex-row items-start sm:items-center gap-4 w-full">
                      <input
                        type="text"
                        id="contract-item-number"
                        :class="{ 'border-2 border-red-400': errors.number }"
                        class="focus:ring-blue-500 w-auto sm:w-1/6 focus:border-blue-500 flex rounded-md border-gray-300"
                        v-model="form.number"
                        ref="number"
                        placeholder="000"
                      />

                      <div class="relative w-1/6">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                          <span class="text-gray-500 sm:text-sm"> R$ </span>
                        </div>
                        <input
                          type="number"
                          step="0.01"
                          id="contract-item-value"
                          :class="{ 'border-2 border-red-400': errors.item_value }"
                          class="focus:ring-blue-500 w-full pl-10 focus:border-blue-500 flex rounded-md border-gray-300"
                          v-model="form.item_value"
                          ref="item_value"
                          placeholder="0,00"
                        />
                      </div>

                      <input
                        type="text"
                        id="contract-item"
                        :class="{ 'border-2 border-red-400': errors.title }"
                        class="focus:ring-blue-500  focus:border-blue-500 flex rounded-md border-gray-300"
                        v-model="form.title"
                        ref="title"
                        placeholder="Item"
                      />
                      <div class="flex items-center space-x-6">
                        <link-button tag="button">Adicionar</link-button>
                        <a
                          @click="
                            showCreateForm = false;
                            loading = false;
                            errors.title = null;
                          "
                          class="text-gray-600 hover:text-red-500 cursor-pointer"
                          >Cancelar</a
                        >
                        <svg v-if="loading" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve" class="w-5 h-5">
                          <path
                            opacity="0.2"
                            fill="#000"
                            d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946 s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634 c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z"
                          />
                          <path fill="#000" d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0 C22.32,8.481,24.301,9.057,26.013,10.047z">
                            <animateTransform attributeType="xml" attributeName="transform" type="rotate" from="0 20 20" to="360 20 20" dur="0.5s" repeatCount="indefinite" />
                          </path>
                        </svg>
                      </div>
                      <span v-if="errors.title" class="text-red-400 font-medium text-sm">{{ errors.title }}</span>
                    </form>
                  </td>
                </tr>
                <tr v-for="(item, index) in contractItemsList" :key="index" class="hover:bg-yellow-50 odd:bg-gray-100">
                  <td v-show="editOffset != index" class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm tabular-nums">
                      {{ item.number }}
                    </div>
                  </td>
                  <td v-show="editOffset != index" class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm tabular-nums text-right space-x-2">
                      {{ new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(item.item_value) }}
                    </div>
                  </td>
                  <td v-show="editOffset != index" class="px-6 py-4 whitespace-nowrap w-full">
                    <div class="text-sm font-bold">
                      {{ item.title.toUpperCase().trim() }}
                    </div>
                  </td>
                  <td v-show="editOffset != index" class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a @click.prevent="showEdit(item, index)" class="text-blue-600 hover:text-blue-900 cursor-pointer">Alterar</a>
                  </td>

                  <td v-show="editOffset == index" class="px-6 py-4 whitespace-nowrap" colspan="4">
                    <form @submit.prevent="update()" class="flex items-center gap-2">
                      <input type="text" :id="'contract-item-number-' + index" :class="{ 'border-2 border-red-400': errors.number }" class="focus:ring-blue-500 w-1/6 focus:border-blue-500 flex rounded-md border-gray-300" v-model="form.number" ref="number" placeholder="000" />
                      <div class="relative w-auto">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                          <span class="text-gray-500 sm:text-sm"> R$ </span>
                        </div>
                        <input type="number" step="0.01" :id="'contract-item-value-' + index" :class="{ 'border-2 border-red-400': errors.item_value }" class="focus:ring-blue-500 w-full pl-10 focus:border-blue-500 block rounded-md border-gray-300" v-model="form.item_value" ref="item_value" placeholder="0,00" />
                      </div>
                      <input type="text" :id="'contract-item-' + index" class="focus:ring-blue-500 focus:border-blue-500 flex w-full rounded-md sm:text-sm border-gray-300" v-model="form.title" />
                      <link-button tag="button">Atualizar</link-button>
                      <a @click="cancelEditing" class="cursor-pointer">Cancelar</a>
                    </form>
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
import { reactive, ref, nextTick, computed } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { PlusCircleIcon, ChevronDownIcon, ChevronUpIcon } from '@heroicons/vue/outline';
import LinkButton from '@/Components/LinkButton.vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
  contractItems: Object,
  errors: Object,
});

const form = reactive({
  title: null,
  number: null,
  item_value: null,
});
const showCreateForm = ref(false);
const loading = ref(false);
const sortProperty = ref('number');
const sortDirection = ref('asc');
const editOffset = ref(-1);
const edit = {};

async function create() {
  this.showCreateForm = true;
  this.form.title = null;
  this.form.number = null;
  this.form.item_value = null;
  this.editOffset = -1;
  await nextTick();
  document.getElementById('contract-item-number').focus();
}

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

function update() {
  this.loading = true;
  this.form._method = 'PUT';
  Inertia.post('/contract_items/' + this.edit.id, this.form, {
    preserveState: (page) => Object.keys(page.props.errors).length,
    onSuccess: (page) => {
      editOffset.value = -1;
      edit.value = {};
      form.title = null;
    },
  });
  this.loading = false;
}

function cancelEditing() {
  editOffset.value = -1;
  edit.value = {};
  form.title = null;
}

async function showEdit(item, index) {
  this.showCreateForm = false;
  console.log(item);
  this.form = Object.assign({}, item);
  this.editOffset = index;
  this.edit = this.contractItemsList[index];

  await nextTick(
    function () {
      document.getElementById('contract-item-number-' + this.editOffset).focus();
    }.bind(this)
  );
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

const contractItemsList = computed(() => {
  if(sortProperty.value == 'item_value') {
    return _.orderBy(props.contractItems, [(contractItem) => parseInt(contractItem[sortProperty.value])], sortDirection.value);
  }

  return _.orderBy(props.contractItems, [(contractItem) => contractItem[sortProperty.value].toString().toLowerCase()], sortDirection.value);
});
</script>
