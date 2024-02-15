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

    import { onMount } from "svelte";
    import axios from "axios";
    import slugify from "slugify";

    export let form;

    let personTypes = [];
    let documentTypes = [];

    const searchpersonTypes = () => {
        axios
            .get(route("person-types.get-all-from-api"))
            .then((response) => {
                personTypes = response.data;
            })
            .catch((error) => {
                console.log(error);
            });
    };

    const getDocumentTypes = (deletedDocumentTypeId = true) => {
        if (deletedDocumentTypeId) {
            $form.document_type_id = "";
        }
        // Lo buscamos dentro de nuestro arreglo person types
        documentTypes = personTypes.find(
            (person_type) => person_type.id == $form.person_type_id,
        ).document_types;
    };

    $: if ($form.name && $form.name.length > 0) {
        $form.alias = slugify($form.name);
    } else {
        $form.alias = null;
    }

    $: if ($form.person_type_id && personTypes.length > 0) {
        getDocumentTypes(false);
    }

    onMount(() => {
        searchpersonTypes();
    });
</script>

<div class="grid md:grid-cols-3 gap-2">
    <div class="md:col-span-2">
        <Card horizontal size="xl" class="w-full grid md:grid-cols-2 gap-2">
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
                <Label for="name">
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
                    autocomplete="name"
                />
                {#if $form.errors.name}
                    <Helper color="red" class="mt-2">
                        {$form.errors.name}
                    </Helper>
                {/if}
            </div>
            <div class="w-full md:mt-4">
                <Label for="email">
                    Correo electrónico<sup class="text-red-600">*</sup>
                </Label>
                <Input
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    bind:value={$form.email}
                    required
                    autofocus
                    autocomplete="email"
                />
                {#if $form.errors.email}
                    <Helper color="red" class="mt-2"
                        >{$form.errors.email}</Helper
                    >
                {/if}
            </div>
            <div class="w-full md:mt-4">
                <Label for="phone">Teléfono</Label>
                <Input
                    id="phone"
                    type="text"
                    class="mt-1 block w-full"
                    bind:value={$form.phone}
                    autofocus
                    autocomplete="phone"
                />
                {#if $form.errors.phone}
                    <Helper color="red" class="mt-2">
                        {$form.errors.phone}
                    </Helper>
                {/if}
            </div>

            <div class="w-full md:mt-4">
                <Label for="address">Dirección</Label>
                <Input
                    id="address"
                    type="text"
                    class="mt-1 block w-full"
                    bind:value={$form.address}
                    autofocus
                    autocomplete="address"
                />
                {#if $form.errors.address}
                    <Helper color="red" class="mt-2">
                        {$form.errors.address}
                    </Helper>
                {/if}
            </div>

            {#if personTypes.length > 0}
                <div class="w-full md:mt-4">
                    <Label for="person_type" class="ml-0">
                        Tipo de persona
                        <sup class="text-red-600">*</sup>
                    </Label>
                    <Select
                        id="person_type"
                        class="mt-1 block w-full"
                        bind:value={$form.person_type_id}
                        required
                        on:change={getDocumentTypes}
                    >
                        {#each personTypes as person_type}
                            <option value={person_type.id}>
                                {person_type.name}
                            </option>
                        {/each}
                    </Select>
                    {#if $form.errors.person_type}
                        <Helper color="red" class="mt-2">
                            {$form.errors.person_type}
                        </Helper>
                    {/if}
                </div>
            {/if}

            {#if documentTypes.length > 0}
                <div class="w-full md:mt-4">
                    <Label for="role" class="ml-0">
                        Tipo de documento<sup class="text-red-600">*</sup>
                    </Label>
                    <Select
                        id="role"
                        class="mt-1 block w-full"
                        bind:value={$form.document_type_id}
                        required
                    >
                        {#each documentTypes as document_type}
                            <option value={document_type.id}>
                                {document_type.name}
                            </option>
                        {/each}
                    </Select>
                    {#if $form.errors.document_type}
                        <Helper color="red" class="mt-2">
                            {$form.errors.document_type}
                        </Helper>
                    {/if}
                </div>
            {/if}

            <div class="w-full md:mt-4">
                <Label for="document">
                    Numero de documento<sup class="text-red-600">*</sup>
                </Label>
                <Input
                    id="document"
                    type="text"
                    class="mt-1 block w-full"
                    bind:value={$form.document_number}
                    required
                    autofocus
                    autocomplete="document"
                />
                {#if $form.errors.document_number}
                    <Helper color="red" class="mt-2"
                        >{$form.errors.document_number}</Helper
                    >
                {/if}
            </div>
        </Card>
    </div>
    <div class="md:col-span-1">
        <Card size="xl">
            <Heading tag="h4" class="border-b">Estado</Heading>
            <Label for="email" class="block mt-4 w-full">
                ¿Desea que este proveedor esté activo?<sup class="text-red-600"
                    >*</sup
                >
            </Label>
            <Toggle bind:checked={$form.status} color="green" class="mt-4"
                >{$form.status ? "Activo" : "Inactivo"}</Toggle
            >
        </Card>
    </div>
</div>

<div class="flex items-center mt-4">
    <Button type="submit">Registrar</Button>
    <Button href="/admin/providers" color="alternative" class="ml-4">
        Cancelar
    </Button>
</div>
