<script lang="ts">
    import { Heading, Button, Input } from "flowbite-svelte";
    import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.svelte";
    import BulkDeleteAction from "../../Components/Core/BulkDeleteActionOption.svelte";

    import Pagination from "../../Components/Gui/Pagination.svelte";
    import Table from "../../Components/Gui/Table.svelte";
    import TableSingleActions from "../../Components/Core/TableSingleActions.svelte";
    import TableBodyRowFormat from "./Partials/TableBodyRowFormat.svelte";

    let selected = [];
    let selectedAll = false;

    export let paginate: Paginate = null;
    const route = window.route;
</script>

<AuthenticatedLayout>
    <div class="flex justify-between items-center">
        <Heading tag="h3">Listado de clientes</Heading>
        <Button href="/admin/clients/create">Nuevo</Button>
    </div>

    <div class="bg-white dark:bg-gray-800 p-4 my-4 rounded-md border shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <div>
                {#if selected.length > 1}
                    <BulkDeleteAction
                        bind:selected
                        bind:selectedAll
                        url={route("clients.bulk-destroy")}
                    />
                {/if}
            </div>
            <div>
                <Input placeholder="Buscar..."></Input>
            </div>
        </div>
        <Table
            data={paginate.data}
            ACTIONS={TableSingleActions}
            bind:selected
            bind:selectedAll
            editRoute="clients.edit"
            deleteRoute="clients.destroy"
            TABLEROWPANEL={TableBodyRowFormat}
        ></Table>
        <Pagination {paginate}></Pagination>
    </div>
</AuthenticatedLayout>
