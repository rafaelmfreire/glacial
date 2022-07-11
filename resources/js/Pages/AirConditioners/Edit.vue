<template>
  <AppLayout title="Alterar Ar Condionado">
    <template #header>
      <div class="flex items-center justify-between">
        <div class="space-x-4">
          <LinkButton tag="button" @click="submit()">Alterar</LinkButton>
          <LinkButton tag="a" appearance="cancel" :href="route('air_conditioners.index')">Cancelar</LinkButton>
        </div>
      </div>
    </template>

    <div class="flex flex-col">
      <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
          <div class="shadow overflow-hidden border border-gray-200 sm:rounded-lg">
            <div class="px-4 py-5 shadow border-b border-gray-200 bg-white sm:px-6 sm:rounded-t-lg">
              <h3 class="text-lg leading-6 font-medium text-gray-900">Detalhes do Aparelho</h3>
            </div>

            <div class="bg-white shadow overflow-hidden sm:rounded-b-lg max-w-full">
              <div class="bg-white">
                <div class="px-4 py-6">
                  <div class="block sm:grid grid-cols-4">
                    <CompInput class="col-span-2" name="room" autofocus v-model="form.room" :message="errors.room" @keydown="errors.room = null">Sala</CompInput>
                    
                    <CompSelect name="brand_id" v-model="form.brand_id" :message="errors.brand_id" @change="errors.brand_id = null" >Marca
                      <template #options>
                        <CompOption v-for="brand in brands" :key="brand.id" :value="brand.id.toString()">
                          {{ brand.name.toUpperCase() }}
                        </CompOption>
                      </template>
                    </CompSelect>

                    <CompInput name="btu" autofocus v-model="form.btu" :message="errors.btu" @keydown="errors.btu = null">BTU</CompInput>
                  </div>

                  <div class="block sm:grid grid-cols-2">
                    <CompInput name="identifier" autofocus v-model="form.identifier" :message="errors.identifier" @keydown="errors.identifier = null">Tombamento</CompInput>
                    <CompInput name="cpf" autofocus v-model="form.cpf" :message="errors.cpf" @keydown="errors.cpf = null">CPF</CompInput>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { reactive, ref, nextTick, computed } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Inertia } from '@inertiajs/inertia';
import LinkButton from '@/Components/LinkButton.vue';
import CompInput from '@/Components/Input.vue';
import CompSelect from '@/Components/Select.vue';
import CompOption from '@/Components/Option.vue';

const loading = ref(false);
const props = defineProps({
  brands: Object,
  airConditioner: Object,
  errors: Object,
});

const form = reactive({
  room: props.airConditioner.room,
  btu: props.airConditioner.btu,
  identifier: props.airConditioner.identifier,
  cpf: props.airConditioner.cpf,
  brand_id: props.airConditioner.brand_id,
});

function submit() {
  this.loading = true;
  Inertia.put(route('air_conditioners.update', props.airConditioner.id), this.form, {
    preserveState: (page) => Object.keys(page.props.errors).length,
  });
  this.loading = false;
}
</script>
