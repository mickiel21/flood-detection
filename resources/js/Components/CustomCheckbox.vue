<template>
    <input 
        type="checkbox" 
        :value="value" 
        :checked="checked.includes(value)"
        @change="toggleChecked"
        class="text-indigo-600"
    >
</template>

<script setup>
import { defineProps, defineEmits } from 'vue';

const emit = defineEmits(['update:checked']);

const props = defineProps({
    checked: {
        type: Array, // Must be an array for multiple selections
        default: () => [],
    },
    value: {
        type: String, // This is the permission name
        required: true,
    },
});

const toggleChecked = () => {
    let updatedValues = [...props.checked];

    if (updatedValues.includes(props.value)) {
        updatedValues = updatedValues.filter(item => item !== props.value); // Remove if unchecked
    } else {
        updatedValues.push(props.value); // Add if checked
    }

    emit('update:checked', updatedValues); // Emit updated array
};
</script>