<script>
    import { Checkbox, TableBodyCell, TableBodyRow } from "flowbite-svelte";
    import { createEventDispatcher } from "svelte";
    const dispatch = createEventDispatcher();
    export let selected = [];
    export let hasBulkAction = true;
    export let item;
</script>

<TableBodyRow  on:click={() => dispatch("click")}>
    {#if hasBulkAction}
        <TableBodyCell>
            <Checkbox bind:group={selected} value={item.id}></Checkbox>
        </TableBodyCell>
    {/if}
    <slot />
</TableBodyRow>
