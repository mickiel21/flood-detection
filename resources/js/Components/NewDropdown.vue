<template>
    <select 
        class="block mt-1 w-full rounded-md form-select focus:border-indigo-600"
        :value="modelValue" 
        @change="$emit('update:modelValue', $event.target.value)" 
        ref="input">
        <option value="" disabled>Select an option</option>
        <option v-for="option in options" :key="option" :value="option">
            {{ option }}
        </option>
    </select>
</template>

<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: String, // Bound value
    options: Array // Dynamic list of options
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value && input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});
</script>