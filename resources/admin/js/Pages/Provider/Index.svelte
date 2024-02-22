<script lang="ts">
    import { Heading, Button, Input } from "flowbite-svelte";
    import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.svelte";

    import BulkDeleteAction from "./Partials/BulkDeleteActionOption.svelte";
    import Pagination from "../../Components/Gui/Pagination.svelte";
    import Table from "../../Components/Gui/Table.svelte";
    import IndexBodyTableCells from "./Partials/IndexBodyTableCells.svelte";

    export let providers: Paginate = null;

    let selected = [];
    let selectedAll = false;
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
                    <BulkDeleteAction bind:selected bind:selectedAll
                    ></BulkDeleteAction>
                {/if}
            </div>
            <div>
                <Input placeholder="Buscar..."></Input>
            </div>
        </div>
        <Table
            data={providers.data}
            bind:selected
            bind:selectedAll
            BODY_FORMAT_TABLE={IndexBodyTableCells}
        ></Table>

        <Pagination paginate={providers}></Pagination>
    </div>
</AuthenticatedLayout>
