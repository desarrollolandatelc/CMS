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

    import WindowTable from "../../../Components/Core/WindowTable.svelte";
    import InputAction from "../../../Components/Gui/InputAction.svelte";

    export let form;
    import slugify from "slugify";
    import Table from "../../../Components/Gui/Table.svelte";
    let defaultModal = false;

    $: if ($form.name && $form.name.length > 0) {
        $form.alias = slugify($form.name);
    } else {
        $form.alias = null;
    }

    const selected = (event) => {
        console.log(event);
        $form.parent_id = event.detail.id;
        $form.parent.name = event.detail.name;
        defaultModal = false;
    };
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
            </div>
        </Card>
    </div>
    <div class="md:col-span-1">
        <Card size="xl">
            <Heading tag="h4" class="border-b">Estado</Heading>
            <Label for="email" class="block mt-4 w-full">
                ¿Desea que esta categoria esté activa?<sup class="text-red-600"
                    >*</sup
                >
            </Label>
            <Toggle bind:checked={$form.status} color="green" class="mt-4"
                >{$form.status ? "Activo" : "Inactivo"}</Toggle
            >
        </Card>

        <Card size="xl" class="mt-2">
            <Heading tag="h4" class="border-b">Asociación</Heading>
            <Blockquote size="sm" class="mt-4">
                <QuoteSolid
                    class="w-10 h-10 text-gray-400 dark:text-gray-600"
                />
                Si la categoría tiene un elemento padre, deberá buscarlo y seleccionarlo
                en la parte inferior
            </Blockquote>
            <Label for="email" class="block mt-4 w-full">Categoría padre</Label>

            <InputAction value={$form.parent?.name} bind:defaultModal>
                <WindowTable
                    COMPONENT={Table}
                    searchRoute="categories.search"
                    table="categories"
                    on:change={selected}
                ></WindowTable>
            </InputAction>
        </Card>
    </div>
</div>

<div class="flex items-center mt-4">
    <Button type="submit">Registrar</Button>
    <Button href="/admin/categories" color="alternative" class="ml-4">
        Cancelar
    </Button>
</div>
