<script>
    import {
        Button,
        Card,
        Heading,
        Helper,
        Input,
        Label,
        Toggle,
        Select,
        Blockquote,
    } from "flowbite-svelte";
    import { QuoteSolid } from "flowbite-svelte-icons";

    import { onMount } from "svelte";

    const route = window.route;

    export let form;
    let roles = [];

    const getRoles = () => {
        axios
            .get(route("admin.roles.get-all-from-api"))
            .then((response) => {
                roles = response.data;
            })
            .catch((error) => {
                console.log(error);
            });
    };

    onMount(() => {
        getRoles();
    });
</script>

<div class="grid md:grid-cols-3 gap-2">
    <div class="md:col-span-2">
        <Card horizontal size="xl" class="w-full grid md:grid-cols-2 gap-2">
            <div class="w-full">
                <Label for="name">Nombre de usuario</Label>

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
                    <Helper color="red" class="mt-2">{$form.errors.name}</Helper
                    >
                {/if}
            </div>
            <div class="w-full">
                <Label for="email">Correo electrónico</Label>
                <Input
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />
                {#if $form.errors.email}
                    <Helper color="red" class="mt-2"
                        >{$form.errors.email}</Helper
                    >
                {/if}
            </div>

            <div class="w-full md:mt-4">
                <Label for="role" class="ml-0">Función del usuario</Label>
                {#if roles.length > 0}
                    <Select
                        id="role"
                        class="mt-1 block w-full"
                        bind:value={$form.role}
                        required
                    >
                        {#each roles as role}
                            <option value={role.name}>{role.name}</option>
                        {/each}
                    </Select>
                    {#if $form.errors.role}
                        <Helper color="red" class="mt-2"
                            >{$form.errors.role}</Helper
                        >
                    {/if}
                {/if}
            </div>
        </Card>
    </div>
    <div class="md:col-span-1">
        <Card size="xl">
            <Heading tag="h4" class="border-b">Estado</Heading>
            <Label for="email" class="block mt-4 w-full"
                >¿Desea que este usuario este activo?</Label
            >
            <Toggle bind:checked={$form.status} color="green" class="mt-4"
                >{$form.status ? "Activo" : "Inactivo"}</Toggle
            >
        </Card>

        <Card size="xl" class="mt-2">
            <Heading tag="h4" class="border-b">Asociación</Heading>
            <Blockquote size="sm" class="mt-4">
                <QuoteSolid class="w-10 h-10 text-gray-400 dark:text-gray-600" />
                Si el usuario está asociado con un cliente, deberá buscarlo y seleccionarlo
                en la parte inferior
            </Blockquote>
            <Label for="email" class="block mt-4 w-full">Clientes</Label>
        </Card>
    </div>
</div>
