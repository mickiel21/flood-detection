<template>
  <div class="max-w-sm mx-auto bg-white rounded-lg shadow-md p-6">
    <h2 class="text-xl font-semibold text-gray-800">Water Level</h2>
    <p class="mt-4 text-4xl font-bold text-blue-500">{{ waterLevel }} cm</p>
    <div class="mt-4 text-sm text-gray-600">Last Updated: {{ updatedTime }}</div>
  </div>
</template>

<script>
import { ref, watch, defineComponent } from "vue";

export default defineComponent({
  props: {
    initialWaterLevel: {
      required: true
    }
  },
  setup(props) {
    const waterLevel = ref(props.initialWaterLevel);
    const updatedTime = ref(new Date().toLocaleTimeString());

    // Watch for prop updates and update state accordingly
    watch(() => props.initialWaterLevel, (newLevel) => {
      waterLevel.value = newLevel;
      updatedTime.value = new Date().toLocaleTimeString();
    });

    return { waterLevel, updatedTime };
  }
});
</script>