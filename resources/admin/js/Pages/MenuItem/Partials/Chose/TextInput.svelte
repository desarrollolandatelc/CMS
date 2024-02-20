<script>
    import { Input, Label } from "flowbite-svelte";
    export let form;
</script>

<div class="mt-4">
    <Label>Enlace</Label>
    <Input
        type="text"
        class="mt-1 block w-full"
        bind:value={$form.internal_link.resource_value}
        placeholder="Escriba el texto..."
    />
</div>
