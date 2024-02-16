<script lang="ts">
    import {
        Table,
        TableHead,
        TableHeadCell,
        TableBodyRow,
        TableBodyCell,
        TableBody,
        Heading,
        Button,
        Input,
        Checkbox,
    } from "flowbite-svelte";
    import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.svelte";

    import Pagination from "../../Components/Gui/Pagination.svelte";
    import BulkDeleteActionOption from "../../Components/Core/BulkDeleteActionOption.svelte";
    import DeleteAction from "../../Components/Core/DeleteAction.svelte";

    let selected = [];
    let selectedAll = false;

    export let paginate: Paginate = null;
    const route = window.route;

    const toggleAll = (e) => {
        // Seleccionar todos los ids
        selected = selectedAll ? paginate.data.map((user) => user.id) : [];
    };
</script>

<AuthenticatedLayout>
    <div class="flex justify-between items-center">
        <Heading tag="h3">Listado de usuarios</Heading>
        <Button href="/admin/user/register">Nuevo</Button>
    </div>

    <div class="bg-white dark:bg-gray-800 p-4 mt-4 rounded-md">
        <div class="flex items-center justify-between mb-4">
            <div>
                {#if selected.length > 1}
                    <BulkDeleteActionOption
                        bind:selected
                        bind:selectedAll
                        url={route("users.bulk-delete")}
                    />
                {/if}
            </div>
            <div>
                <Input placeholder="Buscar..."></Input>
            </div>
        </div>
        <Table shadow>
            <TableHead>
                <TableHeadCell>
                    <Checkbox
                        on:change={toggleAll}
                        bind:checked={selectedAll}
                    />
                </TableHeadCell>
                <TableHeadCell>Nombre</TableHeadCell>
                <TableHeadCell>Correo</TableHeadCell>
                <TableHeadCell>Acciones</TableHeadCell>
            </TableHead>
            <TableBody>
                {#each paginate.data as user}
                    <TableBodyRow>
                        <TableBodyCell>
                            <Checkbox bind:group={selected} value={user.id}
                            ></Checkbox>
                        </TableBodyCell>
                        <TableBodyCell>{user.name}</TableBodyCell>
                        <TableBodyCell>{user.email}</TableBodyCell>
                        <TableBodyCell>
                            <DeleteAction
                                url={route("users.destroy", user.id)}
                            />
                        </TableBodyCell>
                    </TableBodyRow>
                {/each}
            </TableBody>
        </Table>
        <Pagination {paginate}></Pagination>
    </div>
</AuthenticatedLayout>
