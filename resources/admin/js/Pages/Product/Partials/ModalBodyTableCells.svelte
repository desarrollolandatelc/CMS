<script>
    import { createEventDispatcher } from "svelte";
    import { TableBodyCell } from "flowbite-svelte";

    const dispatch = createEventDispatcher();

    export let item;
</script>

<TableBodyCell>{item.barcode}</TableBodyCell>
<TableBodyCell>
    <button
        type="button"
        class="hover:underline text-blue-600 cursor-pointer"
        on:click={() => dispatch("change", item)}
    >
        {item.title.name}
    </button>
</TableBodyCell>
<TableBodyCell>{item.price}</TableBodyCell>
