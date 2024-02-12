<script>
    import { Button, Heading, Helper, Input, Label } from "flowbite-svelte";
    import GuestLayout from "../../Layouts/GuestLayout.svelte";
    import { Link, useForm } from "@inertiajs/svelte";

    const route = window.route;

    const form = useForm({
        name: "",
        email: "",
    });
    const submit = () => {};
</script>

<GuestLayout>
    <Heading title="Register" />

    <form on:submit|preventDefault={submit}>
        <div>
            <Label for="name" value="Name" />

            <Input
                id="name"
                type="text"
                class="mt-1 block w-full"
                v-model="form.name"
                required
                autofocus
                autocomplete="name"
            />
            {#if $form.errors.name}
                <Helper color="red" class="mt-2">{$form.errors.name}</Helper>
            {/if}
        </div>

        <div class="mt-4">
            <Label for="email" value="Email" />

            <Input
                id="email"
                type="email"
                class="mt-1 block w-full"
                v-model="form.email"
                required
                autocomplete="username"
            />
            {#if $form.errors.email}
                <Helper color="red" class="mt-2">{$form.errors.email}</Helper>
            {/if}
        </div>

        <div class="flex items-center justify-end mt-4">
            <Link
                href={route("login")}
                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
                Already registered?
            </Link>

            <Button color="red" class="ms-4">Register</Button>
        </div>
    </form>
</GuestLayout>
