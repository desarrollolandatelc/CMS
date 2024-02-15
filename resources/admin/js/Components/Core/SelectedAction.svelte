<script>
    import { Button } from "flowbite-svelte";
    import { createEventDispatcher } from "svelte";

    const dipatch = createEventDispatcher();

    export let data = {};
</script>

<Button type="button" on:click={() => dipatch("change", data)}>
    Seleccionar
</Button>
