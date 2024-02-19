<script>
    import { TableBodyCell } from "flowbite-svelte";

    import TableBodyRowFormat from "../../../Components/Core/TableBodyRowFormat.svelte";

    export let selected = [];
    export let hasBulkAction = true;

    export let item;

    const route = window.route;
</script>

<TableBodyRowFormat bind:selected {item} {hasBulkAction}>
    <TableBodyCell>
        {item.id}
    </TableBodyCell>
    <TableBodyCell>
        <a
            type="button"
            class="hover:underline text-blue-600 cursor-pointer"
            href={route("modules.edit", item.id)}
        >
            {item.name}
        </a>
    </TableBodyCell>
    <TableBodyCell>
        <span
            class="text-white p-1 rounded-md"
            class:bg-green-500={item.status}
            class:bg-orange-500={!item.status}
        >
            {item.status ? "Activo" : "Inactivo"}
        </span>
    </TableBodyCell>
</TableBodyRowFormat>
