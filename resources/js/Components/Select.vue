<template>
	<div :class="{ 'p-2': withPadding }">
		<label :for="name" class="block text-sm leading-5 text-gray-500"><slot></slot></label>
		<div class="mt-1 relative rounded-md shadow-sm">
			<select
				:name="name"
				:id="name"
				class="w-full border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 rounded-md shadow-sm font-medium"
				:class="{ 'border-red-500': message }"
				:value="modelValue"
				@input="$emit('update:modelValue', $event.target.value)"
				@change="message = null"
			>
				<option v-if="withDefault" value="">Selecione...</option>
				<slot name="options"></slot>
			</select>
			<small v-if="message" class="text-red-500 text-xs">{{ message }}</small>
		</div>
	</div>
</template>

<script>
export default {
	props: {
		name: {
			type: String,
		},
		message: {
			type: String,
		},
		withDefault: {
			type: Boolean,
			default: true,
		},
		modelValue: {},
		withPadding: {
			default: true,
		},
	},

	emits: ["update:modelValue"],
};
</script>

<style>
</style>