<script>
    import { TableBodyCell } from "flowbite-svelte";

    import TableBodyRowFormat from "../../../Components/Core/TableBodyRowFormat.svelte";
    import DeleteAction from "../../../Components/Core/DeleteAction.svelte";
    export let selected = [];
    export let hasBulkAction = true;

    const route = window.route;
    export let item;

    let statusAvailable = {
        pending: "Pendiente",
        accepted: "Aceptado",
        rejected: "Rechazado",
    };
</script>

<TableBodyRowFormat bind:selected {item} {hasBulkAction}>
    <TableBodyCell>{item.id}</TableBodyCell>
    <TableBodyCell>
        <a
            type="button"
            class="hover:underline text-blue-600 cursor-pointer"
            href={route("quotations.edit", item.id)}
        >
            {item.client_name}
        </a>
    </TableBodyCell>
    <TableBodyCell>
        {item.user_name}
    </TableBodyCell>

    <TableBodyCell>
        <span class="bg-gray-400 text-white p-1 rounded-md">
            {statusAvailable[item.status]}
        </span>
    </TableBodyCell>
    <TableBodyCell>
        {item.updated_at}
    </TableBodyCell>
    <TableBodyCell>
        <DeleteAction url={route("quotations.destroy", item.id)}></DeleteAction>
    </TableBodyCell>
</TableBodyRowFormat>
