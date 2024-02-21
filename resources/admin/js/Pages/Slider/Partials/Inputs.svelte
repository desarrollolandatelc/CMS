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

    export let form;
    let modules = [];

    import slugify from "slugify";
    import Repeater from "../../../Components/Gui/Repeater.svelte";
    import ImageForm from "./ImageForm.svelte";
    import Editor from "@tinymce/tinymce-svelte";

    $: if ($form.name && $form.name.length > 0) {
        $form.alias = slugify($form.name);
    } else {
        $form.alias = null;
    }

    const searchMenuModulesByType = () => {
        axios
            .get(
                route("modules.get-all-by-type", {
                    type: "slider",
                }),
            )
            .then((response) => {
                modules = response.data;
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

                <div class="w-full col-span-full mt-4">
                    <Label for="price">
                        Descripción <sup class="text-red-600">*</sup>
                    </Label>
                    <Editor
                        id="description"
                        apiKey="2b1c61f1wtvokeiudot95vc7iu0bdr8pm9rzyj8lmgdc5n1o"
                        bind:value={$form.description}
                    />
                    {#if $form.errors.description}
                        <Helper color="red" class="mt-2">
                            {$form.errors.description}
                        </Helper>
                    {/if}
                </div>

                <div class="w-full col-span-full">
                    <Label>Imágenes</Label>
                    <Repeater
                        COMPONENT={ImageForm}
                        bind:values={$form.details}
                    />
                </div>
            </div>
        </Card>
    </div>
    <div class="md:col-span-1">
        <Card size="xl">
            <Heading tag="h4" class="border-b">Estado</Heading>
            <Label for="email" class="block mt-4 w-full">
                ¿Desea que este slider esté activo?<sup class="text-red-600"
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
                    Slider<sup class="text-red-600">*</sup>
                </Label>
                <Select bind:value={$form.module_id}>
                    {#each modules as module}
                        <option value={module.id}>{module.name}</option>
                    {/each}
                </Select>
            </div>
        </Card>
    </div>
</div>

<div class="flex items-center mt-4">
    <Button type="submit">Registrar</Button>
    <Button href="/admin/sliders" color="alternative" class="ml-4">
        Cancelar
    </Button>
</div>
