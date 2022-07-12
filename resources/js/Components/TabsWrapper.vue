<template>
  <div>
		<div class="border-b border-gray-200 h-16 flex">
			<div class="flex ml-6 space-x-12">
				<button 
					v-for="title in tabTitles" 
					:key="title" 
					class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-700 transition"
					:class="[  selectedTitle == title ? 'border-blue-400 hover:border-blue-500 focus:border-blue-400' : 'border-transparent hover:border-gray-300 focus:border-gray-300' ]"
					@click="selectedTitle = title"
				>
					{{ title }}
				</button >
			</div>
		</div>
		<div class="px-6 py-8">
			<slot />
		</div>
	</div>
</template>
<script>
import { ref, provide } from 'vue';
export default {
  setup(props, { slots }) {
    const tabTitles = ref(slots.default().map((tab) => tab.props.title));
		const selectedTitle = ref(tabTitles.value[0])

		provide("selectedTitle", selectedTitle)

    return {
			selectedTitle,
      tabTitles,
    };
  },
};
</script>