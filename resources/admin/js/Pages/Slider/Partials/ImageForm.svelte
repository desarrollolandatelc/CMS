<script>
    import { Input, Label } from "flowbite-svelte";
    import MenuItemForm from "./MenuItem/MenuItemForm.svelte";
    import FileManager from "./FileManager/InputFileManager.svelte";

    export let detail = {
        alt: null,
        path: null,
        menu_item_name: null,
        menu_item_href: null,
    };
</script>

<div class="grid md:grid-cols-3 gap-2">
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
        <FileManager bind:value={detail.path} />
    </div>

    <div class="w-full">
        <MenuItemForm bind:value={detail.menu_item} />
    </div>
</div>
