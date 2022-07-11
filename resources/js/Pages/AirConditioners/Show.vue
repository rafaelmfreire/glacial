<template>
  <AppLayout :title="airConditioner.room" :smallTitle="false">
    <template #header>
      <div class="flex items-center justify-between">
        <LinkButton tag="a" appearance="edit" :href="route('air_conditioners.edit', airConditioner.id)">Alterar</LinkButton>
      </div>
    </template>

    <div class="flex flex-col">
      <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle flex flex-col lg:flex-row gap-4 min-w-full sm:px-6 lg:px-8">
          <div class="lg:col-span-2 flex-1 bg-white shadow overflow-hidden sm:rounded-lg">
            <div class=""></div>
          </div>
          <div class="bg-white shadow overflow-hidden sm:rounded-lg min-w-[295px]">
            <div class="px-4 py-5 sm:px-6">
              <dl>
                <div class="py-5">
                  <div class="bg-slate-100 p-2 max-w-[250px]">
                    <dt class="text-sm text-gray-500 sr-only">Tombamento</dt>
                    <dd class="text-2xl rounded-lg text-center border border-blue-800 bg-slate-100 py-4 px-2 font-semibold">
                      <span v-if="airConditioner.identifier" class="font-mono flex items-center justify-between text-slate-500 tracking-wider after:content-[''] after:w-5 after:h-5 after:rounded-full after:bg-gray-500 after:border-[6px] after:border-gray-300 after:inline-block before:content-[''] before:w-5 before:h-5 before:rounded-full before:bg-gray-500 before:border-[6px] before:border-gray-300 before:inline-block">{{ airConditioner.identifier }}</span>
                      <span v-else class="font-mono text-sm flex items-center justify-between text-red-400 tracking-wider after:content-[''] after:w-5 after:h-5 after:rounded-full after:bg-gray-500 after:border-[6px] after:border-gray-300 after:inline-block before:content-[''] before:w-5 before:h-5 before:rounded-full before:bg-gray-500 before:border-[6px] before:border-gray-300 before:inline-block">Sem tombamento</span>
                    </dd>
                  </div>
                </div>
                <div>
                  <dt class="text-sm text-gray-500 sr-only">Marca e BTU</dt>
                  <dd class="mt-1 text-gray-900 sm:mt-0 space-x-2"><span class="font-bold uppercase">{{ airConditioner.brand }}</span><span v-if="airConditioner.btu" class="px-3 py-1 font-bold bg-blue-100 rounded-full text-blue-700">{{ airConditioner.btu }} <label class="text-xs font-normal">BTUs</label></span></dd>
                </div>
                <div v-if="airConditioner.cpf" class="py-5 flex items-center sm:gap-4">
                  <dt class="text-sm text-gray-400">CPF</dt>
                  <dd class="mt-1 text-sm text-gray-900 sm:mt-0">{{ airConditioner.cpf }}</dd>
                </div>
              </dl>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Inertia } from '@inertiajs/inertia';
import LinkButton from '@/Components/LinkButton.vue';

const props = defineProps({
  airConditioner: Object,
});
</script>
