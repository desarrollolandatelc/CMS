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

    export let data;

    const toggleAll = (e) => {
        // Seleccionar todos los ids
        selected = selectedAll ? data.map((item) => item.id) : [];
    };
</script>

<Table shadow>
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
                <TableBodyCell>{item.name}</TableBodyCell>
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
        {/each}
    </TableBody>
</Table>
