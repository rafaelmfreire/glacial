<template>
  <AppLayout title="Marcas">
    <template #header></template>

    <div class="flex flex-col">
      <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
          <div class="shadow overflow-hidden border border-gray-200 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-white">
                <tr>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    <button @click="sort('name')" class="text-xs font-medium text-gray-500 uppercase tracking-wider flex items-center space-x-2">
                      <span>Marca</span>
                      <ChevronUpIcon v-if="sortDirection == 'desc' && sortProperty == 'name'" class="h-4 w-4" aria-hidden="true" />
                      <ChevronDownIcon v-if="sortDirection == 'asc' && sortProperty == 'name'" class="h-4 w-4" aria-hidden="true" />
                    </button>
                  </th>
                  <th scope="col" class="relative px-6 py-3">
                    <span class="sr-only">Alterar</span>
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-if="$page.props.canManageBrands" class="bg-gray-100 hover:bg-yellow-50">
                  <td v-if="!showCreateForm" class="px-6 py-6 whitespace-nowrap" colspan="2">
                    <div class="text-sm font-medium">
                      <a @click="createBrand()" class="text-blue-400 hover:text-blue-500 flex items-center gap-1 cursor-pointer"> <PlusCircleIcon class="h-5 w-5" /> Nova Marca </a>
                    </div>
                  </td>
                  <td v-show="showCreateForm" class="px-6 py-4 whitespace-nowrap" colspan="2">
                    <form @submit.prevent="submit()" class="flex flex-col sm:flex-row items-start sm:items-center gap-4 w-full">
                      <input
                        type="text"
                        id="brand-item"
                        :class="{ 'border-2 border-red-400': errors.name }"
                        class="focus:ring-blue-500 w-full md:w-1/2 lg:w-1/3 focus:border-blue-500 flex rounded-md border-gray-300"
                        v-model="form.name"
                        ref="name"
                        placeholder="Marca"
                      />
                      <div class="flex items-center space-x-6">
                        <link-button tag="button">Adicionar</link-button>
                        <a
                          @click="
                            showCreateForm = false;
                            loading = false;
                            errors.name = null;
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
                      <span v-if="errors.name" class="text-red-400 font-medium text-sm">{{ errors.name }}</span>
                    </form>
                  </td>
                </tr>
                <tr v-for="(item, index) in brandsList" :key="index" class="hover:bg-yellow-50 odd:bg-gray-100">
                  <td v-show="editOffset != index" class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-bold">
                      {{ item.name.toUpperCase().trim() }}
                    </div>
                  </td>
                  <td v-show="editOffset != index" class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a v-if="$page.props.canManageBrands" @click.prevent="showEdit(item, index)" class="text-blue-600 hover:text-blue-900 cursor-pointer">Alterar</a>
                  </td>

                  <td v-show="editOffset == index" class="px-6 py-4 whitespace-nowrap" colspan="3">
                    <form @submit.prevent="update()" class="flex items-center gap-2">
                      <input type="text" :id="'brand-item-' + index" class="focus:ring-blue-500 focus:border-blue-500 flex w-1/4 rounded-md sm:text-sm border-gray-300" v-model="form.name" />
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
  brands: Object,
  errors: Object,
});

const form = reactive({
  id: null,
  name: null,
});
const showCreateForm = ref(false);
const loading = ref(false);
const sortProperty = ref('name');
const sortDirection = ref('asc');
const editOffset = ref(-1);
const editBrand = {};

async function createBrand() {
  showCreateForm.value = true;
  form.name = null;
  form.id = null;
  editOffset.value = -1;
  await nextTick();
  document.getElementById('brand-item').focus();
}

async function submit() {
  Inertia.post(route('brands.store'), form, {
    preserveState: (page) => Object.keys(page.props.errors).length,
    onSuccess: (page) => {
      showCreateForm.value = false;
    },
  });
}

function update() {
  Inertia.put('/brands/' + editBrand.id, form, {
    preserveState: (page) => Object.keys(page.props.errors).length,
    onSuccess: (page) => {
      editOffset.value = -1;
      editBrand.value = {};
      form.name = null;
      form.id = null;
    }
  });
}

function cancelEditing() {
  editOffset.value = -1;
  editBrand.value = {};
  form.name = null;
  form.id = null;
}

async function showEdit(item, index) {
  showCreateForm.value = false;
  form.name = item.name;
  form.id = item.id;
  editOffset.value = index;
  editBrand.id = brandsList.value[index].id;
  editBrand.name = brandsList.value[index].name;

  await nextTick(
    function () {
      document.getElementById('brand-item-' + editOffset.value).focus();
    }.bind(this)
  );
}

function sort(property) {
  sortProperty.value = property;
  if (sortDirection.value == 'asc') {
    sortDirection.value = 'desc';
  } else {
    sortDirection.value = 'asc';
  }
}

const brandsList = computed(() => {
  return _.orderBy(props.brands, [(brand) => brand[sortProperty.value].toString().toLowerCase()], sortDirection.value);
});
</script>
