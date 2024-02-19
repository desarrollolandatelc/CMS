<script>
    import { Label } from "flowbite-svelte";
    import InputAction from "../../../../Components/Gui/InputAction.svelte";
    import { SearchSolid } from "flowbite-svelte-icons";

    export let form;
    let defaultModal = false;

    const selected = (event) => {
        console.log(event);
        $form.title_id = event.detail.id;
        $form.title.name = event.detail.name;
        defaultModal = false;
    };
</script>

<Label for="email" class="block w-full">
    Tipo de menú <sup class="text-red-600">*</sup>
</Label>
<InputAction value={$form.title?.name} bind:defaultModal>
    <SearchSolid slot="button-title" />
</InputAction>
