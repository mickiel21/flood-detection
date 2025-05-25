<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import NewDropdown from '@/Components/NewDropdown.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

const page = usePage();
const sensors = page.props.sensors; // Fetch sensors from the backend
const severityOptions = ['Low', 'Medium', 'High'];
const form = useForm({
    sensor_id: '',
    type: '',
    messages: [{ severity: '', message: '' }] // Array to store multiple messages
});


const submit = () => {
    form.post(route("alerts.store"));
};

const addMessage = () => {
    form.messages.push({ severity: '', message: '' });
};

const removeMessage = (index) => {
    form.messages.splice(index, 1);
};

const filteredSeverityOptions = (index) => {
    return severityOptions.filter(option => {
        return !form.messages.some((msg, i) => msg.severity === option && i !== index);
    });
};

</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Alert</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <section>
                    <form @submit.prevent="submit" class="mt-6 space-y-6">
                        <!-- Sensor Dropdown -->
                        <div>
                            <InputLabel for="sensor_id" value="Select Sensor" />
                            <select
                                id="sensor_id"
                                v-model="form.sensor_id"
                                class="mt-1 block w-full rounded-md form-select focus:border-indigo-600"
                                required
                            >
                                <option value="" disabled>Select a Sensor</option>
                                <option v-for="sensor in sensors" :key="sensor.id" :value="sensor.id">
                                    {{ sensor.name }} ({{ sensor.location }})
                                </option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.sensor_id" />
                        </div>

                        <div>
                            <InputLabel for="type" value="Type" />
                            <TextInput
                                id="type"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.type"
                                required 
                            />
                            <InputError class="mt-2" :message="form.errors.type" />
                        </div>

                        <!-- Dynamic Messages Section -->
                        <div v-for="(msg, index) in form.messages" :key="index">
                            <InputLabel :for="`severity-${index}`" value="Severity" />
                            <NewDropdown
                                :id="`severity-${index}`"
                                class="mt-1 block w-full"
                                v-model="msg.severity"
                                :options="filteredSeverityOptions(index)"
                            />
                            <InputError class="mt-2" :message="form.errors[`messages.${index}.severity`]"/>

                            <InputLabel :for="`message-${index}`" value="Message" class="mt-4"/>
                            <TextInput
                                :id="`message-${index}`"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="msg.message"
                                required
                            />
                            <InputError class="mt-2" :message="form.errors[`messages.${index}.message`]"/>

                            <!-- Remove Message Button -->
                            <button type="button" @click="removeMessage(index)" class="text-red-500 mt-2">Remove</button>
                        </div>

                        <!-- Add More Messages -->
                        <button type="button" @click="addMessage" class="text-blue-500 mt-4">+ Add More Messages</button>

                        <div class="flex items-center gap-4">
                            <PrimaryButton :disabled="form.processing">Save</PrimaryButton>
                            <Transition
                                enter-active-class="transition ease-in-out"
                                enter-from-class="opacity-0"
                                leave-active-class="transition ease-in-out"
                                leave-to-class="opacity-0"
                            >
                                <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                            </Transition>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </AuthenticatedLayout>
</template>