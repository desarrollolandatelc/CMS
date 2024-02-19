<script>
    import {
        Button,
        Card,
        Heading,
        Helper,
        Input,
        Label,
        Select,
        Toggle,
    } from "flowbite-svelte";
    import slugify from "slugify";
    import { onMount } from "svelte";
    import MenuItemType from "./MenuItemType/MenuItemType.svelte";

    export let form;

    let modules = [];
    let parents = [];

    $: if ($form.name && $form.name.length > 0) {
        $form.alias = slugify($form.name);
        $form.href = `/${$form.alias}`;
    } else {
        $form.alias = null;
        $form.href = null;
    }

    $: if ($form.module_id) {
        searchMenuItems();
    }

    const searchMenuModulesByType = () => {
        axios
            .get(
                route("modules.get-all-by-type", {
                    type: "menu",
                }),
            )
            .then((response) => {
                modules = response.data;
            });
    };

    const searchMenuItems = () => {
        axios
            .get(
                route("menu-items.get-all-by-module-id", {
                    module_id: $form.module_id,
                    id: $form.id,
                }),
            )
            .then((response) => {
                parents = response.data;
            });
    };

    onMount(() => {
        searchMenuModulesByType();
    });
</script>

{JSON.stringify($form)}
<div class="grid md:grid-cols-3 gap-2">
    <div class="md:col-span-2">
        <Card size="xl">
            <div class="w-full grid md:grid-cols-2 gap-2 bg-white">
                <div class="w-full">
                    <Label for="name">
                        Nombre <sup class="text-red-600">*</sup>
                    </Label>
                    <Input
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        bind:value={$form.name}
                        required
                        autofocus
                        autocomplete="name"
                    />
                    {#if $form.errors.name}
                        <Helper color="red" class="mt-2">
                            {$form.errors.name}
                        </Helper>
                    {/if}
                </div>
                <div class="w-full">
                    <Label for="alias">
                        Alias <sup class="text-red-600">*</sup>
                    </Label>
                    <Input
                        id="alias"
                        type="text"
                        class="mt-1 block w-full"
                        bind:value={$form.alias}
                        required
                        disabled={true}
                        placeholder="Este campo se genera automáticamente"
                        autofocus
                        autocomplete="alias"
                    />
                    {#if $form.errors.alias}
                        <Helper color="red" class="mt-2">
                            {$form.errors.alias}
                        </Helper>
                    {/if}
                </div>

                <div class="w-full">
                    <Label for="href">
                        Enlace <sup class="text-red-600">*</sup>
                    </Label>
                    <Input
                        id="href"
                        type="text"
                        class="mt-1 block w-full"
                        bind:value={$form.href}
                        required
                        disabled={true}
                        placeholder="Este campo se genera automáticamente"
                        autofocus
                        autocomplete="href"
                    />
                    {#if $form.errors.href}
                        <Helper color="red" class="mt-2">
                            {$form.errors.href}
                        </Helper>
                    {/if}
                </div>

                <div class="w-full col-span-full">
                    <MenuItemType bind:form />
                    {#if $form.errors.title_id}
                        <Helper color="red" class="mt-2">
                            {$form.errors.title_id}
                        </Helper>
                    {/if}
                </div>
            </div>
        </Card>
    </div>
    <div class="md:col-span-1">
        <Card size="xl">
            <Heading tag="h4" class="border-b">Estado</Heading>
            <Label for="email" class="block mt-4 w-full">
                ¿Desea que esta marca esté activo?<sup class="text-red-600"
                    >*</sup
                >
            </Label>
            <Toggle bind:checked={$form.status} color="green" class="mt-4"
                >{$form.status ? "Activo" : "Inactivo"}</Toggle
            >
        </Card>

        <Card size="xl">
            <Heading tag="h4" class="border-b">Asociaciones</Heading>
            <div>
                <Label for="email" class="block mt-4 w-full">
                    Menú<sup class="text-red-600">*</sup>
                </Label>
                <Select
                    bind:value={$form.module_id}
                    on:change={searchMenuItems}
                >
                    {#each modules as module}
                        <option value={module.id}>{module.name}</option>
                    {/each}
                </Select>
            </div>

            <div>
                <Label for="email" class="block mt-4 w-full">
                    Elemento padre
                </Label>
                <Select bind:value={$form.parent_id}>
                    {#each parents as parent}
                        <option value={parent.id}>{parent.name}</option>
                    {/each}
                </Select>
            </div>
        </Card>
    </div>
</div>

<div class="flex items-center mt-4">
    <Button type="submit">Registrar</Button>
    <Button href="/admin/menu-items" color="alternative" class="ml-4">
        Cancelar
    </Button>
</div>
