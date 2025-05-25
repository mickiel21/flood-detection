<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            Dashboard
        </template>
           <div class="flex flex-col md:flex-row gap-4 p-4">
        <!-- Filter Type Dropdown -->
        <div class="w-full md:w-1/3">
            <label class="block text-sm font-medium text-gray-700 mb-1">Filter Type</label>
            <select 
                v-model="filterType" 
                @change="fetchData"
                class="w-full px-3 py-2 border rounded-lg shadow-sm focus:ring focus:ring-blue-300 focus:border-blue-500 bg-white text-gray-700"
            >
                <option value="month">This Month</option>
                <option value="today">Today</option>
            </select>
        </div>

        <!-- Month Selection Dropdown (Visible only if 'month' is selected) -->
        <div class="w-full md:w-1/3" v-if="filterType === 'month'">
            <label class="block text-sm font-medium text-gray-700 mb-1">Select Month</label>
            <select 
                v-model="selectedMonth" 
                @change="fetchData"
                class="w-full px-3 py-2 border rounded-lg shadow-sm focus:ring focus:ring-blue-300 focus:border-blue-500 bg-white text-gray-700"
            >
                <option v-for="month in 12" :key="month" :value="month">
                    {{ new Date(0, month - 1).toLocaleString('default', { month: 'long' }) }}
                </option>
            </select>
        </div>
    </div>

        <div style="height: 400px;"> <!-- Set a fixed height for the chart container -->
            <Line :data="data" :options="options" />
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Line,Bar } from 'vue-chartjs'
import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend
} from 'chart.js'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head,router } from '@inertiajs/vue3';
import { reactive, ref, onMounted,nextTick  } from 'vue';


const props = defineProps({
    waterLevels: Array,
    labels: Array,
    selectedMonth: Number,
    filterType: String,
});
const filterType = ref(props.filterType);
const selectedMonth = ref(props.selectedMonth);

const fetchData = () => {
   router.get(route('dashboard'), { filter: filterType.value, month: selectedMonth.value });

};

// Register Chart.js components
ChartJS.register(CategoryScale, LinearScale, PointElement, LineElement, Title, Tooltip, Legend);
// Generate labels dynamically (January to December)


// Convert Laravel data into datasets dynamically

const data = reactive({
    labels: props.labels.map(date => new Date(date).toLocaleTimeString()), // Format labels
    datasets: [{
        label: 'Water Level (cm)',
        borderColor: 'rgba(78, 115, 223, 1)',
        data: props.waterLevels,
        fill: false,
    }]
});


const options = reactive({
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: { display: true, position: 'top' },
        title: { display: true, text: 'Water Level Over Time' }
    },
    scales: {
        x: { title: { display: true, text: filterType.value === 'today' ? 'Time' : 'Days' } },
        y: { title: { display: true, text: 'Water Level (cm)' }, beginAtZero: true }
    }
});

// onMounted(() => {
//   Echo.channel('water-level')
//     .listen('.WaterLevel', (event) => {
//        updateChart(event.message);
//     });
// });
// const updateChart = (newWaterLevel) => {
//     const currentTime = new Date().toLocaleTimeString();

//     // Limit data points to prevent excessive updates
//     if (data.labels.length > 50) {
//         data.labels.shift(); // Remove oldest entry
//         data.datasets[0].data.shift(); // Remove matching data point
//     }

//     // Append new values
//     data.labels.push(currentTime);
//     data.datasets[0].data.push(newWaterLevel);
// };


</script>
