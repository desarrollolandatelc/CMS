<script>
    import { TableBodyCell } from "flowbite-svelte";

    export let item;

    const route = window.route;
</script>

<TableBodyCell>
    <a
        type="button"
        class="hover:underline text-blue-600 cursor-pointer"
        href={route("brands.edit", item.id)}
    >
        {item.name}
    </a>
</TableBodyCell>
<TableBodyCell>
    <span class="text-white p-1 rounded-md" class:bg-green-500={item.status} class:bg-orange-500={!item.status}>
        {item.status ? "Activo" : "Inactivo"}
    </span>
</TableBodyCell>
