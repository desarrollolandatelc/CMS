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
    <TableBodyCell><img src={item.images[0].url} alt="" /></TableBodyCell>
    <TableBodyCell>{item.barcode}</TableBodyCell>
    <TableBodyCell>{item.sku}</TableBodyCell>
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
    <TableBodyCell>{item.brand_name}</TableBodyCell>
</TableBodyRowFormat>
