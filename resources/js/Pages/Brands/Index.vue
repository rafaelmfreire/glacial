<template>
  <AppLayout title="Marcas">
    <template #header>
      <div class="flex items-center justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Marcas</h2>
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
                    <button class="text-xs font-medium text-gray-500 uppercase tracking-wider flex items-center">
                      Marca
                      <!-- <ChevronDownIcon v-if="sortDirection == 'desc' && sortProperty == 'name'" class="h-5 w-5" aria-hidden="true" /> -->
                      <!-- <ChevronUpIcon v-if="sortDirection == 'asc' && sortProperty == 'name'" class="h-5 w-5" aria-hidden="true" /> -->
                    </button>
                  </th>
                  <th scope="col" class="relative px-6 py-3">
                    <span class="sr-only">Alterar</span>
                  </th>
                  <th></th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr class="bg-gray-100 hover:bg-yellow-50">
                  <td v-if="!showCreateForm" class="px-6 py-4 whitespace-nowrap" colspan="2">
                    <div class="text-sm font-medium">
                      <!-- <svg v-if="loading" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve" class="w-5 h-5">
                        <path
                          opacity="0.2"
                          fill="#000"
                          d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946 s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634 c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z"
                        />
                        <path fill="#000" d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0 C22.32,8.481,24.301,9.057,26.013,10.047z">
                          <animateTransform attributeType="xml" attributeName="transform" type="rotate" from="0 20 20" to="360 20 20" dur="0.5s" repeatCount="indefinite" />
                        </path>
                      </svg> -->
                      <a @click="createBrand()" class="text-blue-400 flex items-center gap-1 cursor-pointer"> <PlusCircleIcon class="h-5 w-5" /> Nova Marca </a>
                      <!-- <a class="text-blue-400 flex items-center gap-1 cursor-pointer"> <PlusCircleIcon class="h-5 w-5" /> Nova Marca </a> -->
                    </div>
                  </td>
                  <td v-show="showCreateForm" class="px-6 py-4 whitespace-nowrap" colspan="2">
                    <!-- <form @submit.prevent="submit" class="flex items-center gap-2"> -->
                    <form class="flex items-center gap-2">
                      <div class="flex w-full rounded-md shadow-sm space-x-4">
                        <input type="text" id="brand-item" class="focus:ring-indigo-500 focus:border-indigo-500 flex w-1/4 rounded-md sm:text-sm border-gray-300" v-model="form.name" ref="name" placeholder="Marca" />
                      </div>
                      <link-button tag="button">Adicionar</link-button>
                      <a @click="showCreateForm = false" class="cursor-pointer">Cancelar</a>
                    </form>
                  </td>
                  <td></td>
                </tr>
                <tr v-for="(item, index) in brands" :key="index" class="hover:bg-yellow-50 odd:bg-gray-100">
                  <td v-show="editOffset != index" class="px-6 py-4 whitespace-nowrap" colspan="2">
                    <div class="text-sm font-bold">
                      {{ item.name.toUpperCase().trim() }}
                    </div>
                  </td>
                  <td v-show="editOffset != index" class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a @click.prevent="showEdit(item, index)" class="text-indigo-600 hover:text-indigo-900 cursor-pointer">Alterar</a>
                  </td>

                  <td v-show="editOffset == index" class="px-6 py-4 whitespace-nowrap" colspan="3">
                    <form @submit.prevent="update" class="flex items-center gap-2">
                      <input type="text" :id="'brand-item-' + index" class="focus:ring-indigo-500 focus:border-indigo-500 flex w-1/4 rounded-md sm:text-sm border-gray-300" v-model="form.name" />
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
import { reactive, ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { PlusCircleIcon } from '@heroicons/vue/outline';

defineProps({
  brands: Object,
});

const form = reactive({
  model: {},
});
const showCreateForm = ref(false);

function createBrand() {
  this.showCreateForm = true;
  this.editOffset = -1;
  this.form.brand = null;
  this.$nextTick(function () {
    // this.$refs.brand.focus();
    document.getElementById('brand-item').focus();
  });
}
</script>
