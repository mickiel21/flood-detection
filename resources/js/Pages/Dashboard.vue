<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            Dashboard
        </template>

        <div style="height: 400px;"> <!-- Set a fixed height for the chart container -->
            <Line :data="data" :options="options" />
        </div>
    </AuthenticatedLayout>
</template>

<script>
import { Line } from 'vue-chartjs'
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
import { Head } from '@inertiajs/vue3';

// Register Chart.js components
ChartJS.register(CategoryScale, LinearScale, PointElement, LineElement, Title, Tooltip, Legend);

export default {
    name: 'Dashboard',
    components: {
        Line,
        AuthenticatedLayout,
        Head,
    },
    data() {
        return {
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'], // X-axis labels
                datasets: [{
                    label: 'Water Level (cm)',
                    backgroundColor: 'rgba(78, 115, 223, 0.2)', // Bar fill color
                    borderColor: 'rgba(78, 115, 223, 1)', // Line color
                    pointBackgroundColor: 'rgba(78, 115, 223, 1)', // Point color
                    data: [40, 39, 10, 40, 39, 80, 40], // Water level data
                    fill: true, // Option to fill the area under the line
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // Allow flexible resizing
                plugins: {
                    legend: {
                        display: true,
                        position: 'top', // Place the legend at the top
                    },
                    title: {
                        display: true,
                        text: 'Water Level Over Time', // Title for the chart
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Time (Months)' // Label for the X-axis
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Water Level (cm)' // Label for the Y-axis
                        },
                        beginAtZero: true // Start Y-axis at 0
                    }
                }
            }
        }
    }
};
</script>
