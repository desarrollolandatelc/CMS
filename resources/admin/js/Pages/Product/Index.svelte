<script lang="ts">
    import { Heading, Button, Input, Checkbox } from "flowbite-svelte";
    import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.svelte";
    import BulkDeleteAction from "../../Components/Core/BulkDeleteActionOption.svelte";

    import Pagination from "../../Components/Gui/Pagination.svelte";
    import Table from "../../Components/Gui/Table.svelte";
    import TableSingleActions from "../../Components/Core/TableSingleActions.svelte";

    let selected = [];
    let selectedAll = false;

    export let paginate: Paginate = null;
    const route = window.route;
</script>

<AuthenticatedLayout>
    <div class="flex justify-between items-center">
        <Heading tag="h3">Listado de productos</Heading>
        <Button href="/admin/products/create">Nuevo</Button>
    </div>

    <div class="bg-white dark:bg-gray-800 p-4 mt-4 rounded-md">
        <div class="flex items-center justify-between mb-4">
            <div>
                {#if selected.length > 1}
                    <BulkDeleteAction
                        bind:selected
                        bind:selectedAll
                        url={route("products.bulk-destroy")}
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
            editRoute="products.edit"
            deleteRoute="products.destroy"
        ></Table>
        <Pagination {paginate}></Pagination>
    </div>
</AuthenticatedLayout>
