<script>
    import { TableBodyCell } from "flowbite-svelte";

    import { createEventDispatcher } from "svelte";

    const dispatch = createEventDispatcher();

    export let item;

    const route = window.route;
</script>

<TableBodyCell>
    <button
        type="button"
        class="hover:underline text-blue-600 cursor-pointer"
        on:click={() => dispatch("change", item)}
    >
        {item.name}
    </button>
</TableBodyCell>
<TableBodyCell>
    <span class="text-white p-1 rounded-md" class:bg-green-500={item.status} class:bg-orange-500={!item.status}>
        {item.status ? "Activo" : "Inactivo"}
    </span>
</TableBodyCell>
