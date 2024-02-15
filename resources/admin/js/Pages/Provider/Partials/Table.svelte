<script lang="ts">
    import {
        Table,
        TableHead,
        TableHeadCell,
        TableBodyRow,
        TableBodyCell,
        TableBody,
        Input,
        Checkbox,
    } from "flowbite-svelte";
    import StatusCell from "../../../Components/Gui/StatusCell.svelte";
    import type { ComponentType } from "svelte";
    import Pagination from "../../../Components/Gui/Pagination.svelte";

    export let ACTIONS: ComponentType = null;
    export let hasDeleteAll = true;

    export let selected = [];
    export let selectedAll = false;
    export let data: [
        {
            id: number;
            name: string;
            email: string;
            phone: string;
            status: number;
        },
    ] = [
        {
            id: 0,
            name: "",
            email: "",
            phone: "",
            status: 0,
        },
    ];

    const toggleAll = (e) => {
        // Seleccionar todos los ids
        selected = selectedAll ? data.map((provider) => provider.id) : [];
    };
</script>

<Table shadow>
    <TableHead>
        {#if hasDeleteAll}
            <TableHeadCell>
                <Checkbox on:change={toggleAll} bind:checked={selectedAll}
                ></Checkbox>
            </TableHeadCell>
        {/if}
        <TableHeadCell>Nombre</TableHeadCell>
        <TableHeadCell>Correo</TableHeadCell>
        <TableHeadCell>Teléfono</TableHeadCell>
        <TableHeadCell>Estado</TableHeadCell>
        <TableHeadCell>Acciones</TableHeadCell>
    </TableHead>
    <TableBody>
        {#each data as provider}
            <TableBodyRow>
                {#if hasDeleteAll}
                    <TableBodyCell>
                        <Checkbox bind:group={selected} value={provider.id}
                        ></Checkbox>
                    </TableBodyCell>
                {/if}
                <TableBodyCell>{provider.name}</TableBodyCell>
                <TableBodyCell>{provider.email}</TableBodyCell>
                <TableBodyCell>
                    {provider.phone ?? "No disponible"}
                </TableBodyCell>
                <TableBodyCell>
                    <StatusCell status={provider.status} />
                </TableBodyCell>
                <TableBodyCell>
                    <svelte:component
                        this={ACTIONS}
                        data={provider}
                        on:change
                    />
                </TableBodyCell>
            </TableBodyRow>
        {/each}
    </TableBody>
</Table>
