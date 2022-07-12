<template>
	<div :class="{ 'p-2': withPadding }">
		<label :for="name" class="block text-sm leading-5 text-gray-500"><slot></slot></label>
		<div class="mt-1 relative rounded-md shadow-sm">
			<input
				:id="name"
				:name="name"
				:type="type"
				:title="title"
				:maxlength="maxlength"
				:autofocus="autofocus"
				:min="min"
				:max="max"
				class="w-full border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 rounded-md shadow-sm font-medium text-black placeholder:text-gray-400 placeholder:font-normal"
				:class="{ 'border-red-500': message }"
				ref="input"
				:placeholder="placeholder"
				:value="modelValue"
				@input="$emit('update:modelValue', $event.target.value)"
				@keydown="message = null"
			/>

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
		type: {
			default: "text",
		},
		title: {
			type: String,
			default: "",
		},
		placeholder: {
			type: String,
			default: "",
		},
		message: {
			type: String,
		},
		maxlength: {
			type: Number,
			default: 255,
		},
		min: {
			type: Number,
		},
		max: {
			type: Number,
		},
		pattern: {
			default: "",
		},
		autofocus: {
			default: false,
		},
		modelValue: {},
		withPadding: {
			default: true
		},
	},
	emits: ["update:modelValue"],
	mounted() {
		if (this.pattern != "") {
			this.$refs.input.setAttribute("pattern", this.pattern);
		}
	},
};
</script>

<style>
</style>