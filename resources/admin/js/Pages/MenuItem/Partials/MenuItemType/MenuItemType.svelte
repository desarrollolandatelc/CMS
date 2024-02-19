<script>
    import { Label } from "flowbite-svelte";
    import InputAction from "../../../../Components/Gui/InputAction.svelte";
    import { SearchSolid } from "flowbite-svelte-icons";
    import MenuTypeOptions from "./MenuTypeOptions.svelte";

    export let form;
    let defaultModal = false;

    const selected = (event) => {
        console.log(event);
        $form.internal_link.name = event.detail.name;
        defaultModal = false;
    };
</script>

<Label for="email" class="block w-full">
    Tipo de menú <sup class="text-red-600">*</sup>
</Label>
<InputAction value={$form.internal_link?.name} bind:defaultModal modalTitle="Tipo de menú">
    <SearchSolid slot="button-title" />
    <MenuTypeOptions on:selected={selected} />
</InputAction>
