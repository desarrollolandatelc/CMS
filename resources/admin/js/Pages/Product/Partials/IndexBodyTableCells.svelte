<script>
    import { TableBodyCell } from "flowbite-svelte";

    import TableBodyRowFormat from "../../../Components/Core/TableBodyRowFormat.svelte";
    export let selected = [];
    export let hasBulkAction = true;

    const route = window.route;
    export let item;
</script>

<TableBodyRowFormat bind:selected {item} {hasBulkAction}>
    <TableBodyCell>{item.barcode}</TableBodyCell>
    <TableBodyCell>
        <a
            type="button"
            class="hover:underline text-blue-600 cursor-pointer"
            href={route("products.edit", item.id)}
        >
            {item.title.name}
        </a>
    </TableBodyCell>
    <TableBodyCell>{item.price}</TableBodyCell>
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
