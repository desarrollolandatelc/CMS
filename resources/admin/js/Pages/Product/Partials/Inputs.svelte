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
        Tabs,
        TabItem,
    } from "flowbite-svelte";

    import { onMount } from "svelte";

    import slugify from "slugify";
    import Title from "./Title/Title.svelte";
    import Category from "./Category/Category.svelte";
    import Brand from "./Brand/Brand.svelte";
    import Provider from "./Provider/Provider.svelte";
    import axios from "axios";
    import ImageForm from "./ImageForm.svelte";
    import ExtraField from "./ExtraField/ExtraField.svelte";
    import Repeater from "../../../Components/Gui/Repeater.svelte";
    import Editor from "@tinymce/tinymce-svelte";

    export let form;

    $: if ($form.name && $form.name.length > 0) {
        $form.alias = slugify($form.name);
    } else {
        $form.alias = null;
    }
    let currencies = [];
    const searchCurrencies = () => {
        axios
            .get(route("currencies.get-all-from-api"))
            .then((response) => {
                currencies = response.data;
            })
            .catch((error) => {
                console.log(error);
            });
    };

    onMount(() => {
        searchCurrencies();
    });
</script>

<div class="grid md:grid-cols-3 gap-2">
    <div class="md:col-span-2">
        <Tabs
            style="underline"
            class="bg-white rounded-t-md border"
            contentClass="bg-white p-4 shadow-lg rounded-b-md border-b border-l border-r"
        >
            <TabItem open title="Información básica">
                <div class="w-full grid md:grid-cols-2 gap-2 bg-white">
                    <div class="w-full">
                        <Title bind:form />
                        {#if $form.errors.title_id}
                            <Helper color="red" class="mt-2">
                                {$form.errors.title_id}
                            </Helper>
                        {/if}
                    </div>
                    <div class="w-full">
                        <Label for="sku">
                            SKU <sup class="text-red-600">*</sup>
                        </Label>
                        <Input
                            id="sku"
                            type="text"
                            class="mt-1 block w-full"
                            bind:value={$form.sku}
                            required
                            autofocus
                            autocomplete="sku"
                        />
                        {#if $form.errors.sku}
                            <Helper color="red" class="mt-2">
                                {$form.errors.sku}
                            </Helper>
                        {/if}
                    </div>

                    <div class="w-full mt-4">
                        <Label for="barcode">
                            Código de barras <sup class="text-red-600">*</sup>
                        </Label>
                        <Input
                            id="barcode"
                            type="text"
                            class="mt-1 block w-full"
                            bind:value={$form.barcode}
                            required
                            autofocus
                            autocomplete="barcode"
                        />
                        {#if $form.errors.barcode}
                            <Helper color="red" class="mt-2">
                                {$form.errors.barcode}
                            </Helper>
                        {/if}
                    </div>

                    <div class="w-full mt-4">
                        <Provider bind:form />
                        {#if $form.errors.provider_id}
                            <Helper color="red" class="mt-2">
                                {$form.errors.provider_id}
                            </Helper>
                        {/if}
                    </div>

                    <div class="w-full mt-4">
                        <Brand bind:form />
                        {#if $form.errors.brand_id}
                            <Helper color="red" class="mt-2">
                                {$form.errors.brand_id}
                            </Helper>
                        {/if}
                    </div>

                    <div class="w-full mt-4">
                        <Category bind:form />
                        {#if $form.errors.category_id}
                            <Helper color="red" class="mt-2">
                                {$form.errors.category_id}
                            </Helper>
                        {/if}
                    </div>

                    <div class="w-full mt-4">
                        <Label for="currency" class="block w-full">
                            Moneda<sup class="text-red-600">*</sup>
                        </Label>
                        <Select
                            id="currency"
                            class="mt-2"
                            bind:value={$form.currency_id}
                        >
                            {#each currencies as currency}
                                <option value={currency.id}>
                                    {currency.name}
                                </option>
                            {/each}
                        </Select>
                        {#if $form.errors.currency_id}
                            <Helper color="red" class="mt-2">
                                {$form.errors.currency_id}
                            </Helper>
                        {/if}
                    </div>

                    <div class="w-full mt-4">
                        <Label for="min_quantity">
                            Cantidad mínima <sup class="text-red-600">*</sup>
                        </Label>
                        <Input
                            id="min_quantity"
                            type="number"
                            class="mt-1 block w-full"
                            bind:value={$form.min_quantity}
                            required
                            autofocus
                            autocomplete="min_quantity"
                        />
                        {#if $form.errors.min_quantity}
                            <Helper color="red" class="mt-2">
                                {$form.errors.min_quantity}
                            </Helper>
                        {/if}
                    </div>

                    <div class="w-full mt-4">
                        <Label for="max_quantity">
                            Cantidad máxima <sup class="text-red-600">*</sup>
                        </Label>
                        <Input
                            id="max_quantity"
                            type="number"
                            class="mt-1 block w-full"
                            bind:value={$form.max_quantity}
                            required
                            autofocus
                            autocomplete="max_quantity"
                        />
                        {#if $form.errors.max_quantity}
                            <Helper color="red" class="mt-2">
                                {$form.errors.max_quantity}
                            </Helper>
                        {/if}
                    </div>

                    <div class="w-full mt-4">
                        <Label for="price">
                            Precio <sup class="text-red-600">*</sup>
                        </Label>
                        <Input
                            id="price"
                            type="number"
                            class="mt-1 block w-full"
                            bind:value={$form.price}
                            required
                            autofocus
                            autocomplete="price"
                        />
                        {#if $form.errors.price}
                            <Helper color="red" class="mt-2">
                                {$form.errors.price}
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
                </div>
            </TabItem>

            <TabItem title="Imágenes">
                <Repeater COMPONENT={ImageForm} bind:values={$form.images} />
            </TabItem>
            <TabItem title="Campos extras">
                <Repeater COMPONENT={ExtraField} bind:values={$form.fields} />
            </TabItem>
        </Tabs>
    </div>
    <div class="md:col-span-1">
        <Card size="xl">
            <Heading tag="h4" class="border-b">Estado</Heading>
            <Label for="email" class="block mt-4 w-full">
                ¿Desea que este producto esté activo?<sup class="text-red-600"
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
    <Button href="/admin/products" color="alternative" class="ml-4">
        Cancelar
    </Button>
</div>
