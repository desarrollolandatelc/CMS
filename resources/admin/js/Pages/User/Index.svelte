<script lang="ts">
    import { Heading, Button, Input } from "flowbite-svelte";
    import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.svelte";

    import Pagination from "../../Components/Gui/Pagination.svelte";
    import BulkDeleteActionOption from "../../Components/Core/BulkDeleteActionOption.svelte";
    import IndexBodyTableCells from "./partials/IndexBodyTableCells.svelte";
    import Table from "../../Components/Gui/Table.svelte";

    let selected = [];
    let selectedAll = false;

    export let paginate: Paginate = null;
    const route = window.route;

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
        <Table
            data={paginate.data}
            bind:selected
            bind:selectedAll
            headerLabel={["Nombre", "Estado"]}
            BODY_FORMAT_TABLE={IndexBodyTableCells}
        ></Table>
        <Pagination {paginate}></Pagination>
    </div>
</AuthenticatedLayout>
