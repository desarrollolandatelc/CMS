<script>
    import { createEventDispatcher } from "svelte";
    import {
        Heading,
        ImagePlaceholder,
        Label,
        TableBodyCell,
        TableBodyRow,
    } from "flowbite-svelte";

    import TableBodyRowFormat from "../../../Components/Core/TableBodyRowFormat.svelte";
    import { slide } from "svelte/transition";
    export let selected = [];

    const dispatch = createEventDispatcher();

    export let item;
    let openRow;
    const toggleRow = (i) => {
        console.log(i);
        openRow = openRow === i ? null : i;
    };
</script>

<TableBodyRowFormat
    bind:selected
    {item}
    hasBulkAction={false}
    on:click={() => toggleRow(item.id)}
>
    <TableBodyCell>{item.id}</TableBodyCell>
    <TableBodyCell>{item.barcode}</TableBodyCell>
    <TableBodyCell>
        <button
            type="button"
            class="hover:underline text-blue-600 cursor-pointer"
            on:click={() => dispatch("change", item)}
        >
            {item.name}
        </button>
    </TableBodyCell>
    <TableBodyCell>{item.price}</TableBodyCell>
</TableBodyRowFormat>

{#if openRow === item.id}
    <TableBodyRow>
        <TableBodyCell colspan="4" class="p-0">
            <div
                class="px-2 py-3 grid grid-cols-4"
                transition:slide={{ duration: 300, axis: "y" }}
            >
                <div class="col-span-1">
                    <img
                        src={item.images[0].url}
                        alt={item.images[0].name}
                        class="w-32"
                    />
                </div>
                <div class="flex flex-col col-span-3">
                    <div>
                        <Heading tag="h5" class="font-bold">Marca</Heading>
                        <span class="text-gray-500">{item.brand.name}</span>
                    </div>
                    <div>
                        <Heading tag="h5" class="font-bold">Categoría</Heading>
                        <span class="text-gray-500">{item.category.name}</span>
                    </div>
                    {#each item.fields as field}
                        <div>
                            <Heading tag="h5" class="font-bold">{field.field.name}</Heading>
                            <span class="text-gray-500">{field.value}</span>
                        </div>
                    {/each}
                </div>
            </div>
        </TableBodyCell>
    </TableBodyRow>
{/if}
