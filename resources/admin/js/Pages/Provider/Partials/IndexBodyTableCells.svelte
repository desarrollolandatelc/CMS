<script>
    import { TableBodyCell } from "flowbite-svelte";
    import TableBodyRowFormat from "../../../Components/Core/TableBodyRowFormat.svelte";

    export let item;

    export let hasBulkAction = true;
    export let selected = [];

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
            href={route("providers.edit", item.id)}
        >
            {item.name}
        </a>
    </TableBodyCell>
    <TableBodyCell>{item.email}</TableBodyCell>
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
