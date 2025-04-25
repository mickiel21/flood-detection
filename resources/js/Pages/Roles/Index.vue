<script setup>
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import PrimaryLink from '@/Components/PrimaryLink.vue';
import Pagination from '@/Components/Pagination.vue';

const props = defineProps({
    roles: Object,
    filters: Object,
    message: String
});

const filters = {
    filter: props.filters.filter,
}
const form = useForm(filters);

const deleteTrade = (id) => {
    if (confirm("Are you sure you want to move this to trash")) {
        form.delete(route('roles.destroy', { id: id }), {
            preserveScroll: true,
        });
    }
};
</script>
<template>

    <Head title="Roles" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"><a
                    :href="route('roles.index')">Roles</a>
                <PrimaryLink :href="route('roles.index', { filter: 'only' })" class="max-w-xl ml-2">View Trashed
                </PrimaryLink>
                <PrimaryLink :href="route('roles.create')" class="max-w-xl ml-2">Add Role</PrimaryLink>
            </h2>
        </template>
        <div v-if="props.message"
            class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
            role="alert">
            <span class="font-medium">
                {{ props.message }}
            </span>
        </div>
        <div class="inline-block min-w-full overflow-x-auto rounded-lg shadow">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr
                        class="border-b bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                        <th
                            class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            ID</th>
                        <th
                            class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            NAME</th>
                        <th
                            class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="entry in props.roles.data" :key="entry.id" class="text-gray-700">
                        <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ entry.id }}</p>
                        </td>
                        <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ entry.name }}</p>
                        </td>
                        
                        <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                            <PrimaryLink v-if="entry.deleted_at == null" :href="route('roles.edit', { 'id': entry.id })"
                                class="max-w-xl ml-2">EDIT
                            </PrimaryLink>
                            <DangerButton class="ml-3" @click="deleteTrade(entry.id)" v-if="entry.deleted_at == null">
                                Trash
                            </DangerButton>
                        </td>
                    </tr>
                    <tr v-if="props.roles.data.length === 0">
                        <td class="px-6 py-4 border-t" colspan="4">No posts found.</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <pagination class="mt-6" :links="props.roles.links" />
    </AuthenticatedLayout>
</template>