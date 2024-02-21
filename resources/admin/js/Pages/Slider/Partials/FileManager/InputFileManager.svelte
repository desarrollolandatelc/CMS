<script>
    import { Label } from "flowbite-svelte";
    import InputAction from "../../../../Components/Gui/InputAction.svelte";
    import { SearchSolid } from "flowbite-svelte-icons";
    import FileManagerComponent from "./FileManagerComponent.svelte";

    export let value = "";
    let defaultModal = false;

    const selected = (event) => {
        console.log(event.detail);
        value = event.detail;
        defaultModal = false;
    };
</script>

<Label for="email" class="block w-full">Imágen</Label>
<InputAction
    modalTitle="Seleccionar Imágen"
    value={value}
    bind:defaultModal
>
    <SearchSolid slot="button-title" />
    <FileManagerComponent on:change={selected} />
</InputAction>
