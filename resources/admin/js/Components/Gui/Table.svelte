<script>
    import {
        Checkbox,
        Table,
        TableBody,
        TableBodyCell,
        TableBodyRow,
        TableHead,
        TableHeadCell,
    } from "flowbite-svelte";

    export let selected = [];
    export let selectedAll = false;

    export let hasBulkAction = true;
    /**
     * Componentes
     */
    export let BODY_FORMAT_TABLE = null;

    export let headerLabel = [];

    export let data;

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
        <TableHeadCell>ID</TableHeadCell>
        {#each headerLabel as header}
            <TableHeadCell>{header}</TableHeadCell>
        {:else}
            <TableHeadCell>Nombre</TableHeadCell>
        {/each}
    </TableHead>
    <TableBody>
        {#each data as item}
            <TableBodyRow>
                {#if hasBulkAction}
                    <TableBodyCell>
                        <Checkbox bind:group={selected} value={item.id}
                        ></Checkbox>
                    </TableBodyCell>
                {/if}
                <TableBodyCell>{item.id}</TableBodyCell>

                {#if BODY_FORMAT_TABLE}
                    <svelte:component
                        this={BODY_FORMAT_TABLE}
                        {item}
                        on:change
                    />
                {:else}
                    <TableBodyCell>{item.name}</TableBodyCell>
                {/if}
            </TableBodyRow>
        {/each}
    </TableBody>
</Table>
