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
    import { toasts, ToastContainer, FlatToast } from "svelte-toasts";
    import BulkDeleteAction from "./Partials/BulkDeleteActionOption.svelte";
    import { router } from "@inertiajs/svelte";

    import Pagination from "../../Components/Gui/Pagination.svelte";

    let selected = [];
    let selectedAll = false;

    export let paginate: Paginate = null;

    const toggleAll = (e) => {
        // Seleccionar todos los ids
        selected = selectedAll ? paginate.data.map((client) => client.id) : [];
    };

    const deleteProvider = (id: string) => {
        const confirm = window.confirm("¿Desea eliminar el proveedor?");
        if (!confirm) {
            return;
        }
        router.delete(`/admin/clients/${id}`, {
            onSuccess: () => {
                toasts.success({
                    description: "Se ha eliminado el cliente correctamente",
                });
            },
        });
    };
</script>

<AuthenticatedLayout>
    <div class="flex justify-between items-center">
        <Heading tag="h3">Listado de clientes</Heading>
        <Button href="/admin/clients/create">Nuevo</Button>
    </div>

    <div class="bg-white dark:bg-gray-800 p-4 mt-4 rounded-md">
        <div class="flex items-center justify-between mb-4">
            <div>
                {#if selected.length > 1}
                    <BulkDeleteAction bind:selected bind:selectedAll />
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
                <TableHeadCell>Teléfono</TableHeadCell>
                <TableHeadCell>Acciones</TableHeadCell>
            </TableHead>
            <TableBody>
                {#each paginate.data as client}
                    <TableBodyRow>
                        <TableBodyCell>
                            <Checkbox bind:group={selected} value={client.id}
                            ></Checkbox>
                        </TableBodyCell>
                        <TableBodyCell>{client.name}</TableBodyCell>
                        <TableBodyCell>{client.email}</TableBodyCell>
                        <TableBodyCell>
                            {client.phone ?? "No disponible"}
                        </TableBodyCell>
                        <TableBodyCell>
                            <a
                                href="/admin/clients/{client.id}/edit"
                                class="font-medium text-primary-600 hover:underline dark:text-primary-500"
                            >
                                Editar
                            </a>
                            <Button
                                size="xs"
                                color="red"
                                on:click={() => deleteProvider(client.id)}
                            >
                                Eliminar
                            </Button>
                        </TableBodyCell>
                    </TableBodyRow>
                {/each}
            </TableBody>
        </Table>
        <Pagination {paginate}></Pagination>
    </div>
</AuthenticatedLayout>
<ToastContainer placement="bottom-right" let:data>
    <FlatToast {data} />
</ToastContainer>
