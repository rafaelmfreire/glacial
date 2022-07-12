<template>
	<div :class="{ 'p-2': withPadding }">
		<label :for="name" class="block text-sm leading-5 text-gray-500"><slot></slot></label>
		<div class="mt-1 relative rounded-md">
			<textarea
				:rows="rows"
				:id="name"
				:name="name"
				:autofocus="autofocus"
				class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm font-medium"
				:class="{ 'border-red-500': message }"
				:value="modelValue"
				@input="$emit('update:modelValue', $event.target.value)"
				:placeholder="placeholder"
				@keydown="message = null"
			></textarea>
			<small v-if="message" role="alert" class="text-red-500 text-xs">{{ message }}</small>
		</div>
	</div>
</template>

<script>
export default {
	props: {
		name: {
			type: String,
		},
		rows: {
			default: 5,
		},
		message: {
			type: String,
		},
		modelValue: {},
		withPadding: {
			default: true,
		},
		placeholder: {
			default: '',
		},
		autofocus: {
			default: false,
		},
	},

	emits: ["update:modelValue"],
};
</script>

<style>
</style>