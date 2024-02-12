<script setup>
    import AuthenticatedLayout from "../Layouts/AuthenticatedLayout.svelte";
    import { Card } from 'flowbite-svelte';
    import { Heading } from "flowbite-svelte";

    import { onMount } from "svelte";

    onMount(() => {
        console.log("mounted");
    });
</script>

<AuthenticatedLayout>
    <Heading tag="h4" class="mb-4">Dashboard</Heading>
    <div class="max-w-7xl mx-auto ">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">You're logged in!</div>
        </div>
    </div>
</AuthenticatedLayout>
