<script>
    import { Helper, Input, Label, Select } from "flowbite-svelte";
    import InputAction from "../../../Components/Gui/InputAction.svelte";
    import { SearchSolid } from "flowbite-svelte-icons";
    import WindowTable from "../../../Components/Core/WindowTable.svelte";
    import ModalBodyTableCells from "../../../Components/Core/ModalBodyTableCells.svelte";
    import ProductBodyTableCells from "../../Product/Partials/ModalBodyTableCells.svelte";

    import TableFormat from "./TableFormat.svelte";

    const discount_fields = [
        {
            label: "Producto",
            field_value: "id",
            table: "products",
            modalComponent: ProductBodyTableCells,
        },
        {
            label: "Proveedor",
            field_value: "provider_id",
            table: "providers",
            modalComponent: ModalBodyTableCells,
        },
        {
            label: "Marca",
            field_value: "brand_id",
            table: "brands",
            modalComponent: ModalBodyTableCells,
        },
    ];

    export let form;
    let modalComponent = null;
    let defaultModal = false;

    const selected = (event) => {
        $form.table_field = discount_fields[event.target.value].table;
        $form.product_field = discount_fields[event.target.value].field_value;
        $form.product_field_value = null;
        $form.product_field_value_name = null;
        modalComponent = discount_fields[event.target.value].modalComponent;
    };

    const selectedResource = (event) => {
        $form.product_field_value = event.detail.id;
        $form.product_field_value_name = event.detail.name;

        defaultModal = false;
    };
</script>

<div class="w-full mt-4 col-span-full">
    <Label for="discount_field" class="block w-full">
        Campo<sup class="text-red-600">*</sup>
        <Helper class="text-sm" color="info">
            Seleccione el campo al que desea asociar el descuento
        </Helper>
    </Label>
    <Select id="discount_field" class="mt-2" on:change={selected}>
        {#each discount_fields as discount_field, index}
            <option value={index}>
                {discount_field.label}
            </option>
        {/each}
    </Select>
    {#if $form.errors.discount_field_id}
        <Helper color="red" class="mt-2">
            {$form.errors.discount_field}
        </Helper>
    {/if}
</div>

<div class="w-full mt-4">
    <Label for="discount_field" class="block w-full">
        Tabla asociada<sup class="text-red-600">*</sup>
    </Label>
    <Input
        id="discount_field"
        type="text"
        class="mt-1 block w-full"
        disabled={true}
        value={$form.table_field}
    ></Input>
</div>
{#if $form.table_field}
    <div class="w-full mt-4">
        <Label for="discount_field" class="block w-full">
            Valor del recurso<sup class="text-red-600">*</sup>
        </Label>
        <InputAction
            value={$form.product_field_value_name}
            bind:defaultModal
            modalTitle="Buscar recurso"
        >
            <SearchSolid slot="button-title" />
            <WindowTable
                COMPONENT={TableFormat}
                searchRoute="{$form.table_field}.search"
                table={$form.table_field}
                extraProps={{ modalComponent: modalComponent }}
                on:change={selectedResource}
            ></WindowTable>
        </InputAction>
    </div>
{/if}
