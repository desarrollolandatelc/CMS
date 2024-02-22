<script>
    import {
        Checkbox,
        Table,
        TableBody,
        TableHead,
        TableHeadCell,
    } from "flowbite-svelte";
    import TableBodyRowFormat from "../Core/TableBodyRowFormat.svelte";
    import { trans } from "../../utils/lang.js";
    export let selected = [];
    export let selectedAll = false;

    export let hasBulkAction = true;
    /**
     * Componentes
     */
    export let BODY_FORMAT_TABLE = null;

    export let data;
    let headers = Object.keys(data[0]);
    const toggleAll = (e) => {
        selected = selectedAll ? data.map((item) => item.id) : [];
    };
</script>

<Table noborder={true}>
    <TableHead>
        {#if hasBulkAction}
            <TableHeadCell>
                <Checkbox on:change={toggleAll} bind:checked={selectedAll} />
            </TableHeadCell>
        {/if}
        {#each headers as header}
            <TableHeadCell>{trans(header)}</TableHeadCell>
        {/each}
    </TableHead>
    <TableBody>
        {#each data as item}
            {#if BODY_FORMAT_TABLE}
                <svelte:component
                    this={BODY_FORMAT_TABLE}
                    bind:selected
                    {item}
                    on:change
                />
            {:else}
                <TableBodyRowFormat bind:selected {item} {hasBulkAction} />
            {/if}
        {/each}
    </TableBody>
</Table>
