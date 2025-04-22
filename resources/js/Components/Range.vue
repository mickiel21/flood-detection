<template>
    <div class="min-max-component">
        <label class="block">
            Min Value:
            <input 
                type="number" 
                class="block mt-1 w-full rounded-md form-input focus:border-indigo-600" 
                v-model="minValue" 
                @input="updateValues" 
            />
        </label>
        <label class="block mt-2">
            Max Value:
            <input 
                type="number" 
                class="block mt-1 w-full rounded-md form-input focus:border-indigo-600" 
                v-model="maxValue" 
                @input="updateValues" 
            />
        </label>
    </div>
</template>

<script setup>
import { ref } from 'vue';

// Props to pass initial values and receive updates
defineProps({
    initialMin: {
        type: Number,
        default: 0
    },
    initialMax: {
        type: Number,
        default: 100
    }
});

defineEmits(['update:minMax']);

const minValue = ref(initialMin);
const maxValue = ref(initialMax);

const updateValues = () => {
    emit('update:minMax', { min: minValue.value, max: maxValue.value });
};
</script>

<style scoped>
.min-max-component label {
    font-weight: bold;
}
</style>