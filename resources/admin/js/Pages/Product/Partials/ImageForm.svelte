<script>
    import { Input, Label } from "flowbite-svelte";

    export let detail = {
        alt: null,
        url: null,
    };
</script>

<div>
    <Label for="name" class="block w-full">Nombre de la imágen</Label>

    <Input
        id="name"
        type="text"
        class="mt-1 block w-full"
        bind:value={detail.alt}
        required
        autofocus
        autocomplete="name"
    />
</div>

<div>
    <Label for="url" class="block w-full">Url</Label>
    <Input
        id="url"
        type="text"
        class="mt-1 block w-full"
        bind:value={detail.url}
        required
        autofocus
        autocomplete="url"
    />
</div>
