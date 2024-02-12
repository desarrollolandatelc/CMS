<script>
    import { Button, Heading, Helper, Input, Label } from "flowbite-svelte";
    import GuestLayout from "../../Layouts/GuestLayout.svelte";
    import { useForm } from "@inertiajs/svelte";
    const form = useForm({
        password: "",
    });
    const submit = () => {
        $form.post(route("password.confirm"), {
            onFinish: () => $form.reset(),
        });
    };
</script>

<template>
    <GuestLayout>
        <Heading>Confirmar constraseña</Heading>

        <div class="mb-4 text-sm text-gray-600">
            Este es un area segura de la aplicación. Por favor, confirme su
            constraseña antes de continuar.
        </div>

        <form on:submit|preventDefault={submit}>
            <div>
                <Label for="password" value="Password" />
                <Input
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    bind:value={$form.password}
                    required
                    autocomplete="current-password"
                    autofocus
                />
                {#if form.errors.password}
                    <Helper class="mt-2" color="red"
                        >{form.errors.password}</Helper
                    >
                {/if}
            </div>

            <div class="flex justify-end mt-4">
                <Button color="red" class="ms-4">Confirmar</Button>
            </div>
        </form>
    </GuestLayout>
</template>
