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

    export let editRoute = "";
    export let deleteRoute = "";

    export let ACTIONS = null;

    export let TABLEROWPANEL = null;

    export let data;

    let openRow = null;

    const toggleAll = (e) => {
        // Seleccionar todos los ids
        selected = selectedAll ? data.map((item) => item.id) : [];
    };

    const toggleRow = (i) => {
        openRow = openRow === i ? null : i;
    };
</script>

<Table noborder={true}>
    <TableHead>
        <TableHeadCell>
            <Checkbox on:change={toggleAll} bind:checked={selectedAll} />
        </TableHeadCell>

        <TableHeadCell>ID</TableHeadCell>
        <TableHeadCell>Nombre</TableHeadCell>
        <TableHeadCell>Acciones</TableHeadCell>
    </TableHead>
    <TableBody>
        {#each data as item}
            <TableBodyRow>
                <TableBodyCell>
                    <Checkbox bind:group={selected} value={item.id}></Checkbox>
                </TableBodyCell>

                <TableBodyCell>{item.id}</TableBodyCell>
                <TableBodyCell class="text-blue-700 cursor-pointer hover:underline" on:click={() => toggleRow(item.id)}>{item.name}</TableBodyCell>
                <TableBodyCell>
                    <svelte:component
                        this={ACTIONS}
                        data={item}
                        {editRoute}
                        {deleteRoute}
                        on:change
                    />
                </TableBodyCell>
            </TableBodyRow>

            {#if TABLEROWPANEL && openRow === item.id}
                <svelte:component this={TABLEROWPANEL} {item} />
            {/if}
        {/each}
    </TableBody>
</Table>
