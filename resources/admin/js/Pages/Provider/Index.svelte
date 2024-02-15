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

    import BulkDeleteAction from "./Partials/BulkDeleteActionOption.svelte";
    import { router } from "@inertiajs/svelte";

    let selected = [];
    let selectedAll = false;
    export let providers: {
        data: [{ id: string; name: string; email: string; phone: string }];
    } = { data: [{ id: "", name: "", email: "", phone: "" }] };

    const toggleAll = (e) => {
        // Seleccionar todos los ids
        selected = selectedAll
            ? providers.data.map((provider) => provider.id)
            : [];
    };
</script>

<AuthenticatedLayout>
    <div class="flex justify-between items-center">
        <Heading tag="h3">Listado de proveedores</Heading>
        <Button href="/admin/providers/create">Nuevo</Button>
    </div>

    <div class="bg-white dark:bg-gray-800 p-4 mt-4 rounded-md">
        <div class="flex items-center justify-between mb-4">
            <div>
                {#if selected.length > 1}
                    <BulkDeleteAction
                        bind:selected
                        bind:selectedAll
                    ></BulkDeleteAction>
                {/if}
            </div>
            <div>
                <Input placeholder="Buscar..."></Input>
            </div>
        </div>
        <Table shadow>
            <TableHead>
                <TableHeadCell>
                    <Checkbox on:change={toggleAll} bind:checked={selectedAll}
                    ></Checkbox>
                </TableHeadCell>
                <TableHeadCell>Nombre</TableHeadCell>
                <TableHeadCell>Correo</TableHeadCell>
                <TableHeadCell>Teléfono</TableHeadCell>
                <TableHeadCell>Acciones</TableHeadCell>
            </TableHead>
            <TableBody>
                {#each providers.data as provider}
                    <TableBodyRow>
                        <TableBodyCell>
                            <Checkbox bind:group={selected} value={provider.id}
                            ></Checkbox>
                        </TableBodyCell>
                        <TableBodyCell>{provider.name}</TableBodyCell>
                        <TableBodyCell>{provider.email}</TableBodyCell>
                        <TableBodyCell>
                            {provider.phone ?? "No disponible"}
                        </TableBodyCell>
                        <TableBodyCell>
                            <a
                                href="/admin/providers/{provider.id}/edit"
                                class="font-medium text-primary-600 hover:underline dark:text-primary-500"
                            >
                                Editar
                            </a>
                            <Button
                                size="xs"
                                color="red"
                                on:click={() =>
                                    router.delete(
                                        `/admin/providers/${provider.id}`,
                                    )}
                            >
                                Eliminar
                            </Button>
                        </TableBodyCell>
                    </TableBodyRow>
                {/each}
            </TableBody>
        </Table>
    </div>
</AuthenticatedLayout>
