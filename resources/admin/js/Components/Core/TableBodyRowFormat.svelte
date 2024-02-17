<script>
    import { Checkbox, TableBodyCell, TableBodyRow } from "flowbite-svelte";

    export let selected = [];
    export let hasBulkAction = true;
    export let item;
</script>

<TableBodyRow>
    {#if hasBulkAction}
        <TableBodyCell>
            <Checkbox bind:group={selected} value={item.id}></Checkbox>
        </TableBodyCell>
    {/if}
    <slot />
</TableBodyRow>
