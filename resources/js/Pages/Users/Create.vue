<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import NewDropdown from '@/Components/NewDropdown.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

const props = defineProps({
    roles : Object
});
const form = useForm({
    name: '',
    email: '',
    phone: '',
    role: '',
    password: '',
    password_confirmation: '',
});
const submit = () => {
    form.post(route("users.store"));
};
</script>
<template>
    <Head title="Create User" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create User</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <section>
                    <form @submit.prevent="submit" class="mt-6 space-y-6">
                        <div>
                            <InputLabel for="name" value="Name" />

                            <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.name"
                                required 
                                autofocus
                            />

                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>

                        <div>
                            <InputLabel for="type" value="Email" />

                            <TextInput
                                id="type"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.email"
                                required 
                                autofocus
                            />

                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>

                        <div>
                            <InputLabel for="type" value="Phone" />
                            <TextInput 
                                id="phone" 
                                type="tel" 
                                class="mt-1 block w-full"   
                                v-model="form.phone" 
                                required 
                                autofocus autocomplete="phone"  
                                placeholder="+639123456789" 
                            />
                            <InputError class="mt-2" :message="form.errors.phone" />
                        </div>
                        
                        <div class="mt-3">
                            <InputLabel for="password" value="Password" />
                            <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="new-password" />
                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>

                        <div class="mt-3">
                            <InputLabel for="password_confirmation" value="Confirm Password" />
                            <TextInput id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="new-password" />
                            <InputError class="mt-2" :message="form.errors.password_confirmation" />
                        </div>
                        <!-- Role Dropdown -->
                        <div>
                            <InputLabel for="Role" value="Role" />
                            <NewDropdown
                                id="role"
                                class="mt-1 block w-full"
                                v-model="form.role"
                                :options="roles"
                            />
                            <InputError class="mt-2" :message="form.errors.role" />
                        </div>

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