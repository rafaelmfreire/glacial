<template>
  <AppLayout :title="airConditioner.room" :smallTitle="false">
    <template #header>
      <div class="flex items-center justify-between">
        <LinkButton tag="a" appearance="edit" :href="route('air_conditioners.edit', airConditioner.id)">Alterar</LinkButton>
      </div>
    </template>

    <div class="flex flex-col">
      <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle flex flex-col-reverse lg:flex-row gap-4 min-w-full sm:px-6 lg:px-8">
          <div class="lg:col-span-2 flex-1 bg-white shadow overflow-hidden sm:rounded-lg">
            <TabsWrapper>

              <Tab title="Chamados">
                <div class="grid grid-cols-1 gap-4">
                  <CompTextarea @keypress.enter.exact.prevent="submitTicket()" :withPadding="false" name="problem" rows="3" v-model="formTicket.problem" :message="errors.problem" @keydown="errors.problem = null">Descreva o problema</CompTextarea>
                  <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <CompInput @keypress.enter="submitTicket()" :withPadding="false" name="informed_by" v-model="formTicket.informed_by" :message="errors.informed_by" @keydown="errors.informed_by = null">Informado por</CompInput>
                    <CompInput @keypress.enter="submitTicket()" :withPadding="false" type="date" name="opened_at" v-model="formTicket.opened_at" :message="errors.opened_at" @keydown="errors.opened_at = null">Aberto em</CompInput>
                  </div>
                  <div>
                    <LinkButton tag="button" @click="submitTicket()">Adicionar</LinkButton>
                  </div>
                </div>

                <div class="mt-8">
                  <h2 class="font-medium text-gray-700 text-xl pt-4 mb-4">Histórico</h2>

                  <ul v-if="airConditioner.tickets.length > 0" class="mt-6">
                    <li v-for="ticket in airConditioner.tickets" :key="ticket.id" class="flex items-start relative group">
                      <div class="absolute right-full top-[2.5rem] bottom-0 w-px bg-slate-200 block -mr-5"></div>
                      <SpeakerphoneIcon class="w-10 h-10 text-slate-300 bg-slate-50 border border-slate-200 p-2 mr-5 rounded-full z-10" />
                      <div>
                        <div class="flex items-center space-x-3 mb-2 mt-1">
                          <h3 class="font-bold text-lg">
                            {{ ticket.informed_by }}
                          </h3>
                          <time class="font-medium text-xs text-blue-700 bg-blue-50 ml-2 px-2 py-1 inline-flex items-center rounded-full">
                            <CalendarIcon class="h-4 w-4 mr-1 text-blue-400/60 inline"/>
                            <span>{{ ticket.date_diff }}</span>
                          </time>
                          <time class="text-xs text-white group-hover:text-gray-400">{{ ticket.opened_date }}</time>
                        </div>
                        <p class="text-slate-500 text-sm mb-12 whitespace-pre-line">{{ ticket.problem }}</p>
                      </div>
                      <div class="text-slate-100 group-hover:text-gray-400 absolute left-full -ml-6">
                        <BtnDelete :id="ticket.id" :route="`/tickets/${ticket.id}`">
                          <TrashIcon class="w-8 h-8 cursor-pointer p-1 rounded-lg hover:text-red-400" />
                        </BtnDelete>
                      </div>
                    </li>
                  </ul>

                  <div v-else class="text-slate-500 text-sm">Ainda não foram cadastrados Chamados para este aparelho.</div>

                </div>
              </Tab>

              <Tab title="Ordens de Serviço">
                <div class="grid grid-cols-1 gap-4">
                  <CompTextarea @keypress.enter.exact.prevent="submitServiceOrder()" :withPadding="false" name="services" rows="3" v-model="formServiceOrder.services" :message="errors.services" @keydown="errors.services = null">Descreva os serviços</CompTextarea>
                  <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <CompInput @keypress.enter="submitServiceOrder()" :withPadding="false" name="technicians" v-model="formServiceOrder.technicians" :message="errors.technicians" @keydown="errors.technicians = null">Equipe</CompInput>
                    <CompSelect :withPadding="false" name="status" v-model="formServiceOrder.status" :message="errors.status" @change="errors.status = null" >Status
                      <template #options>
                        <CompOption v-for="(index, item) in statuses" :key="index.toString()" :value="index.toString()">
                          {{ item.toUpperCase() }}
                        </CompOption>
                      </template>
                    </CompSelect>
                  </div>
                  <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <CompInput @keypress.enter="submitServiceOrder()" :withPadding="false" type="date" name="done_at" v-model="formServiceOrder.done_at" :message="errors.done_at" @keydown="errors.done_at = null">Realizado em</CompInput>
                    <CompInput @keypress.enter="submitServiceOrder()" :withPadding="false" type="time" name="done_at_time" v-model="formServiceOrder.done_at_time" :message="errors.done_at_time" @keydown="errors.done_at_time = null">Horário</CompInput>
                  </div>
                  <div>
                    <LinkButton tag="button" @click="submitServiceOrder()">Adicionar</LinkButton>
                  </div>
                </div>

                <div class="mt-8">
                  <h2 class="font-medium text-gray-700 text-xl pt-4 mb-4">Histórico</h2>

                  <ul v-if="airConditioner.serviceOrders.length > 0" class="mt-6">
                    <li v-for="serviceOrder in airConditioner.serviceOrders" :key="serviceOrder.id" class="flex items-start relative group">
                      <div class="absolute right-full top-[2.5rem] bottom-0 w-px bg-slate-200 block -mr-5"></div>
                      <div class="w-10 h-10 text-sm text-slate-400 uppercase font-bold bg-slate-50 border border-slate-200 p-2 mr-5 flex items-center justify-center rounded-full z-10">{{ serviceOrder.status_abbr }}</div>
                      <div>
                        <div class="flex items-center space-x-3 mb-2 mt-1">
                          <h3 class="font-bold text-lg">
                            {{ serviceOrder.technicians }}
                          </h3>
                          <time class="font-medium text-xs text-blue-700 bg-blue-50 ml-2 px-2 py-1 inline-flex items-center rounded-full">
                            <CalendarIcon class="h-4 w-4 mr-1 text-blue-400/60 inline"/>
                            <span>{{ serviceOrder.date_diff }}</span>
                          </time>
                          <time class="text-xs text-white group-hover:text-gray-400">{{ serviceOrder.done_date }}</time>
                        </div>
                        <p class="text-slate-500 text-sm mb-12 whitespace-pre-line">{{ serviceOrder.services }}</p>
                      </div>
                      <div class="text-slate-100 group-hover:text-gray-400 absolute left-full -ml-6">
                        <BtnDelete :id="serviceOrder.id" :route="`/service_orders/${serviceOrder.id}`">
                          <TrashIcon class="w-8 h-8 cursor-pointer p-1 rounded-lg hover:text-red-400" />
                        </BtnDelete>
                      </div>
                    </li>
                  </ul>
                  <div v-else class="text-slate-500 text-sm">Ainda não foram cadastradas Ordens de Serviço para este aparelho.</div>
                </div>
              </Tab>

              <Tab title="Orçamentos">
                <div class="grid grid-cols-1 gap-4">
                  <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <CompInput @keypress.enter="submitQuote()" :withPadding="false" name="number" v-model="formQuote.number" :message="errors.number" @keydown="errors.number = null">Orçamento Nº</CompInput>
                    <CompInput @keypress.enter="submitQuote()" :withPadding="false" type="date" name="date" v-model="formQuote.date" :message="errors.date" @keydown="errors.date = null">Data do Orçamento</CompInput>
                  </div>
                  <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                    <CompInput @keypress.enter="submitQuote()" :withPadding="false" name="contract_item_id" v-model="formQuote.contract_item_id" :message="errors.contract_item_id" @keydown="errors.contract_item_id = null">Item</CompInput>
                    <CompInput @keypress.enter="submitQuote()" :withPadding="false" name="quantity" :min="1" type="number" v-model="formQuote.quantity" :message="errors.quantity" @keydown="errors.quantity = null">Quantidade</CompInput>
                    <CompInput @keypress.enter="submitQuote()" :withPadding="false" type="date" name="service_date" v-model="formQuote.service_date" :message="errors.service_date" @keydown="errors.service_date = null">Data do Serviço</CompInput>
                  </div>
                  <div>
                    <LinkButton tag="button" @click="submitQuote()">Adicionar</LinkButton>
                  </div>
                </div>

                <div class="mt-8">
                  <h2 class="font-medium text-gray-700 text-xl pt-4 mb-4">Histórico</h2>
                  <div v-if="airConditioner.quotes.length > 0" class="divide-y">
                    <div v-for="quote in airConditioner.quotes" :key="quote.id" class="space-y-2 py-10 first:pt-6 last:pb-0">
                      <div class="flex items-center justify-between">
                        <h3>
                          Orçamento Nº: 
                          <span class="font-bold text-blue-700 hover:text-blue-600 ml-2">
                            <Link :href="route('reports.quotes.quote_items', quote.id)">
                              {{ quote.number }}
                            </Link>
                          </span>
                        </h3>
                        <div class="flex items-center">
                          <div class="text-sm">
                            Total: 
                            <span class="font-bold">
                              {{ new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(quote.total) }}
                            </span>
                          </div>
                          <time class="font-medium text-xs text-blue-700 bg-blue-50 ml-2 px-2 py-1 inline-flex items-center rounded-full">
                            <CalendarIcon class="h-4 w-4 mr-1 text-blue-400/60 inline"/>
                            <span>{{ quote.date_formatted }}</span>
                          </time>
                        </div>
                      </div>
                      <div class="shadow overflow-x-auto border border-gray-200 sm:rounded-lg mt-2">
                        <table class="min-w-full divide-y divide-gray-200">
                          <thead class="bg-white">
                            <tr class="divide-x">

                              <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                              </th>
                              <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <span>Item</span>
                              </th>
                              <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <span>QTD</span>
                              </th>
                              <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[115px]">
                                <span>Valor</span>
                              </th>
                              <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[115px]">
                                <span>Total</span>
                              </th>
                              <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-full">
                                <span>Data</span>
                              </th>
                              <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-full">
                                <span>Descrição</span>
                              </th>
                            </tr>
                          </thead>
                          <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="quoteItem in resort(quote.quote_items, 'contract_item.number', 'asc')" :key="quoteItem.id" class="hover:bg-yellow-50 odd:bg-gray-100 divide-x group">
                              <td class="text-slate-200 group">
                                <div class="group-hover:text-slate-500">
                                  <BtnDelete :id="quoteItem.id" :route="`/quotes/${quote.id}/quote_items/${quoteItem.id}`">
                                    <template #title>Apagar Item nº {{ quoteItem.contract_item.number }}</template>
                                    <TrashIcon class="w-8 h-8 cursor-pointer p-1 rounded-lg hover:text-red-400" />
                                  </BtnDelete>
                                </div>
                              </td>
                              <td class="px-4 py-2 whitespace-nowrap tabular-nums text-right">
                                <div class="text-sm text-slate-800">
                                  {{ quoteItem.contract_item.number }}
                                </div>
                              </td>
                              <td class="px-4 py-2 whitespace-nowrap tabular-nums text-right">
                                <div class="text-sm text-slate-800">
                                  {{ quoteItem.quantity }}
                                </div>
                              </td>
                              <td class="px-4 py-2 whitespace-nowrap tabular-nums text-right">
                                <div class="text-sm text-slate-800 tracking-tight">
                                  {{ new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(quoteItem.contract_item.item_value) }}
                                </div>
                              </td>
                              <td class="px-4 py-2 whitespace-nowrap tabular-nums text-right">
                                <div class="text-sm text-slate-800 font-semibold tracking-tight">
                                  {{ new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(quoteItem.contract_item.item_value * quoteItem.quantity) }}
                                </div>
                              </td>
                              <td class="px-4 py-2 whitespace-nowrap tabular-nums text-right">
                                <div class="text-sm text-slate-800">
                                  {{ quoteItem.service_date_formatted }}
                                </div>
                              </td>
                              <td class="px-4 py-2 whitespace-nowrap tabular-nums">
                                <div class="text-sm text-slate-800">
                                  {{ quoteItem.contract_item.title }}
                                </div>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div v-else class="text-slate-500 text-sm">Ainda não foram cadastrados Orçamentos para este aparelho.</div>
                </div>
              </Tab>

              <Tab title="Requisições">
                <div class="grid grid-cols-1 gap-4">
                  <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <CompInput @keypress.enter="submitRequisition()" :withPadding="false" name="number" v-model="formRequisition.number" :message="errors.number" @keydown="errors.number = null">Requisição Nº</CompInput>
                    <CompInput @keypress.enter="submitRequisition()" :withPadding="false" type="number" name="year" v-model="formRequisition.year" :message="errors.year" @keydown="errors.year = null">Ano</CompInput>
                  </div>
                  <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                    <CompInput @keypress.enter="submitRequisition()" :withPadding="false" name="contract_item_id" v-model="formRequisition.contract_item_id" :message="errors.contract_item_id" @keydown="errors.contract_item_id = null">Item</CompInput>
                    <CompInput @keypress.enter="submitRequisition()" :withPadding="false" name="quantity" type="number" :min="1" v-model="formRequisition.quantity" :message="errors.quantity" @keydown="errors.quantity = null">Quantidade</CompInput>
                    <CompInput @keypress.enter="submitRequisition()" :withPadding="false" name="quote_number" v-model="formRequisition.quote_number" :message="errors.quote_number" @keydown="errors.quote_number = null">Nº do orçamento</CompInput>
                  </div>
                  <div>
                    <LinkButton tag="button" @click="submitRequisition()">Adicionar</LinkButton>
                  </div>
                </div>

                <div class="mt-8">
                  <h2 class="font-medium text-gray-700 text-xl pt-4 mb-4">Histórico</h2>
                  <div v-if="airConditioner.requisitions.length > 0" class="divide-y">
                    <div v-for="requisition in airConditioner.requisitions" :key="requisition.id" class="space-y-2 py-10 first:pt-6 last:pb-0">
                      <div class="flex items-center justify-between">
                        <h3>
                          Requisição Nº: 
                          <span class="font-bold text-blue-700 hover:text-blue-600 ml-2">
                            <Link :href="route('reports.requisitions.requisition_items', requisition.id)">
                            {{ requisition.number }}/{{ requisition.year }}
                            </Link>
                          </span>
                        </h3>
                        <div class="flex items-center">
                          <div class="text-sm">
                            Total: 
                            <span class="font-bold">
                              {{ new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(requisition.total) }}
                            </span>
                          </div>
                        </div>
                      </div>
                      <div class="shadow overflow-x-auto border border-gray-200 sm:rounded-lg mt-2">
                        <table class="min-w-full divide-y divide-gray-200">
                          <thead class="bg-white">
                            <tr class="divide-x">

                              <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                              </th>
                              <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <span>Item</span>
                              </th>
                              <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <span>QTD</span>
                              </th>
                              <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[115px]">
                                <span>Valor</span>
                              </th>
                              <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[115px]">
                                <span>Total</span>
                              </th>
                              <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <span>Orç.</span>
                              </th>
                              <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-full">
                                <span>Descrição</span>
                              </th>
                            </tr>
                          </thead>
                          <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="requisitionItem in resort(requisition.requisition_items, 'contract_item.number', 'asc')" :key="requisitionItem.id" class="hover:bg-yellow-50 odd:bg-gray-100 divide-x group">
                              <td class="text-slate-200 group">
                                <div class="group-hover:text-slate-500">
                                  <BtnDelete :id="requisitionItem.id" :route="`/requisitions/${requisition.id}/requisition_items/${requisitionItem.id}`">
                                    <template #title>Apagar Item nº {{ requisitionItem.contract_item.number }}</template>
                                    <TrashIcon class="w-8 h-8 cursor-pointer p-1 rounded-lg hover:text-red-400" />
                                  </BtnDelete>
                                </div>
                              </td>
                              <td class="px-4 py-2 whitespace-nowrap tabular-nums text-right">
                                <div class="text-sm text-slate-800">
                                  {{ requisitionItem.contract_item.number }}
                                </div>
                              </td>
                              <td class="px-4 py-2 whitespace-nowrap tabular-nums text-right">
                                <div class="text-sm text-slate-800">
                                  {{ requisitionItem.quantity }}
                                </div>
                              </td>
                              <td class="px-4 py-2 whitespace-nowrap tabular-nums text-right">
                                <div class="text-sm text-slate-800 tracking-tight">
                                  {{ new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(requisitionItem.contract_item.item_value) }}
                                </div>
                              </td>
                              <td class="px-4 py-2 whitespace-nowrap tabular-nums text-right">
                                <div class="text-sm text-slate-800 font-semibold tracking-tight">
                                  {{ new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(requisitionItem.contract_item.item_value * requisitionItem.quantity) }}
                                </div>
                              </td>
                              <td class="px-4 py-2 whitespace-nowrap tabular-nums text-right">
                                <div class="text-sm text-slate-800">
                                  {{ requisitionItem.quote.number }}
                                </div>
                              </td>
                              <td class="px-4 py-2 whitespace-nowrap tabular-nums">
                                <div class="text-sm text-slate-800">
                                  {{ requisitionItem.contract_item.title }}
                                </div>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div v-else class="text-slate-500 text-sm">Ainda não foram cadastradas Requisições para este aparelho.</div>
                </div>
              </Tab>

            </TabsWrapper>
          </div>

          <!-- Panel Right -->
          <div class="bg-white shadow overflow-hidden sm:rounded-lg min-w-[295px]">
            <div class="px-4 py-5 sm:px-6">
              <dl>
                <div class="py-5">
                  <div class="bg-slate-100 p-2 max-w-[250px] border border-gray-300">
                    <dt class="text-sm text-gray-500 sr-only">Tombamento</dt>
                    <dd class="text-2xl rounded-lg text-center border border-blue-800 bg-gradient-to-tr from-slate-200 to-slate-200 via-slate-50 py-4 px-2 font-semibold">
                      <span v-if="airConditioner.identifier" class="font-mono flex items-center justify-between text-slate-500 tracking-wider after:content-[''] after:w-5 after:h-5 after:rounded-full after:bg-gray-500 after:border-[6px] after:border-gray-300 after:inline-block before:content-[''] before:w-5 before:h-5 before:rounded-full before:bg-gray-500 before:border-[6px] before:border-gray-300 before:inline-block">{{ airConditioner.identifier }}</span>
                      <span v-else class="font-mono text-sm flex items-center justify-between text-red-400 tracking-wider after:content-[''] after:w-5 after:h-5 after:rounded-full after:bg-gray-500 after:border-[6px] after:border-gray-300 after:inline-block before:content-[''] before:w-5 before:h-5 before:rounded-full before:bg-gray-500 before:border-[6px] before:border-gray-300 before:inline-block">Sem tombamento</span>
                    </dd>
                  </div>
                </div>
                <div>
                  <dt class="text-sm text-gray-500 sr-only">Marca e BTU</dt>
                  <dd class="mt-1 text-gray-900 sm:mt-0 space-x-2"><span class="font-bold uppercase">{{ airConditioner.brand }}</span><span v-if="airConditioner.btu" class="px-3 py-1 font-bold bg-blue-100 rounded-full text-blue-700">{{ airConditioner.btu }} <label class="text-xs font-normal">BTUs</label></span></dd>
                </div>
                <div v-if="airConditioner.cpf" class="py-5 flex items-center gap-4">
                  <dt class="text-sm text-gray-400">CPF</dt>
                  <dd class="text-sm text-gray-900 mt-0">{{ airConditioner.cpf }}</dd>
                </div>

                <div v-if="airConditioner.observation" class="py-3 flex flex-col items-start gap-2">
                  <dt class="text-sm text-gray-400">Observações</dt>
                  <dd class="text-sm text-gray-900 mt-0 whitespace-pre-wrap">{{ airConditioner.observation }}</dd>
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
import CompInput from '@/Components/Input.vue';
import CompSelect from '@/Components/Select.vue';
import CompOption from '@/Components/Option.vue';
import CompTextarea from '@/Components/Textarea.vue';
import BtnDelete from '@/Components/Delete.vue';
import TabsWrapper from '@/Components/TabsWrapper.vue';
import Tab from '@/Components/Tab.vue';
import { CalendarIcon, SpeakerphoneIcon, DocumentTextIcon, TrashIcon  } from '@heroicons/vue/outline';
import { reactive, computed, onMounted, watch } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

const formTicket = reactive({
  problem: null,
  opened_at: (new Date().getFullYear()+'-'+(new Date().getMonth() + 1).toString().padStart(2, '0')+'-'+new Date().getDate()),
  informed_by: props.user.name,
  identifier: props.airConditioner.identifier,
  page: 'airConditioner'
});

const formServiceOrder = reactive({
  services: null,
  done_at: (new Date().getFullYear()+'-'+(new Date().getMonth() + 1).toString().padStart(2, '0')+'-'+new Date().getDate()),
  done_at_time: '00:00',
  technicians: '',
  status: null,
  identifier: props.airConditioner.identifier,
  page: 'airConditioner'
});

const formQuote = reactive({
  number: null,
  date: (new Date().getFullYear()+'-'+(new Date().getMonth() + 1).toString().padStart(2, '0')+'-'+new Date().getDate()),
  contract_item_id: '000',
  quantity: 1,
  service_date: (new Date().getFullYear()+'-'+(new Date().getMonth() + 1).toString().padStart(2, '0')+'-'+new Date().getDate()),
  identifier: props.airConditioner.identifier,
  page: 'airConditioner'
});

const formRequisition = reactive({
  number: null,
  year: new Date().getFullYear(),
  contract_item_id: '000',
  quantity: 1,
  quote_number: null,
  identifier: props.airConditioner.identifier,
  page: 'airConditioner'
});

watch(formQuote, async (newNumber, oldNumber) => {
  if(parseInt(oldNumber.contract_item_id, 10) != 0 && !isNaN(parseInt(oldNumber.contract_item_id, 10))) {
    formQuote.contract_item_id = parseInt(oldNumber.contract_item_id, 10).toString().padStart(3, '0')
  }
})

watch(formRequisition, async (newNumber, oldNumber) => {
  if(parseInt(oldNumber.contract_item_id, 10) != 0 && !isNaN(parseInt(oldNumber.contract_item_id, 10))) {
    formRequisition.contract_item_id = parseInt(oldNumber.contract_item_id, 10).toString().padStart(3, '0')
  }
})

const props = defineProps({
  user: Object,
  airConditioner: Object,
  statuses: Object,
  errors: Object,
});

async function submitTicket() {
  this.loading = true;
  Inertia.post(route('tickets.store'), this.formTicket, {
    preserveState: (page) => Object.keys(page.props.errors).length,
  });
  this.loading = false;
}

async function submitQuote() {
  this.loading = true;
  Inertia.post(route('quotes.store'), this.formQuote, {
    preserveState: true,
    onSuccess: (page) => {
      formQuote.date = (new Date().getFullYear()+'-'+(new Date().getMonth() + 1).toString().padStart(2, '0')+'-'+new Date().getDate())
      formQuote.contract_item_id = null
      formQuote.quantity = 1
    }
  });
  this.loading = false;
}

async function submitRequisition() {
  this.loading = true;
  Inertia.post(route('requisitions.store'), this.formRequisition, {
    preserveState: true,
    onSuccess: (page) => {
      formRequisition.year = new Date().getFullYear()
      formRequisition.contract_item_id = null
      formRequisition.quantity = 1
    }
  });
  this.loading = false;
}

async function submitServiceOrder() {
  this.loading = true;
  Inertia.post(route('service_orders.store'), this.formServiceOrder, {
    preserveState: true,
    onSuccess: (page) => {
      formServiceOrder.services = null
      formServiceOrder.done_at = (new Date().getFullYear()+'-'+(new Date().getMonth() + 1).toString().padStart(2, '0')+'-'+new Date().getDate())
      formServiceOrder.done_at_time = '00:00'
      formServiceOrder.technicians = null 
      formServiceOrder.status = null
    }
  });
  this.loading = false;
}

function resort(list, property, direction) {
  return _.orderBy(list, property, direction);
}

onMounted(() => {
  document.getElementById("problem")?.focus()
})
</script>
