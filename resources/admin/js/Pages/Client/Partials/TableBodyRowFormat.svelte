<script>
    import {
        TableBodyRow,
        TableBodyCell,
        Checkbox,
        ImagePlaceholder,
    } from "flowbite-svelte";
    import { slide } from "svelte/transition";
    export let item;
</script>

<TableBodyRow>
    <TableBodyCell colspan="4" class="p-0">
        <div class="px-2 py-3" transition:slide={{ duration: 300, axis: "y" }}>
            <ImagePlaceholder />
        </div>
    </TableBodyCell>
</TableBodyRow>
