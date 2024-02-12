<script lang="ts">
    import { Link, useForm } from "@inertiajs/svelte";
    import {
        Label,
        Input,
        Button,
        Checkbox,
        Helper,
        Heading,
    } from "flowbite-svelte";

    import GuestLayout from "../../Layouts/GuestLayout.svelte";
    const route = window.route;

    const form = useForm({
        email: "",
        password: "",
        remember: false,
    });

    const login = () => {
        $form.post(route("admin.login.store"), {
            preserveScroll: true,
            onSuccess: () => $form.reset("password"),
        });
    };
</script>

<GuestLayout>
    <Heading tag="h4" class="mb-4">Iniciar sesión</Heading>

    <form on:submit|preventDefault={login}>
        <div class="mt-4">
            <Label for="email" class="block mb-2">
                Usuario <sup class="text-red-600">*</sup>
            </Label>

            <Input
                id="email"
                type="email"
                class="mt-1 block w-full"
                bind:value={$form.email}
                required
                autofocus
                autocomplete="username"
            />
            {#if $form.errors.email}
                <Helper class="mt-2" color="red">
                    {$form.errors.email}
                </Helper>
            {/if}
        </div>

        <div class="mt-4">
            <Label for="password">
                Contraseña <sup class="text-red-600">*</sup>
            </Label>

            <Input
                id="password"
                type="password"
                class="mt-1 block w-full"
                bind:value={$form.password}
                required
                autocomplete="current-password"
            />
        </div>

        <div class="block mt-4">
            <Label class="flex items-center">
                <Checkbox name="remember" />
                <span class="ms-2 text-sm text-gray-600">Remember me</span>
            </Label>
        </div>

        <div class="flex items-center justify-end mt-4">
            <Link
                class="underline text-sm text-gray-600 hover:text-gray-900 
            rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 
            focus:ring-indigo-500"
                href={route("password.request")}
            >
                ¿Olvidó la contraseña?
            </Link>

            <Button color="red" class="ms-4" type="submit">
                Inicia sesión con tu cuenta
            </Button>
        </div>
    </form>
</GuestLayout>
