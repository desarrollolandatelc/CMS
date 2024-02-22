<script>
    import {
        Button,
        Card,
        Heading,
        Helper,
        Input,
        Label,
        Toggle,
    } from "flowbite-svelte";

    export let form;
    import slugify from "slugify";
    import DiscountOptions from "./DiscountOptions.svelte";

    $: if ($form.name && $form.name.length > 0) {
        $form.alias = slugify($form.name);
    } else {
        $form.alias = null;
    }
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

                <DiscountOptions {form} />

                <div class="w-full mt-4">
                    <Label for="discount_field" class="block w-full">
                        Valor del descuento %<sup class="text-red-600">*</sup>
                    </Label>
                    <Input
                        id="discount_field"
                        type="text"
                        class="mt-1 block w-full"
                        value={$form.value}
                    ></Input>
                </div>
            </div>
        </Card>
    </div>
    <div class="md:col-span-1">
        <Card size="xl">
            <Heading tag="h4" class="border-b"
                >Estado <sup class="text-red-600">*</sup>
            </Heading>
            <Helper class="block mt-4 w-full text-xs">
                ¿Desea que este desuento esté activo?
            </Helper>
            <Toggle bind:checked={$form.status} color="green" class="mt-4"
                >{$form.status ? "Activo" : "Inactivo"}</Toggle
            >
        </Card>

        <Card size="xl">
            <Heading tag="h4" class="border-b">Fecha</Heading>
            <Helper class="block mt-4 w-full text-xs">
                Aquí puedes cambiar asignar un rango de fechas para el descuento
            </Helper>
            <div class="mt-4">
                <Label>Fecha de inicio</Label>
                <Input type="date" bind:value={$form.start_date}></Input>
            </div>
            <div class="mt-4">
                <Label>Fecha final</Label>
                <Input type="date" bind:value={$form.end_date}></Input>
            </div>
        </Card>
    </div>
</div>

<div class="flex items-center mt-4">
    <Button type="submit">Registrar</Button>
    <Button href="/admin/discounts" color="alternative" class="ml-4">
        Cancelar
    </Button>
</div>
