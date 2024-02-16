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
    </div>
</div>

<div class="flex items-center mt-4">
    <Button type="submit">Registrar</Button>
    <Button href="/admin/clients" color="alternative" class="ml-4">
        Cancelar
    </Button>
</div>
